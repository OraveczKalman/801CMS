<!DOCTYPE HTML>
<html>
    <head>
        <meta charset="utf-8"/>
        <meta name="keywords" content="<?php if (isset($menuPoint[0]['Kulcsszavak'])) { print $menuPoint[0]['Kulcsszavak']; } ?>"/>
        <meta property="og:title" content="<?php print $_SESSION['setupData']['siteTitle']; if (isset($menuPoint[0]['Title'])) { print ' - ' . $menuPoint[0]['Title'];} ?>"/>
        <meta property="og:type" content="<?php //print $this->headerData['siteType']; ?>"/>
        <meta property="og:url" content="<?php print $address; ?>"/>
        <meta property="og:image" content="<?php print $menuPoint[0]['ProfilePicture']; ?>"/>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="robots" content="index, follow"/>
        <meta name="revisit-after" content="1 Week"/>
        <meta name="author" content="<?php print $_SESSION['setupData']['siteAuthor']; ?>"/>

        <title><?php print $_SESSION['setupData']['siteTitle']; if (isset($menuPoint[0]['Title'])) { print ' - ' . $menuPoint[0]['Title']; } ?></title>        
        
        <link href="<?php print COMMON_CSS_PATH; ?>bootstrap.css" rel="stylesheet" type="text/css">
        <link href="<?php print SITE_CSS_PATH; ?>modern-business.css" rel="stylesheet" type="text/css">
        <link href="<?php print SITE_CSS_PATH; ?>grid-gallery.css" rel="stylesheet" type="text/css">
        <link href="<?php print SITE_CSS_PATH; ?>jquery.fancybox.min.css" rel="stylesheet" type="text/css">
        <!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
        <link href="https://fonts.googleapis.com/css?family=Lora:400,700,400italic,700italic" rel="stylesheet" type="text/css">
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800" rel="stylesheet" type="text/css">-->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->

        <script>
            (function (d, s, id) {
                var js, fjs = d.getElementsByTagName(s)[0];
                if (d.getElementById(id)) return;
                js = d.createElement(s);
                js.id = id;
                js.src = "//connect.facebook.net/hu_HU/all.js#xfbml=1&appId=836761219799816";
                fjs.parentNode.insertBefore(js, fjs);
            }(document, 'script', 'facebook-jssdk'));
        </script>
    </head>

    <body>
        <nav class="navbar fixed-top navbar-expand-lg navbar-dark bg-dark fixed-top" id="mainNav">
            <div class="container">
                <a class="navbar-brand" href="/">Oravecz Kálmán</a>
                <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
    
                <div class="collapse navbar-collapse" id="navbarResponsive">
<?php
                    include_once(SITE_CONTROLLER_PATH . 'MenuTreeController.php');
                    $menuTreeDataArray = array();
                    $menuTreeDataArray[0]['mainPointId'] = 0;
                    $menuTreeDataArray[0]['menuDirection'] = 0;
                    $menuTreeDataArray[0]['event'] = 'RenderMenuItems';
                    $menu = new MenuTreeController($menuTreeDataArray, $this->db);
?>                     
                </div>
            </div>
        </nav>

        <!-- carousel example container -->
        <!-- TODO: make this programmed from uploaded main menu points -->    
        <div class="container">
<?php
    include_once(SITE_CONTROLLER_PATH . $controllerName . '.php');
    $controllerRout = new $controllerName($menuPoint, $this->db);
?>            
        </div>
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
        <script type="text/javascript" src="<?php print SITE_JS_PATH; ?>scripts.js"></script>
        <!--<script type="text/javascript" src="<?php //print SITE_JS_PATH; ?>clearbox.js"></script>-->
        <script type="text/javascript" src="<?php print SITE_JS_PATH; ?>jquery.fancybox.min.js"></script>
        <script type="text/javascript">
            /*var _gaq = _gaq || [];
            _gaq.push(['_setAccount', 'UA-29326599-1']);
            _gaq.push(['_trackPageview']);

            (function() {
            var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
            ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
            var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
            })();*/
        </script>
    </body>
</html>
