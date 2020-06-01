<script type="text/javascript">
    $('#galeriaForm').ajaxForm({
        success: function () {
            loadGallery(<?php print $this->dataArray[0]['galleryId']; ?>);
            $('#formModal').modal('hide');
            //loadInsertContainer(galleryId);
        }
    });
</script>
<div class="modal-header">
    <h5 class="modal-title">Új képek</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>   
</div>
<form role="form" method="post" enctype="multipart/form-data" id="galeriaForm" action="Gallery">
    <div class="modal-body">
        <div id="MessageBody" style="display:none;"></div>
        <div class="form-group">
            <label for="kep" class="col-sm-2 control-label"><?php print $galleryLabels->labels->pictures; ?></label>
            <input class="form-control" type="file" class="input" name="pictureArray[]" id="kep" multiple="multiple">
        </div>
        <div class="modal-footer">
            <input type="hidden" id="MainHeaderId" name="MainHeaderId" value="<?php print $this->dataArray[0]['galleryId']; ?>"/>
            <button type="submit" name="send" id="send" class="btn btn-default"><?php print $galleryLabels->labels->upload; ?></button>
            <input type="hidden" name="event" id="event" value="PictureUpload" />
        </div>
    </div>
</form>