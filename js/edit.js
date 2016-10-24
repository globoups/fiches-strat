var blocTypes = [".info-item", ".schema-item", ".info-bloc", ".schema-bloc", ".wrapper-bloc"];
var roles = ["rl", "tank", "heal", "dps"];

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
            bloc = buildInfoItem(element);
            break;
        case 4:
            bloc = buildSchemaBloc(element);
            break;
        case 5:
            bloc = buildSchemaItem(element);
            break;
        default:
            break;
    }

    return bloc;
}

function buildCard() {
    var card = {
        blocs: [],
        bossKey: $("input[name=boss]").val(),
        difficultyKey: $("input[name=difficulty]").val(),
        roleKey: $("input[name=role]").val()
    };
    var order = 0;

    $("#card-content").children(".info-bloc, .schema-bloc, .wrapper-bloc").each(function () {
        var bloc = buildBloc($(this));
        bloc.order = ++order;
        card.blocs.push(bloc);
    });

    return card;
}

function buildInfoBloc(element) {
    var children = [];
    var order = 0;

    element.children(".list-group").first().children(".info-item").each(function () {
        var child = buildInfoItem($(this));
        child.order = ++order;
        children.push(child);
    });

    var bloc = {
        children: children,
        content: element.find("input[type=text]").first().val(),
        order: 0,
        roleKeys: null,
        type: 2
    };

    return bloc;
}

function buildInfoItem(element) {
    var roleKeys = [];

    element.find(".toggle-role").each(function () {
        var roleKey = getRole($(this));

        if ($(this).hasClass("enabled")) {
            roleKeys.push(roleKey);
        }
    });

    var bloc = {
        children: null,
        content: element.find("textarea").first().val(),
        order: 0,
        roleKeys: roleKeys,
        type: 3
    };

    return bloc;
}

function buildSchemaBloc(element) {
    var children = [];
    var order = 0;

    element.children(".list-group").first().children(".schema-item").each(function () {
        var child = buildSchemaItem($(this));
        child.order = ++order;
        children.push(child);
    });

    var bloc = {
        children: children,
        content: element.find("input[type=text]").first().val(),
        order: 0,
        roleKeys: null,
        type: 4
    };

    return bloc;
}

function buildSchemaItem(element) {
    var title = element.find("input[type=text]").eq(0).val();
    var url = element.find("input[type=text]").eq(1).val();
    var content = "[schema:" + title + "|" + url + "]";

    var bloc = {
        children: null,
        content: content,
        order: 0,
        roleKeys: null,
        type: 5
    };

    return bloc;
}

function buildWrapperBloc(element) {
    var children = [];
    var order = 0;

    element.find(".panel-body").first().children(".info-bloc, .schema-bloc").each(function () {
        var child = buildBloc($(this));
        child.order = ++order;
        children.push(child);
    });

    var bloc = {
        children: children,
        content: element.find("input[type=text]").first().val(),
        order: 0,
        roleKeys: null,
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
    else if (element.hasClass("info-item")) {
        result = 3;
    }
    else if (element.hasClass("schema-bloc")) {
        result = 4;
    }
    else if (element.hasClass("schema-item")) {
        result = 5;
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

function getTextareaOffset() {
    var dummy = $("<textarea></textarea>");
    dummy.css({ opacity: 0, position: "absolute" });
    $("body").append(dummy);
    var result = dummy[0].offsetHeight - dummy[0].clientHeight;
    dummy.remove();

    return result;
}

$(function () {
    var emptyWrapperBloc = $(".empty-blocs > .wrapper-bloc");
    var emptyInfoBloc = $(".empty-blocs > .info-bloc");
    var emptyInfoItem = $(".empty-blocs > .info-item");
    var emptySchemaBloc = $(".empty-blocs > .schema-bloc");
    var emptySchemaItem = $(".empty-blocs > .schema-item");
    var textareaOffset = getTextareaOffset();

    $.each($("textarea"), function () {
        var resizeTextarea = function (el) {
            $(el).css("height", "auto").css("height", el.scrollHeight + textareaOffset);
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

    $(".add-info-item").click(function () {
        $(this).parent().before(emptyInfoItem.clone(true));
    });

    $(".add-schema-bloc").click(function () {
        $(this).parent().before(emptySchemaBloc.clone(true));
    });

    $(".add-schema-item").click(function () {
        $(this).parent().before(emptySchemaItem.clone(true));
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
        $("#modalSaving").modal();

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
            if (result.status == "success") {
                $("#modalSaveSuccess").modal();
            }
            else if (result.status == "error" && result.errorCode == 2) {
                $("#modalSaveFailNotAuthenticated").modal();
            }
            else {
                $("#modalSaveFail").modal();
            }
        })
        .fail(function () {
            $("#modalSaveFail").modal();
        })
        .always(function () {
            $("#modalSaving").modal("hide");
            btn.removeClass("disabled");
        });
    });

    $(".toggle-role").click(function () {
        var role = getRole($(this));

        $(this).toggleClass("enabled disabled");
        $(this).toggleClass("role-" + role + "-32 role-" + role + "-disabled-32");
    });
});