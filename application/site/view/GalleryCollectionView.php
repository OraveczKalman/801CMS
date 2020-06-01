<h1 class="mt-4 mb-3">
    <small><?php print $this->articleLabels->labels->authorLabel; ?>: <a href="#"><?php print $this->dataArray[0]['Name']; ?></a></small>
</h1>

<ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="#"><?php print $this->articleLabels->labels->breadCrumbHomeLabel; ?></a>
    </li>
</ol>
    

<?php
for ($i=0; $i<=count($galleryCollectionObjects)-1; $i++) {
?>
<div class="row">
    <div class="col-md-7">
        <a href="<?php print $galleryCollectionObjects[$i]["Link"]; ?>">
            <img class="img-fluid rounded mb-3 mb-md-0" src="<?php print UPLOADED_PATH . "media/" . $galleryCollectionObjects[$i]['ThumbName']; ?>" />
        </a>
    </div>
    <div class="col-md-5">
        <h3><?php print $galleryCollectionObjects[$i]['Caption']; ?></h3>
        <a class="btn btn-primary" href="<?php print $galleryCollectionObjects[$i]["Link"]; ?>">Megtekintés
            <span class="glyphicon glyphicon-chevron-right"></span>
        </a>
    </div>
</div>
<hr>
<?php
}