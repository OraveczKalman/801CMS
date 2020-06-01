function loadNewMenuForm(menuObject) {
    $('#form-wrapper').load('../admin/Menu', { event:'newMenuForm', menuObject: menuObject });
}

function loadEditMenuForm(menuObject) {
    $('#form-wrapper').load('../admin/Menu', { event:'editMenuForm', menuObject: menuObject });
}

function deleteMenu(menuObject) {
    $.post('../admin/Menu', {event:'deleteMenu', menuObject: menuObject}, function () { loadPage('../admin/MenuTree', 'RenderMenuItems'); });
}