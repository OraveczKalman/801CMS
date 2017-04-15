<div class="row">
<?php
    foreach ($timelineArray['headerData'] as $headerArray) {
?>
    <div class="col-sm-2 col-xs-12">
        <div>
            <a href="GetByGenre/<?php print $headerArray['GenreName']; ?>">
<?php
            print $headerArray['GenreName'];
?>
            </a>
        </div>
<?php
        foreach ($timelineArray['columnData'][$headerArray['GenreName']] as $columnData) {
?>
        <div>
            <a href="../<?php print $columnData['Link']; ?>">
<?php
            print $columnData['Felirat'];
?>
            </a>
        </div>
<?php
        }
?>
    </div>
<?php
    }
?>
</div>