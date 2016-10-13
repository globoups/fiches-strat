var blocTypes = [".info-bloc-line", ".info-bloc", ".wrapper-bloc"];
var roles = ["tank", "heal", "dps"];

function buildBloc(element) {
    var blocType = getBlocType(element);
    var bloc;

    switch (blocType) {
        case 1:
            bloc = buildWrapperBloc(element);
            break;
        case 2:
            bloc = buildInfoBloc(element);
            break;
        case 3:
            bloc = buildInfoBlocLine(element);
            break;
        default:
            break;
    }

    return bloc;
}

function buildCard() {
    var card = {
        blocs: [],
        boss_key: $("input[name=boss]").val(),
        difficulty_key: $("input[name=difficulty]").val(),
        role_key: $("input[name=role]").val()
    };
    var order = 0;

    $("#card-content").children(".info-bloc, .wrapper-bloc").each(function () {
        var bloc = buildBloc($(this));
        bloc.order = ++order;
        card.blocs.push(bloc);
    });

    return card;
}

function buildInfoBloc(element) {
    var children = [];
    var order = 0;

    element.children(".list-group").first().children(".info-bloc-line").each(function () {
        var child = buildInfoBlocLine($(this));
        child.order = ++order;
        children.push(child);
    });

    var bloc = {
        children: children,
        content: element.find("input[type=text]").first().val(),
        order: 0,
        roles: null,
        type: 2
    };

    return bloc;
}

function buildInfoBlocLine(element) {
    var roles = [];

    element.find(".toggle-role").each(function () {
        var role = getRole($(this));

        if ($(this).hasClass("enabled")) {
            roles.push(role);
        }
    });

    var bloc = {
        children: null,
        content: element.find("textarea").first().val(),
        order: 0,
        roles: roles,
        type: 3
    };

    return bloc;
}

function buildWrapperBloc(element) {
    var children = [];
    var order = 0;

    element.find(".panel-body").first().children(".info-bloc").each(function () {
        var child = buildInfoBloc($(this));
        child.order = ++order;
        children.push(child);
    });

    var bloc = {
        children: children,
        content: element.find("input[type=text]").first().val(),
        order: 0,
        roles: null,
        type: 1
    };

    return bloc;
}

function getBlocType(element) {
    var result;

    if (element.hasClass("wrapper-bloc")) {
        result = 1;
    }
    else if (element.hasClass("info-bloc")) {
        result = 2;
    }
    else if (element.hasClass("info-bloc-line")) {
        result = 3;
    }

    return result;
}

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

function getRole(element) {
    var result;

    for (i = 0; i < roles.length; i++) {
        if (element.hasClass(roles[i])) {
            result = (roles[i]);
        }
    }

    return result;
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

    $(".save").click(function () {
        var btn = $(this);
        btn.addClass("disabled");

        var card = buildCard();
        var data = JSON.stringify(card);

        $.ajax({
            url: "./svc/editcard.php",
            method: "POST",
            contentType: "application/json;charset=utf-8",
            dataType: "json",
            data: data
        })
        .done(function (result) {
            alert(result);
        })
        .fail(function () {
            alert("failed");
        })
        .always(function () {
            btn.removeClass("disabled");
        });
    });

    $(".toggle-role").click(function () {
        var role = getRole($(this));

        $(this).toggleClass("enabled disabled");
        $(this).toggleClass("role-" + role + "-32 role-" + role + "-disabled-32");
    });
});