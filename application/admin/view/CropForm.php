<style type="text/css">
    #cropbox {
        width: <?php print $origWidth; ?>px;
    }
</style>
<script type="text/javascript" src="<?php print ADMIN_JS_PATH; ?>/formScripts/CropForm.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        initCropForm(<?php print $ratio . ', ' . $origWidth . ', ' . $origHeight . ', ' . $this->dataArray[0]['targW'] . ', ' . $this->dataArray[0]['targH']; ?>);
    });
</script>

<form id="imgCropOver" method="post" action="Crop">
    <div class="modal-header">
        <h4 class="modal-title">Kép részletei</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    </div>
    <div class="modal-body">
        <div class="row">
            <div class="col-sm-8">
                <img class="img-fluid" src="<?php print PATH_LEVEL_UP2 . "resources/uploaded/media/" . $this->dataArray[0]['fileName']; ?>" id="cropbox" alt="cropbox" />
            </div>
            <div class="col-sm-4">
                <div class="row">
                    File név: <?php print $this->dataArray[0]['fileName']; ?>
                </div>
                <div class="row">
                    File típusa: <?php print $origWidth . " x " . $origHeight . " pixel"; ?>
                </div>
                <div class="row">
                    <button type="submit" id="submit" name="submit" class="btn btn-primary col-md-12 mb-sm-2">Kép vágása</button>	    
                </div>
                <div class="row">
                    <button type="button" id="deleteImage" name="deleteImage" class="btn btn-primary col-md-12 mb-sm-2" onclick="javascript: deletePicture(<?php print $this->dataArray[0]['picId']; ?>, <?php print $this->dataArray[0]['galleryId']; ?>);">Törlés</button>	    
                </div>
                <div class="row">
                    <button type="button" id="coverImage" name="coverImage" class="btn btn-primary col-md-12 mb-sm-2" onclick="javascript: makeCimlap({ media:'<?php print $this->dataArray[0]['fileName']; ?>', mediaType:1, mediaId:<?php print $this->dataArray[0]['picId']; ?>, galleryId:<?php print $this->dataArray[0]['galleryId']; ?> });">Címlap</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <input type="hidden" id="event" name="event" value="ImageCrop" />
        <input type="hidden" id="x" name="x" />
        <input type="hidden" id="y" name="y" />
        <input type="hidden" id="w" name="w" />
        <input type="hidden" id="h" name="h" />
        <input type="hidden" id="modeHidden" name="modeHidden" value="<?php print $this->dataArray[0]['mode']; ?>" />
        <input type="hidden" id="picId" name="picId" value="<?php print $this->dataArray[0]['picId']; ?>" />
        <input type="hidden" id="MainHeaderId" name="MainHeaderId" value="<?php print $this->dataArray[0]['galleryId']; ?>" />
        <input type="hidden" id="targW" name="targW" value="<?php print $this->dataArray[0]['targW']; ?>" />
        <input type="hidden" id="targH" name="targH" value="<?php print $this->dataArray[0]['targH']; ?>" />
        <input type="hidden" id="ratio" name="ratio" value="<?php print $ratio; ?>" />
        <input type="hidden" id="fileName" name="fileName" value="<?php print $this->dataArray[0]['fileName']; ?>" />
        <input type="hidden" id="thumbFileName" name="thumbFileName" value="<?php print $this->dataArray[0]['thumbFileName']; ?>" />				
    </div>
</form>