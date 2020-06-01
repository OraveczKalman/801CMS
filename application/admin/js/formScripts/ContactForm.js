function initContactForm() {
    $('.alert').css('display', 'none');

    $().tooltip({
        'placement': 'right',
        'trigger': 'manual'
    });     

    $('#contactForm').ajaxForm({
        datatype: 'json',
        success: processError
    });

    $('#Name').on('blur', function () {
        sendOneField('validateText', 'ContactForm', $('#Name').val(), 'Name');
    });

    $('#TargetMail').on('blur', function () {
        sendOneField('validateEmail', 'ContactForm', $('#TargetMail').val(), 'TargetMail');
    });

    $('#Address').on('blur', function () {
        sendOneField('validateText', 'ContactForm', $('#Address').val(), 'Address');
    });

    $('#Phone').on('blur', function () {
        sendOneField('validatePhone', 'ContactForm', $('#Phone').val(), 'Phone');
    });

    $('#Fax').on('blur', function () {
        sendOneField('validatePhone', 'ContactForm', $('#Fax').val(), 'Fax');
    });

    $('#Mobile').on('blur', function () {
        sendOneField('validatePhone', 'ContactForm', $('#Mobile').val(), 'Mobile');
    });

    $('#SmtpServer').on('blur', function () {
        sendOneField('validateText', 'ContactForm', $('#SmtpServer').val(), 'SmtpServer');
    });

    $('#SmtpPassword').on('blur', function () {
        sendOneField('validateText', 'ContactForm', $('#SmtpPassword').val(), 'SmtpPassword');
    });

    $('#Port').on('blur', function () {
        sendOneField('validateInt', 'ContactForm', $('#Port').val(), 'Port');
    });

    $('#UserName').on('blur', function () {
        sendOneField('validateText', 'ContactForm', $('#UserName').val(), 'UserName');
    });
}

function processError(data) {
    data = JSON.parse(data);
    if (typeof data.good !== "undefined") {
        $('#MessageBox #MessageBody').html('<div style="text-align: center;">Az adatok feltöltése sikeres volt!</div>');
        $('#MessageBox').modal('show');
        setTimeout(function () {               
            $('#MessageBox').modal('hide');
            location.reload();
        }, 5000);
    } else if (typeof data.error !== "undefined") {
        showErrors(data.error);
    }
}