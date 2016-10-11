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
});