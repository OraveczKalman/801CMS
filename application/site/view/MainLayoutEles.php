<?php
$address = $_SESSION['prefix'] .'://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
?>

<!DOCTYPE HTML>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <meta name="keywords" content="<?php print $menuPoint[0]['Kulcsszavak']; ?>"/>
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
        <link href="<?php print SITE_CSS_PATH; ?>modern-business.css" rel="stylesheet">
        <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->

        <title><?php print $_SESSION['setupData']['siteTitle']; if (isset($menuPoint[0]['Title'])) { print ' - ' . $menuPoint[0]['Title']; } ?></title>

        <script type="text/javascript" src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
        <script type="text/javascript" src="<?php print SITE_JS_PATH; ?>scripts.js"></script>
        <script type="text/javascript" src="<?php print SITE_JS_PATH; ?>jquery.form.js"></script>
        <script type="text/javascript" src="<?php print SITE_JS_PATH; ?>clearbox.js"></script>

        <script>
            (function (d, s, id) {
                var js, fjs = d.getElementsByTagName(s)[0];
                if (d.getElementById(id)) return;
                js = d.createElement(s);
                js.id = id;
                js.src = "//connect.facebook.net/hu_HU/all.js#xfbml=1&appId=231522500287850";
                fjs.parentNode.insertBefore(js, fjs);
            }(document, 'script', 'facebook-jssdk'));
        </script>
    </head>

    <body>
        <div id="popupContainer"></div>
        <div id="fb-root"></div>

        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="true">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="index.html"><?php print $_SESSION['setupData']['siteTitle']; ?></a>
                </div>
                <div class="navbar-collapse collapse in" id="bs-example-navbar-collapse-1" aria-expanded="true" style="">

                </div>
            </div>
        </nav>
        
        <header id="myCarousel" class="carousel slide">
            <!-- Indicators -->
            <ol class="carousel-indicators">
                <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                <li data-target="#myCarousel" data-slide-to="1"></li>
                <li data-target="#myCarousel" data-slide-to="2"></li>
            </ol>

            <!-- Wrapper for slides -->
            <div class="carousel-inner">
                <div class="item active">
                    <div class="fill" style="background-image:url('http://placehold.it/1900x1080&text=Slide One');"></div>
                    <div class="carousel-caption">
                        <h2>Caption 1</h2>
                    </div>
                </div>
                <div class="item">
                    <div class="fill" style="background-image:url('http://placehold.it/1900x1080&text=Slide Two');"></div>
                    <div class="carousel-caption">
                        <h2>Caption 2</h2>
                    </div>
                </div>
                <div class="item">
                    <div class="fill" style="background-image:url('http://placehold.it/1900x1080&text=Slide Three');"></div>
                    <div class="carousel-caption">
                        <h2>Caption 3</h2>
                    </div>
                </div>
            </div>

            <!-- Controls -->
            <a class="left carousel-control" href="#myCarousel" data-slide="prev">
                <span class="icon-prev"></span>
            </a>
            <a class="right carousel-control" href="#myCarousel" data-slide="next">
                <span class="icon-next"></span>
            </a>
        </header>
        
          <!-- Page Content -->
        <div class="container">
            <!-- Page Heading/Breadcrumbs -->
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">ÜSC
                        <small>hírek, információk</small>
                    </h1>              
                </div>
            </div>
            <!-- /.row -->
            <div class="row">
                <!-- Blog Entries Column -->
                <div class="col-md-8">
                    <!-- First Blog Post -->
                    <h2>
                        <a href="#">Edzések 2015. 11.21-28-ig</a>
                    </h2>
                    <hr>
                    <a href="blog-post.html">
                        <img class="img-responsive img-hover" src="http://placehold.it/900x300" alt="">
                    </a>
                    <hr>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolore, veritatis, tempora, necessitatibus inventore nisi quam quia repellat ut tempore laborum possimus eum dicta id animi corrupti debitis ipsum officiis rerum.</p>
                    <a class="btn btn-primary" href="#">Read More <i class="fa fa-angle-right"></i></a>
                    <hr>

                    <!-- Pager -->
                    <ul class="pager">
                        <li class="previous">
                            <a href="#">← Older</a>
                        </li>
                        <li class="next">
                            <a href="#">Newer →</a>
                        </li>
                    </ul>
                </div>

                <!-- Blog Sidebar Widgets Column -->
                <div class="col-md-4">
                    <!-- face -->
                    <div class="well">
                        <div id="fb-like-box">
                            <div class="fb-like-box" data-href="https://www.facebook.com/uromisportclub?fref=ts" data-width="292" data-colorscheme="light" data-show-faces="true" data-header="true" data-stream="true" data-show-border="true"></div>
                        </div>
                    </div>
                    <!-- Side Widget Well -->
                    <div class="well">
                        <h4>támogatók</h4>
                        <p align="center"><a href="http://www.urom.hu" target="_blank"><img src="<?php print SITE_IMAGE_PATH; ?>/urom.gif" alt="Üröm" width="70" height="100" border="0"/></a></p>				
                        <p align="center"><a href="http://gyogyaszati-talpbetet.hu/index.html" target="_blank"><img src="<?php print SITE_IMAGE_PATH; ?>/batz.jpg" alt="batz" width="100" height="103" border="0" /></a></p>
                        <p align="center"><a href="http://www.fordsolymar.hu/" target="_blank"><img src="<?php print SITE_IMAGE_PATH; ?>/fordsolymar.jpg" alt="Ford Solymár" width="100" height="80" border="0" /></a></p> 
                        <p align="center"><a href="http://humadala.com/" target="_blank"><img src="<?php print SITE_IMAGE_PATH; ?>/humadala.gif" alt="humadala" width="100" height="66" border="0" /></a></p>
                        <p align="center"><img src="<?php print SITE_IMAGE_PATH; ?>/zodiac.jpg" alt="zodiac" width="154" height="80" border="0" /></a></p>
                        <p align="center"><a href="http://www.euronovex.eu/" target="_blank"><img src="<?php print SITE_IMAGE_PATH; ?>/euronovex.jpg" alt="euro-novex" width="154" height="48" border="0" /></a></p>      
                        <p align="center"><a href="http://www.gtm.hu/ecard/euro-rubber-kft" target="_blank"><img src="<?php print SITE_IMAGE_PATH; ?>/eurorubber.jpg" alt="euro-rubber" width="154" height="48" border="0" /></a></p>  
                    </div>
                </div>
            </div>
            <!-- /.row -->
            <hr>
            <!-- Footer -->
            <footer>
                <div class="row">
                    <div class="col-lg-12">
                        <h3 align="center" class="style1">&Uuml;r&ouml;mi Sport Club  hivatalos honlapja</h3>
                        <p align="center" class="style2">
                            Seg&iacute;ts&uuml;k az &Uuml;SC-t t&aacute;rsas&aacute;gi ad&oacute; egy r&eacute;sz&eacute;nek felaj&aacute;nl&aacute;s&aacute;val! 
                            Ad&oacute;sz&aacute;m:18716803-1-13 
                            Banksz&aacute;mlasz&aacute;m: 65700093-10134937
                        </p>
                    </div>
                </div>
            </footer>
        </div>
        
<?php
                /*$dataArray[0]['event'] = 'RenderMenuItems';
                $dataArray[0]['menuQueue'] = 1;
                $menuSide = new MenuTreeController($dataArray, $this->db);*/
?>
<?php
    /*include_once(SITE_CONTROLLER_PATH . $controllerName . '.php');
    $controllerRout = new $controllerName($menuPoint, $this->db);*/
?>
        <script type="text/javascript">
            var _gaq = _gaq || [];
            _gaq.push(['_setAccount', 'UA-29326599-1']);
            _gaq.push(['_trackPageview']);

            (function() {
            var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
            ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
            var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
            })();
        </script>
    </body>
</html>
