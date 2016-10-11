var wowhead_tooltips = { "colorlinks": true, "iconizelinks": true, "renamelinks": true };

$(function () {
    $('.role-item[data-toggle="tooltip"]').tooltip({
        animation: false,
        container: ".container",
        html: true,
        placement: "left"
    });

    $('[data-toggle="tooltip"]').tooltip({
        animation: false,
        container: ".container",
        placement: "bottom"
    });

    $.each($('textarea'), function () {
        var offset = this.offsetHeight - this.clientHeight;

        var resizeTextarea = function (el) {
            $(el).css('height', 'auto').css('height', el.scrollHeight + offset);
        };

        $(this).on('keyup input', function () { resizeTextarea(this); });

        resizeTextarea(this);
    });
});