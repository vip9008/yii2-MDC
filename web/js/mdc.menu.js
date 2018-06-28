function mdc_close_menus() {
    $('.mdc-menu-container.active').removeClass('active').find('.menu-button').removeClass('active');
}

function mdc_close_menu(selector) {
    $(selector).removeClass('active').find('.menu-button').removeClass('active');
}

$(document).ready(function() {
    $('html').on(md_click_event, function(event) {
        $('.mdc-menu-container.active').removeClass('active').find('.menu-button').removeClass('active');
    });

    $('body').on(md_click_event, '.mdc-menu-container .mdc-list-container', function(event) {
        event.stopPropagation();
    });

    $('body').on(md_click_event, '.mdc-menu-container .menu-button', function(event) {
        event.stopPropagation();

        var menu_container = $(this).closest('.mdc-menu-container');

        if ($(menu_container).hasClass('active')) {
            $(menu_container).removeClass('active');
            $(this).removeClass('active');
            return false;
        }

        $('.mdc-menu-container.active').removeClass('active').find('.menu-button').removeClass('active');

        $(menu_container).removeClass('bottom reverse');

        if ($(this).hasClass('disabled') || $(this).is(':disabled')) {
            return false;
        }

        var viewport_width = window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth;
        var viewport_height = window.innerHeight || document.documentElement.clientHeight || document.body.clientHeight;

        var menu = $(menu_container).find('.mdc-list-container');
        var menu_height = $(menu).outerHeight();
        var menu_width = $(menu).outerWidth();
        var menu_position = $(menu)[0].getBoundingClientRect();

        if ((menu_position.top + menu_height) > viewport_height) {
            $(menu_container).addClass('bottom');
        }

        if (parseInt($(menu).css('left')) == 0) {
            if ((menu_position.left + menu_width) > viewport_width) {
                $(menu_container).addClass('reverse');
            }
        } else {
            if ((menu_position.right - menu_width) < 0) {
                $(menu_container).addClass('reverse');
            }
        }

        $(menu_container).addClass('active').find('.mdc-list-container').focus();
        $(this).addClass('active');
    });

    $('body').on('blur', '.mdc-menu-container.select-menu .mdc-list-container', function (event) {
        $(this).closest('.mdc-menu-container').removeClass('active');
    });

    $('body').on(md_click_event, '.mdc-menu-container.select-menu .mdc-list-container button.mdc-list-item, .mdc-menu-container.select-menu .mdc-list-container a.mdc-list-item, .mdc-menu-container.select-menu .mdc-list-container .mdc-list-item.interactive', function(event) {
        var container = $(this).closest('.select-menu');

        if ($(this).hasClass('selected')) {
            mdc_close_menu(container);
            return false;
        } else {
            $(container).find('.mdc-list-item.selected').removeClass('selected');
        }

        var value = $(this).addClass('selected').attr('data-value');
        var text = $(this).children('.text').text();
        var input = $(container).children('.mdc-text-field').children('.input');

        if ($(input).prop("tagName").toLowerCase() == 'input') {
            $(input).val(text);
        } else {
            $(input).text(text);
        }

        if (text.length) {
            $(container).children('.mdc-text-field').addClass('focus');
        } else {
            $(container).children('.mdc-text-field').removeClass('focus');
        }

        $(container).children('.mdc-text-field').children('.select-value').val(value);
        mdc_close_menu(container);
    });
});