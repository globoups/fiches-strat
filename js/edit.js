var blocTypes = [".info-bloc-line", ".info-bloc", ".wrapper-bloc"];

function getNextBloc(bloc) {
    var blocType;
    var nextBloc;
    var i = 0;

    do {
        blocType = blocTypes[i];
        nextBloc = bloc.next(blocType);
        i++;
    } while (nextBloc.length == 0 && i < blocTypes.length)

    return nextBloc;
}

function getParentBloc(element) {
    var blocType;
    var parentBloc;
    var i = 0;

    do {
        blocType = blocTypes[i];
        parentBloc = element.parents(blocType);
        i++;
    } while (parentBloc.length == 0 && i < blocTypes.length)

    return parentBloc;
}

function getPreviousBloc(bloc) {
    var blocType;
    var previousBloc;
    var i = 0;

    do {
        blocType = blocTypes[i];
        previousBloc = bloc.prev(blocType);
        i++;
    } while (previousBloc.length == 0 && i < blocTypes.length)

    return previousBloc;
}

$(function () {
    var emptyWrapperBloc = $(".empty-blocs > .wrapper-bloc");
    var emptyInfoBloc = $(".empty-blocs > .info-bloc");
    var emptyInfoBlocLine = $(".empty-blocs > .info-bloc-line");

    $.each($("textarea"), function () {
        var offset = this.offsetHeight - this.clientHeight;

        var resizeTextarea = function (el) {
            $(el).css("height", "auto").css("height", el.scrollHeight + offset);
        };

        $(this).on("keyup input", function () { resizeTextarea(this); });

        if ($(this).parents(".empty-blocs").length == 0) {
            resizeTextarea(this);
        }
    });

    $(".add-wrapper-bloc").click(function () {
        $(this).parent().before(emptyWrapperBloc.clone(true));
    });

    $(".add-info-bloc").click(function () {
        $(this).parent().before(emptyInfoBloc.clone(true));
    });

    $(".add-info-bloc-line").click(function () {
        $(this).parent().before(emptyInfoBlocLine.clone(true));
    });

    $(".delete").click(function () {
        var currentBloc = getParentBloc($(this));

        if (confirm("Toute modification sera perdue. Continuer ?")) {
            currentBloc.remove();
        }
    });

    $(".move-down").click(function () {
        var currentBloc = getParentBloc($(this));
        var nextBloc = getNextBloc(currentBloc);

        if (nextBloc.length == 1) {
            currentBloc.detach();
            nextBloc.after(currentBloc);
        }
    });

    $(".move-up").click(function () {
        var currentBloc = getParentBloc($(this));
        var previousBloc = getPreviousBloc(currentBloc);

        if (previousBloc.length == 1) {
            currentBloc.detach();
            previousBloc.before(currentBloc);
        }
    });
});