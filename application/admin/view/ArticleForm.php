<script type="text/javascript" src="<?php print ADMIN_JS_PATH; ?>/formScripts/ArticleForm.js"></script>

<div class="card shadow mb-12" style="margin-top:1rem;">
    <div class="card-header py-3 form-inline">
        <h6 class="m-0 font-weight-bold text-primary" style="padding-right:1rem;"><?php print $articleFormObject->labels->header; ?></h6>
        <button class="btn btn-primary" onclick="javascript: addNewChapter(<?php print $this->dataArray[0]['MainHeaderId']; ?>);">Új fejezet</button>
    </div>
    <div class="card-body">
        <table class="table">
            <tbody>
                <tr class="table-secondary">
                    <td><?php print $articleFormObject->labels->prologue; ?></td>
                    <td colspan="2"><button class="btn btn-primary" onclick="javascript: modifyChapter(<?php print $this->dataArray[0]['MainHeaderId'] . ', ' . $documentData['Header'][0]['TextId']; ?>);">Szerkesztés</button></td>
                </tr>
<?php
    for ($i=0; $i<=count($documentData['Article'])-1; $i++) {
?>
                <tr>
                    <td><?php print $documentData['Article'][$i]['Title']; ?></pre></td>
                    <td><button class="btn btn-primary" onclick="javascript: modifyChapter(<?php print $documentData['Article'][$i]['SuperiorId'] . ', ' . $documentData['Article'][$i]['TextId']; ?>);">Szerkesztés</button></td>
                    <td><button class="btn btn-primary" onclick="javascript: deleteChapter(<?php print $documentData['Article'][$i]['TextId']; ?>">Törlés</button></td>
                </tr>
<?php
    }
?>
            </tbody>
        </table>
    </div>
</div>

<!--<h1><?php //print $articleFormObject->labels->header; ?></h1>
<div class="row-fluid">
    <div class="col-sm-10">
        <form method="post" id="articleForm" name="articleForm" action="admin/Article">
            <div>
                <div><?php //print $articleFormObject->labels->prologue; ?></div>
                <div>
                    <textarea name="article[0][Text]" id="article0"><?php //if (!empty($documentData['Header'])) { print $documentData['Header'][0]['Text']; } ?></textarea>
                    <input type="hidden" id="articleId0" name="article[0][TextId]" value="<?php //if (!empty($documentData['Header'])) { print $documentData['Header'][0]['TextId']; } ?>" />
                    <input type="hidden" id="type0" name="article[0][Type]" value="1" />
                    <input type="hidden" id="language0" name="article[0][Language]" value="hu" />
                    <input type="hidden" id="chapterState0" name="article[0][ChapterState]" value="<?php //if (empty($documentData['Header'])) { print 1; } else { print 0; } ?>" />
                    <input type="hidden" id="superior0" name="article[0][SuperiorId]" value="<?php //if (!empty($documentData['Header'])) { print $documentData['Header'][0]['SuperiorId']; } else { print $this->dataArray[0]['MainHeaderId']; } ?>" />
                </div>
            </div>

            <div id="cikkDiv">
                <ul class="nav nav-tabs" role="tablist" id="chapterNav">
                    <li role="presentation" id="newChapterDiv">
                        <a href="javascript: void(0);" onclick="javascript: addNewChapter('chaptersDiv', 'currentArticleCount', <?php //print $this->dataArray[0]['MainHeaderId']; ?>);" role="tab"><?php print $articleFormObject->labels->addnewchapter; ?></a>
                    </li>
<?php
            /*$articleCount = count($documentData['Article']);
            $counter = 0;
            if (!empty($documentData['Article'])) {
                $this->newArticleItemHead($counter, $documentData['Article']);
            } else {
                $this->newArticleItemHead($counter);
            }*/
?>
                </ul>
                <div class="tab-content" id="chaptersDiv">
<?php
            /*if (!empty($documentData['Article'])) {
                $this->newArticleItem($counter, $documentData['Article']);
            } else {
                $this->newArticleItem($counter);
            }*/
?>
                </div>
            </div>

            <div class="form_row">
                <div class="form_label">
                    <button type="button" class="btn btn-default" onclick="javascript: $('#articleForm').submit();" id="saveButton" name="saveButton"><?php //print $articleFormObject->labels->save; ?></button>
                    <input type="hidden" name="currentArticleCount" id="currentArticleCount" value="<?php //print $articleCount; ?>" />
                    <input type="hidden" name="MainHeaderId" id="MainHeaderId" value="<?php //print $this->dataArray[0]['MainHeaderId']; ?>" />
                    <input type="hidden" name="event" id="event" value="updateArticle" />
                </div>
            </div>
        </form>
    </div>
    <div class="col-sm-2" id="galleryInsertContainer" style="border:1px solid #000000;">&nbsp;</div>
</div>-->