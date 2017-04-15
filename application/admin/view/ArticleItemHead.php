<?php
for ($i=0; $i<=$articleCount; $i++) {
    if (!empty($articleArray)) {
        $actCount = $i;
    } else {
        $actCount = $counter;
    }
?>
    <li role="presentation">
        <a href="#columnDiv<?php print $actCount; ?>" onclick="javascript:selectChapter('cikk<?php print $actCount+1; ?>', 'chapterState<?php print $actCount+1; ?>');" role="tab" data-toggle="tab">Hasáb <?php print $actCount; ?></a>
    </li>
<?php
}
