<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="<?php if (!isset($_SESSION['setupData']['siteAuthor'])) { print "Site author not set"; } else { print $_SESSION['setupData']['siteAuthor']; } ?>">
    <title><?php if (!isset($_SESSION['setupData']['siteTitle'])) { print "Untitled Site"; } else { print $_SESSION['setupData']['siteTitle']; } ?></title>
    <link href="<?php print ADMIN_CSS_PATH; ?>bootstrap.css" rel="stylesheet" type="text/css">
    <link href="<?php print ADMIN_CSS_PATH; ?>metisMenu.css" rel="stylesheet" type="text/css">
    <link href="<?php print ADMIN_CSS_PATH; ?>timeline.css" rel="stylesheet" type="text/css">
    <link href="<?php print ADMIN_CSS_PATH; ?>sb-admin-2.css" rel="stylesheet" type="text/css">
    <link href="<?php print ADMIN_CSS_PATH; ?>morris.css" rel="stylesheet" type="text/css">
    <link href="<?php print ADMIN_CSS_PATH; ?>font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="<?php print ADMIN_CSS_PATH; ?>tree.css" rel="stylesheet" type="text/css">
    <link href="<?php print ADMIN_CSS_PATH; ?>jquery.Jcrop.min.css" rel="stylesheet" type="text/css">
    <style type="text/css">
        .modal-lg { width:90%; }
    </style>
	
	
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <!--<script type="text/javascript" src="<?php //print COMMON_JS_PATH; ?>jquery-2.1.3.min.js"></script>-->
    <script src="https://code.jquery.com/jquery-2.2.4.js" integrity="sha256-iT6Q9iMJYuQiMWNd9lDyBUStIq/8PuOW33aOqmvFpqI=" crossorigin="anonymous"></script>
    <script type="text/javascript" src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
    <script type="text/javascript" src="<?php print ADMIN_JS_PATH; ?>bootstrap.min.js"></script>
    <script type="text/javascript" src="<?php print COMMON_JS_PATH; ?>jquery.form.min.js"></script>
    <script type="text/javascript" src="<?php print ADMIN_JS_PATH; ?>metisMenu.min.js"></script>
    <script type="text/javascript" src="<?php print ADMIN_JS_PATH; ?>sb-admin-2.js"></script>
    <script type="text/javascript" src="<?php print ADMIN_JS_PATH; ?>jquery.Jcrop.min.js"></script>
    <script type="text/javascript" src="<?php print ADMIN_JS_PATH; ?>CoreScripts.js"></script>
    
    <script type="text/javascript" src="//cdn.ckeditor.com/4.4.7/full/ckeditor.js"></script>
    <script type="text/javascript" src="//cdn-source.ckeditor.com/4.4.7/standard/adapters/jquery.js"></script>
</head>

<body>
<div class="modal fade" tabindex="-1" role="dialog" id="largeModalContainer"></div>
<div class="modal fade" tabindex="-1" role="dialog" id="modalContainer"></div>
<div class="modal fade" tabindex="-1" role="dialog" id="MessageBox">
    <div class="modal-content">
        <div class="modal-body" id="MessageBody"></div>
    </div>
</div>
<div id="wrapper">
    <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="./admin"><?php if (!isset($_SESSION['setupData']['siteTitle'])) { print "Untitled Site"; } else { print $_SESSION['setupData']['siteTitle']; } ?></a>
        </div>

        <ul class="nav navbar-top-links navbar-right">
            <li><a href="javascript: void(0);" onclick="javascript: loadPage('./admin/LanguageForm', 'RenderLanguageForm');"><?php print $adminMainMenu->labels->languageForm; ?></a></li>
            <li><a href="javascript: void(0);" onclick="javascript: loadPage('./admin/ContactForm', 'RenderContactForm');"><?php print $adminMainMenu->labels->contactForm; ?></a></li>
            <li><a href="javascript: void(0);" onclick="javascript: loadPage('./admin/Setup', 'RenderSetupForm');"><?php print $adminMainMenu->labels->siteSetup; ?></a></li>
            <li><a href="javascript: void(0);" onclick="javascript: loadPage('./admin/User', 'newUserForm');"><?php print $adminMainMenu->labels->newUser; ?></a></li>
            <li><a href="javascript: void(0);" onclick="javascript: loadPage('./admin/User', 'UserList');"><?php print $adminMainMenu->labels->userHandling; ?></a></li>
            <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                    <i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
                </a>
                <ul class="dropdown-menu dropdown-user">
                    <li>
                        <a href="#">
                        <i class="fa fa-user fa-fw"></i><?php print $adminMainMenu->labels->profile; ?></a>
                    </li>
                    <li class="divider"></li>
                        <li><a href="./admin/logout"><i class="fa fa-sign-out fa-fw"></i><?php print $adminMainMenu->labels->quit; ?></a>
                    </li>
                </ul>
            </li>
        </ul>

        <div class="navbar-default sidebar" role="navigation">
            <div class="sidebar-nav navbar-collapse">
                <ul class="nav in">
                    <li>
                        <a href="javascript:void(0);" onclick="javascript: loadPage('./admin/MenuTree', 'RenderMenuItems');"><?php print $adminMainMenu->labels->editSite; ?></a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div id="page-wrapper">
        <!--<div id="tartalom"></div>-->
    </div>
</div>
<script type="text/javascript">
$(document).ready(function() {
    //$.ajaxSetup({ cache: true });
    /*$.getScript('//connect.facebook.net/en_US/sdk.js', function(){
            FB.init({
            appId: '836761219799816',
            version: 'v2.7' // or v2.1, v2.2, v2.3, ...
        });     
    });*/
});
</script>
</body>

</html>