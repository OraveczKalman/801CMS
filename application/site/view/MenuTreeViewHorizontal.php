<ul class="nav navbar-nav ml-auto">
<?php
    for ($i=0; $i<=count($menuItems)-1; $i++) {
        if ($menuItems[$i]['Role'] != 2) {
?>
    <li class="nav-item">
        <a class="nav-link" href="<?php print $menuItems[$i]["Link"]; ?>"><?php print $menuItems[$i]["Caption"]; ?></a>
    </li>
<?php
        } else {
?>
    <li class="nav-item dropdown">
        <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php print $menuItems[$i]["Caption"]; ?><b class="caret"></b></a>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownPortfolio">
<?php
            for ($j=0; $j<=count($menuItems[$i]["subItems"])-1; $j++) {
?>
            <a <?php if ($menuItems[$i]["subItems"][$j]["Target"] != '') { print 'target="' . $menuItems[$i]["subItems"][$j]["Target"] . '"'; } ?> href="<?php print $menuItems[$i]["subItems"][$j]["Link"]; ?>"><?php print $menuItems[$i]["subItems"][$j]["Caption"]; ?></a>
<?php
            }
?>
        </div>
    </li>    
<?php
        }
    }
?>
</ul>

