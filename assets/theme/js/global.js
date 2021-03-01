$.urlParam = function (name) {
  var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);

  if (results == null) {
    return null;
  } else {
    return decodeURI(results[1]) || 0;
  }
}

function setCookie(name, value, days) {
  var expires = "";

  if (days) {
    var date = new Date();
    date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
    expires = "; expires=" + date.toUTCString();
  }

  document.cookie = name + "=" + (value || "") + expires + "; path=/";
}

function validURL(str) {
  var pattern = new RegExp('^(https?:\\/\\/)?' +
    '((([a-z\\d]([a-z\\d-]*[a-z\\d])*)\\.)+[a-z]{2,}|' +
    '((\\d{1,3}\\.){3}\\d{1,3}))' +
    '(\\:\\d+)?(\\/[-a-z\\d%_.~+]*)*' +
    '(\\?[;&a-z\\d%_.~+=-]*)?' +
    '(\\#[-a-z\\d_]*)?$', 'i');
  return !!pattern.test(str);
}

function getUrlParameter(sParam) {
  var sPageURL = window.location.search.substring(1),
    sURLVariables = sPageURL.split('&'),
    sParameterName,
    i;

  for (i = 0; i < sURLVariables.length; i++) {
    sParameterName = sURLVariables[i].split('=');

    if (sParameterName[0] === sParam) {
      return sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
    }
  }
};

function goto(url) {
  if (url)
    window.location.href = url;
  else
    return false;
}

function isEmpty(str) {
  return !str.replace(/\s+/, '').length;
}

function ucfirst(str) {
  var text = str;
  var parts = text.split(' '),
    len = parts.length,
    i, words = [];
  for (i = 0; i < len; i++) {
    var part = parts[i];
    var first = part[0].toUpperCase();
    var rest = part.substring(1, part.length);
    var word = first + rest;
    words.push(word);
  }

  return words.join(' ');
};

function randomString(length) {
  var text = "";
  var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

  for (var i = 0; i < length; i++)
    text += possible.charAt(Math.floor(Math.random() * possible.length));

  return text;
}

function notifySuccess(message, params) {
  var notifyTitle = 'Bildirim';
  var notifyTimeout = 3000;

  if (typeof params === 'object' && params !== null) {
    if (params.title != undefined && params.title != '') {
      notifyTitle = params.title;
    }

    if (!isNaN(params.timeout) && params.timeout > 0) {
      notifyTimeout = params.timeout;
    }
  } else if (!isNaN(params) && params > 0) {
    notifyTimeout = params;
  } else if (params != undefined && params != '') {
    notifyTitle = params;
  }

  $.notify({
    title: notifyTitle,
    body: message,
    icon: 'fa fa-check-circle',
    id: 'notify-success',
    timeout: notifyTimeout
  });
}

function notifyError(message, params) {
  var notifyTitle = 'Uyarı';
  var notifyTimeout = 3000;

  if (typeof params === 'object' && params !== null) {
    if (params.title != undefined && params.title != '') {
      notifyTitle = params.title;
    }

    if (!isNaN(params.timeout) && params.timeout > 0) {
      notifyTimeout = params.timeout;
    }
  } else if (!isNaN(params) && params > 0) {
    notifyTimeout = params;
  } else if (params != undefined && params != '') {
    notifyTitle = params;
  }

  if (message != '') {
    $.notify({
      title: notifyTitle,
      body: message,
      icon: 'fa fa-exclamation-circle',
      id: 'notify-error',
      timeout: notifyTimeout,
    });
  } else {
    $.notify({
      title: notifyTitle,
      body: ajax_error_msg,
      icon: 'fa fa-exclamation-circle',
      id: 'notify-error',
      timeout: notifyTimeout,
    });
  }
}

function notifyShow(title, message, icon, id, timeout) {
  var notifyTimeout = 3000;

  if (!isNaN(timeout) && timeout > 0) {
    var notifyTimeout = timeout;
  }

  $.notify({
    title: title,
    body: message,
    icon: icon,
    id: id,
    timeout: notifyTimeout
  });
}

function setFormError(formid, value_id) {
  if (formid && value_id) {
    $(formid + ' ' + value_id).each(function () {
      $(this).addClass('form-error');
    });
  }
}

function clearForm(formid) {
  if (formid) {
    $(formid + ' input[type="text"]').each(function () {
      $(this).val('');
    });

    $(formid + ' input[type="email"]').each(function () {
      $(this).val('');
    });

    $(formid + ' input[type="number"]').each(function () {
      $(this).val('');
    });

    $(formid + ' input[type="password"]').each(function () {
      $(this).val('');
    });
  }
}

function clearFormError(formid) {
  $('.form-error').each(function () {
    $(this).removeClass('form-error');
  });
}

function getExcerpt(str, limit) {
  var fullText = str;
  var shortText = str;
  shortText = shortText.substr(0, shortText.lastIndexOf(' ', limit)) + '...';

  var returnString = {
    fullText: fullText,
    shortText: shortText
  };

  return returnString;
}

function screenSizeToggle() {
  var width = $(window).width();

  if (width >= 1200) {
    sdevice = 'xl';
  }

  if (width < 1200 && width >= 992) {
    sdevice = 'lg';
  }

  if (width < 992 && width >= 768) {
    sdevice = 'md';
  }

  if (width < 768 && width >= 576) {
    sdevice = 'sm';
  }

  if (width < 576) {
    sdevice = 'xs';
  }

  sdwidth = width;
}

$(window).on('resize', function () {
  screenSizeToggle();
});

$(document).ready(function () {
  screenSizeToggle();

  $('#scrollToTop').click(function () {
    $('html, body').animate({ scrollTop: 0 }, 'slow');
    return false;
  });

  $('[data-email]').each(function () {
    var email = $(this).attr('data-email');

    if (email != undefined && email != '') {
      $(this).attr('href', 'mailto:'+ email);
    }
  });

  $('[data-phone]').each(function () {
    var phone = $(this).attr('data-phone');

    if (phone != undefined && phone != '') {
      $(this).attr('href', 'tel:'+ phone);
    }
  });

  $('[data-parallax]').each(function () {
    var image_url = $(this).attr('data-parallax');

    if (image_url != undefined && image_url != '') {
      $(this).css('background-image', 'url('+ image_url + ')');
    }
  });

  $("textarea[data-maxlength]").on("propertychange input", function () {
    var thislength = $(this).val().length;
    var maxlength = parseInt($(this).data('maxlength'));
    var $counter = $(this).parent().find('.maxlength-counter em');

    if (!isNaN(maxlength) && thislength > maxlength) {
      this.value = this.value.substring(0, maxlength);
    }

    if ($counter != undefined && $counter.length > 0) {
      var lt = maxlength - thislength;

      if (lt > 0) {
        $counter.text(lt);
      } else {
        $counter.text('0');
      }
    }
  });

  $('[data-num]').click(function () {
    var type = $(this).data('num');
    var $input = $(this).parent().children('input');
    var number = parseInt($input.val());

    if (type == 'minus') {
      $input.val(number - 1);
    } else if (type == 'plus') {
      $input.val(number + 1);
    }
  });

  $('.custom-file-input').change(function () {
    var file = $(this)[0].files[0];

    if (file != undefined && file.name != undefined && file != '') {
      var $label = $(this).parent().children('.custom-file-label');
      $label.text(file.name);
    }
  });
});
