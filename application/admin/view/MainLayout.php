<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="<?php if (!isset($_SESSION['setupData']['siteAuthor'])) { print "Site author not set"; } else { print $_SESSION['setupData']['siteAuthor']; } ?>">
    <title><?php if (!isset($_SESSION['setupData']['siteTitle'])) { print "Untitled Site"; } else { print $_SESSION['setupData']['siteTitle']; } ?></title>
    <!-- Custom fonts for this template-->
    <link href="<?php print ADMIN_CSS_PATH; ?>fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <!-- Custom styles for this template-->
    <link href="<?php print ADMIN_CSS_PATH; ?>sb-admin-2.css" rel="stylesheet">
    <link href="<?php print ADMIN_CSS_PATH; ?>jquery.Jcrop.min.css" rel="stylesheet" type="text/css">
    <style type="text/css">
        .modal-lg { width:100%; }
    </style>
</head>

<body id="page-top">
    <!-- page wrapper -->
    <div id="wrapper">
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion">
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-laugh-wink"></i>
                </div>
                <div class="sidebar-brand-text mx-3">Oravecz Kálmán</div>
            </a>
            <hr class="sidebar-divider my-0">
            <li class="nav-item active">
                <a class="nav-link" href="index.html">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <hr class="sidebar-divider">
            <div class="sidebar-heading">Beállítások</div>
            <li class="nav-item">
                <a class="nav-link" href="../admin/LanguageForm">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span><?php print $adminMainMenu->labels->languageForm; ?></span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="../admin/ContactForm">
                    <i class="fas fa-fw fa-chart-area"></i>
                    <span><?php print $adminMainMenu->labels->contactForm; ?></span>
                </a>
            </li>
            <hr class="sidebar-divider">
            <div class="sidebar-heading">Felhasználók</div>
            <li class="nav-item">
                <a class="nav-link" href="../admin/User">
                    <i class="fas fa-fw fa-chart-area"></i>
                    <span><?php print $adminMainMenu->labels->userHandling; ?></span>
                </a>
            </li>
            <hr class="sidebar-divider">
            <div class="sidebar-heading">Oldal</div>
            <li class="nav-item">
                <a class="nav-link" href="../admin/Setup">
                    <i class="fas fa-fw fa-table"></i>
                    <span><?php print $adminMainMenu->labels->siteSetup; ?></span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="../admin/MenuTree">
                    <i class="fas fa-fw fa-table"></i>
                    <span><?php print $adminMainMenu->labels->editSite; ?></span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="../admin/Gallery">
                    <i class="fas fa-fw fa-table"></i>
                    <span><?php print $adminMainMenu->labels->media; ?></span>
                </a>
            </li>
            <hr class="sidebar-divider d-none d-md-block">
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>
        </ul>
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Topbar Search -->
                    <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                        <div class="input-group">
                            <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="button">
                                    <i class="fas fa-search fa-sm"></i>
                                </button>
                            </div>
                        </div>
                    </form>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                        <li class="nav-item dropdown no-arrow d-sm-none">
                            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-search fa-fw"></i>
                            </a>
                            <!-- Dropdown - Messages -->
                            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in" aria-labelledby="searchDropdown">
                                <form class="form-inline mr-auto w-100 navbar-search">
                                    <div class="input-group">
                                        <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button">
                                                <i class="fas fa-search fa-sm"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </li>

                        <!-- Nav Item - Alerts -->
                        <!--<li class="nav-item dropdown no-arrow mx-1">
                            <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-bell fa-fw"></i>
                            </a>
                            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="alertsDropdown">
                            </div>
                        </li>-->

                        <!-- Nav Item - Messages -->
                        <!--<li class="nav-item dropdown no-arrow mx-1">
                            <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-envelope fa-fw"></i>
                            </a>
                            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="messagesDropdown">
                            </div>
                        </li>-->

                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php print $_SESSION["admin"]["userData"]["Name"]; ?></span>
                                <!--<img class="img-profile rounded-circle" src="https://source.unsplash.com/QAB-WJcbgJk/60x60">-->
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Profile
                                </a>
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Settings
                                </a>
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Activity Log
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="../admin/Logout">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>
                    </ul>
                </nav>
                <!-- Begin Page Content -->
                <div class="container-fluid" id="form-wrapper">
<?php
    include_once(ADMIN_CONTROLLER_PATH . $controllerName . '.php');
    $controllerRout = new $controllerName($menuPoint, $this->db);
?>            
                </div>             
            </div>
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Your Website <?php print date("Y"); ?></span>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <div class="modal" tabindex="-1" role="dialog" id="formModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content" id="modalContainer"></div>
        </div>
    </div>
    <div class="modal" tabindex="-1" role="dialog" id="lgFormModal">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content" id="lgModalContainer"></div>
        </div>
    </div>
    <div class="modal" tabindex="-1" role="dialog" id="MessageBox">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body" id="MessageBody"></div>
            </div>
        </div>
    </div>

    <script type="text/javascript" src="<?php print COMMON_JS_PATH; ?>jquery-2.1.3.min.js"></script>
    <script type="text/javascript" src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
    <script type="text/javascript" src="<?php print COMMON_JS_PATH; ?>jquery.form.min.js"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="<?php print COMMON_JS_PATH; ?>bootstrap.min.js"></script>
    <!--Custom JavaScript -->
    <script src="<?php print ADMIN_JS_PATH; ?>sb-admin.js"></script>
    <!--This page JavaScript -->
    <!-- <script src="../../dist/js/pages/dashboards/dashboard1.js"></script> -->
    <!-- Charts js Files -->
    <script type="text/javascript" src="<?php print ADMIN_JS_PATH; ?>jquery.Jcrop.min.js"></script>
    <script type="text/javascript" src="<?php print ADMIN_JS_PATH; ?>CoreScripts.js"></script>

    <script type="text/javascript" src="//cdn.ckeditor.com/4.4.7/full/ckeditor.js"></script>
    <script type="text/javascript" src="//cdn-source.ckeditor.com/4.4.7/standard/adapters/jquery.js"></script>
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
<?php
    $controllerRout->getFooter();
?>
</body>

</html>