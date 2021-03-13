$(document).ready(function() {
    $('#loginForm').ajaxForm ({
        datatype: 'json',
        success: processError
    });            
});
            
function processError(data) {
    if (data!=='') {
        /*$('#errorContainer').css('text-align', 'center');
        $('#errorContainer').css('color', 'red');
        $('#errorContainer').html('Rossz felhasználónév vagy jelszó!');
        $('#errorContainer').css('display', 'block');*/
    } else {
        location.href = '../admin/MenuTree';
    }
}