<?php
if (isset($this->headerData[0]['fullReload'])) {
?>
<div class="col-md-8" id="szoveges">
<?php
}
foreach ($newsData as $newsData2) {
    //var_dump($newsData2);
    $mediaData = $this->getNewsPicture($newsData2['MainHeaderId']);
    //var_dump($mediaData);
    if (!empty($mediaData)) {
        $newsData2['Text'] = $this->mediaChanger($mediaData, $newsData2['Text']);
    }
?>
    <h2>
        <a href="<?php print $newsData2['Link']; ?>"><?php print $newsData2['Title']; ?></a>
    </h2>
    <hr>
    <!--<a href="<?php //print $newsData2['Link']; ?>">
        <img class="img-responsive img-hover" src="http://placehold.it/900x300" alt="">
    </a>
    <hr>-->
<?php
    print $newsData2['Text'];
    if ($newsData2['MoreFlag'] == 1) {
?>
    <a class="btn btn-primary" href="<?php print $newsData2['Link']; ?>">Bővebben <i class="fa fa-angle-right"></i></a>
<?php
    }
}
if ($_SESSION['actNewsCount'] > $_SESSION['setupData']['newsCount']) {
?>
<ul class="pager">
<?php
    if ($this->headerData[0]['page']-$this->headerData[0]['limit']>=0) {
?>
    <li class="previous">
        <a href="javascript:void(0);" onclick="javascript: NewsPage(<?php print $this->headerData[0]['page'] - $this->headerData[0]['limit']; ?>, '<?php print $this->headerData[0]['Link']; ?>');">&larr; Újabb hírek</a>
    </li>
<?php
    }
    if ($this->headerData[0]['page']+$this->headerData[0]['limit']<=$_SESSION['actNewsCount']) {
?>
    <li class="next">
        <a href="javascript:void(0);" onclick="javascript: NewsPage(<?php print $this->headerData[0]['page'] + $this->headerData[0]['limit']; ?>, '<?php print $this->headerData[0]['Link']; ?>');">Korábbi hírek &rarr;</a>
    </li>
<?php
    }
?>
</ul>
<?php
}
if (isset($this->headerData[0]['fullReload'])) {
?>
</div>
<?php
}
if (isset($this->headerData[0]['fullReload'])) {
?>
<!-- Blog Sidebar Widgets Column -->
<div class="col-md-4">
<?php
    $likeBoxDataArray = array();
    $likeBoxDataArray[0]['event'] = 'RenderLikeBox';
    include_once(SITE_CONTROLLER_PATH . 'LikeBoxController.php');
    $likeBox = new LikeBoxController($likeBoxDataArray, $this->db);
    $sponsorsDataArray = array();
    $sponsorsDataArray[0]['event'] = 'RenderSponsors';
    include_once(SITE_CONTROLLER_PATH . 'SponsorController.php');
    $sponsors = new SponsorController($sponsorsDataArray, $this->db);
?>
</div>
<?php
}