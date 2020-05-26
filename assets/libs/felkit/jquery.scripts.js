$(document).ready(function () {
    felKitTab();
    felKitDropdown();
});

function felKitTab() {
    $('[fk-tab-btn]').on('click', function () {
        if (!$(this).hasClass('active')) {
            var tab = $(this).attr('fk-tab-btn');
            var $parent = $(this).closest('[fk-tabs]');
            var $tab = $parent.find('[fk-tab-item="' + tab + '"]');
            var animate = $(this).attr('data-animate');
            var effect = $(this).attr('data-effect');

            if ($tab != undefined && $tab.length > 0) {
                $parent.find('.tab-btn').removeClass('active');
                $parent.find('.tab-content').removeClass('active');

                $(this).addClass('active');
                $parent.find('.tab-content').stop().hide();

                if (animate != undefined && animate != '') {
                    $parent.find('.tab-content').removeClass('animated ' + animate);
                    $tab.stop().addClass('animated ' + animate).show();
                } else if (effect != undefined && effect != '') {
                    if (effect == 'slideDown') {
                        $tab.stop().slideDown(400);
                    } else if (effect == 'fadeIn') {
                        $tab.stop().fadeIn(400);
                    } else {
                        $tab.stop().show();
                    }
                } else {
                    $tab.stop().fadeIn(400);
                }
            }
        }
    });
}

function felKitDropdown() {
    $(document).on('mouseup', function (e) {
        var $items = $('.fk-dropdown-show');

        if ($items != undefined && $items.length > 0) {
            $items.each(function () {
                var container = $(this).closest('[fk-dropdown]');

                if (!container.is(e.target) && container.has(e.target).length === 0) {
                    $(this).fadeOut(200).removeClass('fk-dropdown-show');
                }
            });
        }
    });

    $('[fk-dropdown-click]').on('click', function () {
        var $parent = $(this).closest('[fk-dropdown]');
        var item = $(this).attr('fk-dropdown-click');
        var $item = $parent.find(item);

        if ($item != undefined && $item.length > 0) {
            if ($item.css('display') != 'none') {
                $item.stop().fadeOut(200).removeClass('fk-dropdown-show');
            } else {
                $item.stop().fadeIn(300).addClass('fk-dropdown-show');
            }
        }
    });

    $('[fk-dropdown-hover]').on('mouseenter', function (e) {
        var $parent = $(this).closest('[fk-dropdown]');
        var item = $(this).attr('fk-dropdown-hover');
        var $item = $parent.find(item);

        if ($item != undefined && $item.length > 0) {
            $item.stop().fadeIn(300).addClass('fk-dropdown-hover-show');
            $parent.addClass('fk-dropdown-hover-on');
        }
    });

    $(document).on('mouseleave', '.fk-dropdown-hover-on', function (e) {
        var $item = $(this).find('.fk-dropdown-hover-show');
        $item.stop().fadeOut(200).removeClass('fk-dropdown-hover-show');
        $(this).removeClass('fk-dropdown-hover-on');
    });
}