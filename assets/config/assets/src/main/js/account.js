$(document).ready(function () {
    $('#forgot-password').click(function () {
        var username = $('#username').val();
        $.ajax({
            url: '/account/forgot-password',
            dataType: 'json',
            method: 'post',
            data: {username: username},
            success: function (data) {
                alert.show(data.message, data.status);
                if (data.status === true) {
                    
                }
            },
            error: function (data) {
                alert.show('An error has occurred please try again later.', false);
            }
        });
    });
});