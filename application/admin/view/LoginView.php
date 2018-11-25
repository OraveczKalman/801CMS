<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="<?php if (!isset($_SESSION['setupData']['siteAuthor'])) { print "Site author not set"; } else { print $_SESSION['setupData']['siteAuthor']; } ?>">
        <title><?php if (!isset($_SESSION['setupData']['siteTitle'])) { print "Untitled Site"; } else { print $_SESSION['setupData']['siteTitle']; } ?></title>
        <!-- Bootstrap Core CSS -->
        <link href="<?php print COMMON_CSS_PATH; ?>bootstrap.min.css" rel="stylesheet">
        <!-- MetisMenu CSS -->
        <link href="<?php print ADMIN_CSS_PATH; ?>metisMenu.min.css" rel="stylesheet">
        <!-- Custom CSS -->
        <link href="<?php print ADMIN_CSS_PATH; ?>sb-admin-2.css" rel="stylesheet">
        <!-- Custom Fonts -->
        <link href="<?php print ADMIN_CSS_PATH; ?>font-awesome.min.css" rel="stylesheet" type="text/css">
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
        <script type="text/javascript" src="<?php print COMMON_JS_PATH; ?>jquery-2.1.3.min.js"></script>
        <script type="text/javascript" src="<?php print COMMON_JS_PATH; ?>bootstrap.min.js"></script>
        <script type="text/javascript" src="<?php print COMMON_JS_PATH; ?>jquery.form.min.js"></script>
        <script type="text/javascript">
            $(document).ready(function () {
                $('#loginForm').ajaxForm ({
                    datatype: 'json',
                    success: processError
                });
            });

            function processError(data) {
                $('.form-group').removeClass('has-error');
                if (data.length > 0) {
                    data = $.parseJSON(data);
                    for (var i=0; i<=data.length-1; i++) {
                        $('#' + data[i]).parent().addClass('has-error');
                    }
                } else {
                    location.href = "admin";
                }
            }
        </script>
    </head>

    <body>
        <div class="container">
            <div class="row">
                <div class="col-md-4 col-md-offset-4">
                    <div class="login-panel panel panel-default">

                        <div class="panel-heading">
                            <h3 class="panel-title"><?php if (!isset($_SESSION['setupData']['siteTitle'])) { print "Untitled Site"; } else { print $_SESSION['setupData']['siteTitle']; } ?></h3>
                        </div>

                        <div class="panel-body">
                            <form role="form" action="./admin/Login" method="post" id="loginForm">
                                <fieldset>
                                    <div class="form-group">
                                        <input class="form-control" placeholder="Felhasználónév" name="UserName" id="UserName" type="text" autofocus>
                                    </div>
                                    <div class="form-group">
                                        <input class="form-control" placeholder="Jelszó" name="Password" id="Password" type="password" value="">
                                    </div>
                                    <button type="submit" class="btn btn-lg btn-success btn-block">Belépés</button>
                                    <input type="hidden" id="event" name="event" value="login" />
                                </fieldset>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </body>
</html>