    // Custom Serilizer
    (function($) {

        $.fn.ipanel_serialize = function() {
            var toReturn    = [];
            var els         = $(this).find(':input').get();
            $.each(els, function() {
                if (
                    this.name &&
                    !this.disabled &&
                    (
                        $(this).is(':checkbox') ||
                        /select|textarea/i.test( this.nodeName ) ||
                        /text|hidden|password/i.test( this.type ))
                    )
                {
                    var val = $(this).val();
                    if( $(this).is(':checkbox') ){
                        if( $(this).is(':checked') ) {
                            val = 'on';
                        } else{
                            val = 'off';
                        }
                    }
                    toReturn.push( encodeURIComponent(this.name) + "=" + encodeURIComponent( val ) );
                }

            });

            return toReturn.join("&").replace(/%20/g, "+");
        }

        $.fn.reloadIframe = function() {
			return this.each( function(){
				$(this).attr( 'src' , $(this).attr('src') );
			});
        }

        $.fn.exist = function() {
			return this.size() > 0 ? true : false;
        }

    })(jQuery);



    jQuery(document).ready( function( $ ){


        var _ipanel_panel_id = $('#IPANEL').data('panelid');
        ipanel_editors = Array;
        $('.ipanel-tabs').hide();

        $('.ipanel-code-editor').each(function(index) {
                var __this = this;
                $(this).attr('id', 'ipanel-code-' + index);
                var _code_type = $(this).data('lang');
                var tesdex = 'abcd' + index;
                var _line_numbers_ = $(this).data('line-numbers') == 'enable' ? true : false;
                var _auto_close_brackets = $(this).data('auto-close-brackets') == 'enable' ? true : false;
                var _auto_close_tags = $(this).data('auto-close-tags') == 'enable' ? true : false;
                tesdex = CodeMirror.fromTextArea(
                    document.getElementById('ipanel-code-' + index),
                        {
                            mode: _code_type,
                            lineNumbers: _line_numbers_,
                            autoCloseBrackets: _auto_close_brackets,
                            autoCloseTags: _auto_close_tags,
                        }
                    );
                    tesdex.on("change", function() {
                        $(__this).val( tesdex.getValue() );
                    });
                    tesdex.refresh();
            ipanel_editors[ index ]    = tesdex;
        });
        function refresh_ipanel_editors(){
            $.each( ipanel_editors, function(i,o){
                o.refresh();
            });
        }

        function ipanel_slider_input( _element ){
            _element.each( function(){
                var _min = $(this).data('min');
                var _max = $(this).data('max');
                var _step = $(this).data('step');
                var _animate = $(this).data('animation') == 'enable' ? true : false;
                var _dimension = ' ' + $(this).data('dimension');
                var _val = $(this).data('val');
                var _this = $(this);
                $(this).slider({
                    range: 'min',
                    animate: _animate,
                    value: _val,
                    step: _step,
                    min: _min,
                    max: _max,
                    slide: function(  event, ui ) {
                        $(this).find(".ui-slider-handle").html( '<span><span></span>'+ui.value+_dimension+'</span>' );
                        _this.siblings('.ipanel-slider-input').val( ui.value );
                    },
                    create: function(  event, ui ) {
                        $(this).find(".ui-slider-handle").html( '<span><span></span>'+_val+_dimension+'</span>' );
                    }
                });
            });
        }
        ipanel_slider_input( $('.ipanel-slider-slider') );

		if ( $('#ipanel-preview-wrap').exist() ) {
			$('.ipanel-toggle-preview').on('click', function(){
				if( $('#IPANEL').is(':visible') ) {
					$('#ipanel-preview-wrap').find('iframe').reloadIframe();
					$('#IPANEL').fadeOut(function(){
						$('#ipanel-preview-wrap').fadeIn();
					});
				} else {
					$('#ipanel-preview-wrap').fadeOut(function(){
						$('#IPANEL').fadeIn();
					});
				}
			});
			$('.ipanel-devices-nav').find('>ul').find('>li').on('click', function(){
				var __id = $(this).attr('class');

				$('#ipanel-preview-wrap').find( '.ipanel-device:visible' ).fadeOut( function(){

					$('#ipanel-preview-wrap').find( '#ipanel-preview-' + __id ).fadeIn(function(){



					});

				});
			});
	}


		var __current_tab = $.cookie( 'ipanel_current_tab_' + _ipanel_panel_id );

		// Show main tab after registration
        if(__current_tab == 'registration') {
            __current_tab = 'main_settings';
        }

		// Check if there is tab data in cookie
        if( typeof( __current_tab ) == "undefined" ) {

			$('.ipanel-tabs').eq(0).slideDown(function(){ refresh_ipanel_editors() });
			$('#ipanel-tabs').find('a').eq(0).addClass('current_tab');

		} else {

			// Show the tab from cookie
			$('#ipanel-'+__current_tab).slideDown(function(){ refresh_ipanel_editors() });

			// If the button is a child
			if( $('#ipanel-tabs').find('a[data-target="'+__current_tab+'"]').parent('.submenu').size() > 0 ) {
				$('#ipanel-tabs').find('a[data-target="'+__current_tab+'"]').closest('li').find('a').eq(0).addClass('current_tab').end().siblings('.submenu').slideDown();
			} else {
				$('#ipanel-tabs').find('a[data-target="'+__current_tab+'"]').addClass('current_tab');
				$('#ipanel-tabs').find('a[data-target="'+__current_tab+'"]').siblings('.submenu').slideDown();
			}

		}

		$('#ipanel-tabs').find('a').on('click', function(){
			var _target = $(this).attr('data-target');
			$(this).closest('#ipanel-tabs').find('.current_tab').removeClass('current_tab');
			 $.cookie( 'ipanel_current_tab_' + _ipanel_panel_id , _target , { expires: 7, path: '/' });

			if( $(this).parent('.submenu').size() > 0 ) {

				$(this).closest('li').find('a:first').addClass('current_tab');

			} else {

				$(this).closest('#ipanel-tabs').find('.submenu:visible').slideUp();
				$(this).addClass('current_tab');
				$(this).siblings('.submenu').slideDown();

			}

			if( $('#ipanel-'+_target).size() > 0 ) {
				if( $('.ipanel-tabs:visible').size() == 0 ){
					$('#ipanel-'+_target).fadeIn(function(){
						refresh_ipanel_editors();
					});
				} else {
					$('.ipanel-tabs:visible').fadeOut( 200 , function(){
						$('#ipanel-'+_target).fadeIn( 150, function(){
							refresh_ipanel_editors();
						});
					});
				}
			}

			return false;

		});





        // @Fire iCheck Box
        // @Since 1.0
        $("input:radio").not('.ipanel-image-field-radio').iCheck({ radioClass: 'iradio_square-grey' });
        $("input:checkbox").not('.ipanel-wpml-installer input:checkbox').switcher();



        // @Fire Chosen Plugin
        // @Since 1.0
        function ipanel_chosen( _element ){
            _element.not('.no-chosen').each( function(){
                var _chosen_width = $.isNumeric( $(this).data('width') ) ? $(this).data('width') : 100;
                $(this).chosen({ width: _chosen_width + '%' });
            });
        }
        ipanel_chosen( $('select') );




        // @Media Stuff
        // @Since 1.0
        $('body').on( 'click' , '.ipanel-media-upload-button' ,function() {
            var _this = $(this);
            var custom_uploader;
            var media_title = _this.attr('data-mediaTitle');
            var media_button = _this.attr('data-mediaButton');
            if (custom_uploader) {
                custom_uploader.open();
                return;
            }
            custom_uploader = wp.media.frames.file_frame = wp.media({
                title: media_title,
                button: {
                    text: media_button
                },
                multiple: false
            });
            custom_uploader.on('select', function() {
                attachment = custom_uploader.state().get('selection').first().toJSON();
                _this.parent().find('.ipanel-media-uploader-input').val( attachment.url );
                custom_uploader.state().get('selection').each( function(i,o){
                });
            });
            custom_uploader.open();
            return false;
        });


        /*
            Image Select
            @since 1.0
        */
        $('.ipanel-image-field-radio').each( function(){
            if( $(this).is(':checked') )
                $(this).parent('label').addClass('checked');
        });
        $('body').on( 'click' , '.ipanel-image-select-image' , function(){
            $(this).parent().parent().find(':radio').filter(':checked').removeAttr('checked');
            $(this).parent().parent().find('label.checked').removeClass('checked');
            $(this).siblings(':radio').attr('checked', 'checked');
            $(this).closest('label').addClass('checked');
        });


        function ipanel_cleditor( _element ){
            _element.each( function(){
                var _width = $(this).data('width');
                $(this).cleditor({
                    width: _width
                });
            });
        }
        ipanel_cleditor( $(".ipanel-cleditor") );

    function ipanel_date_picker( _element ){
        _element.each( function(){
            var _date_format = $(this).data('ipanel-date-format');
            $(this).datepicker({ dateFormat: _date_format });
        });
    }
    ipanel_date_picker( $('.ipanel-date-picker') );

	$(document).on('keypress', function(event) {
		if( event.which === 83 && event.shiftKey ) {
			$('.ipanel-save-settings').trigger('click');
		}
	});

    $('body').on( 'click' , '.ipanel-save-settings' , function(){
        if( $('.ipanel-wp_editor-field').size() > 0 )
            tinyMCE.triggerSave();
        _serialized = $('#ipanel-fields-container').ipanel_serialize();
        _serialized += '&' + $('#ipanel-settings-form :radio').serialize();
        $.blockUI({
            message: $('#ipanel-canvesLoader'),
            css: {
                border: 'none',
                padding: '15px',
                background: 'none',
                left: '50%',
                marginLeft: '-115px',
                width: '200px',
				'z-index': 100001
            }
        });
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: iPanelAjax.ajaxurl,
            data:{
                action: 'ipanel_ajax_request',
                _data: _serialized,
                action2: 'save_settings',
                panelid: _ipanel_panel_id,
                security: $.trim( $('#ipanel_ajax_nonce').val() )
            },
            success: function(data, textStatus, XMLHttpRequest){
                if( data.status == 'succeed' ){
                    $('#ipanel-message-box').html('<div class="ipanel-ok-icon"></div> <p class="save-message">'+data.message+'</p>').find('p').css('font-size','20px').end().fadeIn();

                    setTimeout( function(){
                        $('#ipanel-message-box').fadeOut(function(){
                            $(this).html('');
                        });
                    }, 2000);

                } else{
                    $('#ipanel-message-box').html('<div class="ipanel-error-icon"></div> <p class="save-message">'+data.message+'</p>').find('p').css('font-size','20px').end().fadeIn();

                    setTimeout( function(){
                        $('#ipanel-message-box').fadeOut(function(){
                            $(this).html('');
                        });
                    }, 2000);

                }
                $.unblockUI();
                console.log( data );
            },
            error: function(MLHttpRequest, textStatus, errorThrown){
                $('#ipanel-message-box').html('<div class="ipanel-error-icon"></div> <p class="save-message">Error!</p>').find('p').css('font-size','20px').end().fadeIn();

                setTimeout( function(){
                    $('#ipanel-message-box').fadeOut(function(){
                        $(this).html('');
                    });
                }, 2000);

                $.unblockUI();
            }
        });


        return false;
    });

    $('body').on( 'click' , '.ipanel-reset-settings' , function(){
        if( confirm(iPanelAjax.reset_confirm_message) ){
            $.blockUI({
                message: $('#ipanel-canvesLoader'),
                css: {
                    border: 'none',
                    padding: '15px',
                    background: 'none',
                    left: '50%',
                    marginLeft: '-115px',
                    width: '200px',
					'z-index': 100001
                }
            });
            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: iPanelAjax.ajaxurl,
                data:{
                    action: 'ipanel_ajax_request',
                    action2: 'reset_settings',
                    panelid: _ipanel_panel_id,
                    security: $.trim( $('#ipanel_ajax_nonce').val() )
                },
                success: function(data, textStatus, XMLHttpRequest){
                    if( data.status == 'succeed' ){
                        $('#ipanel-message-box').html('<div class="ipanel-ok-icon"></div> <p class="save-message">'+data.message+'</p>').find('p').css('font-size','20px').end().fadeIn();
                        setTimeout( function(){
                            location.reload();
                        }, 2000);

                    } else {
                        $('#ipanel-message-box').html('<div class="ipanel-error-icon"></div> <p class="save-message">'+data.message+'</p>').find('p').css('font-size','20px').end().fadeIn();
                        setTimeout( function(){
                            $('#ipanel-message-box').fadeOut(function(){
                                $(this).html('');
                            });
                        }, 2000);

                    }
                    $.unblockUI();
                },
                error: function(MLHttpRequest, textStatus, errorThrown){
                    $('#ipanel-message-box').html('<div class="ipanel-error-icon"></div> <p class="save-message">Error!!</p>').find('p').css('font-size','20px').end().fadeIn();
                    setTimeout( function(){
                        $('#ipanel-message-box').fadeOut(function(){
                            $(this).html('');
                        });
                    }, 2000);
                    $.unblockUI();
                }
            });
        }
        return false;
    });

    var ipanel_desc_tooltip_placment = $('body').hasClass('ipanel-ltr') ? 'w' : 'e';
    $('.ipanel-description-icon').each( function(){
        $(this).data('powertip', function() {
            var tooltip = $(this).parent().find('.tooltip_data').html();
            return tooltip;
        });
        $(this).powerTip({
            placement: ipanel_desc_tooltip_placment,
            mouseOnToPopup: true,
            offset : 4
        });
    });




    function ipanel_color_picker( _element ){
        _element.each( function(){
            var _this = $(this);
            _this.ColorPicker({
                color: _this.val(),
                onShow: function (colpkr) {
                    $(colpkr).fadeIn();
                    return false;
                },
                onHide: function (colpkr) {
                    $(colpkr).fadeOut();
                    return false;
                },
                onChange: function (hsb, hex, rgb) {
                    _this.val('#' + hex);
                    _this.siblings('.ipanel-color-picker-preview').css({backgroundColor:'#'+hex});
                }
            });
        });

    }
    ipanel_color_picker( $('.ipanel-color-picker') );

	$('body').on( 'click' , '.ipanel-color-picker-preview' , function(){
		$(this).siblings('.ipanel-color-picker').trigger('click');
	});


    $(window).scroll(function() {
        $('#ipanel-message-box').dequeue().animate({
            top: $(window).scrollTop() + 150 }
            , 600
            , 'easeInOutCirc'
        );
    });

    $('.ipanel-repeater-new-item').on('click', function(){
        var highest = 0, this_id, _closest = $(this).closest(".ipanel-repeater-input-container");
        $(this).parent().find('>li').each( function(i,v){
            this_id = parseInt($(this).attr('data-repeatercounter'));
            if ( this_id > highest){
                highest = this_id;
            }
        });
        var new_num = highest + 2;
        var _clone = $( $(this).parent().find("script[type='text/html']").html().replace( /\[(\d)\]/g, '['+new_num+']' ) )
        .find('h2.ipanel-repeater-title span.item_number')
        .text( function(n,o){
            var new_item_number = _closest.find('>li.ipanel-repeater-item').size() + 1;
            return o.replace( /(\d)/g, new_item_number );
        })
        .end()
        .html()
        ;

        var new_item = '<li class="ipanel-repeater-item tempClass" style="display:none" data-repeaterCounter="'+(new_num-1)+'">' + _clone + '</li>';
        $(this).before( new_item ).parent().find('.tempClass').fadeIn().removeClass('tempClass');

        ipanel_chosen( $(".ipanel-repeater-item:last select") );
        ipanel_color_picker( $(".ipanel-repeater-item:last .ipanel-color-picker") );
        iPanel_AjaxFileUpload( $(".ipanel-quick-up-file") );
        $(".ipanel-repeater-item:last").find('input:checkbox').iCheck({ checkboxClass: 'icheckbox_square-grey' });
        $(".ipanel-repeater-item:last").find('input:radio:not(.ipanel-image-field-radio)').iCheck({ radioClass: 'iradio_square-grey' });
        ipanel_cleditor( $(".ipanel-repeater-item:last textarea.ipanel-cleditor") );
        ipanel_date_picker( $(".ipanel-repeater-item:last input.ipanel-date-picker") );

        return false;

    });

    $('body').on( 'click' , '.ipanel-delete-repeater-item' , function(){
        if( confirm( iPanelAjax.confirm_message ) ){
            $(this).closest('li').slideUp( function(){
                $(this).remove();
            });
        }
        return false;
    });


    $( ".ipanel-repeater-input-container" ).sortable2({
        distance: 25,
        tolerance: -25,
        handle: 'i.ipanel-drag-repeater-item',
        pullPlaceholder: true,
        onDrop: function  (item, targetContainer, _super) {
            var clonedItem = $('<li/>').css({height: 0})
            item.before(clonedItem)
            clonedItem.animate({'height': item.height()})
            item.animate(clonedItem.position(), function  () {
                clonedItem.detach()
                _super(item)
            })
        },
        onDragStart: function ($item, container, _super) {
            var offset = $item.offset(),
            pointer = container.rootGroup.pointer
            adjustment = {
                left: pointer.left - offset.left,
                top: pointer.top - offset.top
            }
            _super($item, container)
        },
        onDrag: function ($item, position) {
            $item.css({
                left: position.left - adjustment.left,
                top: position.top - adjustment.top
            })
        }

    });

    $('body').on( 'click' , '.ipanel-repeater-title' , function(){
        var _sib = $(this).siblings('.ipanel-repeater-fields').eq(0);
        if( _sib.is(':visible') )
            _sib.slideUp();
        else
            _sib.slideDown();

    });

    $('.ipanel-repeater-option:last-child').addClass('last');

    $('body').on( 'click' , '.ipanel-select-file' , function(){
        $(this).siblings('.ipanel-quick-up-file').trigger('click');
    });


    function iPanel_AjaxFileUpload( _elemnt ){
        _elemnt.each( function(){
            $(this).fileupload({
                limitMultiFileUploads: 1,
                formData: {
                    action: 'ipanel_ajax_request',
                    action2: 'qup',
                    fileID: $(this).attr('name'),
                    security: $.trim( $('#ipanel_ajax_nonce').val() )
                },
                url: iPanelAjax.ajaxurl,
                dataType: 'json',
                start: function (e) {
                    $(this).siblings('.ipanel-qup-progress-bar').slideDown('fast');
                },
                done: function (e, data) {

                    $(this).siblings('.ipanel-qup-progress-bar').slideUp( function(){
                        $(this).find('.text').text('');
                        $(this).find('.percent').width('0');
                    });

                    if( data.result.status == 'error' ){

                        alert( data.result.message );

                    } else if ( data.result.status == 'succeed' ) {

                        $(this).siblings('.ipanel-quick-upload-value').val( $.trim( data.result.url ) );
                        $(this).siblings('.ipanel-quick-upload-filePath').val( $.trim( data.result.path ) );
                        $(this).siblings('.ipanel-quick-upload-file').html( data.result.file_html );
                        $(this).siblings('.ipanel-quick-upload-file').fadeIn();;

                    }


                },
                progressall: function (e, data) {
                    var progress = parseInt( data.loaded / data.total * 100, 10);
                    $(this).siblings('.ipanel-qup-progress-bar').find('.text').text( progress + '%' );
                    $(this).siblings('.ipanel-qup-progress-bar').find('.bar').find('.percent').stop().animate({ 'width' : progress + '%' });
                },
                drop: function (e, data) {
                    return false;
                }
            });
        });
    }
    iPanel_AjaxFileUpload( $('.ipanel-quick-up-file') );

    $('body').on( 'click' , '.ipanel-remove-qup-file' , function(){
        if( confirm( iPanelAjax.confirm_message ) ){
            var _this = $(this);
            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: iPanelAjax.ajaxurl,
                data:{
                    action: 'ipanel_ajax_request',
                    file_path: encodeURI( $(this).closest('.ipanel-input').find('.ipanel-quick-upload-filePath').val() ),
                    action2: 'delete_qup_file',
                    security: $.trim( $('#ipanel_ajax_nonce').val() )
                },
                success: function(data, textStatus, XMLHttpRequest){
                    if( data.status == 'succeed' ){
                        _this.closest('.ipanel-quick-upload-file').slideUp( function(){
                            $(this).html( '' );
                            $('.ipanel-save-settings').trigger( 'click' );
                        });
                        _this.closest('.ipanel-input').find('.ipanel-quick-upload-value').val('');
                        _this.closest('.ipanel-input').find('.ipanel-quick-upload-filePath').val('');
                    } else{
                        alert( data.message );
                    }
                    console.log( data );
                },
                error: function(MLHttpRequest, textStatus, errorThrown){
                    alert( 'ERROR!!' );
                }
            });
        }
        return false;
    });


    // Export Stuff
    $('body').on( 'click' , '.ipanel-highlight-export-code' , function(){
        return false;
    });

    function ipanel_copy_export_to_clipbourd(){
        $(".ipanel-highlight-export-code").each( function(){
            $(this).zclip({
                path: iPanelAjax.assetsurl + "zclip/ZeroClipboard.swf",
                copy: function(){
                    return $(this).siblings('.ipanel-export-value').find('span').html();
                }
            });
        });
    }
    ipanel_copy_export_to_clipbourd();




    // Export Text Selection
    $('body').on( 'mouseenter' , '.ipanel-export-value' , function(){
        $(this).find('span').textSelect('select');
    });




    // Import Stuff
    var _ipanel_import_from_file = false;

    $('.ipanel-import-file').change( function(){
        $(this).parent().parent().find('.ipanel-chosen-filename').text( this.value.split(/(\\|\/)/g).pop() );
        _ipanel_import_from_file = true;
    });

    $('.ipanel-import-file').fileupload({
        limitMultiFileUploads: 1,
        url: iPanelAjax.ajaxurl,
        autoUpload: false,
        dataType: 'json',
        formData: {
            action: 'ipanel_ajax_request',
            action2: 'import',
            panelid: _ipanel_panel_id,
            import_type: 'file',
            security: $.trim( $('#ipanel_ajax_nonce').val() )
        },
        add: function (e, data) {
            ipanel_import_submit = function () {
                return data.submit();
            };
        },
        fail: function (e, data) {
            console.log( data );
            $.unblockUI();
        },
        start: function (e) {
            $.blockUI({
                message: $('#ipanel-canvesLoader'),
                css: {
                    border: 'none',
                    padding: '15px',
                    background: 'none',
                    left: '50%',
                    marginLeft: '-115px',
                    width: '200px',
					'z-index': 100001
                }
            });
        },
        done: function (e, data) {
            console.log( data.result );
            $.unblockUI();
            if( data.result.status == 'succeed' ){
                $('#ipanel-message-box').html('<div class="ipanel-ok-icon"></div> <p class="import-message">'+data.result.message+'</p>').find('p').css('font-size','20px').end().fadeIn();
                setTimeout( function(){
                    location.reload();
                }, 2000);
            } else {
                $('#ipanel-message-box').html('<div class="ipanel-error-icon"></div> <p class="import-message">'+data.result.message+'</p>').find('p').css('font-size','20px').end().fadeIn();
                setTimeout( function(){
                    $('#ipanel-message-box').fadeOut(function(){
                        $(this).html('');
                    });
                }, 2000);
            }
        },
        progressall: function (e, data) {
            var progress = parseInt( data.loaded / data.total * 100, 10);
        },
        drop: function (e, data) {
            return false;
        }
    });


    $('.ipanel-import-button').on('click', function(){
        if( _ipanel_import_from_file === true ) {
            ipanel_import_submit();
        } else if ( $('.ipanel-import-text').eq(0).val().length > 1 ){
            $.blockUI({
                message: $('#ipanel-canvesLoader'),
                css: {
                    border: 'none',
                    padding: '15px',
                    background: 'none',
                    left: '50%',
                    marginLeft: '-115px',
                    width: '200px',
					'z-index': 100001
                }
            });
            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: iPanelAjax.ajaxurl,
                data:{
                    action: 'ipanel_ajax_request',
                    action2: 'import',
                    data: $('.ipanel-import-text').eq(0).val(),
                    import_type: 'code',
                    panelid: _ipanel_panel_id,
                    security: $.trim( $('#ipanel_ajax_nonce').val() )
                },
                success: function(data, textStatus, XMLHttpRequest){
                    $.unblockUI();
                    if( data.status == 'succeed' ){
                        $('#ipanel-message-box').html('<div class="ipanel-ok-icon"></div> <p class="import-message">'+data.message+'</p>').find('p').css('font-size','20px').end().fadeIn();
                        setTimeout( function(){
                            location.reload();
                        }, 2000);
                    } else {
                        $('#ipanel-message-box').html('<div class="ipanel-error-icon"></div> <p class="import-message">'+data.message+'</p>').find('p').css('font-size','20px').end().fadeIn();
                        setTimeout( function(){
                            $('#ipanel-message-box').fadeOut(function(){
                                $(this).html('');
                            });
                        }, 2000);
                    }
                    console.log( data );

                },
                error: function(MLHttpRequest, textStatus, errorThrown){
                    $.unblockUI();
                }
            });

        } else {
            alert( 'You need to enter your code or choose a backup file to import.' );
        }
        return false;
    });


    $('.ipanel-usection > h2').disableSelection();
    $('body').on( 'click' , '.ipanel-usection > h2' , function(){
        if( $(this).siblings('div').eq(0).is(':visible') )
            $(this).siblings('div').eq(0).slideUp( 'normal' , 'easeInOutBack' );
        else
            $(this).siblings('div').eq(0).slideDown( 'normal' , 'easeInOutBack' );
    });

});
