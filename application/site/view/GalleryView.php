<?php
for ($i=0; $i<=count($galleryObjects)-1; $i++) {
?>
    <img src="<?php print UPLOADED_MEDIA_PATH . $galleryObjects[$i]['kep_nev']; ?>" />
<?php
}