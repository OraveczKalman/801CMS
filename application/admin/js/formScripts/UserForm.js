var sLabel = "";

function initUserForm(successLabel) {
    sLabel = successLabel;
    $('#userReg').ajaxForm({
        datatype: 'json',
        success: processError
    });

    $('#Name').on('blur', function () {
        sendOneField('validateText', 'User', $('#Name').val(), 'Name');
    });

    $('#UserName').on('blur', function () {
        sendOneField('validateText', 'User', $('#UserName').val(), 'UserName');
    });

    $('#Password').on('blur', function () {
        sendOneField('validateText', 'User', $('#Password').val(), 'Password');
    });

    $('#Pwdr').on('blur', function () {
        sendOneField('validateText', 'User', $('#Pwdr').val(), 'Pwdr');
    });

    $('#Email').on('blur', function () {
        sendOneField('validateEmail', 'User', $('#Email').val(), 'Email');
    });

    $('#RightId').on('blur', function () {
        sendOneField('validateText', 'User', $('#RightId').val(), 'RightId');
    });
}

function processError(data) {
    data = JSON.parse(data);
    if (typeof data.good !== "undefined") {
        $('#MessageBody').html('<div class="alert alert-success" role="alert">' + sLabel + '</div>');
        $('#MessageBody').modal('show');
        setTimeout(function () {               
            $('#formModal').modal('hide');
            location.reload();
        }, 5000);
    } else if (typeof data.error !== "undefined") {
        showErrors(data.error);
    }
}