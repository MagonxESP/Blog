function isUsedUsername(username) {
    $.ajax({
        url: '/user/checkusername',
        type: 'post',
        dataType: 'json',
        data: { "username": username },
        success: function(data) {

        }
    });
}