<div class="row-fluid">
    <div class="col-sm-12">
        <h1>Oldal szerkesztése</h1>
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
                if ($menuItems[$i][$j]['Role'] == 1 || $menuItems[$i][$j]['Role'] == 2 || $menuItems[$i][$j]['Role'] == 5 || $menuItems[$i][$j]['Role'] == 21) {
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
        <div class="panel-group" id="ModuleContainer">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#ModuleContainer" href="#">Modulok</a>
                        <a onclick="javascript: loadNewMenuForm({ parentId:0, parentNode:<?php print $i; ?> })" href="javascript:void(0);"><i class="fa fa-plus"></i></a>                         
                    </h4>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row-fluid">
    <div class="col-sm-12">
    </div>
</div>