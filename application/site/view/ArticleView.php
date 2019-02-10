<h1 class="mt-4 mb-3">
    <small>Készítette: <a href="#"><?php print $this->dataArray[0]['Name']; ?></a></small>
</h1>

<ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="#">Home</a>
    </li>
</ol>
    
<div class="row">
<?php
    if (!empty($this->dataArray[0]['widgets'])) {
?>
    <div class="col-lg-8">
<?php
    } else {
?>
    <div class="col-lg-12">
<?php        
    }
?>
        <img class="img-fluid rounded" src="<?php print UPLOADED_PATH . "/media/" . $documentData["CoverPicture"]; ?>" alt="">
        <hr>    
        <p>Posted on <?php if (!empty($documentData['Header'])) { print $documentData['Header'][0]['Created']; } ?></p>
        <hr>
<?php
    $displayText = "";
    if (count($documentData['Body']) > 1) {
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
    } else if (count($documentData['Body']) == 1) {
?>
            <div id="sheet1" class="sheet">
<?php
        print $documentData['Body'][0]['Text'];
?>
            </div>
<?php        
    }
    if (!empty($this->mediaData)) {
?>
        <div class="row">
            <div class="row">
<?php
        for ($i=0; $i<=count($this->mediaData)-1; $i++) {
?>
            <div class="col-lg-3 col-md-4 col-xs-6 thumb">
                <a class="thumbnail" data-fancybox="gallery" <?php if (!is_null($this->mediaData[$i]["Text"])) { ?>data-caption="<?php print $this->mediaData[$i]["Text"]; ?>"<?php } ?> href="<?php print UPLOADED_MEDIA_PATH . $this->mediaData[$i]['Name']; ?>">
                    <img class="img-responsive" src="<?php print UPLOADED_MEDIA_PATH . $this->mediaData[$i]['ThumbName']; ?>" />
                    
<?php
            if (!is_null($this->mediaData[$i]["Text"])) {
?>
                    <div class="text-right">
                        <small class="text-muted"><?php print $this->mediaData[$i]["Text"]; ?></small>
                    </div>
<?php
            }
?>                  
                </a>
            </div>

            
<?php
        }
?>
            </div>
        </div>
<?php
    }
?>
    </div>
<?php
    if (!empty($this->dataArray[0]['widgets'])) {
?>
    <div class="col-lg-4">
<?php
        for ($i=0; $i<=count($this->dataArray[0]['widgets'])-1; $i++) {
            include_once(SITE_CONTROLLER_PATH . $this->dataArray[0]['widgets'][$i]['ControllerName'] . 'Controller.php');
            $widgetName = $this->dataArray[0]['widgets'][$i]['ControllerName'] . 'Controller';
            $widgetRout = new $widgetName($this->db);
        }
?>
    </div>
<?php
    }
?>
    </div>
 <?php
    if (count($documentData['Body']) > 1) {
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

<?php
    }
?>
</div>