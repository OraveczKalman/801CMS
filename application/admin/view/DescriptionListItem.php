<?php
for ($i=0; $i<=$descriptionCount; $i++) {
    if (!empty($descriptionArray)) {
        $actCount = $i;
    } else {
        $actCount = $counter;
    }
?>
    <div class="form-group">
        <label for="description<?php print $actCount; ?>" class="col-sm-2 control-label">Képaláírás:</label>
        <div class="col-sm-10">
            <input class="form-control" onkeyup="javascript: descriptionStateChange('descriptionState<?php print $actCount; ?>');" type="text" <?php if (isset($descriptionArray[$actCount]['Text'])) { print 'value="' . $descriptionArray[$actCount]['Text'] . '"'; }?> id="description<?php print $actCount; ?>" name="descriptions[<?php print $actCount; ?>][Text]">
            <input type="hidden" id="descriptionState<?php print $actCount; ?>" name="descriptions[<?php print $actCount; ?>][descriptionState]" value="<?php if (empty($descriptionArray)) { print 1; } else { print 2; } ?>">
<?php
    if (!empty($descriptionArray)) {
?>
            <input type="hidden" id="textId<?php print $actCount; ?>" name="descriptions[<?php print $actCount; ?>][TextId]" value="<?php print $descriptionArray[$i]["TextId"]; ?>" /> 
<?php
    }
?>
        </div>
    </div>
    <div style="clear:both;"></div>
<?php
}