<?php
	for ($i=0; $i<=count($galleryObjects)-1; $i++) {
?>
        <div class="row" style="margin-bottom: 1rem;">
            <div class="col-sm-4">
		<img class="img-thumbnail img-responsive" src="../<?php print $galleryObjects[$i]['kep_nev']; ?>">			
            </div>
            <div class="col-sm-8">
		<?php print $galleryObjects[$i]['buttons']; ?>
            </div>
        </div>
<?php
	}