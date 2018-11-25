<style type="text/css">
    #sortable {
        list-style-type: none;
    }

    .ui-state-highlight {
        height: 1.5em;
        line-height: 1.2em;
    }
</style>

<script type="text/javascript">
    $(document).ready(function () {
        loadGallery(<?php print $this->dataArray[0]['MainHeaderId']; ?>);
        loadInsertContainer(<?php print $this->dataArray[0]['MainHeaderId']; ?>);
        
        $('#galeriaForm').ajaxForm({
            success: function () {
                loadGallery(<?php print $this->dataArray[0]['MainHeaderId']; ?>);
                loadInsertContainer(<?php print $this->dataArray[0]['MainHeaderId']; ?>);
            }
        });

        $('#musicForm').ajaxForm({
            success: function () {
                loadGallery(<?php print $this->dataArray[0]['MainHeaderId']; ?>);
                loadInsertContainer(<?php print $this->dataArray[0]['MainHeaderId']; ?>);
            }
        });

        $('#videoForm').ajaxForm({
            success: function () {
                loadGallery(<?php print $this->dataArray[0]['MainHeaderId']; ?>);
                loadInsertContainer(<?php print $this->dataArray[0]['MainHeaderId']; ?>);
            }
        });

        $('#youtubeForm').ajaxForm({
            success: function () {
                loadGallery(<?php print $this->dataArray[0]['MainHeaderId']; ?>);
                loadInsertContainer(<?php print $this->dataArray[0]['MainHeaderId']; ?>);
            }
        });

        $('#add').bind('click', function () {
            addVideo('youtubeContainer');
        });

        $('#youtubeSend').bind('click', function () {
            $('#youtubeForm').submit();
        });

        $('#galleryPictures').ajaxForm({
            success: function () {
                loadGallery(<?php print $this->dataArray[0]['MainHeaderId']; ?>);
            }
        });

        $('#pictureSort').sortable({
            update: function (event, ui) {
                $('#galleryPictures').submit();
            }
        });
    });

    function loadGallery(galleryId) {
        $('#pictureSort').load('./admin/Gallery', { event:'getGalleryList', MainHeaderId:galleryId });
    }
	
    function loadInsertContainer(galleryId) {
        $('#galleryInsertContainer').load('./admin/Gallery', { event:'GetInsertList', MainHeaderId:galleryId });
    }

    function cropForm(data) {
        $.post('./admin/Crop', { 
            event:'RenderCropForm',
            picId:data.picId,
            galleryId: data.galleryId, 
            fileName: data.fileName,
            thumbFileName: data.thumbFileName,
            mode:data.mode,  
            targW: data.targW,
            targH: data.targH
        }, function (data) {
            $('#largeModalContainer').html(data);	
        });
        $("#largeModalContainer").modal();
    }    

    function deletePictures(pictNumber) {
        var submitval = '';
        var gallery_val = $('#galleryHidden').val();
        for (i = 0; i <= pict_number; i++) {
            if ($('#image_id' + i).attr('checked') === 'checked') {
                submitval += $('#picId' + i).val() + '|';
            }
        }
        $.post("Gallery", { event:'PictureDelete', val: submitval, g_val: gallery_val}, function (data) {
            $('#galleryImagesDiv').html(data);
        });
    }

    function select_filler(select_id, min_value, max_value) {
        for (i = min_value; i <= max_value; i++) {
            $('#' + select_id).append('<option value="' + i + '">' + i + '</option>');
        }
    }

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

    function descriptionForm(data) {
        $.post('./admin/Gallery', { 
                event:'RenderDescriptionForm',
                pictureId: data.pictureId
            },
            function (data) {
                $('#modalContainer').html(data);
            }
        );

        $('#modalContainer').modal();
    }

    function makeCimlap(mediaDescription) {
        console.log(mediaDescription.mediaType);
        switch (mediaDescription.mediaType) {
            case 1 :
                $.post('./admin/Gallery', { 
                    event:'makeCover',
                    mediaId: mediaDescription.mediaId,
                    mediaName: mediaDescription.media,
                    gallery: mediaDescription.galleryId
                }, function (data) {
                });
                break;
            case 2 :
                $.post('./admin/Gallery', { 
                    event:'makeCover',
                    mediaId: mediaDescription.mediaId,
                    mediaName: mediaDescription.media,
                    gallery: mediaDescription.galleryId
                }, function (data) {
                });
                break;
        }
    }
    
    function deletePicture(pictureId, galleryId) {
        $.post("./admin/Gallery", { event: 'DeletePicture', PictureId: pictureId, MainHeaderId:galleryId }, function () {
            loadGallery(galleryId);
        });
    }
