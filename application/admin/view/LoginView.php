<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="<?php if (!isset($_SESSION['setupData']['siteAuthor'])) { print "Site author not set"; } else { print $_SESSION['setupData']['siteAuthor']; } ?>">
        <title><?php if (!isset($_SESSION['setupData']['siteTitle'])) { print "Untitled Site"; } else { print $_SESSION['setupData']['siteTitle']; } ?></title>
        <!-- Custom Fonts -->
        <link href="<?php print ADMIN_CSS_PATH; ?>font-awesome.min.css" rel="stylesheet" type="text/css">        
        <!-- Bootstrap Core CSS -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
        <!-- Custom CSS -->
        <link href="<?php print ADMIN_CSS_PATH; ?>sb-admin-2.css" rel="stylesheet">

    </head>

    <body class="bg-gradient-primary">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-10 col-lg-12 col-md-9">
                    <div class="card o-hidden border-0 shadow-lg my-5">
                        <div class="card-body p-0">
                            <div class="row">
                                <div class="col-lg-6 d-none d-lg-block"></div>
                                <div class="col-lg-6">
                                    <div class="p-5">
                                        <div class="text-center">
                                            <h1 class="h4 text-gray-900 mb-4">Üdv!</h1>
                                        </div>
                                        <form class="user" role="form" action="./admin/Login" method="post" id="loginForm">
                                            <div class="form-group">
                                                <input type="text" class="form-control form-control-user" name="UserName" id="UserName" autofocus placeholder="Felhasználónév">
                                            </div>
                                            <div class="form-group">
                                                <input type="password" class="form-control form-control-user" placeholder="Jelszó" name="Password" id="Password">
                                            </div>
                                            <div class="form-group">
                                                <div class="custom-control custom-checkbox small">
                                                    <input type="checkbox" class="custom-control-input" id="customCheck">
                                                    <label class="custom-control-label" for="customCheck">Remember Me</label>
                                                </div>
                                            </div>
                                            <button type="submit" class="btn btn-primary btn-user btn-block">Belépés</button>
                                            <input type="hidden" id="event" name="event" value="login" />
                                            <hr>
                                            <!--<a href="index.html" class="btn btn-google btn-user btn-block">
                                                <i class="fab fa-google fa-fw"></i> Login with Google
                                            </a>
                                            <a href="index.html" class="btn btn-facebook btn-user btn-block">
                                                <i class="fab fa-facebook-f fa-fw"></i> Login with Facebook
                                            </a>-->
                                        </form>
                                        <hr>
                                        <div class="text-center">
                                            <a class="small" href="forgot-password.html">Forgot Password?</a>
                                        </div>
                                        <div class="text-center">
                                            <a class="small" href="register.html">Create an Account!</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script type="text/javascript" src="<?php print COMMON_JS_PATH; ?>jquery-2.1.3.min.js"></script>
        <script type="text/javascript" src="<?php print COMMON_JS_PATH; ?>bootstrap.min.js"></script>
        <script type="text/javascript" src="<?php print COMMON_JS_PATH; ?>jquery.form.min.js"></script>
        <script type="text/javascript" src="<?php print ADMIN_JS_PATH; ?>formScripts/LoginController.js"></script>
    </body>
</html>