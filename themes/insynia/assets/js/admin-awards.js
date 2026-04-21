(function ($) {
	'use strict';

	function renderPreview($wrap, ids) {
		$wrap.empty();
		if (!ids.length) {
			return;
		}

		ids.forEach(function (id) {
			var attachment = wp.media.attachment(id);
			attachment.fetch().then(function () {
				var image = attachment.get('sizes');
				var thumbUrl = image && image.thumbnail ? image.thumbnail.url : attachment.get('url');
				if (!thumbUrl) {
					return;
				}

				var $item = $('<div />', { class: 'bh-award-admin__preview-item' });
				$item.append($('<img />', { src: thumbUrl, alt: '' }));
				$wrap.append($item);
			});
		});
	}

	$(function () {
		var frame = null;

		$('.bh-award-admin').each(function () {
			var $container = $(this);
			var $input = $container.find('.bh-award-admin__ids');
			var $preview = $container.find('.bh-award-admin__preview');

			var currentIds = ($input.val() || '')
				.split(',')
				.map(function (id) {
					return parseInt(id, 10);
				})
				.filter(function (id) {
					return !isNaN(id) && id > 0;
				});

			renderPreview($preview, currentIds);

			$container.on('click', '.bh-award-admin__choose', function (event) {
				event.preventDefault();

				if (frame) {
					frame.open();
					return;
				}

				frame = wp.media({
					title: 'Select award images',
					button: { text: 'Use selected images' },
					multiple: true,
					library: { type: 'image' }
				});

				frame.on('select', function () {
					var ids = frame.state().get('selection').toJSON().map(function (attachment) {
						return attachment.id;
					});
					$input.val(ids.join(','));
					renderPreview($preview, ids);
				});

				frame.open();
			});

			$container.on('click', '.bh-award-admin__clear', function (event) {
				event.preventDefault();
				$input.val('');
				$preview.empty();
			});
		});
	});
})(jQuery);
