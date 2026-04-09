(function ($) {
    "use strict";

    var $output = $("#wpgp-status-output");

    function showOutput(data) {
        if (!$output.length) return;
        $output.show().text(JSON.stringify(data, null, 2));
    }

    function setLoading($btn, $spinner, loading) {
        $btn.prop("disabled", loading);
        if (loading) {
            $spinner.addClass("is-active");
        } else {
            $spinner.removeClass("is-active");
        }
    }

    // AJAX Push — timeout set to 5 minutes to allow large pushes
    $("#wpgp-push-form").on("submit", function (e) {
        e.preventDefault();

        var $btn = $("#wpgp-push-btn");
        var $spinner = $("#wpgp-push-spinner");
        var commitMessage = $("#wpgp_commit_message").val() || "Sync from WordPress";

        setLoading($btn, $spinner, true);
        showOutput({ status: "pushing", message: "Scanning files and pushing to GitHub…" });

        $.ajax({
            url: wpgpAdmin.ajaxUrl,
            method: "POST",
            timeout: 300000,
            data: {
                action: "wpgp_direct_push",
                nonce: wpgpAdmin.pushNonce,
                commit_message: commitMessage
            }
        })
        .done(function (res) {
            if (res && res.success) {
                showOutput({
                    status: "success",
                    commit: res.data.commit_sha,
                    files_pushed: res.data.files_pushed,
                    text_inline: res.data.text_inline,
                    blobs_created: res.data.blobs_created
                });
                setTimeout(function () { location.reload(); }, 2000);
            } else {
                showOutput({
                    status: "error",
                    message: (res && res.data && res.data.message) || "Unknown error"
                });
            }
        })
        .fail(function (xhr, textStatus) {
            var msg = "Push request failed";
            if (textStatus === "timeout") {
                msg = "Request timed out — the push may still be processing server-side. Refresh the page and check the debug log.";
            } else {
                try {
                    var body = JSON.parse(xhr.responseText);
                    if (body && body.data && body.data.message) msg = body.data.message;
                } catch (_) {}
            }
            showOutput({ status: "error", message: msg });
        })
        .always(function () {
            setLoading($btn, $spinner, false);
        });
    });

    // ---- Scan GitHub for remote themes + manual slug entry ----
    (function () {
        var $btn = $("#wpgp-scan-github-themes");
        var $spinner = $("#wpgp-scan-spinner");
        var $list = $("#wpgp-remote-themes-list");
        var $textarea = $("#wpgp_remote_theme_slugs");
        var $status = $("#wpgp-scan-status");
        var $addInput = $("#wpgp-remote-theme-add-input");
        var $addBtn = $("#wpgp-remote-theme-add-btn");
        var $addMsg = $("#wpgp-remote-add-msg");

        var i18n = (typeof wpgpAdmin !== "undefined" && wpgpAdmin.remoteThemeI18n) ? wpgpAdmin.remoteThemeI18n : {};
        var localSlugs = (typeof wpgpAdmin !== "undefined" && wpgpAdmin.localThemeSlugs) ? wpgpAdmin.localThemeSlugs : [];

        function scanStatus(msg, type) {
            var color = type === "error" ? "#d63638" : (type === "success" ? "#00a32a" : "#666");
            $status.html('<span style="color:' + color + ';">' + msg + "</span>").show();
            if (type === "error") {
                console.error("[WPGP Scan]", msg);
            } else {
                console.log("[WPGP Scan]", msg);
            }
        }

        function addMsg(text, isError) {
            $addMsg.html(text ? '<span style="color:' + (isError ? "#d63638" : "#666") + ';">' + text + "</span>" : "");
        }

        function isLocalSlug(slug) {
            return localSlugs.indexOf(slug) !== -1;
        }

        function parseRemoteLines() {
            return ($textarea.val() || "").split("\n").map(function (s) { return s.trim(); }).filter(Boolean);
        }

        function slugLooksValid(slug) {
            return /^[a-zA-Z0-9_-]+$/.test(slug);
        }

        function existingSlugSet() {
            var set = {};
            $list.find(".wpgp-remote-theme-cb").each(function () {
                set[$(this).val()] = true;
            });
            return set;
        }

        var remoteCheckboxName = "wpgp_settings[remote_theme_slugs_list][]";

        function appendRemoteRow(slug, checked) {
            var $label = $("<label/>").css({ display: "block", margin: "0.35em 0" });
            $label.append(
                $("<input/>", {
                    type: "checkbox",
                    class: "wpgp-remote-theme-cb",
                    name: remoteCheckboxName,
                    value: slug
                }).prop("checked", !!checked)
            );
            $label.append(" ");
            $label.append($("<code/>").text(slug));
            $label.append(" ");
            $label.append($("<em/>", { css: { color: "#888" } }).text("(not installed locally)"));
            $list.append($label);
        }

        /**
         * Build merged slug list: API remote-only themes plus manual slugs (not installed locally).
         */
        function mergedRemoteSlugs(themes, currentRemote) {
            var bySlug = {};
            (themes || []).forEach(function (t) {
                bySlug[t.slug] = t;
            });

            var out = {};
            (themes || []).forEach(function (t) {
                if (!t.installed_locally) {
                    out[t.slug] = true;
                }
            });

            currentRemote.forEach(function (s) {
                if (isLocalSlug(s)) {
                    return;
                }
                var t = bySlug[s];
                if (!t) {
                    out[s] = true;
                    return;
                }
                if (!t.installed_locally) {
                    out[s] = true;
                }
            });

            return Object.keys(out).sort();
        }

        function renderRemoteThemeRows(themes, currentRemote) {
            var slugs = mergedRemoteSlugs(themes, currentRemote);
            $list.empty();

            if (slugs.length === 0) {
                var note = "";
                if ((themes || []).length === 0) {
                    note = "No theme folders found under <code>themes/</code> in the repo.";
                } else {
                    note = "All theme folders in the repo match installed themes — use “Themes to sync” above, or add a folder name manually.";
                }
                $list.html('<em style="color:#888;">' + note + "</em>");
                syncTextarea();
                return slugs.length;
            }

            slugs.forEach(function (slug) {
                var checked = currentRemote.indexOf(slug) !== -1;
                appendRemoteRow(slug, checked);
            });
            syncTextarea();
            return slugs.length;
        }

        function syncTextarea() {
            var slugs = [];
            $list.find(".wpgp-remote-theme-cb:checked").each(function () {
                slugs.push($(this).val());
            });
            $textarea.val(slugs.join("\n"));
        }

        $list.on("change", ".wpgp-remote-theme-cb", syncTextarea);

        var $settingsForm = $textarea.closest("form");
        if ($settingsForm.length) {
            $settingsForm.on("submit", function () {
                syncTextarea();
            });
        }

        function tryAddManualSlug() {
            addMsg("", false);
            var raw = ($addInput.val() || "").trim();
            if (!raw) {
                addMsg(i18n.invalid || "Enter a theme folder name.", true);
                return;
            }
            if (!slugLooksValid(raw)) {
                addMsg(i18n.invalid || "Invalid theme folder name.", true);
                return;
            }
            var slug = raw;
            if (isLocalSlug(slug)) {
                addMsg(i18n.alreadyInstalled || "Already installed locally.", true);
                return;
            }
            if (existingSlugSet()[slug]) {
                addMsg(i18n.duplicate || "Already in the list.", true);
                return;
            }

            if (!$list.find(".wpgp-remote-theme-cb").length) {
                $list.empty();
            }

            appendRemoteRow(slug, true);
            $addInput.val("");
            syncTextarea();
            addMsg("Added — click “Save Settings” to keep it.", false);
        }

        if ($addBtn.length) {
            $addBtn.on("click", tryAddManualSlug);
        }
        if ($addInput.length) {
            $addInput.on("keydown", function (e) {
                if (e.key === "Enter" || e.keyCode === 13) {
                    e.preventDefault();
                    tryAddManualSlug();
                }
            });
        }

        if (!$btn.length) {
            console.warn("[WPGP Scan] Button #wpgp-scan-github-themes not found in DOM");
            syncTextarea();
            return;
        }

        $btn.on("click", function () {
            if (typeof wpgpAdmin === "undefined" || !wpgpAdmin.ajaxUrl) {
                scanStatus("Configuration error — wpgpAdmin not defined. Try reloading the page.", "error");
                return;
            }

            var currentRemote = parseRemoteLines();

            $btn.prop("disabled", true);
            $spinner.addClass("is-active");
            scanStatus("Scanning GitHub repository\u2026", "info");

            try {
                $.ajax({
                    url: wpgpAdmin.ajaxUrl,
                    method: "POST",
                    dataType: "json",
                    timeout: 90000,
                    data: {
                        action: "wpgp_discover_themes",
                        nonce: wpgpAdmin.discoverNonce
                    }
                })
                .done(function (res) {
                    if (!res || !res.success) {
                        var msg = (res && res.data && res.data.message) || "Scan failed — unknown error";
                        scanStatus(msg, "error");
                        return;
                    }

                    var themes = res.data.themes || [];
                    var n = renderRemoteThemeRows(themes, currentRemote);

                    if (themes.length === 0) {
                        scanStatus(
                            n > 0
                                ? "Scan found no themes/ paths — kept your manually added slug(s)."
                                : "Scan complete — no theme folders found in the repository.",
                            n > 0 ? "success" : "error"
                        );
                        return;
                    }

                    var remoteOnly = themes.filter(function (t) { return !t.installed_locally; });
                    if (remoteOnly.length === 0 && n === 0) {
                        scanStatus("All " + themes.length + " theme(s) in the repo are installed locally.", "success");
                    } else if (n > 0) {
                        scanStatus(
                            "Listed " + n + " remote-only theme(s) (including manual entries).",
                            "success"
                        );
                    } else {
                        scanStatus("Scan complete — no remote-only rows after merge.", "success");
                    }
                })
                .fail(function (xhr, textStatus) {
                    var msg = "Scan request failed";
                    if (textStatus === "timeout") {
                        msg = "Request timed out — the GitHub API may be slow. Try again.";
                    } else {
                        try {
                            var body = JSON.parse(xhr.responseText);
                            if (body && body.data && body.data.message) msg = body.data.message;
                        } catch (_) {
                            msg += " (HTTP " + (xhr.status || "0") + ")";
                        }
                    }
                    scanStatus(msg, "error");
                })
                .always(function () {
                    $btn.prop("disabled", false);
                    $spinner.removeClass("is-active");
                });
            } catch (e) {
                console.error("[WPGP Scan] Exception:", e);
                scanStatus("JavaScript error: " + e.message, "error");
                $btn.prop("disabled", false);
                $spinner.removeClass("is-active");
            }
        });

        syncTextarea();
    })();

    // AJAX Pull — chunked tree + blobs with automatic retry
    $("#wpgp-pull-form").on("submit", function (e) {
        e.preventDefault();

        var MAX_RETRIES = 3;
        var RETRY_DELAY = 2000;

        var $btn = $("#wpgp-pull-btn");
        var $spinner = $("#wpgp-pull-spinner");

        setLoading($btn, $spinner, true);

        function stopPullSpinner() {
            setLoading($btn, $spinner, false);
        }

        function showPullProgress(processed, total, extra) {
            var data = {
                status: "pulling",
                message: "Downloading files from GitHub…",
                progress: processed + " / " + total + " files"
            };
            if (extra) data.detail = extra;
            showOutput(data);
        }

        function finishPull(d) {
            stopPullSpinner();
            var result = {
                status: "success",
                files_updated: d.changed,
                files_skipped: d.skipped || 0
            };
            if (d.errors && d.errors.length) {
                result.status = "partial_success";
                result.failed = d.errors.length;
                result.permission_hint = d.permission_hint || null;
                result.errors = d.errors;
            }
            showOutput(result);
            setTimeout(function () { location.reload(); }, 3000);
        }

        function parseError(xhr, textStatus) {
            if (textStatus === "timeout") return "Request timed out";
            try {
                var body = JSON.parse(xhr.responseText);
                if (body && body.data && body.data.message) return body.data.message;
            } catch (_) {}
            return "HTTP " + (xhr.status || "error");
        }

        showOutput({ status: "pulling", message: "Fetching repository tree…" });

        $.ajax({
            url: wpgpAdmin.ajaxUrl,
            method: "POST",
            timeout: 120000,
            data: {
                action: "wpgp_pull_start",
                nonce: wpgpAdmin.pullNonce
            }
        })
        .done(function (res) {
            if (!res || !res.success) {
                var err0 = (res && res.data && res.data.message) || "Pull failed";
                showOutput({ status: "error", message: err0 });
                stopPullSpinner();
                return;
            }

            var start = res.data || {};
            var jobId = start.job_id;
            var total = start.total_files || 0;

            function pullChunk(retries) {
                $.ajax({
                    url: wpgpAdmin.ajaxUrl,
                    method: "POST",
                    timeout: 120000,
                    data: {
                        action: "wpgp_pull_chunk",
                        nonce: wpgpAdmin.pullNonce,
                        job_id: jobId
                    }
                })
                .done(function (chunkRes) {
                    if (!chunkRes || !chunkRes.success) {
                        var msg = (chunkRes && chunkRes.data && chunkRes.data.message) || "Pull failed";
                        if (retries < MAX_RETRIES) {
                            showPullProgress("?", total, "Chunk error, retrying (" + (retries + 1) + "/" + MAX_RETRIES + ")…");
                            setTimeout(function () { pullChunk(retries + 1); }, RETRY_DELAY);
                            return;
                        }
                        showOutput({ status: "error", message: msg, report: chunkRes && chunkRes.data && chunkRes.data.report });
                        stopPullSpinner();
                        return;
                    }

                    var cd = chunkRes.data || {};
                    if (cd.done && cd.report) {
                        var rep = cd.report;
                        if (rep.errors && rep.errors.length && !rep.changed) {
                            showOutput({ status: "error", message: rep.errors[0], report: rep });
                            stopPullSpinner();
                            return;
                        }
                        var out = {
                            changed: rep.changed,
                            skipped: rep.skipped || 0,
                            errors: rep.errors || [],
                            permission_hint: null
                        };
                        if (rep.errors && rep.errors.length) {
                            out.permission_hint = "Some files could not be written due to permissions. Run: sudo chmod -R 775 " +
                                (wpgpAdmin.contentThemesPath || "wp-content/themes/");
                        }
                        finishPull(out);
                        return;
                    }

                    showPullProgress(cd.processed_total || 0, cd.total_files || total);
                    pullChunk(0);
                })
                .fail(function (xhr, textStatus) {
                    var detail = parseError(xhr, textStatus);
                    if (retries < MAX_RETRIES) {
                        showPullProgress("?", total, "Retrying chunk (" + (retries + 1) + "/" + MAX_RETRIES + "): " + detail);
                        setTimeout(function () { pullChunk(retries + 1); }, RETRY_DELAY * (retries + 1));
                        return;
                    }
                    showOutput({ status: "error", message: "Pull failed after " + MAX_RETRIES + " retries: " + detail });
                    stopPullSpinner();
                });
            }

            if (total === 0) {
                showOutput({ status: "pulling", message: "No files matched the selected themes / filters in this branch — finishing…" });
            }
            pullChunk(0);
        })
        .fail(function (xhr, textStatus) {
            showOutput({ status: "error", message: "Pull failed: " + parseError(xhr, textStatus) });
            stopPullSpinner();
        });
    });

})(jQuery);
