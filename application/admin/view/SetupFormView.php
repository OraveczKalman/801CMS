<div class="card shadow mb-12">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary"><?php print $setupLabels->labels->headLabel; ?></h6>
    </div>
    <form id="setupForm" role="form" method="post" action="Setup">
        <div class="card-body">           
            <div class="row">
                <div class="col-lg-12"><?php print $setupLabels->labels->galleryThumbnail; ?>:</div>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="galleryThumbWidth"><?php print $setupLabels->labels->widthLabel; ?>:</label>
                        <input class="form-control" type="text" value="<?php if (isset($setupData)) { print $setupData -> galleryThumb -> width; } ?>" maxlength="4" name="setup[galleryThumb][width]" id="galleryThumbWidth" />
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="galleryThumbHeight"><?php print $setupLabels->labels->heightLabel; ?>:</label>
                        <input class="form-control" type="text" value="<?php if (isset($setupData)) { print $setupData -> galleryThumb -> height; } ?>" maxlength="4" name="setup[galleryThumb][height]" id="galleryThumbHeight" />
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12"><?php print $setupLabels->labels->galleryPicture; ?>:</div>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="galleryPicWidth"><?php print $setupLabels->labels->widthLabel; ?>:</label>
                        <input class="form-control" type="text" value="<?php if (isset($setupData)) { print $setupData -> galleryPic -> width; } ?>" maxlength="4" name="setup[galleryPic][width]" id="galleryPicWidth" />
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="galleryPicHeight"><?php print $setupLabels->labels->heightLabel; ?>:</label>
                        <input class="form-control" type="text" value="<?php if (isset($setupData)) { print $setupData -> galleryPic -> height; } ?>" maxlength="4" name="setup[galleryPic][height]" id="galleryPicHeight" />
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12"><?php print $setupLabels->labels->galleryHeader; ?>:</div>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="galleryHeaderWidth"><?php print $setupLabels->labels->widthLabel; ?>:</label>
                        <input class="form-control" type="text" value="<?php if (isset($setupData)) { print $setupData -> galleryHeader -> width; } ?>" maxlength="4" name="setup[galleryHeader][width]" id="galleryHeaderWidth" />
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="galleryHeaderHeight"><?php print $setupLabels->labels->heightLabel; ?>:</label>
                        <input class="form-control" type="text" value="<?php if (isset($setupData)) { print $setupData -> galleryHeader -> height; } ?>" maxlength="4" name="setup[galleryHeader][height]" id="galleryHeaderHeight" />
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12"><?php print $setupLabels->labels->articleThumbnail; ?>:</div>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="articleThumbWidth"><?php print $setupLabels->labels->widthLabel; ?>:</label>
                        <input class="form-control" type="text" value="<?php if (isset($setupData)) { print $setupData -> articleThumb -> width; } ?>" maxlength="4" name="setup[articleThumb][width]" id="articleThumbWidth" />
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="articleThumbHeight" class="col-sm-1 control-label"><?php print $setupLabels->labels->heightLabel; ?>:</label>
                        <input class="form-control" type="text" value="<?php if (isset($setupData)) { print $setupData -> articleThumb -> height; } ?>" maxlength="4" name="setup[articleThumb][height]" id="articleThumbHeight" />
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12"><?php print $setupLabels->labels->articlePicture; ?>:</div>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="articlePicWidth"><?php print $setupLabels->labels->widthLabel; ?>:</label>
                        <input class="form-control" type="text" value="<?php if (isset($setupData)) { print $setupData -> articlePic -> width; } ?>" maxlength="4" name="setup[articlePic][width]" id="articlePicWidth" />
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="articlePicHeight"><?php print $setupLabels->labels->heightLabel; ?>:</label>
                        <input class="form-control" type="text" value="<?php if (isset($setupData)) { print $setupData -> articlePic -> height; } ?>" maxlength="4" name="setup[articlePic][height]" id="articlePicHeight" />
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12"><?php print $setupLabels->labels->articleCover; ?>:</div>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="articleHeaderWidth"><?php print $setupLabels->labels->widthLabel; ?>:</label>
                        <input class="form-control" type="text" value="<?php if (isset($setupData)) { print $setupData -> articleHeader -> width; } ?>" maxlength="4" name="setup[articleHeader][width]" id="articleHeaderWidth" />
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="articleHeaderHeight"><?php print $setupLabels->labels->heightLabel; ?>:</label>
                        <input class="form-control" type="text" value="<?php if (isset($setupData)) { print $setupData -> articleHeader -> height; } ?>" maxlength="4" name="setup[articleHeader][height]" id="articleHeaderHeight" />
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12"><?php print $setupLabels->labels->youtubeVideo; ?>:</div>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="ytPlayerWidth"><?php print $setupLabels->labels->widthLabel; ?>:</label>
                        <input class="form-control" type="text" value="<?php if (isset($setupData)) { print $setupData -> ytPlayer -> width; } ?>" maxlength="4" name="setup[ytPlayer][width]" id="ytPlayerWidth" />
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="ytPlayerHeight"><?php print $setupLabels->labels->heightLabel; ?>:</label>
                        <input class="form-control" type="text" value="<?php if (isset($setupData)) { print $setupData -> ytPlayer -> height; } ?>" maxlength="4" name="setup[ytPlayer][height]" id="ytPlayerHeight" />
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12"><?php print $setupLabels->labels->video; ?>:</div>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="vPlayerWidth"><?php print $setupLabels->labels->widthLabel; ?>:</label>
                        <input class="form-control" type="text" value="<?php if (isset($setupData)) { print $setupData -> vPlayer -> width; } ?>" maxlength="4" name="setup[vPlayer][width]" id="vPlayerWidth" />
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="vPlayerHeight"><?php print $setupLabels->labels->heightLabel; ?>:</label>
                        <input class="form-control" type="text" value="<?php if (isset($setupData)) { print $setupData -> vPlayer -> height; } ?>" maxlength="4" name="setup[vPlayer][height]" id="vPlayerHeight" />
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="mainMenus"><?php print $setupLabels->labels->mainMenus; ?>:</label>
                        <input class="form-control" type="text" value="<?php if (isset($setupData)) { print $setupData -> mainMenus; } ?>" maxlength="4" name="setup[mainMenus]" id="mainMenus" />
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="siteTitle"><?php print $setupLabels->labels->siteHeader; ?>:</label>
                        <input class="form-control" type="text" value="<?php if (isset($setupData)) { print $setupData -> siteTitle; } ?>" name="setup[siteTitle]" id="siteTitle" />
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="adminTitle"><?php print $setupLabels->labels->adminHeader; ?>:</label>
                        <input class="form-control" type="text" value="<?php if (isset($setupData)) { print $setupData -> adminTitle; } ?>" name="setup[adminTitle]" id="adminTitle" />
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="siteAuthor"><?php print $setupLabels->labels->developers; ?>:</label>
                        <input class="form-control" type="text" value="<?php if (isset($setupData)) { print $setupData -> siteAuthor; } ?>" name="setup[siteAuthor]" id="siteAuthor" />
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="siteAuthor"><?php print $setupLabels->labels->maxImageText; ?>:</label>
                        <input class="form-control" type="text" value="<?php if (isset($setupData)) { print $setupData -> maxPicText; } ?>" name="setup[maxPicText]" id="maxPicText" />
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="newsCount"><?php print $setupLabels->labels->newsPerPage; ?>:</label>
                        <input class="form-control" type="text" value="<?php if (isset($setupData)) { print $setupData -> newsCount; } ?>" name="setup[newsCount]" id="newsCount" />
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="messageWallType"><?php print $setupLabels->labels->messageWallType; ?>:</label>
                        <select class="form-control" id="messageWallType" name="setup[messageWallType]">
                            <option value="0" <?php if (isset($setupData->siteType) && $setupData -> messageWallType == 0) { print 'selected'; } ?>><?php print $setupLabels->labels->chooseLabel; ?></option>
                            <option value="1" <?php if (isset($setupData->siteType) && $setupData -> messageWallType == 1) { print 'selected'; } ?>><?php print $setupLabels->labels->typeLabel1; ?></option>
                            <option value="2" <?php if (isset($setupData->siteType) && $setupData -> messageWallType == 2) { print 'selected'; } ?>><?php print $setupLabels->labels->typeLabel2; ?></option>
                        </select>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="siteType"><?php print $setupLabels->labels->siteType; ?>:</label>
                        <select class="form-control" id="siteType" name="setup[siteType]">
                            <option value="0" <?php if (isset($setupData->siteType) && $setupData->siteType == 0) { print 'selected'; } ?>><?php print $setupLabels->labels->chooseLabel; ?></option>
                            <option value="1" <?php if (isset($setupData->siteType) && $setupData->siteType == 1) { print 'selected'; } ?>><?php print $setupLabels->labels->siteTypeLabel1; ?></option>
                            <option value="2" <?php if (isset($setupData->siteType) && $setupData->siteType == 2) { print 'selected'; } ?>><?php print $setupLabels->labels->siteTypeLabel2; ?></option>
                            <option value="3" <?php if (isset($setupData->siteType) && $setupData->siteType == 3) { print 'selected'; } ?>><?php print $setupLabels->labels->siteTypeLabel3; ?></option>
                        </select>
                    </div>
                </div>
            </div>
        </div>            
        <div class="card-footer">
            <input type="hidden" name="event" id="event" value="SaveSetupForm" />
            <input type="button" class="btn btn-primary" onclick="javascript: $('#setupForm').submit();" name="save" id="save" value="<?php print $setupLabels->labels->send; ?>" />
        </div>
    </form>
</div>