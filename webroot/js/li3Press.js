/**
 * Li3Press: A CMS with the Lithium (Li3) framework
 *
 * @author 			Romain Wurtz (http://www.t3kila.com)
 * @copyright		Copyright 2012, Romain Wurtz (http://www.t3kila.com)
 *
 */

var _alertTimer = {};

function stringFromArrayClean(data) {
    var out = '<ul>';
    for (var i in data) {
        if (data[i] instanceof Array) out += stringFromArrayClean(data[i]);
        else out += "<li>" + data[i] + "</li>";
    }
    out += '</ul>';
    return out;
}

function displayClearErrors() {
    $(".alert").fadeOut('slow', function () {
        $(this).remove();
    });
    return false;
}

function generateErrorNotice(errors) {
    var error = "";
    var title = "Oh snap!";

    if (errors != null && typeof errors != "undefined" && typeof errors['_title'] != "undefined") {
        title = errors['_title'];
        delete errors['_title'];
    } //else title += " You got an error!";
    if (errors != null && typeof errors == "undefined" || !errors || errors.length == 0) error = "<ul><li>An unexpected error occurred :(</li></ul>";
    else error = stringFromArrayClean(errors);
    return '<div class="alert alert-block alert-error fade in">\
    <button type="button" class="close" data-dismiss="alert">&times;</button>\
    <h4 class="alert-heading">' + title + '</h4>\
    <p>Error details:' + error + '</p></div>';
}

function generateSuccessNotice(details) {
    var title = "Well done!";
    var notice = "";
    var output = "";

    if (details != null && typeof details != "undefined" && typeof details['_title'] != "undefined") {
        title = details['_title'];
        delete details['_title'];
    }
    if (details != null && typeof details != "undefined" && typeof details['_desc'] != "undefined") {
        notice = details['_desc'];
        delete details['_desc'];
    } //else notice = 'Your changes have been successfully made.';
    output = '<div class="alert alert-block alert-success fade in">\
    <button type="button" class="close" data-dismiss="alert">&times;</button>\
     <h4 class="alert-heading">' + title + '</h4>';
    if (notice != '') output += '<p>' + notice + '</p></div>';
    return output;
}

function displaySuccessNotice(details, element) {
    if (element == null || element) element = $(".alert-area");
    if (_alertTimer && typeof _alertTimer[$(element)] != "undefined") {
        clearTimeout(_alertTimer[$(element)]);
        delete _alertTimer[$(element)];
    };
    $(element).stop(true, true).fadeOut('slow', function () {
        $(this).empty();
        $(generateSuccessNotice(details)).prependTo(this)
        $(this).fadeIn("slow");
        _alertTimer[$(this)] = setTimeout(function () {
            $(element).fadeOut("slow");
        }, 8000);
    });
    return false;
}

function displayErrorNotice(errors, element) {
    if (element == null || element) element = $(".alert-area");
    if (_alertTimer && typeof _alertTimer[$(element)] != "undefined") {
        clearTimeout(_alertTimer[$(element)]);
        delete _alertTimer[$(element)];
    };
    $(element).stop(true, true).fadeOut('slow', function () {
        $(this).empty();
        $(generateErrorNotice(errors)).prependTo(this);
        $(this).fadeIn("slow");
        _alertTimer[$(this)] = setTimeout(function () {
            $(element).fadeOut("slow");
        }, 8000);
    });
    return false;
}

function postAddAction(url, title, body) {
    $.ajaxQueue({
        type: "POST",
        url: url,
        async: true,
        cache: false,
        timeout: 50000,
        data: {
            "title": title,
            "body": body
        },
        success: function (data) {
            if (data) {
                if (data.success) {
                    window.location.replace(data.url);
                } else displayErrorNotice(data.errors, null);
            } else displayErrorNotice(null, null);
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            displayErrorNotice({
                'URL': "This url is not defined or does not exist."
            }, null);
        }
    });
    return false;
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
            "visibility": status
        },
        success: function (data) {
            if (data) {
                if (data.success) {
                    var group = $('#visible_choice');
                    $('.disabled', group).not("#visible_text").removeClass('disabled');
                    $('.active', group).not("#visible_text").removeClass('active');
                    (status == true) ? $('#visible_off', group).addClass('disabled') : $('#visible_on', group).addClass('disabled');
                    displaySuccessNotice(null, null);
                } else displayErrorNotice(data.errors, null);
            } else displayErrorNotice(null, null);
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            displayErrorNotice({
                'URL': "This url is not defined or does not exist."
            }, null);
        }
    });
    return false;
}

