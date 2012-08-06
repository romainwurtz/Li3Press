Object.size = function(obj) {
	var size = 0, key;
	for (key in obj) {
		if (obj.hasOwnProperty(key))
			size++;
	}
	return size;
};

function stringFromArrayClean(data) {
	var out = '';
	for (var i in data) {
		if (data[i] instanceof Array)
		out += stringFromArrayClean(data[i]);
		else
		out += data[i] + "<br />";
	}
	return out;
}

function generateError(errors) {
	var error = "";
	if ( typeof errors == "undefined" || Object.size(errors) == 0)
		error = "An unexpected error occurred :(";
	else
		error = stringFromArrayClean(errors);

	return '<div class="alert alert-block alert-error fade in"><button type="button" class="close" data-dismiss="alert">&times;</button><h4 class="alert-heading">Oh snap! You got an error!</h4><p>' + error + '</p></div>';
}