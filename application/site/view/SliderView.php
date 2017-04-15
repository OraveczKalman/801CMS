<header>
    <div class="container-fluid">
        <div class="slider-container">
            <div class="owl-slider owl-carousel">
<?php
            for ($i=0; $i<=count($galleryObjects)-1; $i++) {
?>
                <div class="item">
                    <div class="owl-slider-item">
                        <img src="<?php print UPLOADED_MEDIA_PATH . $galleryObjects[$i]['kep_nev_big']; ?>" class="img-responsive" alt="portfolio">
                        <div class="intro-text">
                            <div class="intro-lead-in">Próba szöveg</div>
                            <div class="intro-heading">Próba szöveg</div>
                        </div>
                    </div>
                </div>
<?php
            }
?>
            </div>
        </div>
    </div>
</header>