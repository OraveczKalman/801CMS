<?php
/**
 * Created by PhpStorm.
 * User: Oravecz Kálmán
 * Date: 2015.03.06.
 * Time: 16:53
 */
?>
<header class="intro">
    <div class="intro-body">
        <div class="container">
            <div class="row ">
                <div class="col-lg-4 rowheight" ><img src="img/tigrincs.png" alt="tigrincsnyúl" width="304" height="315"></div>
                <div class="col-lg-8 rowheight second carousel slide" data-ride="carousel">
                    <div class="carousel-inner">
<?php
                        $news1 = new NewsController($newsStreams[0], $this->db);
?>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-8 rowheight third carousel slide" data-ride="carousel">
                    <div class="carousel-inner">
<?php
                        $news2 = new NewsController($newsStreams[1], $this->db);
?>
                    </div>
                </div>
                <div class="col-lg-4 rowheight fourth">negyedik</div>
            </div>
        </div>
    </div>
    <footer>
        <div class="col-lg-12 footer"> Tigrincsnyúlword</div>
    </footer>
</header>