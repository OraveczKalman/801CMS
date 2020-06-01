var sLabel = "";

function initSetupForm(successLabel) {
    sLabel = successLabel;
    $('#setupForm').ajaxForm({
        datatype: 'json',
        success: processError
    });

    $('#galleryThumbWidth').on('blur', function () {
        sendOneField('validateInt', 'Setup', $('#galleryThumbWidth').val(), 'galleryThumbWidth');
    });

    $('#galleryThumbHeight').on('blur', function () {
        sendOneField('validateInt', 'Setup', $('#galleryThumbHeight').val(), 'galleryThumbHeight');
    });

    $('#galleryPicWidth').on('blur', function () {
        sendOneField('validateInt', 'Setup', $('#galleryPicWidth').val(), 'galleryPicWidth');
    });

    $('#galleryPicHeight').on('blur', function () {
        sendOneField('validateInt', 'Setup', $('#galleryPicHeight').val(), 'galleryPicHeight');
    });

    $('#galleryHeaderWidth').on('blur', function () {
        sendOneField('validateInt', 'Setup', $('#galleryHeaderWidth').val(), 'galleryHeaderWidth');
    });

    $('#galleryHeaderHeight').on('blur', function () {
        sendOneField('validateInt', 'Setup', $('#galleryHeaderHeight').val(), 'galleryHeaderHeight');
    });

    $('#articleThumbWidth').on('blur', function () {
        sendOneField('validateInt', 'Setup', $('#articleThumbWidth').val(), 'articleThumbWidth');
    });

    $('#articleThumbHeight').on('blur', function () {
        sendOneField('validateInt', 'Setup', $('#articleThumbHeight').val(), 'articleThumbHeight');
    });

    $('#articlePicWidth').on('blur', function () {
        sendOneField('validateInt', 'Setup', $('#articlePicWidth').val(), 'articlePicWidth');
    });

    $('#articlePicHeight').on('blur', function () {
        sendOneField('validateInt', 'Setup', $('#articlePicHeight').val(), 'articlePicHeight');
    });

    $('#articleHeaderWidth').on('blur', function () {
        sendOneField('validateInt', 'Setup', $('#articleHeaderWidth').val(), 'articleHeaderWidth');
    });

    $('#articleHeaderHeight').on('blur', function () {
        sendOneField('validateInt', 'Setup', $('#articleHeaderHeight').val(), 'articleHeaderHeight');
    });

    $('#ytPlayerWidth').on('blur', function () {
        sendOneField('validateInt', 'Setup', $('#ytPlayerWidth').val(), 'ytPlayerWidth');
    });

    $('#ytPlayerHeight').on('blur', function () {
        sendOneField('validateInt', 'Setup', $('#ytPlayerHeight').val(), 'ytPlayerHeight');
    });

    $('#vPlayerWidth').on('blur', function () {
        sendOneField('validateInt', 'Setup', $('#vPlayerWidth').val(), 'vPlayerWidth');
    });

    $('#vPlayerHeight').on('blur', function () {
        sendOneField('validateInt', 'Setup', $('#vPlayerHeight').val(), 'vPlayerHeight');
    });

    $('#mainMenus').on('blur', function () {
        sendOneField('validateInt', 'Setup', $('#mainMenus').val(), 'mainMenus');
    });

    $('#siteTitle').on('blur', function () {
        sendOneField('validateText', 'Setup', $('#siteTitle').val(), 'siteTitle');
    });

    $('#adminTitle').on('blur', function () {
        sendOneField('validateText', 'Setup', $('#adminTitle').val(), 'adminTitle');
    });

    $('#siteAuthor').on('blur', function () {
        sendOneField('validateText', 'Setup', $('#siteAuthor').val(), 'siteAuthor');
    });

    $('#messageWallType').on('blur', function () {
        sendOneField('validateInt', 'Setup', $('#messageWallType').val(), 'messageWallType');
    });
}

function processError(data) {
    data = JSON.parse(data);
    if (typeof data.good !== "undefined") {
        $('#MessageBox #MessageBody').html('<div style="text-align: center;">' + sLabel + '</div>');
        $('#MessageBox').modal('show');
        setTimeout(function () {               
            $('#MessageBox').modal('hide');
            location.reload();
        }, 5000);
    } else if (typeof data.error !== "undefined") {
        showErrors(data.error);
    }
}