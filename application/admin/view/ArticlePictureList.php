<?php
	for ($i=0; $i<=count($galleryObjects)-1; $i++) {
?>
        <div class="row-fluid">
            <div class="col-sm-4">
		<img class="img-thumbnail img-responsive" src="<?php print $galleryObjects[$i]['kep_nev']; ?>">			
            </div>
            <div class="col-sm-8">
		<?php print $galleryObjects[$i]['buttons']; ?>
            </div>
        </div>
        <div style="clear:both;"></div>
<?php
	}