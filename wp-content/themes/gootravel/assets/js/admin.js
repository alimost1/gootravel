/**
 * GooTravel Admin JavaScript
 * Handles media uploader for taxonomy images
 */

(function ($) {
    'use strict';

    $(document).ready(function () {
        var mediaUploader;

        // Upload Image Button
        $(document).on('click', '.gootravel-upload-image', function (e) {
            e.preventDefault();

            var $button = $(this);
            var $wrapper = $('#location-image-wrapper');
            var $input = $('#location_image');
            var $removeBtn = $('.gootravel-remove-image');

            // If the media uploader already exists, open it
            if (mediaUploader) {
                mediaUploader.open();
                return;
            }

            // Create the media uploader
            mediaUploader = wp.media({
                title: 'Select Location Image',
                button: {
                    text: 'Use this image'
                },
                multiple: false
            });

            // When an image is selected
            mediaUploader.on('select', function () {
                var attachment = mediaUploader.state().get('selection').first().toJSON();

                // Update the hidden input with the attachment ID
                $input.val(attachment.id);

                // Show the image preview
                $wrapper.html('<img src="' + attachment.sizes.thumbnail.url + '" style="max-width: 150px; height: auto; margin-bottom: 10px; display: block;">');

                // Show the remove button
                $removeBtn.show();
            });

            // Open the uploader
            mediaUploader.open();
        });

        // Remove Image Button
        $(document).on('click', '.gootravel-remove-image', function (e) {
            e.preventDefault();

            var $wrapper = $('#location-image-wrapper');
            var $input = $('#location_image');
            var $removeBtn = $(this);

            // Clear the hidden input
            $input.val('');

            // Remove the image preview
            $wrapper.html('');

            // Hide the remove button
            $removeBtn.hide();
        });

        // Reset form after adding new term (AJAX)
        $(document).ajaxComplete(function (event, xhr, settings) {
            if (settings.data && settings.data.indexOf('action=add-tag') !== -1) {
                $('#location_image').val('');
                $('#location-image-wrapper').html('');
                $('.gootravel-remove-image').hide();
            }
        });

        // =============================================
        // TOUR GALLERY
        // =============================================

        function updateGalleryInput() {
            var ids = [];
            $('#gootravel-gallery-thumbs .gootravel-gallery-thumb').each(function () {
                ids.push($(this).data('id'));
            });
            $('#gootravel_gallery').val(ids.join(','));
        }

        // Make gallery sortable
        if ($('#gootravel-gallery-thumbs').length) {
            $('#gootravel-gallery-thumbs').sortable({
                placeholder: 'gootravel-gallery-thumb ui-sortable-placeholder',
                tolerance: 'pointer',
                cursor: 'move',
                update: function () {
                    updateGalleryInput();
                }
            });
        }

        // Add gallery images
        $(document).on('click', '.gootravel-gallery-add', function (e) {
            e.preventDefault();

            var galleryFrame = wp.media({
                title: 'Select Gallery Images',
                button: { text: 'Add to Gallery' },
                multiple: true,
                library: { type: 'image' }
            });

            galleryFrame.on('select', function () {
                var selection = galleryFrame.state().get('selection');
                selection.each(function (attachment) {
                    var data = attachment.toJSON();
                    var thumbUrl = data.sizes && data.sizes.thumbnail ? data.sizes.thumbnail.url : data.url;
                    var html = '<div class="gootravel-gallery-thumb" data-id="' + data.id + '">';
                    html += '<img src="' + thumbUrl + '" alt="">';
                    html += '<button type="button" class="gootravel-gallery-remove">&times;</button>';
                    html += '</div>';
                    $('#gootravel-gallery-thumbs').append(html);
                });
                updateGalleryInput();
            });

            galleryFrame.open();
        });

        // Remove single gallery image
        $(document).on('click', '.gootravel-gallery-remove', function (e) {
            e.preventDefault();
            e.stopPropagation();
            $(this).closest('.gootravel-gallery-thumb').fadeOut(200, function () {
                $(this).remove();
                updateGalleryInput();
            });
        });

    });

})(jQuery);
