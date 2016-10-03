var wowhead_tooltips = { "colorlinks": true, "iconizelinks": true, "renamelinks": true };

$(function () {
    $('.role-list li[data-toggle="tooltip"]').tooltip({
        animation: false,
        html: true,
        placement: "left"
    });

    $('[data-toggle="tooltip"]').tooltip({
        animation: false,
        placement: "bottom"
    });
});