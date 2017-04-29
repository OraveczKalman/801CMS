function loadPage(url, event) {
    $('#page-wrapper').load(url, { event:event });
}

function loadNewMenuForm(menuObject) {
    $('#page-wrapper').load('./admin/Menu', { event:'newMenuForm', menuObject: menuObject });
}

function loadEditMenuForm(menuObject) {
    $('#page-wrapper').load('./admin/Menu', { event:'editMenuForm', menuObject: menuObject });
}

function deleteMenu(menuObject) {
    $.post('./admin/Menu', {event:'deleteMenu', menuObject: menuObject}, function () { loadPage('./admin/MenuTree', 'RenderMenuItems'); });
}

function save(formName) {
    $('#event').val('save');
    $('#' + formName).submit();
}

function showErrors(data) {
    for (var i=0; i<=data.length-1; i++) {
        $('#' + data[i].controllId).tooltip('destroy');
        $('#' + data[i].controllId).parent().addClass('has-error');
        $('#' + data[i].controllId).tooltip({
            'title': data[i].message,
            'placement': 'right',
            'trigger': 'manual'
        }).tooltip('show');
    }    
}

function sendOneField(functionName, url, data, controllId) {
    $('#' + controllId).parent().removeClass('has-error');
    $('#' + controllId).tooltip('destroy');
    $('.alert').html('');
    $('.alert').css('display', 'none');
    $.post(url, { 'event':'validateField', 'function': functionName, 'data':data, 'controllId':controllId }, function(data) {
        if (data !== '') {
            data = JSON.parse(data);
            showErrors(data);
        }
    });
}