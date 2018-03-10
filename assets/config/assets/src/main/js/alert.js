var template =
    '<div class="alert alert-$type" role="alert">' +
    '$message' +
    '</div>';

var alert = {
    show: function (message, status) {
        if (typeof message !== 'undefined' && message !== null) {
            $('#message-container').html(this.render(message, status));
        }
    },
    render: function (message, status) {
        var error = template.replace('$type', status ? 'success' : 'danger');
        error = error.replace('$message', message);

        return error;
    }
};