<?php
	for ($i=0; $i<=count($galleryObjects)-1; $i++) {
            if ($iPod || $iPhone || $iPad) {
                $ext = $galleryObjects[$i]["OriginalExtension"];
            } else {
                $ext = "webp";
            }
?>
        <div class="row" style="margin-bottom: 1rem;">
            <div class="col-sm-4">
		<img class="img-thumbnail img-responsive" src="../<?php print $galleryObjects[$i]['kep_nev'] . "." . $ext; ?>">			
            </div>
            <div class="col-sm-8">
		<?php print $galleryObjects[$i]['buttons']; ?>
            </div>
        </div>
<?php
	}