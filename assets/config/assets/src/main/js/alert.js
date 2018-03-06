var template =
    '<div class="alert alert-$type" role="alert">' +
    '$message.' +
    '</div>';

var alert = {
    show: function(message, status) {
        $('#message-container').html(this.render(message, status));
    },
    render: function (message, status) {
        var error = template.replace('$type', status ? 'success' : 'danger');
        error = template.replace('$message', message);

        return error;
    }
};