</script>

<form class="form-inline" role="form" method="post" enctype="multipart/form-data" id="galeriaForm" action="./admin/Gallery">
    <div class="form-group">
        <label for="kep" class="col-sm-2 control-label"><?php print $galleryLabels->labels->pictures; ?></label>

        <div class="col-sm-5">
            <input class="form-control" type="file" class="input" name="pictureArray[]" id="kep" multiple="multiple">
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-5">
            <input type="hidden" id="MainHeaderId" name="MainHeaderId" value="<?php print $this->dataArray[0]['MainHeaderId']; ?>"/>
            <button type="submit" name="send" id="send" class="btn btn-default"><?php print $galleryLabels->labels->upload; ?></button>
            <input type="hidden" name="event" id="event" value="PictureUpload" />
        </div>
    </div>
</form>

<form class="form-inline" role="form" method="post" enctype="multipart/form-data" id="musicForm" action="./admin/Gallery">
    <div class="form-group">
        <label for="media" class="col-sm-2 control-label"><?php print $galleryLabels->labels->music; ?></label>

        <div class="col-sm-5">
            <input class="form-control" type="file" class="input" name="media[]" id="music" multiple="multiple">
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-5">
            <input type="hidden" id="MainHeaderId" name="MainHeaderId" value="<?php print $this->dataArray[0]['MainHeaderId']; ?>"/>
            <input type="hidden" id="mediaTypeHidden" name="mediaTypeHidden" value="4"/>
            <button type="submit" name="send" id="send" class="btn btn-default"><?php print $galleryLabels->labels->upload; ?></button>
            <input type="hidden" name="event" id="event" value="FileUpload" />
        </div>
    </div>
</form>

<form class="form-inline" role="form" method="post" enctype="multipart/form-data" id="videoForm" action="./admin/Gallery">
    <div class="form-group">
        <label for="video" class="col-sm-2 control-label"><?php print $galleryLabels->labels->videos; ?></label>

        <div class="col-sm-5">
            <input class="form-control" type="file" class="input" name="media[]" id="video" multiple="multiple">
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-5">
            <input type="hidden" id="MainHeaderId" name="MainHeaderId" value="<?php print $this->dataArray[0]['MainHeaderId']; ?>"/>
            <input type="hidden" id="mediaTypeHidden" name="mediaTypeHidden" value="3"/>
            <button type="submit" name="send" id="send" class="btn btn-default"><?php print $galleryLabels->labels->upload; ?></button>
            <input type="hidden" name="event" id="event" value="FileUpload" />
        </div>
    </div>
</form>

<form class="form-inline" role="form" method="post" id="youtube_form" action="./admin/Gallery">
    <div id="youtube_upload_div">
        <div><?php print $galleryLabels->labels->youtubeVideos; ?></div>
        <div id="youtubeContainer"></div>
        <div class="form_row">
            <div class="form_cell">
                <input type="hidden" id="event" name="event" />
                <input type="hidden" id="MainHeaderId" name="MainHeaderId" value="<?php print $this->dataArray[0]['MainHeaderId']; ?>" />
                <input type="hidden" id="youtubeCountHidden" name="youtubeCountHidden" value="0" />
                <button type="button" class="btn btn-default" name="add" id="add"><?php print $galleryLabels->labels->add; ?></button>
                <button type="button" class="btn btn-default" name="youtubeSend" id="youtubeSend"><?php print $galleryLabels->labels->upload; ?></button>
                <input type="hidden" name="event" id="event" value="YoutubeUpload" />
            </div>
        </div>
    </div>
</form>

<form id="galleryPictures" method="post" action="./admin/Gallery">
    <div id="galleryImagesDiv">
        <table id="pictureSort" class="table table-striped"></table>
    </div>
    <input type="hidden" name="event" id="event" value="UpdatePictureData" />
</form>

<div id="galleryBottomMenu">
    <input type="hidden" id="galleryHidden" name="galleryHidden" value="<?php print $this->dataArray[0]['MainHeaderId']; ?>" />
    <a href="javascript: void(0);" onclick="javascript:$('#galleryPictures').submit();"><?php print $galleryLabels->labels->refresh; ?></a>
</div>