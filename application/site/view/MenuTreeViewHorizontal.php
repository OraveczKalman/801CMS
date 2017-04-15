<ul class="nav navbar-nav navbar-right">
<?php
    for ($i=0; $i<=count($menuItems)-1; $i++) {
        if ($menuItems[$i]['Role'] != 1) {
?>
    <li>
        <a href="<?php print $menuItems[$i]["Link"]; ?>"><?php print $menuItems[$i]["Caption"]; ?></a>
    </li>
<?php
        } else {
?>
    <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php print $menuItems[$i]["Caption"]; ?><b class="caret"></b></a>
        <ul class="dropdown-menu">
<?php
            for ($j=0; $j<=count($menuItems[$i]["subItems"])-1; $j++) {
?>
            <li>
                <a <?php if ($menuItems[$i]["subItems"][$j]["Target"] != '') { print 'target="' . $menuItems[$i]["subItems"][$j]["Target"] . '"'; } ?> href="<?php print $menuItems[$i]["subItems"][$j]["Link"]; ?>"><?php print $menuItems[$i]["subItems"][$j]["Caption"]; ?></a>
            </li>
<?php
            }
?>
        </ul>
    </li>    
<?php
        }
    }
?>
</ul>

