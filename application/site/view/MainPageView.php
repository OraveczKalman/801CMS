<header>
    <div id="carouselIndicators" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
<?php
            print $indicators;
?>
        </ol>
        <div class="carousel-inner" role="listbox">
<?php
            print $carousel;
?>
        </div>
        <a class="carousel-control-prev" href="#carouselIndicators" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselIndicators" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>
</header>

<div class="container">
    <h1 class="my-4">Üdvözöllek az oldalamon</h1>
    <div class="row">
        <div class="col-lg-4 mb-4">
            <div class="card h-100">
                <h4 class="card-header">Bemutatkozás</h4>
                <div class="card-body">
                    <p class="card-text">Bemutatkozás</p>
                </div>
                <div class="card-footer">
                    <a href="#" class="btn btn-primary">Tovább</a>
                </div>
            </div>
        </div>
        <div class="col-lg-4 mb-4">
            <div class="card h-100">
                <h4 class="card-header">Önéletrajz</h4>
                <div class="card-body">
                    <p class="card-text">Önéletrajz</p>
                </div>
                <div class="card-footer">
                    <a href="#" class="btn btn-primary">Tovább</a>
                </div>
            </div>
        </div>
    </div>
</div>