jQuery(document).ready(function ($) {
  $('#wp-form-results-table').submit(function (e) {
    e.preventDefault();
    var page_url = $('#page_url').val();
    var datas = $(this).serializeArray();
    var url = "";

    $.each(datas, function (i, field) {
      var name = field.name;
      var value = field.value;

      if (value != "") {
        url += "&" + name + "=" + value;

        if (name == 'action') {
          var items = [];

          $.each($(".select-item:checked"), function () {
            items.push($(this).val());
          });

          if (items.length > 0) {
            url += "&items=" + items.toString();
          }
        }
      }
    });

    if (page_url != undefined && page_url.length > 0) {
      if (url) {
        window.location.href = page_url + url;
      } else {
        window.location.href = page_url;
      }
    }
  });

  /* WP Media Uploader */
  var _shr_media = true;
  var _orig_send_attachment = wp.media.editor.send.attachment;

  jQuery('.user_avatar-image').click(function () {

    var button = jQuery(this),
      textbox_id = jQuery(this).attr('data-id'),
      image_id = jQuery(this).attr('data-src'),
      _shr_media = true;

    wp.media.editor.send.attachment = function (props, attachment) {
      if (_shr_media && (attachment.type === 'image')) {
        if (image_id.indexOf(",") !== -1) {
          image_id = image_id.split(",");
          $image_ids = '';
          jQuery.each(image_id, function (key, value) {
            if ($image_ids)
              $image_ids = $image_ids + ',#' + value;
            else
              $image_ids = '#' + value;
          });

          var current_element = jQuery($image_ids);
        } else {
          var current_element = jQuery('#' + image_id);
        }

        jQuery('#' + textbox_id).val(attachment.url);
        current_element.attr('src', attachment.url).show();
      } else {
        alert('Please select a valid image file');
        return false;
      }
    }

    wp.media.editor.open(button);
    return false;
  });

});
