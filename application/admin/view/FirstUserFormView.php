<html>
    <head>
        <link href="<?php print COMMON_CSS_PATH; ?>bootstrap.min.css" rel="stylesheet">
        <link href="<?php print ADMIN_CSS_PATH; ?>sb-admin-2.css" rel="stylesheet">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
        
        <script type="text/javascript" src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
        <script type="text/javascript" src="<?php print COMMON_JS_PATH; ?>bootstrap.min.js"></script>
        <script type="text/javascript" src="<?php print COMMON_JS_PATH; ?>jquery.form.min.js"></script> 
        <script type="text/javascript" src="<?php print ADMIN_JS_PATH; ?>CoreScripts.js"></script> 
        
        <script type="text/javascript">
            $(document).ready(function() {
                $('#userReg').ajaxForm({
                    datatype: 'json',
                    success: processError
                });

                $('#Name').on('blur', function () {
                    sendOneField('validateText', 'admin', $('#Name').val(), 'Name');
                });

                $('#UserName').on('blur', function () {
                    sendOneField('validateText', 'admin', $('#UserName').val(), 'UserName');
                });

                $('#Password').on('blur', function () {
                    sendOneField('validateText', 'admin', $('#Password').val(), 'Password');
                });

                $('#Pwdr').on('blur', function () {
                    sendOneField('validateText', 'admin', $('#Pwdr').val(), 'Pwdr');
                });

                $('#Email').on('blur', function () {
                    sendOneField('validateEmail', 'admin', $('#Email').val(), 'Email');
                });

                $('#RightId').on('blur', function () {
                    sendOneField('validateText', 'admin', $('#RightId').val(), 'RightId');
                });
            });

            function processError(data) {
                data = JSON.parse(data);
                if (typeof data.good !== "undefined") {
                    $('#MessageBox #MessageBody').html('<div style="text-align: center;"><?php print $labelObject->labels->success; ?></div>');
                    $('#MessageBox').modal('show');
                    setTimeout(function () {               
                        $('#MessageBox').modal('hide');
                        location.href = "admin";
                    }, 5000);
                } else if (typeof data.error !== "undefined") {
                    showErrors(data.error);
                }
            }
        </script>
    </head>
    
    <body>
        <div class="modal fade" tabindex="-1" role="dialog" id="MessageBox">
            <div class="modal-content">
                <div class="modal-body" id="MessageBody"></div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-md-7 col-md-7-offset-7">
                    <div class="login-panel panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title"><?php print $labelObject->labels->header; ?></h3>
                        </div>
                        <div class="panel-body">
                            <form class="form-horizontal" role="form" id="userReg" method="post" action="admin">
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
                                    <input type="hidden" id="RightId" name="RightId" value="1">
                                    <input type="hidden" id="event" name="event" value="<?php print 'newUser'; ?>" />
                                    <button type="button" class="btn btn-default" onclick="javscript: $('#userReg').submit();" id="send"><?php print $labelObject->labels->send; ?></button>
                                </div>                            
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>