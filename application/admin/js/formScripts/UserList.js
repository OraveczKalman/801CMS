function deleteUser(userId, active) {
    $.post('admin/User', { event:'deleteUser', userid: userId, active: active }, function (data) {
        if (active == 0) {
            $('#deleteDiv' + userId).html('<a href="javascript: void(0);" onclick="javascript: deleteUser(' + userId + ', 1);">Visszaállítás</a>');
        } else if (active == 1) {
            $('#deleteDiv' + userId).html('<a href="javascript: void(0);" onclick="javascript: deleteUser(' + userId + ', 0);">Törlés</a>');
        }
    });
}

function editUser(userId) {
    $('#modalContainer').load('User', { event:'EditUserForm', userId: userId } );
    $('#formModal').modal('show');
}

function addNewUser() {
    $('#modalContainer').load('User', {event:'NewUserForm'});
    $('#formModal').modal('show');
}