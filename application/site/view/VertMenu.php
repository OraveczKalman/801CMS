<?php
    function vertMenuMain($caption, $link=null) {
        if (is_null($link)) {
?>
        <h3 class="menuheader expandable">
            <?php print $caption; ?>
        </h3>
        
<?php
        } else if (!is_null($link)) {
?>
        <h3 class="menuheader">
            <a href="<?php print $link; ?>"><?php print $caption; ?></a>
        </h3>
<?php
        }
    }

    function vertMenuSub($menuData) {
?>
        <ul class="categoryitems">
<?php
        foreach ($menuData as $menuData2) {
?>
            <li>
                <a href="<?php print $menuData2['Link']; ?>" <?php if ($menuData2['Target'] != '') { print 'target="' . $menuData2['Target'] . '"'; } ?>>
                    <?php print $menuData2['Felirat']; ?>
                </a>
            </li>
<?php
        }
?>
        </ul>
<?php
    }