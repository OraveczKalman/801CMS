        <div class="row">
<?php
$iPod    = stripos($_SERVER['HTTP_USER_AGENT'],"iPod");
$iPhone  = stripos($_SERVER['HTTP_USER_AGENT'],"iPhone");
$iPad    = stripos($_SERVER['HTTP_USER_AGENT'],"iPad");
$Android = stripos($_SERVER['HTTP_USER_AGENT'],"Android");
$webOS   = stripos($_SERVER['HTTP_USER_AGENT'],"webOS");

for ($i=0; $i<=count($galleryObjects)-1; $i++) {
    if ($iPod || $iPhone || $iPad) {
        $ext = $galleryObjects[$i]["OriginalExtension"];
    } else {
        $ext = "webp";
    }    
?>
            <div class="col-md-6 col-lg-4 item">
                <a class="thumbnail" data-fancybox="gallery" href="<?php print UPLOADED_MEDIA_PATH . $galleryObjects[$i]['kep_nev_big'] . "." . $ext; ?>">
                    <img src="<?php print UPLOADED_MEDIA_PATH . $galleryObjects[$i]['kep_nev'] . "." . $ext; ?>" />
                </a>
            </div>
<?php
}
?>
        </div>