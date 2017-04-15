<?php
for ($i=0; $i<=$articleCount; $i++) {
    if (!empty($articleArray)) {
        $actCount = $i;
    } else {
        $actCount = $counter;
    }
?>
    <div role="tabpanel" role="tabpanel" class="tab-pane <?php if ($actCount==0) { print "active"; } ?> articleItem" id="columnDiv<?php print $actCount; ?>">
        <textarea name="cikk[<?php print $actCount+1; ?>][Szoveg]" id="cikk<?php print $actCount+1; ?>" cols="60" rows="20"><?php if (isset($articleArray[$actCount]['Text'])) { print $articleArray[$actCount]['Text']; } ?></textarea>
        <input type="hidden" id="cikkId<?php print $actCount+1; ?>" name="cikk[<?php print $actCount+1; ?>][SzovegId]" value="<?php if (isset($articleArray[$actCount]['TextId'])) { print $articleArray[$actCount]['TextId']; } ?>" />
        <input type="hidden" id="tipus<?php print $actCount+1; ?>" name="cikk[<?php print $actCount+1; ?>][Tipus]" value="2" />
        <input type="hidden" id="nyelv<?php print $actCount+1; ?>" name="cikk[<?php print $actCount+1; ?>][Nyelv]" value="hu" />
        <input type="hidden" id="chapterState<?php print $actCount+1; ?>" name="cikk[<?php print $actCount+1; ?>][chapterState]" value="<?php if (empty($articleArray)) { print 1; } else { print 0; } ?>" />
        <input type="hidden" id="felettes<?php print $actCount+1; ?>" name="cikk[<?php print $actCount+1; ?>][FelettesId]" value="<?php if (isset($articleArray[$actCount]['SuperiorId'])) { print $articleArray[$actCount]['SuperiorId']; } else { print $this->dataArray[0]['MainHeaderId']; } ?>" />
    </div>
    <script type="text/javascript">
        addNewEditor('cikk<?php print $actCount+1; ?>', <?php print $actCount+1; ?>);
    </script>
<?php
}
