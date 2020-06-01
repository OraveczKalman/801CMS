<script type="text/javascript">
    $('#videoForm').ajaxForm({
        success: function () {
            loadGallery(galleryId);
            loadInsertContainer(galleryId);
        }
    });
</script>
<div class="modal-header">
    <h5 class="modal-title">Új videók</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>   
</div>
<form role="form" method="post" enctype="multipart/form-data" id="videoForm" action="../admin/Gallery">
    <div class="form-group">
        <label for="video" class="col-sm-2 control-label"><?php print $galleryLabels->labels->videos; ?></label>
        <input class="form-control" type="file" class="input" name="media[]" id="video" multiple="multiple">
    </div>
    <div class="modal-footer">
        <input type="hidden" id="MainHeaderId" name="MainHeaderId" value="<?php print $this->dataArray[0]['MainHeaderId']; ?>"/>
        <input type="hidden" id="mediaTypeHidden" name="mediaTypeHidden" value="3"/>
        <button type="submit" name="send" id="send" class="btn btn-default"><?php print $galleryLabels->labels->upload; ?></button>
        <input type="hidden" name="event" id="event" value="FileUpload" />
    </div>
</form>