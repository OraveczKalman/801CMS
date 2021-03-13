<div class="card shadow mb-12">
    <div class="card-header py-3">
        <ul class="nav nav-pills" id="langTab" role="tablist">
<?php
        for ($i=0; $i<=count($languageList)-1; $i++) {
?>
            <li class="nav-item">
                <a class="nav-link <?php if ($i==0) { print "active"; } ?>" id="langItem<?php print $languageList[$i]["LanguageSign"]; ?>" href="#lang<?php print $languageList[$i]["LanguageSign"]; ?>" data-toggle="pill" role="tab"><?php print $languageList[$i]["Description"]; ?></a>
            </li>
<?php
        }
?>
        </ul>        
    </div>
    <div class="card-body tab-content">
<?php
        foreach ($menuItems as $key=>$value) {
?>
        <div class="tab-pane active" id="lang<?php print $key; ?>" role="tabpanel" aria-labelledby="langItem<?php print $key; ?>">
            <ul>
<?php
            for ($i=0; $i<=count($value)-1; $i++) {
?>
                <li>
                    <?php print $value[$i]["Caption"]; ?>
                    <a onclick="javascript: loadNewMenuForm({ parentId:0, parentNode:<?php print $value[$i]["MainNode"]; ?> })" href="javascript:void(0);"><i class="fa fa-plus"></i></a>
                    <ul>
<?php
                for ($j=0; $j<=count($value[$i]["items"])-1; $j++) {
?>
                        <li>
                            <?php print $value[$i]["items"][$j]["Caption"]; ?>
                            <a href="javascript: void(0);" onclick="javascript: loadEditMenuForm({ menuId:<?php print $value[$i]["items"][$j]['MainHeaderId']; ?>, parentId:<?php print $j; ?>, parentNode:<?php print $i; ?> });"><i class="fa fa-pencil-alt"></i></a>
                            <a href="javascript: void(0);" onclick="javascript: deleteMenu({ menuId:<?php print $value[$i]["items"][$j]['MainHeaderId']; ?> });"><i class="fa fa-eraser"></i></a>

<?php
    if ($value[$i]["items"][$j]["Role"] == 2) {
?>
                            <a href="javascript: void(0);" onclick="javascript: loadNewMenuForm({ parentId:<?php print $value[$i]["items"][$j]['MainHeaderId']; ?>, parentNode:<?php print $i; ?>, parentRole:<?php print $value[$i]["items"][$j]['Role']; ?> })"><i class="fa fa-plus"></i></a>
<?php
        if(!empty($value[$i]["items"][$j]["subItems"])) {
?>
                            <ul>
<?php
            for ($k=0; $k<=count($value[$i]["items"][$j]["subItems"])-1; $k++) {
?>
                                <li><?php print $value[$i]["items"][$j]["subItems"][$k]["Caption"]; ?>
                                    <a href="javascript: void(0);" onclick="javascript: loadEditMenuForm({ menuId:<?php print $value[$i]["items"][$j]["subItems"][$k]['MainHeaderId']; ?>, parentId:<?php print $value[$i]["items"][$j]['MainHeaderId']; ?>, parentNode:<?php print $i; ?> });"><i class="fa fa-pencil-alt"></i></a>
                                    <a href="javascript: void(0);" onclick="javascript: deleteMenu({ menuId:<?php print $value[$i]["items"][$j]["subItems"][$k]['MainHeaderId']; ?> });"><i class="fa fa-eraser"></i></a>
                                </li>

<?php
            }
        }
?>
                            </ul>
<?php
    }
?>
                        </li>
<?php
                }
?>
                    </ul>
                </li>
<?php
            }
?>
            </ul>
        </div>
<?php
        }
?>
    </div>
</div>

<div class="card shadow mb-12">
    <div class="card-header py-3">
        <ul class="nav nav-pills" id="langTab" role="tablist">
<?php
        for ($i=0; $i<=count($languageList)-1; $i++) {
?>
            <li class="nav-item">
                <a class="nav-link <?php if ($i==0) { print "active"; } ?>" id="langItem<?php print $i; ?>" href="#lang<?php print $i; ?>" data-toggle="pill" role="tab"><?php print $languageList[$i]["Description"]; ?></a>
            </li>
<?php
        }
