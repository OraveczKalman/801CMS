<div class="col-md-8" id="szoveges">
<div class="row-fluid">
    <div class="col-sm-12">
<?php
    print $documentData['Header'][0]['Szoveg'];
?>
    </div>
</div>
<?php
if (isset($documentData['Body'])) {
    $i=0;
?>
<div class="row-fluid">
<?php
    foreach ($documentData['Body'] as $document2) {
?>
    <div class="col-sm-12 articleColumn" id="column<?php print $i; ?>" <?php if ($i>0) { print 'style="display:none;"'; } ?>>
<?php
        print $document2['Text']; 
?>
    </div>
<?php
        $i++;
    }
?>
</div>
<?php
    if (count($documentData['Body']) > 1) {
?>
<div class="row-fluid">
    <div class="col-sm-12">
<?php
        for ($i=0; $i<=count($documentData['Body'])-1; $i++) {
?>
        <button type="button" onclick="javascript: pageSwitcher(<?php print $i; ?>);" class="btn btn-dark"><?php print $i+1; ?></button>
<?php
        }
?>
    </div>
</div>
<?php
    }
}
if ($this -> dataArray[0]['Commentable'] == 1 && $_SESSION['setupData']['messageWallType'] == 2) {
?>
    <div class="fb-comments" data-href="<?php print $_SESSION['prefix']; ?>://<?php print $_SERVER['HTTP_HOST']; ?>/<?php print $this->dataArray[0]['Link']; ?>" data-width="770" data-num-posts="2" data-colorscheme="dark"></div>
<?php
}
?>
</div>
<!-- Blog Sidebar Widgets Column -->
<div class="col-md-4">
<?php
    $likeBoxDataArray = array();
    $likeBoxDataArray[0]['event'] = 'RenderLikeBox';
    include_once(SITE_CONTROLLER_PATH . 'LikeBoxController.php');
    $likeBox = new LikeBoxController( $this->db, $likeBoxDataArray);
?>
</div>
<script type="text/javascript">
    function pageSwitcher(pageNumber) {
        $(".articleColumn").css("display", "none");
        $("#column" + pageNumber).css("display", "block");
    }
</script>