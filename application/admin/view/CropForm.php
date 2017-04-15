<style type="text/css">
    #preView {
        position:relative;
        width: <?php print $this->dataArray[0]['targW']; ?>px;
        height: <?php print $this->dataArray[0]['targH']; ?>px;
        overflow:hidden;
    }

    #cropbox {
        width: <?php print $origWidth; ?>px;
    }
</style>

<script type="text/javascript">
    $(function() {
        $('#imgCropOver').ajaxForm({
            success: cropOver
        });
    });

    $(function(){
        $('#cropbox').Jcrop({
            aspectRatio: <?php print $ratio; ?>,
            setSelect: [0,0,<?php print $origWidth.','.$origHeight; ?>],
            onSelect: updateCoords,
            onChange: updateCoords
        });
    });

    function cropOver() {
        loadGallery(<?php print $this->dataArray[0]['galleryId']; ?>);
        $('#largeModalContainer').modal('hide');
    }

    function updateCoords(c) {
        showPreview(c);
        $("#x").val(c.x);
        $("#y").val(c.y);
        $("#w").val(c.w);
        $("#h").val(c.h);
    }

    function showPreview(coords) {
        var rx = <?php print $this->dataArray[0]['targW']; ?> / coords.w;
        var ry = <?php print $this->dataArray[0]['targH']; ?> / coords.h;

        $("#preView img").css({
            width: Math.round(rx*<?php print $origWidth; ?>)+'px',
            height: Math.round(ry*<?php print $origHeight; ?>)+'px',
            marginLeft:'-'+  Math.round(rx*coords.x)+'px',
            marginTop: '-'+ Math.round(ry*coords.y)+'px'
        });
    }
</script>
<div class="modal-dialog modal-lg">
    <form id="imgCropOver" method="post" action="./admin/Crop">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Crop form</h4>
            </div>
            <div class="modal-body">
                <div class="row-fluid">
                    <div class="col-sm-8">
                        <img src="<?php print $this->dataArray[0]['fileName']; ?>" id="cropbox" alt="cropbox" />
                    </div>
                    <div class="col-sm-4">
                        <div id="preView">
                            <img src="<?php print $this->dataArray[0]['fileName']; ?>" alt="thumb" id="preView" />
                        </div>
                    </div>
                </div>
                <div style="clear:both;"></div>
            </div>
            <div class="modal-footer">
                <input type="hidden" id="event" name="event" value="ImageCrop" />
                <input type="hidden" id="x" name="x" />
                <input type="hidden" id="y" name="y" />
                <input type="hidden" id="w" name="w" />
                <input type="hidden" id="h" name="h" />
                <input type="hidden" id="modeHidden" name="modeHidden" value="<?php print $this->dataArray[0]['mode']; ?>" />
                <input type="hidden" id="picId" name="picId" value="<?php print $this->dataArray[0]['picId']; ?>" />
                <input type="hidden" id="galleryId" name="galleryId" value="<?php print $this->dataArray[0]['galleryId']; ?>" />
                <input type="hidden" id="targW" name="targW" value="<?php print $this->dataArray[0]['targW']; ?>" />
                <input type="hidden" id="targH" name="targH" value="<?php print $this->dataArray[0]['targH']; ?>" />
                <input type="hidden" id="ratio" name="ratio" value="<?php print $ratio; ?>" />
                <input type="hidden" id="fileName" name="fileName" value="<?php print $this->dataArray[0]['fileName']; ?>" />
                <input type="hidden" id="thumbFileName" name="thumbFileName" value="<?php print $this->dataArray[0]['thumbFileName']; ?>" />
                <button type="submit" id="submit" name="submit" class="btn btn-default">Crop Image!</button>				
            </div>
        </div>
    </form>
</div>