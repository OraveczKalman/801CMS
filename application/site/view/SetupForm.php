<html>
    <head>
        <link href="<?php print COMMON_CSS_PATH; ?>bootstrap.min.css" rel="stylesheet">
        <link href="<?php print COMMON_CSS_PATH; ?>full.css" rel="stylesheet">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
        
        <script type="text/javascript" src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
        <script type="text/javascript" src="<?php print COMMON_JS_PATH; ?>bootstrap.min.js"></script>
        <script type="text/javascript" src="<?php print SITE_JS_PATH; ?>owl.carousel.min.js"></script>
        <script type="text/javascript" src="<?php print SITE_JS_PATH; ?>cbpAnimatedHeader.js"></script>
        <script type="text/javascript" src="<?php print SITE_JS_PATH; ?>jquery.appear.js"></script>
        <script type="text/javascript" src="<?php print SITE_JS_PATH; ?>SmoothScroll.min.js"></script>
        <script type="text/javascript" src="<?php print SITE_JS_PATH; ?>theme-scripts.js"></script>
        <script type="text/javascript" src="<?php print COMMON_JS_PATH; ?>jquery.form.min.js"></script>        
        <script type="text/javascript" src="<?php print SITE_JS_PATH; ?>scripts.js"></script>      
        <script type="text/javascript">
            $(document).ready(function() {
                $('#SetupForm').ajaxForm({
                    datatype: 'json',
                    success: processError
                });
            });
            
            function processError(data) {
                data = JSON.parse(data);
                if (typeof data.good !== "undefined") {
                    $('#MessageBox #MessageBody').html('<div style="text-align: center;">A mentés sikeres volt!</div>');
                    $('#MessageBox').modal('show');
                    setTimeout(function () {               
                        $('#MessageBox').modal('hide');
                    }, 5000);
                } else if (typeof data.error !== "undefined") {
                    showErrors(data.error);
                }
            }
            
            $("#host").on('blur', function() {
                sendOneField('validateText', '', $('#host').val(), 'host');
            });

            $("#db").on('blur', function() {
                sendOneField('validateText', '', $('#db').val(), 'db');
            });

            $("#port").on('blur', function() {
                sendOneField('validateInt', '', $('#port').val(), 'port');
            });

            $("#charset").on('blur', function() {
                sendOneField('validateText', '', $('#charset').val(), 'charset');
            });

            $("#user").on('blur', function() {
                sendOneField('validateText', '', $('#user').val(), 'user');
            });

            $("#pwd").on('blur', function() {
                sendOneField('validateText', '', $('#pwd').val(), 'pwd');
            });
        </script>        
    </head>
    <body>
        <div class="row-fluid">
            <div class="col-sm-6">
                <h1>Alapadatok</h1>
                <form class="form-horizontal" method="post" action="" id="SetupForm">
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Host:</label>
                        <div class="col-sm-8">
                            <input class="form-control" type="text" name="host" id="host">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Adatbázis név:</label>
                        <div class="col-sm-8">
                            <input class="form-control" type="text" name="db" id="db">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Port:</label>
                        <div class="col-sm-8">
                            <input class="form-control" type="text" name="port" id="port">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Charset:</label>
                        <div class="col-sm-8">
                            <input class="form-control" type="text" name="charset" id="charset">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Adatbázis felhasználó:</label>
                        <div class="col-sm-8">
                            <input class="form-control" type="text" name="user" id="user">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Adatbázis jelszó:</label>
                        <div class="col-sm-8">
                            <input class="form-control" type="password" name="pwd" id="pwd">
                        </div>
                    </div>
                    <div>
                        <button class="btn btn-default" type="button" name="send" id="send" onclick="javascript: $('#SetupForm').submit();">Küldés</button>
                    </div>
                    <input type="hidden" name="event" id="event" value="SaveSetupForm">
                </form>
            </div>
        </div>
    </body>
</html>
