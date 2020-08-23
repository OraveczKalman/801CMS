        <div class="row">
<?php
for ($i=0; $i<=count($galleryObjects)-1; $i++) {
?>
            <div class="col-md-6 col-lg-4 item">
                <a class="thumbnail" data-fancybox="gallery" href="<?php print UPLOADED_MEDIA_PATH . $galleryObjects[$i]['kep_nev_big']; ?>">
                    <img src="<?php print UPLOADED_MEDIA_PATH . $galleryObjects[$i]['kep_nev']; ?>" />
                </a>
            </div>
<?php
}
?>
        </div>