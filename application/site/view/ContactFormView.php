<h1 class="mt-4 mb-3">
    <small><?php print $this->articleLabels->labels->authorLabel; ?>: <a href="#"><?php print $this->dataArray[0]['Name']; ?></a></small>
</h1>

<ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="#"><?php print $this->articleLabels->labels->breadCrumbHomeLabel; ?></a>
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
        <hr>    
        <p><?php print $this->articleLabels->labels->postedOnLabel; ?> <?php if (!empty($documentData['Header'])) { print $documentData['Header'][0]['Created']; } ?></p>
        <hr>
    </div>
<?php
    if (!empty($this->dataArray[0]['widgets'])) {
?>
    <div class="col-lg-4">
<?php
        for ($i=0; $i<=count($this->dataArray[0]['widgets'])-1; $i++) {
            if ($this->dataArray[0]['widgets'][$i]['WidgetContainerName'] == 'WidgetContainer1') {
                include_once(SITE_CONTROLLER_PATH . $this->dataArray[0]['widgets'][$i]['ControllerName'] . 'Controller.php');
                $widgetName = $this->dataArray[0]['widgets'][$i]['ControllerName'] . 'Controller';
                $widgetRout = new $widgetName($this->db, $this->dataArray);
            }
        }
?>
    </div>
<?php
    }
?>
    </div>
</div>