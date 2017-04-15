<div class="row-fluid">
    <div class="col-sm-12">
<?php
        for ($i=0; $i<=$_SESSION['setupData']['mainMenus']-1; $i++) {
?>
            <div class="panel-group" id="accordion<?php print $i; ?>">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordion<?php print $i; ?>" href="#collapse<?php print $i; ?>">Főmenü <?php print $i; ?></a>
                            <a onclick="javascript: loadNewMenuForm({ parentId:0, parentNode:<?php print $i; ?> })" href="javascript:void(0);"><i class="fa fa-plus"></i></a>                            
                        </h4>
                    </div>
                    <div class="panel-collapse collapse in" id="collapse<?php print $i; ?>">
<?php
            for ($j=0; $j<=count($menuItems[$i])-1; $j++) {
                if ($menuItems[$i][$j]['Role'] == 1 || $menuItems[$i][$j]['Role'] == 2 || $menuItems[$i][$j]['Role'] == 5) {
?>
                    <div id="subAccordion<?php print $i . $j; ?>">
                        <div>
                            <a data-toggle="collapse" data-parent="#subAccordion<?php print $i . $j; ?>" href="#subCollapse<?php print $i . $j; ?>">
                                <?php print $menuItems[$i][$j]['Caption']; ?>
                            </a>
                            <a href="javascript: void(0);" onclick="javascript: loadEditMenuForm({ menuId:<?php print $menuItems[$i][$j]['MainHeaderId']; ?>, parentId:<?php print $i; ?>, parentNode:<?php print $i; ?> });"><i class="fa fa-pencil"></i></a>
                            <a href="javascript: void(0);" onclick="javascript: deleteMenu({ menuId:<?php print $menuItems[$i][$j]['MainHeaderId']; ?> });"><i class="fa fa-eraser"></i></a>
                            <a href="javascript: void(0);" onclick="javascript: loadNewMenuForm({ parentId:<?php print $menuItems[$i][$j]['MainHeaderId']; ?>, parentNode:<?php print $i; ?> })"><i class="fa fa-plus"></i></a>
                        </div>
                        <div style="margin-left:10px;" class="collapse" id="subCollapse<?php print $i . $j; ?>">
<?php
                    if (!empty($menuItems[$i][$j]['subItems'])) {
                        for ($k=0; $k<=count($menuItems[$i][$j]['subItems'])-1; $k++) {
?>
                            <div>
                                <?php print $menuItems[$i][$j]['subItems'][$k]['Caption']; ?>
                                <a href="javascript: void(0);" onclick="javascript: loadEditMenuForm({ menuId:<?php print $menuItems[$i][$j]['subItems'][$k]['MainHeaderId']; ?>, parentId:<?php print $i; ?>, parentNode:<?php print $i; ?> });"><i class="fa fa-pencil"></i></a>
                                <a href="javascript: void(0);" onclick="javascript: deleteMenu({ menuId:<?php print $menuItems[$i][$j]['subItems'][$k]['MainHeaderId']; ?> });"><i class="fa fa-eraser"></i></a>
                            </div>
<?php
                        }
                    }
?>                  
                        </div>
                    </div>
<?php
                } else {
?>
                    <div>
                        <?php print $menuItems[$i][$j]['Caption']; ?>
                        <a href="javascript: void(0);" onclick="javascript: loadEditMenuForm({ menuId:<?php print $menuItems[$i][$j]['MainHeaderId']; ?>, parentId:<?php print $i; ?>, parentNode:<?php print $i; ?> });"><i class="fa fa-pencil"></i></a>
                        <a href="javascript: void(0);" onclick="javascript: deleteMenu({ menuId:<?php print $menuItems[$i][$j]['MainHeaderId']; ?> });"><i class="fa fa-eraser"></i></a>
                    </div>
<?php
                }
            }
?>
                    </div>
                </div>
            </div>
<?php
        }
?>
    </div>
</div>

<ul class="nav navbar-nav navbar-right">
<?php
    for ($i=0; $i<=count($menuItems[$i])-1; $i++) {
?>
    <li>
        <a href="index.html">hírek</a>
    </li>
    <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">az egyesület <b class="caret"></b></a>
        <ul class="dropdown-menu">
            <li>
                <a href="portfolio-1-col.html">a csapat</a>
            </li>
            <li>
                <a href="portfolio-2-col.html">a pálya</a>
            </li>                           
        </ul>
    </li>
    <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">tabella <b class="caret"></b></a>
        <ul class="dropdown-menu">
            <li class="active">
                <a href="blog-home-1.html">felnőtt</a>
            </li>
            <li>
                <a href="blog-home-2.html">U14</a>
            </li>                           
        </ul>
    </li>

    <li>
        <a href="about.html">elérhetőség</a>
    </li>
    <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">pályázatok <b class="caret"></b></a>
        <ul class="dropdown-menu">
            <li class="active">
                <a href="blog-home-1.html">TAO pályázatok 2015</a>
            </li>
            <li>
                <a href="blog-home-2.html">TAO határozatok 2015</a>
            </li>
        </ul>
    </li>
    <li>
        <a href="about.html">éves beszámolók</a>
    </li>
<?php
    }
?>
</ul>

