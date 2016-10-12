$(function () {
    $.each($('textarea'), function () {
        var offset = this.offsetHeight - this.clientHeight;

        var resizeTextarea = function (el) {
            $(el).css('height', 'auto').css('height', el.scrollHeight + offset);
        };

        $(this).on('keyup input', function () { resizeTextarea(this); });

        resizeTextarea(this);
    });
});