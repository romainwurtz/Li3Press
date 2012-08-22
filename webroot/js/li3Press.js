/**
 * Li3Press: A simple blog using Lithium framework
 *
 * @author 			Romain Wurtz (http://www.t3kila.com)
 * @copyright		Copyright 2012, Romain Wurtz (http://www.t3kila.com)
 *
 */

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
    $(".alert").fadeOut('slow', function() {
        $(this).remove();
    });
    return false;
}

function generateErrorNotice(errors) {
    var error = "";
    if (typeof errors == "undefined" || !errors || errors.length == 0) error = "<ul><li>An unexpected error occurred :(</li></ul>";
    else error = stringFromArrayClean(errors);
    return '<div class="alert alert-block alert-error fade in">\
    <button type="button" class="close" data-dismiss="alert">&times;</button>\
    <h4 class="alert-heading">Oh snap! You got an error!</h4>\
    <p>Error details:' + error + '</p></div>';
}

function generateSuccessNotice(title, notice) {
    return '<div class="alert alert-block alert-success fade in">\
    <button type="button" class="close" data-dismiss="alert">&times;</button>\
     <h4 class="alert-heading">' + title + '</h4>\
    <p>' + notice + '</p></div>';
}

function displaySuccessNotice(title, notice, element) {
    if (title == null || title) title = 'Well done!';
    if (notice == null || notice) notice = 'Your changes have been successfully saved.';
    if (element == null || element) element = $(".alert-area");
    $(element).stop().clearQueue().fadeOut('slow', function() {
        $(this).empty();
        $(generateSuccessNotice(title, notice)).prependTo(this)
        $(this).fadeIn("slow").delay(2000).fadeOut("slow");
    });
    return false;
}

function displayErrorNotice(errors, element) {
    if (element == null || element) element = $(".alert-area");
    $(element).stop().clearQueue().fadeOut('slow', function() {
        $(this).empty();
        $(generateErrorNotice(errors)).prependTo(this);
        $(this).fadeIn("slow").delay(2000).fadeOut("slow");
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
        success: function(data) {
            if (data) {
                if (data.success) {
                    window.location.replace(data.url);
                } else displayErrorNotice(data.errors, null);
            } else displayErrorNotice(null, null);
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
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
        success: function(data) {
            if (data) {
                if (data.success) {
                    var group = $('#visible_choice');
                    $('.disabled', group).not("#visible_text").removeClass('disabled');
                    $('.active', group).not("#visible_text").removeClass('active');
                    (status == true) ? $('#visible_off', group).addClass('disabled') : $('#visible_on', group).addClass('disabled');
                    displaySuccessNotice(null, null, null);
                } else displayErrorNotice(data.errors, null);
            } else displayErrorNotice(null, null);
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
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
        success: function(data) {
            if (data) {
                if (data.success) {
                    if (callback && $.isFunction(callback)) callback();
                    else window.location.replace(data.url);
                } else displayErrorNotice(data.errors, null);
            } else displayErrorNotice(null, null);
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
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
        success: function(data) {
            if (data) {
                if (data.success) {
                    displaySuccessNotice(null, null, null);
                } else displayErrorNotice(data.errors, null);
            } else displayErrorNotice(null, null);
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
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
        success: function(data) {
            if (data) {
                posts = data;
            } else displayErrorNotice(null, null);
        },
        complete: function() {
            if (callback && $.isFunction(callback)) callback(posts);
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
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
        success: function(data) {
            if (data) {
                posts = data;
            } else displayErrorNotice(null, null);
        },
        complete: function() {
            if (callback && $.isFunction(callback)) callback(posts);
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
            displayErrorNotice({
                'URL': "This url is not defined or does not exist."
            }, null);
        }
    });
    return false;
}

function commentAddAction(url, id, name, email, website, body, callback) {
    $.ajaxQueue({
        type: "POST",
        url: url,
        async: true,
        cache: false,
        timeout: 50000,
        data: {
            "id": id,
            "name": name,
            "email": email,
            "website": website,
            "body": body
        },
        success: function(data) {
            console.log(data);
            if (data) {
                if (data.success) {
                    if (callback && $.isFunction(callback)) callback();
                } else displayErrorNotice(data.errors, null);
            } else displayErrorNotice(null, null);
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
            displayErrorNotice({
                'URL': "This url is not defined or does not exist."
            });
        }
    });
    return false;
}