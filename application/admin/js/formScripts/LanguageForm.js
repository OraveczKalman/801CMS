var langLabel = "";

function initLanguageForm(languageLabel) {
    console.log('xxx');
    langLabel = languageLabel;
    $('.alert').css('display', 'none');

    $().tooltip({
        'placement': 'right',
        'trigger': 'manual'
    });     

    $('#languageForm').ajaxForm({
        datatype: 'json',
        success: processError
    });

    $('#Language').on('blur', function () {
        sendOneField('validateText', 'LanguageForm', $('#Language').val(), 'Language');
    });

    $('#LanguageSign').on('blur', function () {
        sendOneField('validateText', 'LanguageForm', $('#LanguageSign').val(), 'LanguageSign');
    });
}

function processError(data) {
    data = JSON.parse(data);
    if (typeof data.good !== "undefined") {
        $('#MessageBody').html('<div class="alert alert-success" role="alert">' + langLabel + '</div>');
        $('#MessageBody').css("display", "block");
        setTimeout(function () {               
            $('#formModal').modal('hide');
            location.reload();
        }, 5000);
    } else if (typeof data.error !== "undefined") {
        showErrors(data.error);
    }
}