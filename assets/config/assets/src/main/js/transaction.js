$(document).ready(function () {
    $('#buy').click(function () {
        $.ajax({
            url: '/coin/buy',
            dataType: 'json',
            method: 'post',
            success: function (data) {
                alert.show(data.message, data.status);
                if (data.hasOwnProperty('data') && data.data.hasOwnProperty('balance') && data.status === true) {
                    $('#balance').text(data.data.balance);
                }
            },
            error: function (data) {
                alert.show('An error has occurred please try again later.', false);
            }
        });
    });

    $('#verify').click(function () {
        var hash = $('#hash-holder').val();
        $.ajax({
            url: '/coin/verify',
            dataType: 'json',
            data: {hash: hash},
            method: 'post',
            success: function (data) {
                alert.show(data.message, data.status);
            },
            error: function (data) {
                alert.show('An error has occurred please try again later.', false);
            }
        });
    });
});