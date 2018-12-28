<?php
for ($i=0; $i<=$articleCount; $i++) {
    if (!empty($articleArray)) {
        $actCount = $i;
    } else {
        $actCount = $counter;
    }
?>
    <div role="tabpanel" role="tabpanel" class="tab-pane <?php if ($actCount==0) { print "active"; } ?> articleItem" id="columnDiv<?php print $actCount; ?>">
        <textarea name="article[<?php print $actCount+1; ?>][Text]" id="article<?php print $actCount+1; ?>" cols="60" rows="20"><?php if (isset($articleArray[$actCount]['Text'])) { print $articleArray[$actCount]['Text']; } ?></textarea>
        <input type="hidden" id="articleId<?php print $actCount+1; ?>" name="article[<?php print $actCount+1; ?>][TextId]" value="<?php if (isset($articleArray[$actCount]['TextId'])) { print $articleArray[$actCount]['TextId']; } ?>" />
        <input type="hidden" id="type<?php print $actCount+1; ?>" name="article[<?php print $actCount+1; ?>][Type]" value="2" />
        <input type="hidden" id="language<?php print $actCount+1; ?>" name="article[<?php print $actCount+1; ?>][Language]" value="hu" />
        <input type="hidden" id="chapterState<?php print $actCount+1; ?>" name="article[<?php print $actCount+1; ?>][ChapterState]" value="<?php if (empty($articleArray)) { print 1; } else { print 0; } ?>" />
        <input type="hidden" id="superior<?php print $actCount+1; ?>" name="article[<?php print $actCount+1; ?>][SuperiorId]" value="<?php if (isset($articleArray[$actCount]['SuperiorId'])) { print $articleArray[$actCount]['SuperiorId']; } else { print $this->dataArray[0]['MainHeaderId']; } ?>" />
    </div>
    <script type="text/javascript">
        addNewEditor('article<?php print $actCount+1; ?>', <?php print $actCount+1; ?>);
    </script>
<?php
}
