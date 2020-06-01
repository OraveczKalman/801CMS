<script type="text/javascript">
    $('#musicForm').ajaxForm({
        success: function () {
            loadGallery(<?php print $this->dataArray[0]['galleryId']; ?>);
        }
    });
</script>
<div class="modal-header">
    <h5 class="modal-title">Új zenék</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>   
</div>
<form role="form" method="post" enctype="multipart/form-data" id="musicForm" action="Gallery">
    <div class="modal-body">
        <div class="form-group">
            <label for="media" class="col-sm-2 control-label"><?php print $galleryLabels->labels->music; ?></label>
            <input class="form-control" type="file" class="input" name="media[]" id="music" multiple="multiple">
        </div>
    </div>
    <div class="modal-footer">
        <input type="hidden" id="MainHeaderId" name="MainHeaderId" value="<?php print $this->dataArray[0]['galleryId']; ?>"/>
        <input type="hidden" id="mediaTypeHidden" name="mediaTypeHidden" value="4"/>
        <button type="button" name="sendForm" id="sendForm" class="btn btn-primary" onclick="$('#musicForm').submit();"><?php print $galleryLabels->labels->upload; ?></button>
        <input type="hidden" name="event" id="event" value="FileUpload" />
    </div>
</form>