?>
        </ul>
    </div>
    <div class="card-body tab-content">
<?php
        if (!empty($menuItems)) {
            for ($i=0; $i<=count($menuItems)-1; $i++) {
                for ($j=0; $j<=count($menuItems[$i])-1; $j++) {
?>
        <div class="tab-pane fade <?php if ($i==0) { print "show active"; } ?>" id="lang<?php print $i; ?>" role="tabpanel" aria-labelledby="langItem<?php print $i; ?>">
            <a data-toggle="collapse" href="#collapse<?php print $i; ?>">Főmenü<?php print $menuItems[$i][$j]["MainNode"]; ?></a>
            <a onclick="javascript: loadNewMenuForm({ parentId:0, parentNode:<?php print $menuItems[$i][$j]["MainNode"]; ?> })" href="javascript:void(0);"><i class="fa fa-plus"></i></a>
            <div class="collapse in" id="collapse<?php print $i; ?>">
<?php
            for ($k=0; $k<=count($menuItems[$i][$j]["items"])-1; $k++) {
                if ($menuItems[$i][$j]["items"][$k]["Role"] == 1 || $menuItems[$i][$j]["items"][$k]["Role"] == 2) {
?>
            <div id="subAccordion<?php print $i . $j; ?>">
                <div>
                    <a data-toggle="collapse" data-parent="#subAccordion<?php print $i . $j; ?>" href="#subCollapse<?php print $i . $j; ?>"><?php print $menuItems[$i][$j]["Caption"]; ?></a>
                    <a href="javascript: void(0);" onclick="javascript: loadEditMenuForm({ menuId:<?php print $menuItems[$i][$j]['MainHeaderId']; ?>, parentId:<?php print $i; ?>, parentNode:<?php print $i; ?> });"><i class="fa fa-pencil-alt"></i></a>
                    <a href="javascript: void(0);" onclick="javascript: deleteMenu({ menuId:<?php print $menuItems[$i][$j]['MainHeaderId']; ?> });"><i class="fa fa-eraser"></i></a>
                    <a href="javascript: void(0);" onclick="javascript: loadNewMenuForm({ parentId:<?php print $menuItems[$i][$j]['MainHeaderId']; ?>, parentNode:<?php print $i; ?>, parentRole:<?php print $menuItems[$i][$j]['Role']; ?> })"><i class="fa fa-plus"></i></a>
                </div>
                <div style="margin-left:10px;" class="collapse" id="subCollapse<?php print $i . $j; ?>">
<?php
                    if (!empty($menuItems[$i][$j]['subItems'])) {
                        for ($k=0; $k<=count($menuItems[$i][$j]['subItems'])-1; $k++) {
?>
                            <div>
                                <?php print $menuItems[$i][$j]['subItems'][$k]['Caption']; ?>
                                <a href="javascript: void(0);" onclick="javascript: loadEditMenuForm({ menuId:<?php print $menuItems[$i][$j]['subItems'][$k]['MainHeaderId']; ?>, parentId:<?php print $i; ?>, parentNode:<?php print $i; ?> });"><i class="fa fa-pencil-alt"></i></a>
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
                <?php print $menuItems[$i][$j]["Caption"]; ?>
                <a href="javascript: void(0);" onclick="javascript: loadEditMenuForm({ menuId:<?php print $menuItems[$i][$j]['MainHeaderId']; ?>, parentId:<?php print $i; ?>, parentNode:<?php print $i; ?> });"><i class="fa fa-pencil-alt"></i></a>
                <a href="javascript: void(0);" onclick="javascript: deleteMenu({ menuId:<?php print $menuItems[$i][$j]['MainHeaderId']; ?> });"><i class="fa fa-eraser"></i></a>           
            </div>
<?php                  
                }
            }
?>
            </div>
        </div>
<?php
            
                }
            }
        } else {
?>
        <p>Még nincs menüpont!</p>
<?php
        }
?>
    </div>
</div>

<div class="card shadow mb-12" style="margin-top: 1rem;">
    <div class="card-header py-3">&nbsp;</div>
    <div class="card-body">
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
