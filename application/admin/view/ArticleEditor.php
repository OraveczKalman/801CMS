<script type="text/javascript">
    $(document).ready(function() {
        loadInsertContainer(<?php print $this->dataArray[0]['MainHeaderId']; ?>);
        addNewEditor('Chapter');
        $('#chapterForm').submit(function () {
            $(this).ajaxSubmit({
                datatype:'json',
                beforeSubmit: CKupdate(),
                success: processError
            });
            return false;
        });
    });
    
    function loadInsertContainer(galleryId) {
        $.post('../admin/Gallery', {event:'GetInsertList', MainHeaderId:galleryId}, function(data) {
            $('#galleryInsertContainer').html(data);
        });
    }
    
    function processError(data) {
        data = JSON.parse(data);
        if (typeof data.good !== "undefined") {
            $('#MessageContainer').html('<div class="alert alert-success" role="alert">A mentés sikeres volt!</div>');
            $('#MessageContainer').css('display', 'block');
            if (typeof data.good.new !== "undefined") {
                $("#ArticleContainer").load("Article", { "event":"editArticleForm", "MainHeaderId":data.good.MainHeaderId });
            }
            setTimeout(function () {      
                $('#lgFormModal').modal('hide');
            }, 3000);
        } else if (typeof data.error !== "undefined") {
            showErrors(data.error);
        }
    }
    
    function addNewEditor(where, num) {
        CKEDITOR.replace(where);
    }
    
    function insertAtCursor(insertId, typeId, direction) {
        var insert = "";
        switch (parseInt(typeId, 10)) {
            case 1 :
                insert += "#kep_" + direction + "_" + insertId + "#";
                break;
            case 2 :
                insert += "#youtube_" + direction + "_" + insertId + "#";
                break;
            case 3 :
                insert += "#video_" + direction + "_" + insertId + "#";
                break;
            case 4 :
                insert += "#zene_" + direction + "_" + insertId + "#";
                break;
        }
        $("#pictureHidden").val($("#pictureHidden").val() + "," + insertId);
        while ($("#pictureHidden").val().charAt(0) === ",") {
            $("#pictureHidden").val($("#pictureHidden").val().slice(1));
        }
        CKEDITOR.instances['Chapter'].insertText(insert);
    }
    
    function CKupdate() {
        CKEDITOR.instances['Chapter'].updateElement();
    }
</script>
<div class="modal-header">
    <h5 class="modal-title">Új fejezet</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    <div class="row">
        <div class="col-lg-8">
            <form id="chapterForm" role="form" method="post" action="Article">
                <div style="display:none;" id="MessageContainer"></div>
                <div class="form-group">
                    <label>Cím</label>
                    <input class="form-control" type="text" name="Title" id="title" value="<?php if (isset($chapterData)) { print $chapterData[0]['Title']; } ?>" />
                </div>
                <div class="form-group">
                    <label>Szöveg</label>
                    <textarea class="form-control" name="Text" id="Chapter" cols="80" rows="20"><?php if (isset($chapterData)) { print $chapterData[0]['Text']; } ?></textarea>
                </div>
            </form>
        </div>
        <div class="col-lg-4" id="galleryInsertContainer"></div>
    </div>
</div>
<div class="modal-footer">
    <button form="chapterForm" type="button" name="sendForm" id="sendForm" class="btn btn-primary" onclick="javscript: $('#chapterForm').submit();">Feltöltés</button>    
    <input form="chapterForm" type="hidden" name="event" id="event" value="<?php if (!isset($chapterData)) { print "ChapterInsert"; } else { print "ChapterUpdate"; } ?>" />
    <input form="chapterForm" type="hidden" id="superior" name="SuperiorId" value="<?php print $this->dataArray[0]["MainHeaderId"]; ?>" />
    <input form="chapterForm" type="hidden" id="language" name="Language" value="hu" />
    <input form="chapterForm" type="hidden" id="type" name="Type" value="<?php if (!isset($chapterData)) { print "2"; } else { print $chapterData[0]["Type"]; } ?>" />
    <input form="chapterForm" type="hidden" id="pictureHidden" name="pictureHidden" value="" />
<?php
    if (isset($chapterData)) {
?>
    <input form="chapterForm" type="hidden" id="articleId" name="TextId" value="<?php print $chapterData[0]['TextId']; ?>" />
<?php
    }
?>
</div>

<!--<script type="text/javascript">
    //addNewEditor('article<?php //print $actCount+1; ?>', <?php //print $actCount+1; ?>);
</script>-->