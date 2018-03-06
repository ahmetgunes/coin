$(document).ready(function () {
    $('#buy').click(function () {
        $.ajax({
            url: '/coin/buy',
            dataType: 'json',
            method: 'post',
            success: function (data) {
                alert.show(data.message, data.status);
            },
            error: function (data) {
                alert.show(data.message, data.status);
            }
        });
    });
});