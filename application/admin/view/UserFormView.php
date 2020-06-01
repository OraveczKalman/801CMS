<script type="text/javascript" src="<?php print ADMIN_JS_PATH; ?>formScripts/UserForm.js"></script>
<script type="text/javascript">
    initUserForm('<?php print $labelObject->labels->success; ?>');
</script>

<div class="modal-header">
    <h5 class="modal-title"><?php print $labelObject->labels->header; ?></h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<form role="form" id="userReg" method="post" action="User">
    <div class="modal-body">
        <div id="MessageBody" style="display:none;"></div>
        <div class="form-group">
            <label for="Name"><?php print $labelObject->labels->name; ?></label>
            <input class="form-control" type="text" id="Name" name="Name" value="<?php if (isset($userData) && $userData[0]['Name']!='') { print $userData[0]['Name']; } ?>">
        </div>
        <div class="form-group">
            <label for="UserName"><?php print $labelObject->labels->username; ?></label>
            <input class="form-control" type="text" id="UserName" name="UserName" value="<?php if (isset($userData) && $userData[0]['UserName']!='') { print $userData[0]['UserName']; } ?>">
        </div>
        <div class="form-group">
            <label for="Password"><?php print $labelObject->labels->password; ?></label>
            <input class="form-control" type="password" id="Password" name="Password" value="<?php if (isset($userData) && $userData[0]['Password']!='') { print $userData[0]['Password']; } ?>">
        </div>
        <div class="form-group">
            <label for="Pwdr"><?php print $labelObject->labels->passwordRemember; ?></label>
            <input class="form-control" type="text" id="Pwdr" name="Pwdr" value="<?php if (isset($userData) && $userData[0]['Pwdr']!='') { print $userData[0]['Pwdr']; } ?>">
        </div>
        <div class="form-group">
            <label for="Email"><?php print $labelObject->labels->email; ?></label>
            <input class="form-control" type="text" id="Email" name="Email" value="<?php if (isset($userData) && $userData[0]['Email']!='') { print $userData[0]['Email']; } ?>">
        </div>
        <div class="form-group">
            <label for="RightId" class="col-sm-2 control-label"><?php print $labelObject->labels->rights; ?></label>
            <select class="form-control" id="RightId" name="RightId">
                <option value="3" <?php if (isset($userData) && $userData[0]['RightId']==3) { print 'selected'; } ?>>Root</option>
                <option value="4" <?php if (isset($userData) && $userData[0]['RightId']==4) { print 'selected'; } ?>>Admin</option>
                <option value="5" <?php if (isset($userData) && $userData[0]['RightId']==5) { print 'selected'; } ?>>User</option>
            </select>
        </div>
    </div>
    <div class="modal-footer">
<?php
    if (isset($userData)) {
?>
        <input type="hidden" id="UserId" name="UserId" value="<?php print $userData[0]['UserId']; ?>" />
<?php
    }
?>
        <input type="hidden" id="event" name="event" value="<?php if (!isset($userData)) { print 'newUser'; } else { print 'editUser'; } ?>" />
        <button type="button" class="btn btn-primary" onclick="javscript: $('#userReg').submit();" id="send"><?php print $labelObject->labels->send; ?></button>
    </div>
</form>