function postDeleteAction(url, id, callback) {
    $.ajaxQueue({
        type: "POST",
        url: url,
        async: true,
        cache: false,
        timeout: 50000,
        data: {
            "id": id
        },
        success: function (data) {
            if (data) {
                if (data.success) {
                    if (callback && $.isFunction(callback)) callback();
                    else window.location.replace(data.url);
                } else displayErrorNotice(data.errors, null);
            } else displayErrorNotice(null, null);
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            displayErrorNotice({
                'URL': "This url is not defined or does not exist."
            }, null);
        }
    });
    return false;
}

function postEditAction(url, id, title, body) {
    $.ajaxQueue({
        type: "GET",
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
            if (data) {
                if (data.success) {
                    displaySuccessNotice(null, null);
                } else displayErrorNotice(data.errors, null);
            } else displayErrorNotice(null, null);
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            displayErrorNotice({
                'URL': "This url is not defined or does not exist."
            }, null);
        }
    });
    return false;
}

function postsIndexAction(url, page, callback) {
    var posts = null;
    $.ajax({
        dataType: "html",
        url: url + page + '.ajax',
        success: function (data) {
            if (data) {
                posts = data;
            } else displayErrorNotice(null, null);
        },
        complete: function () {
            if (callback && $.isFunction(callback)) callback(posts);
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            displayErrorNotice({
                'URL': "This url is not defined or does not exist."
            }, null);
        }
    });
    return false;
}

function commentsListAction(url, callback) {
    var posts = null;
    $.ajax({
        dataType: "html",
        url: url,
        success: function (data) {
            if (data) {
                posts = data;
            }
        },
        complete: function () {
            if (callback && $.isFunction(callback)) callback(posts);
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            displayErrorNotice({
                'URL': "This url is not defined or does not exist."
            }, null);
        }
    });
    return false;
}

function commentAddAction(values, callback) {
    $.ajaxQueue({
        type: "POST",
        url: values.url,
        async: true,
        cache: false,
        timeout: 50000,
        data: {
            "id": values.id,
            "name": values.name,
            "email": values.email,
            "website": values.website,
            "body": values.body,
            "captcha": values.captcha
        },
        success: function (data) {
            var status = false;

            if (data) {
                if (data.success) {
                    status = true;
                } else displayErrorNotice(data.details, null);
            } else displayErrorNotice(null, null);
            if (callback && $.isFunction(callback)) callback(data);
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            displayErrorNotice({
                'URL': "This url is not defined or does not exist."
            });
        }
    });
    return false;
}

function commentDetailsAction(values, callback) {
    $.ajaxQueue({
        type: "GET",
        url: values.url,
        async: true,
        cache: false,
        timeout: 50000,
        success: function (data) {
            var status = false;

            if (!data) {
                displayErrorNotice(null, null);
            }
            if (callback && $.isFunction(callback)) callback(data);
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            displayErrorNotice({
                'URL': "This url is not defined or does not exist."
            });
        }
    });
    return false;
}

function postDeleteAction(values, callback) {
    $.ajaxQueue({
        type: "POST",
        url: values.url,
        async: true,
        cache: false,
        timeout: 50000,
        data: {
            "id": values.id
        },
        success: function (data) {
            if (data) {
                if (data.success) {
                    if (callback && $.isFunction(callback)) callback();
                } else displayErrorNotice(data.details, null);
            } else displayErrorNotice(null, null);
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            displayErrorNotice({
                'URL': "This url is not defined or does not exist."
            }, null);
        }
    });
    return false;
}

function uploadLoadAction(values, callback) {
    $.ajaxQueue({
        type: "GET",
        url: values.url,
        async: true,
        cache: false,
        timeout: 50000,
        success: function (data) {
            if (data) {
                if (data.success) {
                    if (callback && $.isFunction(callback)) callback(data);
                } else displayErrorNotice(data.details, null);
            } else displayErrorNotice(null, null);
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            displayErrorNotice({
                'URL': "This url is not defined or does not exist."
            }, null);
        }
    });
    return false;
}

function uploadDeleteAction(values, callback) {
    $.ajaxQueue({
        type: "POST",
        url: values.url,
        async: true,
        cache: false,
        timeout: 50000,
        data: {
            "id": values.id
        },
        success: function (data) {
            if (data) {
                if (data.success) {
                    if (callback && $.isFunction(callback)) callback(data);
                } else displayErrorNotice(data.details, null);
            } else displayErrorNotice(null, null);
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            displayErrorNotice({
                'URL': "This url is not defined or does not exist."
            }, null);
        }
    });
    return false;
}
