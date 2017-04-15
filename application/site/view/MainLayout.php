<!DOCTYPE HTML>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <meta name="keywords" content="<?php if (isset($menuPoint[0]['Kulcsszavak'])) { print $menuPoint[0]['Kulcsszavak']; } ?>"/>
        <meta property="og:title" content="<?php print $_SESSION['setupData']['siteTitle']; if (isset($menuPoint[0]['Title'])) { print ' - ' . $menuPoint[0]['Title'];} ?>"/>
        <meta property="og:type" content="<?php //print $this->headerData['siteType']; ?>"/>
        <meta property="og:url" content="<?php print $address; ?>"/>
        <meta property="og:image" content="<?php //print $menuPoint[0]['coverPicture']; ?>"/>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <meta name="robots" content="index, follow"/>
        <meta name="revisit-after" content="1 Week"/>
        <meta name="author" content="<?php print $_SESSION['setupData']['siteAuthor']; ?>"/>

        <link href="<?php print COMMON_CSS_PATH; ?>bootstrap.min.css" rel="stylesheet">
        <link href="<?php print COMMON_CSS_PATH; ?>full.css" rel="stylesheet">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">

        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->

        <title><?php print $_SESSION['setupData']['siteTitle']; if (isset($menuPoint[0]['Title'])) { print ' - ' . $menuPoint[0]['Title']; } ?></title>

        <script>
            /*(function (d, s, id) {
                var js, fjs = d.getElementsByTagName(s)[0];
                if (d.getElementById(id)) return;
                js = d.createElement(s);
                js.id = id;
                js.src = "//connect.facebook.net/hu_HU/all.js#xfbml=1&appId=231522500287850";
                fjs.parentNode.insertBefore(js, fjs);
            }(document, 'script', 'facebook-jssdk'));*/
        </script>
    </head>

    <body id="page-top">
        <div id="popupContainer"></div>
        <div id="fb-root"></div>
        
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <div class="container">
                <div class="navbar-header page-scroll">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="incon-bar"></span>
                        <span class="incon-bar"></span>
                        <span class="incon-bar"></span>
                    </button>
                    <a class="navbar-brand page-scroll" href="#page-top"><img src="<?php print SITE_IMAGE_PATH; ?>logo.png" alt="Oravecz Kálmán"></a>
                </div>
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav navbar-right">
                        <li class="hidden">
                            <a href="#page-top"></a>
                        </li>
<?php
                        include_once(SITE_CONTROLLER_PATH . 'MenuTreeController.php');
                        $menuTreeDataArray = array();
                        $menuTreeDataArray[0]['mainPointId'] = 0;
                        $menuTreeDataArray[0]['menuDirection'] = 0;
                        $menuTreeDataArray[0]['event'] = 'RenderMenuItems';
                        $menu = new MenuTreeController($menuTreeDataArray, $this->db);
?>                            
                    </ul>
                </div>
            </div>
        </nav>
        
<?php
    include_once(SITE_CONTROLLER_PATH . $controllerName . '.php');
    $controllerRout = new $controllerName($menuPoint, $this->db);
                /*$dataArray[0]['event'] = 'RenderMenuItems';
                $dataArray[0]['menuQueue'] = 1;
                $menuSide = new MenuTreeController($dataArray, $this->db);*/
?>
<?php
    /*include_once(SITE_CONTROLLER_PATH . $controllerName . '.php');
    $controllerRout = new $controllerName($menuPoint, $this->db);*/
?>
        <script type="text/javascript" src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
        <script type="text/javascript" src="<?php print COMMON_JS_PATH; ?>bootstrap.min.js"></script>
        <script type="text/javascript" src="<?php print SITE_JS_PATH; ?>owl.carousel.min.js"></script>
        <script type="text/javascript" src="<?php print SITE_JS_PATH; ?>cbpAnimatedHeader.js"></script>
        <script type="text/javascript" src="<?php print SITE_JS_PATH; ?>jquery.appear.js"></script>
        <script type="text/javascript" src="<?php print SITE_JS_PATH; ?>SmoothScroll.min.js"></script>
        <script type="text/javascript" src="<?php print SITE_JS_PATH; ?>theme-scripts.js"></script>        
        <script type="text/javascript" src="<?php print SITE_JS_PATH; ?>scripts.js"></script>
        <!--<script type="text/javascript" src="<?php //print SITE_JS_PATH; ?>clearbox.js"></script>-->
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
