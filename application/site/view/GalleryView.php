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
    </div>
</section>