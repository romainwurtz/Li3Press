/**
 * Li3Press: A simple blog using Lithium framework
 *
 * @author 			Romain Wurtz (http://www.t3kila.com)
 * @copyright		Copyright 2012, Romain Wurtz (http://www.t3kila.com)
 *
 */

// HELPER
Object.size = function (obj) {
    var size = 0,
        key;
    for (key in obj) {
        if (obj.hasOwnProperty(key)) size++;
    }
    return size;
};

function stringFromArrayClean(data) {
    var out = '<ul>';
    for (var i in data) {
        if (data[i] instanceof Array) out += stringFromArrayClean(data[i]);
        else out += "<li>" + data[i] + "</li>";
    }
    out += '</ul>';
    return out;
}

function generateError(errors) {
    var error = "";
    if (typeof errors == "undefined" || Object.size(errors) == 0) error = "<ul><li>An unexpected error occurred :(</li></ul>";
    else error = stringFromArrayClean(errors);

    return '<div class="alert alert-block alert-error fade in"><button type="button" class="close" data-dismiss="alert">&times;</button><h4 class="alert-heading">Oh snap! You got an error!</h4><p>Error details:' + error + '</p></div>';
}

function postVisibleAction(url, id, status) {
    $.ajaxQueue({
        type: "POST",
        url: url,
        async: true,
        cache: false,
        timeout: 50000,
        data: {
            "id": id,
            "visibility": status,
        },
        success: function (data) {
            if (data && data.success) {
                var group = $('#visible_choice');
                $('.disabled', group).not("#visible_text").removeClass('disabled');
                $('.active', group).not("#visible_text").removeClass('active');
                (status == true) ? $('#visible_off', group).addClass('disabled') : $('#visible_on', group).addClass('disabled');
                $('#content').prepend('<div class="alert alert-block alert-success fade in">\
						<button type="button" class="close" data-dismiss="alert">&times;</button>\
						<h4 class="alert-heading">Well done!</h4>\
						<p>Your changes have been successfully saved.</p></div>');
            } else {
                $('#content').prepend(generateError(data.errors));
            }

        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {}
    });
}

function postDeleteAction(url, id) {
    $.ajaxQueue({
        type: "POST",
        url: url,
        async: true,
        cache: false,
        timeout: 50000,
        data: {
            "id": id,
        },
        success: function (data) {
            if (data) {
                if (data.success) {
                    window.location.replace(data.url);
                } else {
                    $('#content').prepend(generateError(data.errors));
                }
            }
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {}
    });
}

function postEditAction(url, id, title, body) {
    $.ajaxQueue({
        type: "POST",
        url: url,
        async: true,
        cache: false,
        timeout: 50000,
        data: {
            "id": id,
            "title": title,
            "body": body
        },
        success: function (data) {
            if (data && data.success) {
                    $('#content').prepend('<div class="alert alert-block alert-success fade in">\
						<button type="button" class="close" data-dismiss="alert">&times;</button>\
						<h4 class="alert-heading">Well done!</h4>\
						<p>Your changes have been successfully saved.</p></div>');
                } else {
                    $('#content').prepend(generateError(data.errors));
                }
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {}
    });
}