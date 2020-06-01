<div class="card shadow mb-12">
    <div class="card-header py-3 form-inline">
        <h6 class="m-0 font-weight-bold text-primary" style="padding-right:1rem;">Felhasználók</h6>
        <button class="btn btn-primary" onclick="javascript: addNewUser();">Új felhasználó</button>
    </div>
    <div class="card-body">
        <table class="table table-striped">
            <thead>
            <tr>
                <th>Név</th>
                <th>Felhasználónév</th>
                <th>&nbsp;</th>
                <th>&nbsp;</th>
            </tr>
            </thead>
            <tbody>
<?php
            foreach ($users as $users2) {
?>
                <tr>
                    <td><?php print $users2['Name']; ?></td>
                    <td><?php print $users2['UserName']; ?></td>
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