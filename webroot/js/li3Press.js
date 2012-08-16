/**
 * Li3Press: A simple blog using Lithium framework
 *
 * @author 			Romain Wurtz (http://www.t3kila.com)
 * @copyright		Copyright 2012, Romain Wurtz (http://www.t3kila.com)
 *
 */

Object.size = function(obj) {
	var size = 0, key;
	for (key in obj) {
		if (obj.hasOwnProperty(key))
			size++;
	}
	return size;
};

function stringFromArrayClean(data) {
	var out = '<ul>';
	for (var i in data) {
		if (data[i] instanceof Array)
		out += stringFromArrayClean(data[i]);
		else
		out += "<li>" + data[i] + "</li>";
	}
	out += '</ul>';
	return out;
}

function generateError(errors) {
	var error = "";
	if ( typeof errors == "undefined" || Object.size(errors) == 0)
		error = "<ul><li>An unexpected error occurred :(</li></ul>";
	else
		error = stringFromArrayClean(errors);

	return '<div class="alert alert-block alert-error fade in"><button type="button" class="close" data-dismiss="alert">&times;</button><h4 class="alert-heading">Oh snap! You got an error!</h4><p>Error details:' + error + '</p></div>';
}