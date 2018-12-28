<script type="text/javascript">
    var cikkNum = 0;
    var actChapter = 'article0';
    var actStateHidden = 'chapterState0';
    var chaptersArray = new Array();

    $(document).ready(function() {
        $('#articleForm').submit(function () {
            $(this).ajaxSubmit({
                datatype:'json',
                beforeSubmit: CKupdate(),
                success: processError
            });
            return false;
        });

        addNewEditor('article0', 0);
    });

    function processError(data) {
        data = JSON.parse(data);
        if (typeof data.good !== "undefined") {
            $('#MessageBox #MessageBody').html('<div style="text-align: center;">A mentés sikeres volt!</div>');
            $('#MessageBox').modal('show');
            setTimeout(function () {      
                //$('#ArticleContainer').load('admin/Article', { event:'editArticleForm', MainHeaderId:data.good });
                //loadInsertContainer(data.good);
                $('#MessageBox').modal('hide');
            }, 5000);
        } else if (typeof data.error !== "undefined") {
            showErrors(data.error);
        }
    }

    function CKupdate() {
        for (instance in CKEDITOR.instances) {
            CKEDITOR.instances[instance].updateElement();
        }
    }

    function insertAtCursor(insert) {
        console.log(actChapter);
        if (actChapter !== "article0") {
            insert = insert.trim();
            CKEDITOR.instances[actChapter].insertText(insert);
            if (parseInt($('#' + actStateHidden).val(), 10) === 0) {
                $('#' + actStateHidden).val(2);
            }
        }
    }
    
    function selectChapter(name, stateName) {
        actChapter = name;
        actStateHidden = stateName;
        if (parseInt($('#' + actStateHidden).val(), 10) === 0) {
            $('#' + actStateHidden).val(2);
        }        
        CKEDITOR.instances[actChapter].focus();
    }    

    function addNewEditor(where, num) {
        CKEDITOR.replace(where);
        CKEDITOR.instances[where].on('key', function () {
            if (parseInt($('#chapterState' + num).val(), 10) === 0) {
                $('#chapterState' + num).val(2);
            }
        });
        if (parseInt($('#currentArticleCount').val(),10) > 0) {
            $('#moreHidden').val(1);
        }
    }

    function addNewChapter(where, counterHidden) {
        var counter = $('.articleItem').length;
        $.post('./admin/Article', { event:'newArticleItemHead', counter:counter }, function (data) { $('#chapterNav').append(data); } );
        $.post('./admin/Article', { event:'newArticleItem', counter:counter, MainHeaderId:<?php print $this->dataArray[0]['MainHeaderId']; ?> }, function (data) { $('#chaptersDiv').append(data); } );
        $('#moreHidden').val(1);
    }
    

</script>

<h1><?php print $articleFormObject->labels->header; ?></h1>
<div class="row-fluid">
    <div class="col-sm-10">
        <form method="post" id="articleForm" name="articleForm" action="admin/Article">
            <div>
                <div><?php print $articleFormObject->labels->prologue; ?></div>
                <div>
                    <textarea name="article[0][Text]" id="article0"><?php if (!empty($documentData['Header'])) { print $documentData['Header'][0]['Text']; } ?></textarea>
                    <input type="hidden" id="articleId0" name="article[0][TextId]" value="<?php if (!empty($documentData['Header'])) { print $documentData['Header'][0]['TextId']; } ?>" />
                    <input type="hidden" id="type0" name="article[0][Type]" value="1" />
                    <input type="hidden" id="language0" name="article[0][Language]" value="hu" />
                    <input type="hidden" id="chapterState0" name="article[0][ChapterState]" value="<?php if (empty($documentData['Header'])) { print 1; } else { print 0; } ?>" />
                    <input type="hidden" id="superior0" name="article[0][SuperiorId]" value="<?php if (!empty($documentData['Header'])) { print $documentData['Header'][0]['SuperiorId']; } else { print $this->dataArray[0]['MainHeaderId']; } ?>" />
                </div>
            </div>

            <div id="cikkDiv">
                <ul class="nav nav-tabs" role="tablist" id="chapterNav">
                    <li role="presentation" id="newChapterDiv">
                        <a href="javascript: void(0);" onclick="javascript: addNewChapter('chaptersDiv', 'currentArticleCount');" role="tab"><?php print $articleFormObject->labels->addnewchapter; ?></a>
                    </li>
<?php
            $articleCount = count($documentData['Article']);
            $counter = 0;
            if (!empty($documentData['Article'])) {
                $this->newArticleItemHead($counter, $documentData['Article']);
            } else {
                $this->newArticleItemHead($counter);
            }
?>
                </ul>
                <div class="tab-content" id="chaptersDiv">
<?php
            if (!empty($documentData['Article'])) {
                $this->newArticleItem($counter, $documentData['Article']);
            } else {
                $this->newArticleItem($counter);
            }
?>
                </div>
            </div>

            <div class="form_row">
                <div class="form_label">
                    <button type="button" class="btn btn-default" onclick="javascript: $('#articleForm').submit();" id="saveButton" name="saveButton">Mentés</button>
                    <input type="hidden" name="currentArticleCount" id="currentArticleCount" value="<?php print $articleCount; ?>" />
                    <input type="hidden" name="MainHeaderId" id="MainHeaderId" value="<?php print $this->dataArray[0]['MainHeaderId']; ?>" />
                    <input type="hidden" name="event" id="event" value="updateArticle" />
                </div>
            </div>
        </form>
    </div>
    <div class="col-sm-2" id="galleryInsertContainer" style="border:1px solid #000000;">&nbsp;</div>
</div>