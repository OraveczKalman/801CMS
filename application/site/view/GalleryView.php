<h1 class="mt-4 mb-3">
    <small><?php print $this->articleLabels->labels->authorLabel; ?>: <a href="#"><?php print $this->dataArray[0]['Name']; ?></a></small>
</h1>

<ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="#"><?php print $this->articleLabels->labels->breadCrumbHomeLabel; ?></a>
    </li>
</ol>
<section class="gallery-block grid-gallery">
    <div class="container">
        <div class="row">
<?php
$iPod    = stripos($_SERVER['HTTP_USER_AGENT'],"iPod");
$iPhone  = stripos($_SERVER['HTTP_USER_AGENT'],"iPhone");
$iPad    = stripos($_SERVER['HTTP_USER_AGENT'],"iPad");
$Android = stripos($_SERVER['HTTP_USER_AGENT'],"Android");
$webOS   = stripos($_SERVER['HTTP_USER_AGENT'],"webOS");

//do something with this information
if ($iPod || $iPhone || $iPad) {
    $ext = $galleryObjects[$i]["OriginalExtension"];
} else {
    $ext = "webp";
}
for ($i=0; $i<=count($galleryObjects)-1; $i++) {
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
    </div>
</section>