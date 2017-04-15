<script type="text/javascript">
    $(document).ready(function() {
        $('#setupForm').ajaxForm({
            datatype: 'json',
            success: processError
        });

        $('#galleryThumbWidth').on('blur', function () {
            sendOneField('validateInt', 'admin/Setup', $('#galleryThumbWidth').val(), 'galleryThumbWidth');
        });

        $('#galleryThumbHeight').on('blur', function () {
            sendOneField('validateInt', 'admin/Setup', $('#galleryThumbHeight').val(), 'galleryThumbHeight');
        });

        $('#galleryPicWidth').on('blur', function () {
            sendOneField('validateInt', 'admin/Setup', $('#galleryPicWidth').val(), 'galleryPicWidth');
        });

        $('#galleryPicHeight').on('blur', function () {
            sendOneField('validateInt', 'admin/Setup', $('#galleryPicHeight').val(), 'galleryPicHeight');
        });

        $('#galleryHeaderWidth').on('blur', function () {
            sendOneField('validateInt', 'admin/Setup', $('#galleryHeaderWidth').val(), 'galleryHeaderWidth');
        });

        $('#galleryHeaderHeight').on('blur', function () {
            sendOneField('validateInt', 'admin/Setup', $('#galleryHeaderHeight').val(), 'galleryHeaderHeight');
        });

        $('#articleThumbWidth').on('blur', function () {
            sendOneField('validateInt', 'admin/Setup', $('#articleThumbWidth').val(), 'articleThumbWidth');
        });

        $('#articleThumbHeight').on('blur', function () {
            sendOneField('validateInt', 'admin/Setup', $('#articleThumbHeight').val(), 'articleThumbHeight');
        });

        $('#articlePicWidth').on('blur', function () {
            sendOneField('validateInt', 'admin/Setup', $('#articlePicWidth').val(), 'articlePicWidth');
        });

        $('#articlePicHeight').on('blur', function () {
            sendOneField('validateInt', 'admin/Setup', $('#articlePicHeight').val(), 'articlePicHeight');
        });

        $('#articleHeaderWidth').on('blur', function () {
            sendOneField('validateInt', 'admin/Setup', $('#articleHeaderWidth').val(), 'articleHeaderWidth');
        });

        $('#articleHeaderHeight').on('blur', function () {
            sendOneField('validateInt', 'admin/Setup', $('#articleHeaderHeight').val(), 'articleHeaderHeight');
        });

        $('#ytPlayerWidth').on('blur', function () {
            sendOneField('validateInt', 'admin/Setup', $('#ytPlayerWidth').val(), 'ytPlayerWidth');
        });

        $('#ytPlayerHeight').on('blur', function () {
            sendOneField('validateInt', 'admin/Setup', $('#ytPlayerHeight').val(), 'ytPlayerHeight');
        });

        $('#vPlayerWidth').on('blur', function () {
            sendOneField('validateInt', 'admin/Setup', $('#vPlayerWidth').val(), 'vPlayerWidth');
        });

        $('#vPlayerHeight').on('blur', function () {
            sendOneField('validateInt', 'admin/Setup', $('#vPlayerHeight').val(), 'vPlayerHeight');
        });

        $('#mainMenus').on('blur', function () {
            sendOneField('validateInt', 'admin/Setup', $('#mainMenus').val(), 'mainMenus');
        });

        $('#siteTitle').on('blur', function () {
            sendOneField('validateText', 'admin/Setup', $('#siteTitle').val(), 'siteTitle');
        });

        $('#adminTitle').on('blur', function () {
            sendOneField('validateText', 'admin/Setup', $('#adminTitle').val(), 'adminTitle');
        });

        $('#siteAuthor').on('blur', function () {
            sendOneField('validateText', 'admin/Setup', $('#siteAuthor').val(), 'siteAuthor');
        });

        $('#messageWallType').on('blur', function () {
            sendOneField('validateInt', 'admin/Setup', $('#messageWallType').val(), 'messageWallType');
        });
    });

    function processError(data) {
        data = JSON.parse(data);
        if (typeof data.good !== "undefined") {
            $('#MessageBox #MessageBody').html('<div style="text-align: center;">A mentés sikeres volt!</div>');
            $('#MessageBox').modal('show');
            setTimeout(function () {               
                $('#MessageBox').modal('hide');
            }, 5000);
        } else if (typeof data.error !== "undefined") {
            showErrors(data.error);
        }
    }
