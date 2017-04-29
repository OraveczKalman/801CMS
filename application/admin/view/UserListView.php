<script type="text/javascript">
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
        $('#page-wrapper').load('admin/User', { event:'EditUserForm', userId: userId }, function (data) {

        });
    }
</script>
<div class="row-fluid">
    <div class="col-sm-12">
        <h1>
            Felhasználók
        </h1>
        <table class="table table-striped">
            <thead>
            <tr>
                <th>Név</th>
                <th>Felhasználónév</th>
                <th>Jelszó</th>
                <th>Jelszó emlékeztető</th>
                <th>Jogosultság</th>
            </tr>
            </thead>
            <tbody>
<?php
            foreach ($users as $users2) {
?>
                <tr>
                    <td><?php print $users2['Name']; ?></td>
                    <td><?php print $users2['UserName']; ?></td>
                    <td><?php print $users2['Password']; ?></td>
                    <td><?php print $users2['Pwdr']; ?></td>
                    <td>
                        <select class="form-control" id="right">
                            <option value="3" <?php if ($users2['RightId'] == 3) { print "selected"; } ?>>Root</option>
                            <option value="4" <?php if ($users2['RightId'] == 4) { print "selected"; } ?>>Admin</option>
                            <option value="5" <?php if ($users2['RightId'] == 5) { print "selected"; } ?>>User</option>
                        </select>
                    </td>
                    <td>
                        <a href="javascript: void(0);" onclick="javascript: editUser(<?php print $users2['UserId']; ?>);">Szerkesztés</a>
                    </td>
                    <td id="deleteDiv<?php print $users2['UserId']; ?>">
<?php
                        if ($users2['Active'] == 1) {
?>
                            <a href="javascript: void(0);" onclick="javascript: deleteUser(<?php print $users2['UserId']; ?>, 0);">Törlés</a>
<?php
                        } else if ($users2['Active'] == 0) {
?>
                            <a href="javascript: void(0);" onclick="javascript: deleteUser(<?php print $users2['UserId']; ?>, 1);">Visszaállítás</a>
<?php
                        }
?>
                    </td>
                </tr>
<?php
            }
?>
            </tbody>
        </table>
    </div>
</div>