<?php
for ($i=0; $i<=$articleCount; $i++) {
    if (!empty($articleArray)) {
        $actCount = $i;
    } else {
        $actCount = $counter;
    }
?>
    <li role="presentation">
        <a href="#columnDiv<?php print $actCount; ?>" onclick="javascript:selectChapter('article<?php print $actCount+1; ?>', 'chapterState<?php print $actCount+1; ?>');" role="tab" data-toggle="tab"><?php print $articleFormObject->labels->chapter . ' ' . $actCount; ?></a>
    </li>
<?php
}