</script>
<div class="row-fluid">
    <div class="col-sm-12">
        <h1>Oldal alapbeállításai</h1>

        <form id="setupForm" role="form" class="form-horizontal" method="post" action="./admin/Setup">
            <div class="form-group">
                <label class="col-sm-3 control-label">Galéria nézőkép mérete:</label>
                <div class="col-sm-7">
                    <label for="galleryThumbWidth" class="col-sm-1 control-label">Sz:</label>
                    <div class="col-sm-5">
                        <input class="form-control" type="text" value="<?php print $setupData -> galleryThumb -> width; ?>" maxlength="4" name="setup[galleryThumb][width]" id="galleryThumbWidth" />
                    </div>
                    <label for="galleryThumbHeight" class="col-sm-1 control-label">M:</label>
                    <div class="col-sm-5">
                        <input class="form-control" type="text" value="<?php print $setupData -> galleryThumb -> height; ?>" maxlength="4" name="setup[galleryThumb][height]" id="galleryThumbHeight" />
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label">Galéria kép mérete:</label>
                <div class="col-sm-7">
                    <label for="galleryPicWidth" class="col-sm-1 control-label">Sz:</label>
                    <div class="col-sm-5">
                        <input class="form-control" type="text" value="<?php print $setupData -> galleryPic -> width; ?>" maxlength="4" name="setup[galleryPic][width]" id="galleryPicWidth" />
                    </div>
                    <label for="galleryPicHeight" class="col-sm-1 control-label">M:</label>
                    <div class="col-sm-5">
                        <input class="form-control" type="text" value="<?php print $setupData -> galleryPic -> height; ?>" maxlength="4" name="setup[galleryPic][height]" id="galleryPicHeight" />
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label">Galéria fejléc mérete:</label>
                <div class="col-sm-7">
                    <label for="galleryHeaderWidth" class="col-sm-1 control-label">Sz:</label>
                    <div class="col-sm-5">
                        <input class="form-control" type="text" value="<?php print $setupData -> galleryHeader -> width; ?>" maxlength="4" name="setup[galleryHeader][width]" id="galleryHeaderWidth" />
                    </div>
                    <label for="galleryHeaderHeight" class="col-sm-1 control-label">M:</label>
                    <div class="col-sm-5">
                        <input class="form-control" type="text" value="<?php print $setupData -> galleryHeader -> height; ?>" maxlength="4" name="setup[galleryHeader][height]" id="galleryHeaderHeight" />
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label">Cikk nézőkép mérete:</label>
                <div class="col-sm-7">
                    <label for="articleThumbWidth" class="col-sm-1 control-label">Sz:</label>
                    <div class="col-sm-5">
                        <input class="form-control" type="text" value="<?php print $setupData -> articleThumb -> width; ?>" maxlength="4" name="setup[articleThumb][width]" id="articleThumbWidth" />
                    </div>
                    <label for="articleThumbHeight" class="col-sm-1 control-label">M:</label>
                    <div class="col-sm-5">
                        <input class="form-control" type="text" value="<?php print $setupData -> articleThumb -> height; ?>" maxlength="4" name="setup[articleThumb][height]" id="articleThumbHeight" />
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label">Cikk kép mérete:</label>
                <div class="col-sm-7">
                    <label for="articlePicWidth" class="col-sm-1 control-label">Sz:</label>
                    <div class="col-sm-5">
                        <input class="form-control" type="text" value="<?php print $setupData -> articlePic -> width; ?>" maxlength="4" name="setup[articlePic][width]" id="articlePicWidth" />
                    </div>
                    <label for="articlePicHeight" class="col-sm-1 control-label">M:</label>
                    <div class="col-sm-5">
                        <input class="form-control" type="text" value="<?php print $setupData -> articlePic -> height; ?>" maxlength="4" name="setup[articlePic][height]" id="articlePicHeight" />
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label">Cikk címlapkép mérete:</label>
                <div class="col-sm-7">
                    <label for="articleHeaderWidth" class="col-sm-1 control-label">Sz:</label>
                    <div class="col-sm-5">
                        <input class="form-control" type="text" value="<?php print $setupData -> articleHeader -> width; ?>" maxlength="4" name="setup[articleHeader][width]" id="articleHeaderWidth" />
                    </div>
                    <label for="articleHeaderHeight" class="col-sm-1 control-label">M:</label>
                    <div class="col-sm-5">
                        <input class="form-control" type="text" value="<?php print $setupData -> articleHeader -> height; ?>" maxlength="4" name="setup[articleHeader][height]" id="articleHeaderHeight" />
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label">Youtube video mérete:</label>
                <div class="col-sm-7">
                    <label for="ytPlayerWidth" class="col-sm-1 control-label">Sz:</label>
                    <div class="col-sm-5">
                        <input class="form-control" type="text" value="<?php print $setupData -> ytPlayer -> width; ?>" maxlength="4" name="setup[ytPlayer][width]" id="ytPlayerWidth" />
                    </div>
                    <label for="ytPlayerHeight" class="col-sm-1 control-label">M:</label>
                    <div class="col-sm-5">
                        <input class="form-control" type="text" value="<?php print $setupData -> ytPlayer -> height; ?>" maxlength="4" name="setup[ytPlayer][height]" id="ytPlayerHeight" />
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label">Video mérete:</label>
                <div class="col-sm-7">
                    <label for="vPlayerWidth" class="col-sm-1 control-label">Sz:</label>
                    <div class="col-sm-5">
                        <input class="form-control" type="text" value="<?php print $setupData -> vPlayer -> width; ?>" maxlength="4" name="setup[vPlayer][width]" id="vPlayerWidth" />
                    </div>
                    <label for="vPlayerHeight" class="col-sm-1 control-label">M:</label>
                    <div class="col-sm-5">
                        <input class="form-control" type="text" value="<?php print $setupData -> vPlayer -> height; ?>" maxlength="4" name="setup[vPlayer][height]" id="vPlayerHeight" />
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="mainMenus" class="col-sm-3 control-label">Fő menüpontok száma:</label>
                <div class="col-sm-5">
                    <input class="form-control" type="text" value="<?php print $setupData -> mainMenus; ?>" maxlength="4" name="setup[mainMenus]" id="mainMenus" />
                </div>
            </div>

            <div class="form-group">
                <label for="siteTitle" class="col-sm-3 control-label">Oldal címsor:</label>
                <div class="col-sm-5">
                    <input class="form-control" type="text" value="<?php print $setupData -> siteTitle; ?>" name="setup[siteTitle]" id="siteTitle" />
                </div>
            </div>

            <div class="form-group">
                <label for="adminTitle" class="col-sm-3 control-label">Admin címsor:</label>
                <div class="col-sm-5">
                    <input class="form-control" type="text" value="<?php print $setupData -> adminTitle; ?>" name="setup[adminTitle]" id="adminTitle" />
                </div>
            </div>

            <div class="form-group">
                <label for="siteAuthor" class="col-sm-3 control-label">Készítők:</label>
                <div class="col-sm-5">
                    <input class="form-control" type="text" value="<?php print $setupData -> siteAuthor; ?>" name="setup[siteAuthor]" id="siteAuthor" />
                </div>
            </div>                        

            <div class="form-group">
                <label for="siteAuthor" class="col-sm-3 control-label">Max. képaláírás :</label>
                <div class="col-sm-5">
                    <input class="form-control" type="text" value="<?php print $setupData -> maxPicText; ?>" name="setup[maxPicText]" id="maxPicText" />
                </div>
            </div>

            <div class="form-group">
                <label for="newsCount" class="col-sm-3 control-label">Hírek száma egy oldalon :</label>
                <div class="col-sm-5">
                    <input class="form-control" type="text" value="<?php print $setupData -> newsCount; ?>" name="setup[newsCount]" id="newsCount" />
                </div>
            </div>

            <div class="form-group">
                <label for="messageWallType" class="col-sm-3 control-label">Üzenőfal típusa:</label>
                <div class="col-sm-5">
                    <select class="form-control" id="messageWallType" name="setup[messageWallType]">
                        <option value="0" <?php if ($setupData -> messageWallType == 0) { print 'selected'; } ?>>Válassz</option>
                        <option value="1" <?php if ($setupData -> messageWallType == 1) { print 'selected'; } ?>>Saját</option>
                        <option value="2" <?php if ($setupData -> messageWallType == 2) { print 'selected'; } ?>>Facebook</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label for="siteType" class="col-sm-3 control-label">Oldal típusa:</label>
                <div class="col-sm-5">
                    <select class="form-control" id="siteType" name="setup[siteType]">
                        <option value="0" <?php if (isset($setupData->siteType) && $setupData->siteType == 0) { print 'selected'; } ?>>Válassz</option>
                        <option value="1" <?php if (isset($setupData->siteType) && $setupData->siteType == 1) { print 'selected'; } ?>>Normál</option>
                        <option value="2" <?php if (isset($setupData->siteType) && $setupData->siteType == 2) { print 'selected'; } ?>>Egyoldalas Parallax</option>
                        <option value="3" <?php if (isset($setupData->siteType) && $setupData->siteType == 3) { print 'selected'; } ?>>Többoldalas Parallax</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <input type="hidden" name="event" id="event" value="SaveSetupForm" />
                <input type="submit" name="save" id="save" value="Mentés" />
            </div>
        </form>
    </div>
</div>