<style type="text/css">
    #sortable {
        list-style-type: none;
    }

    .ui-state-highlight {
        height: 1.5em;
        line-height: 1.2em;
    }
</style>
<?php
if ($this->dataArray[0]["MainHeaderId"] > 0) {
?>
    <script type="text/javascript" src="<?php print ADMIN_JS_PATH; ?>/formScripts/GalleryForm.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            initGalleryForm(<?php print $this->dataArray[0]['MainHeaderId']; ?>);
        });
    </script>
<?php
}
?>
<div class="row-fluid" style="margin-top: 1rem; margin-bottom: 1rem;">
    <button class="btn btn-primary" onclick="javascript: loadPictureUploadForm(<?php print $this->dataArray[0]['MainHeaderId']; ?>);">Képek</button>
    <button class="btn btn-primary" onclick="javascript: loadMusicUploadForm(<?php print $this->dataArray[0]['MainHeaderId']; ?>);">Zenék</button>
    <button class="btn btn-primary">Videók</button>
    <button class="btn btn-primary" onclick="javascript: loadYoutubeUploadForm(<?php print $this->dataArray[0]['MainHeaderId']; ?>);">Youtube videók</button>
</div>

<form id="galleryPictures" method="post" action="../admin/Gallery">
    <div id="galleryImagesDiv">
        <div class="row" id="pictureSort"></div>
    </div>
    <input type="hidden" name="event" id="event" value="UpdatePictureData" />
</form>

<div id="galleryBottomMenu">
    <input type="hidden" id="galleryHidden" name="galleryHidden" value="<?php print $this->dataArray[0]['MainHeaderId']; ?>" />
    <a href="javascript: void(0);" onclick="javascript:$('#galleryPictures').submit();"><?php print $galleryLabels->labels->refresh; ?></a>
</div>