<h1 class="mt-4 mb-3">Blog Home One
    <small>Subheading</small>
</h1>
<ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="index.html">Home</a>
    </li>
    <li class="breadcrumb-item active">Blog Home 1</li>
</ol>
<?php
    foreach ($newsData as $newsData2) {
?>
    <div class="card mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col-lg-6">
                    <a href="#">
                        <img class="img-fluid rounded" src="http://placehold.it/750x300" alt="">
                    </a>
                </div>
                <div class="col-lg-6">
                    <h2 class="card-title"><?php print $newsData2['Title']; ?></h2>
                    <p class="card-text"><?php print $newsData2['Text']; ?></p>
                    <a href="<?php print $newsData2['Link']; ?>" class="btn btn-primary">Read More &rarr;</a>
                </div>
            </div>
        </div>
        <div class="card-footer text-muted">
            Posted on <?php print $newsData2['Created']; ?>
            <!--<a href="#">Start Bootstrap</a>-->
        </div>
    </div>
<?php
    }
