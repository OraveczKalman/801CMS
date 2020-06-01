<script type="text/javascript">
    $('#youtubeForm').ajaxForm({
        success: function () {
            loadGallery(<?php print $this->dataArray[0]['galleryId']; ?>);
        }
    });

    $('#add').bind('click', function () {
        addVideo('youtubeContainer');
    });

    $('#youtubeSend').bind('click', function () {
        $('#youtubeForm').submit();
    });
    
    function addVideo(target) {
        var formString = '';
        var newCount = parseInt($('#youtubeCountHidden').val(), 10) + 1;
        formString += '<div>';
        formString += '<?php print $galleryLabels->labels->videoLink; ?>' + newCount + ':';
        formString += '<input type="text" name="video[' + $('#youtubeCountHidden').val() + '][url]" id="video' + $('#youtubeCountHidden').val() + '" />';
        formString += '</div>';
        $('#' + target).append(formString);
        $('#youtubeCountHidden').val(newCount);
    }
</script>
<div class="modal-header">
    <h5 class="modal-title">Új youtube video</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>   
</div>
<form role="form" method="post" id="youtubeForm" action="Gallery">
    <div class="modal-body" id="youtube_upload_div">
        <div><?php print $galleryLabels->labels->youtubeVideos; ?></div>
        <div id="youtubeContainer"></div>
    </div>
    <div class="modal-footer">
        <input type="hidden" id="event" name="event" />
        <input type="hidden" id="MainHeaderId" name="MainHeaderId" value="<?php print $this->dataArray[0]['galleryId']; ?>" />
        <input type="hidden" id="youtubeCountHidden" name="youtubeCountHidden" value="0" />
        <button type="button" class="btn btn-primary" name="add" id="add"><?php print $galleryLabels->labels->add; ?></button>
        <button type="button" class="btn btn-primary" name="youtubeSend" id="youtubeSend"><?php print $galleryLabels->labels->upload; ?></button>
        <input type="hidden" name="event" id="event" value="YoutubeUpload" />
    </div>
</form>