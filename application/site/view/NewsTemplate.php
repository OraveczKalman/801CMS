<?php

foreach ($newsData as $newsData2) {
?>
<div class="post-preview">
<?php
    //var_dump($newsData2);
    $mediaData = $this->getNewsPicture($newsData2['MainHeaderId']);
    //var_dump($mediaData);
    if (!empty($mediaData)) {
        $newsData2['Text'] = $this->mediaChanger($mediaData, $newsData2['Text']);
    }
?>
    <a href="<?php print $newsData2['Link']; ?>">
        <h2 class="post-title">
            <?php print $newsData2['Title']; ?>
        </h2>
        <h3 class="post-subtitle">
            <?php print $newsData2['Text']; ?>
        </h3>
    </a>
    <p class="post-meta">
        <?php print $newsData2['Created']; ?>
    </p>
    <hr>
<?php
    
    if ($newsData2['MoreFlag'] == 1) {
?>
    <a class="btn btn-primary" href="<?php print $newsData2['Link']; ?>">Bővebben <i class="fa fa-angle-right"></i></a>
<?php
    }
?>
</div>
<?php
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