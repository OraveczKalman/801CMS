<ul class="navbar-nav text-uppercase ml-auto">
<?php
    for ($i=0; $i<=count($menuItems)-1; $i++) {
?>
    <li class="nav-item">
        <a class="nav-link js-scroll-trigger" href="#s<?php print $i; ?>"><?php print $menuItems[$i]["Caption"]; ?></a>
    </li>
<?php
    }
?>
</ul>

