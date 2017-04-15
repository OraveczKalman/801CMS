<script type="text/javascript">
    $(document).ready(function() {
        $('#userReg').ajaxForm({
            datatype: 'json',
            success: processError
        });

        $('#Name').on('blur', function () {
            sendOneField('validateText', 'admin/User', $('#Name').val(), 'Name');
        });

        $('#UserName').on('blur', function () {
            sendOneField('validateText', 'admin/User', $('#UserName').val(), 'UserName');
        });

        $('#Password').on('blur', function () {
            sendOneField('validateText', 'admin/User', $('#Password').val(), 'Password');
        });

        $('#Pwdr').on('blur', function () {
            sendOneField('validateText', 'admin/User', $('#Pwdr').val(), 'Pwdr');
        });

        $('#Email').on('blur', function () {
            sendOneField('validateEmail', 'admin/User', $('#Email').val(), 'Email');
        });

        $('#RightId').on('blur', function () {
            sendOneField('validateText', 'admin/User', $('#RightId').val(), 'RightId');
        });
    });

    function processError(data) {
        data = JSON.parse(data);
        if (typeof data.good !== "undefined") {
            $('#MessageBox #MessageBody').html('<div style="text-align: center;"><?php print $labelObject->labels->success; ?></div>');
            $('#MessageBox').modal('show');
            setTimeout(function () {               
                $('#MessageBox').modal('hide');
            }, 5000);
        } else if (typeof data.error !== "undefined") {
            showErrors(data.error);
        }
    }
</script>
<div class="row-fluid">
    <div class="col-sm-12">
        <h1><?php print $labelObject->labels->header; ?></h1>
        <form class="form-horizontal" role="form" id="userReg" method="post" action="admin/User">

            <div class="form-group">
                <label for="Name" class="col-sm-2 control-label"><?php print $labelObject->labels->name; ?></label>
                <div class="col-sm-5">
                    <input class="form-control" type="text" id="Name" name="Name" value="<?php if (isset($userData) && $userData[0]['Name']!='') { print $userData[0]['Name']; } ?>">
                </div>
            </div>

            <div class="form-group">
                <label for="UserName" class="col-sm-2 control-label"><?php print $labelObject->labels->username; ?></label>
                <div class="col-sm-5">
                    <input class="form-control" type="text" id="UserName" name="UserName" value="<?php if (isset($userData) && $userData[0]['UserName']!='') { print $userData[0]['UserName']; } ?>">
                </div>
            </div>

            <div class="form-group">
                <label for="Password" class="col-sm-2 control-label"><?php print $labelObject->labels->password; ?></label>
                <div class="col-sm-5">
                    <input class="form-control" type="password" id="Password" name="Password" value="<?php if (isset($userData) && $userData[0]['Password']!='') { print $userData[0]['Password']; } ?>">
                </div>
            </div>

            <div class="form-group">
                <label for="Pwdr" class="col-sm-2 control-label"><?php print $labelObject->labels->passwordRemember; ?></label>
                <div class="col-sm-5">
                    <input class="form-control" type="text" id="Pwdr" name="Pwdr" value="<?php if (isset($userData) && $userData[0]['Pwdr']!='') { print $userData[0]['Pwdr']; } ?>">
                </div>
            </div>

            <div class="form-group">
                <label for="Email" class="col-sm-2 control-label"><?php print $labelObject->labels->email; ?></label>
                <div class="col-sm-5">
                    <input class="form-control" type="text" id="Email" name="Email" value="<?php if (isset($userData) && $userData[0]['Email']!='') { print $userData[0]['Email']; } ?>">
                </div>
            </div>

            <div class="form-group">
                <label for="RightId" class="col-sm-2 control-label"><?php print $labelObject->labels->rights; ?></label>
                <div class="col-sm-5">
                    <select class="form-control" id="RightId" name="RightId">
                        <option value="3" <?php if (isset($userData) && $userData[0]['RightId']==3) { print 'selected'; } ?>>Root</option>
                        <option value="4" <?php if (isset($userData) && $userData[0]['RightId']==4) { print 'selected'; } ?>>Admin</option>
                        <option value="5" <?php if (isset($userData) && $userData[0]['RightId']==5) { print 'selected'; } ?>>User</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
<?php
            if (isset($userData)) {
?>
                <input type="hidden" id="UserId" name="UserId" value="<?php print $userData[0]['UserId']; ?>" />
<?php
            }
?>
                <input type="hidden" id="event" name="event" value="<?php if (!isset($userData)) { print 'newUser'; } else { print 'editUser'; } ?>" />
                <button type="button" class="btn btn-default" onclick="javscript: $('#userReg').submit();" id="send"><?php print $labelObject->labels->send; ?></button>
            </div>

        </form>
    </div>
</div>