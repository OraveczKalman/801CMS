<h1 class="mt-4 mb-3"><?php print $this->dataArray[0]["Caption"]; ?>
    <!--<small>Subheading</small>-->
</h1>
<ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="index.html"><?php print $blogLang->labels->breadCrumbHomeLabel; ?></a>
    </li>
    <li class="breadcrumb-item active"><?php print $this->dataArray[0]["Caption"]; ?></li>
</ol>
<?php
    $iPod    = stripos($_SERVER['HTTP_USER_AGENT'],"iPod");
    $iPhone  = stripos($_SERVER['HTTP_USER_AGENT'],"iPhone");
    $iPad    = stripos($_SERVER['HTTP_USER_AGENT'],"iPad");
    $Android = stripos($_SERVER['HTTP_USER_AGENT'],"Android");
    $webOS   = stripos($_SERVER['HTTP_USER_AGENT'],"webOS");

    foreach ($newsData as $newsData2) {
        if ($iPod || $iPhone || $iPad) {
            $ext = $newsData2["OriginalExtension"];
        } else {
            $ext = "webp";
        }
?>
    <div class="card mb-4">
        <div class="card-body">
            <div class="row">
<?php
    if (!is_null($newsData2["ProfilePicture"])) {
?>
                <div class="col-lg-6">
                    <a href="#">
                        <img class="img-fluid rounded" src="<?php print UPLOADED_MEDIA_PATH . $newsData2["ProfilePicture"] . "." . $ext; ?>" alt="">
                    </a>
                </div>
<?php
    }
?>
                <div class="col-lg-6">
                    <h2 class="card-title"><?php print $newsData2['Title']; ?></h2>
                    <p class="card-text"><?php print $newsData2['Text']; ?></p>
                    <a href="<?php print $newsData2['Link']; ?>" class="btn btn-primary"><?php print $blogLang->labels->readMoreLabel; ?> &rarr;</a>
                </div>
            </div>
        </div>
        <div class="card-footer text-muted">
            <?php print $blogLang->labels->postedOnLabel; ?> <?php print $newsData2['Created']; ?>
            <!--<a href="#">Start Bootstrap</a>-->
        </div>
    </div>
<?php
    }
    //if () {
?>
    <ul class="pagination justify-content-center mb-4">
        <li class="page-item">
            <a class="page-link" href="javascript:void(0);" onclick="javascript:pageSwitch();">&larr; <?php print $blogLang->labels->olderLabel; ?></a>
        </li>
        <li class="page-item disabled">
            <a class="page-link" href="javascript:void(0);" onclick="javascript:pageSwitch();"><?php print $blogLang->labels->newerLabel; ?> &rarr;</a>
        </li>
    </ul>
<?php
    //}