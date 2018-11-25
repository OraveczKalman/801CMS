<h1 class="mt-4 mb-3">
    <small>Készítette: <a href="#">Készítő</a></small>
</h1>

<ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="#">Home</a>
    </li>
</ol>
    
<div class="row">
    <div class="col-lg-8">
        <img class="img-fluid rounded" src="<?php print UPLOADED_PATH . "/media/" . $documentData["CoverPicture"]; ?>" alt="">
        <hr>
        <p>Posted on <?php print $documentData['Header'][0]['Created']; ?></p>
        <hr>
        <p class="lead"><?php print $documentData['Header'][0]['Text']; ?></p>
<?php
    $displayText = "";
    for ($i=0; $i<=count($documentData['Body'])-1; $i++) {
        if ($i==0) {
            $displayText = "block;";
        } else {
            $displayText = "none;";
        }
?>
        <div id="sheet<?php print $i+1; ?>" class="sheet" style="display:<?php print $displayText; ?>">
<?php
        print $documentData['Body'][$i]['Text'];
?>
        </div>
<?php
    }
?>
        <div class="btn-toolbar mb-3" role="toolbar">
            <div class="btn-group mr-2" role="group">
 <?php
    for ($i=0; $i<=count($documentData['Body'])-1; $i++) {
?>
                <button type="button" class="btn btn-secondary" onclick="javascript: PageSwitcher(<?php print $i+1; ?>)"><?php print $i+1; ?></button>
<?php
    }
?>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card mb-4">
            <h5 class="card-header">Search</h5>
            <div class="card-body">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Search for...">
                    <span class="input-group-btn">
                        <button class="btn btn-secondary" type="button">Go!</button>
                    </span>
                </div>
            </div>
        </div>
        <div class="card my-4">
            <h5 class="card-header">Categories</h5>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-12">
<?php
    $likeBoxDataArray = array();
    $likeBoxDataArray[0]['event'] = 'RenderLikeBox';
    include_once(SITE_CONTROLLER_PATH . 'LikeBoxController.php');
    $likeBox = new LikeBoxController( $this->db, $likeBoxDataArray);
?>                        
                    </div>
                </div>
            </div>
        </div>
        <div class="card my-4">
            <h5 class="card-header">Side Widget</h5>
            <div class="card-body">
            You can put anything you want inside of these side widgets. They are easy to use, and feature the new Bootstrap 4 card containers!
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    function pageSwitcher(pageNumber) {
        $(".articleColumn").css("display", "none");
        $("#column" + pageNumber).css("display", "block");
    }
</script>