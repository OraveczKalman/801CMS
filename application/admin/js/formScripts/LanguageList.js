function addNewLanguage() {
    $('#modalContainer').load('LanguageForm', { event:'RenderLanguageForm' });
    $('#formModal').modal('show');
}

function setDefaultLanguage(languageId) {
    $.post('LanguageForm', { event:'SetDefaultLanguage', languageId: languageId }, function (data) {
        data = JSON.parse(data);
        if (typeof data.good !== "undefined") {
            $('#MessageBox #MessageBody').html('<div style="text-align: center;">Az alapértelmezett nyelv beállítása sikeres volt!</div>');
            $('#MessageBox').modal('show');
            setTimeout(function () {               
                $('#MessageBox').modal('hide');
                location.reload();
            }, 5000);
        } else if (typeof data.error !== "undefined") {
            showErrors(data.error);
        }            
    });       
}

function deleteLanguage(languageId) {
    $.post('LanguageForm', { event:'DeleteLanguage', languageId: languageId }, function (data) {
        data = JSON.parse(data);
        if (typeof data.good !== "undefined") {
            $('#MessageBox #MessageBody').html('<div style="text-align: center;">A nyelv törlése sikeres volt!</div>');
            $('#MessageBox').modal('show');
            setTimeout(function () {               
                $('#MessageBox').modal('hide');
                location.reload();
            }, 5000);
        } else if (typeof data.error !== "undefined") {
            showErrors(data.error);
        }            
    });
}