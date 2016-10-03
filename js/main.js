var wowhead_tooltips = { "colorlinks": true, "iconizelinks": true, "renamelinks": true };

$(function () {
    $('li[data-toggle="tooltip"]').tooltip({
        animation: false,
        html: true,
        placement: "left"
    });
});