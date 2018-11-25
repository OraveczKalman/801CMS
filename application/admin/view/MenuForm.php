<script type="text/javascript">
    $(document).ready(function() {
        $('#MenuForm').ajaxForm({
            success: processError
        });

        $("#Felirat").on('blur', function() {
            sendOneField('validateText', 'admin/Menu', $('#Felirat').val(), 'Felirat');
        });

        $("#Cim").on('blur', function() {
            sendOneField('validateText', 'admin/Menu', $('#Cim').val(), 'Cim');
        });

        $("#Cimsor").on('blur', function() {
            sendOneField('validateText', 'admin/Menu', $('#Cimsor').val(), 'Cimsor');
        });

        $("#Kulcsszavak").on('blur', function() {
            sendOneField('validateText', 'admin/Menu', $('#Kulcsszavak').val(), 'Kulcsszavak');
        });

        $("#Link").on('blur', function() {
            sendOneField('validateText', 'admin/Menu', $('#Link').val(), 'Link');
        });

        $("#Target").on('blur', function() {
            sendOneField('validateText', 'admin/Menu', $('#Target').val(), 'Target');
        });

        $("#MainPage").on('blur', function() {
            sendOneField('validateInt', 'admin/Menu', $('#MainPage').val(), 'MainPage');
        });

        $("#Nyelv").on('blur', function() {
            sendOneField('validateText', 'admin/Menu', $('#Nyelv').val(), 'Nyelv');
        });

        $("#Kommentezheto").on('blur', function() {
            sendOneField('validateInt', 'admin/Menu', $('#Kommentezheto').val(), 'Kommentezheto');
        });

        $("#Szerep").on('blur', function() {
            sendOneField('validateInt', 'admin/Menu', $('#Szerep').val(), 'Szerep');
        });
        
        $('#Szerep').on('change', function() {
            alert($('#Szerep option:selected').val());
            var additionalHtml = '';
            switch (parseInt($('#Szerep option:selected').val(), 10)) {
                case 4 :
                    additionalHtml += '<div class="form-group">';
                    additionalHtml += '<label for="GalleryType" class="col-sm-2 control-label"><?php print $menuJson->labels->gallerytype; ?></label>';
                    additionalHtml += '<div class="col-sm-10">';
                    additionalHtml += '<select id="GalleryType" class="form-control" name="GalleryType">';
                    additionalHtml += '<option value="0"><?php print $menuJson->gallerytypes->gallery->label; ?></option>';
                    additionalHtml += '<option value="1"><?php print $menuJson->gallerytypes->coverslider->label; ?></option>';
                    additionalHtml += '<option value="2"><?php print $menuJson->gallerytypes->slider->label; ?></option>';
                    additionalHtml += '</select>';
                    additionalHtml += '</div>';
                    additionalHtml += '</div>';
                    $('#additionalWrapper').html(additionalHtml);
                    $('#additionalWrapper').css('display', 'block');
                    break;
                case 6 :
                    additionalHtml += '<div class="form-group">';
                    additionalHtml += '<label for="Tabellakod" class="col-sm-2 control-label"><?php print $menuJson->labels->tableCode; ?></label>';
                    additionalHtml += '<div class="col-sm-10">';
                    additionalHtml += '<input class="form-control" type="text" id="Tabellakod" name="Tabellakod">';
                    additionalHtml += '</div>';
                    additionalHtml += '</div>';
                    additionalHtml += '<div class="form-group">';
                    additionalHtml += '<label for="Csapatszam" class="col-sm-2 control-label"><?php print $menuJson->labels->teamCount; ?></label>';
                    additionalHtml += '<div class="col-sm-10">';
                    additionalHtml += '<input class="form-control" type="text" id="Csapatszam" name="Csapatszam">';
                    additionalHtml += '</div>';
                    additionalHtml += '</div>';
                    additionalHtml += '<div class="form-group">';
                    additionalHtml += '<label for="Fejszoveg" class="col-sm-2 control-label"><?php print $menuJson->labels->headText; ?></label>';
                    additionalHtml += '<div class="col-sm-10">';
                    additionalHtml += '<input class="form-control" type="text" id="Fejszoveg" name="Fejszoveg">';
                    additionalHtml += '</div>';
                    additionalHtml += '</div>';
                    additionalHtml += '<div class="form-group">';
                    additionalHtml += '<label for="Ideny" class="col-sm-2 control-label"><?php print $menuJson->labels->season; ?></label>';
                    additionalHtml += '<div class="col-sm-10">';
                    additionalHtml += '<input class="form-control" type="text" id="Ideny" name="Ideny">';
                    additionalHtml += '</div>';
                    additionalHtml += '</div>';
                    $('#additionalWrapper').html(additionalHtml);
                    $('#additionalWrapper').css('display', 'block');                   
                    break;
                case 7 :
                    additionalHtml += '<div class="form-group">';
                    additionalHtml += '<label for="Feltoltendo" class="col-sm-2 control-label"><?php print $menuJson->labels->fileLabel; ?></label>';
                    additionalHtml += '<div class="col-sm-10"><input class="form-control" type="file" id="Feltoltendo" name="Feltoltendo[]"></div>';
                    additionalHtml += '</div>';
                    $('#additionalWrapper').html(additionalHtml);
                    $('#additionalWrapper').css('display', 'block');
                    break;
                default:
                    $('#additionalWrapper').html('');
                    $('#additionalWrapper').css('display', 'none');
                    break;
            }
        });
    });

    function showTab(tabName) {
        $('.menuTab').css('display', 'none');
        $('#' + tabName).css('display', 'block');
    }

    function processError(data) {
        data = JSON.parse(data);
        if (typeof data.good !== "undefined") {
            $('#MessageBox #MessageBody').html('<div style="text-align: center;">A mentés sikeres volt!</div>');
            $('#MessageBox').modal('show');
            setTimeout(function () {               
                $('#MessageBox').modal('hide');
                switch (parseInt(data.good.role,10)) {
                    case 3 :
                    case 4 :
                        loadEditMenuForm({ menuId:data.good.menuId, parentId:data.good.parentId, parentNode:data.good.parentNode });
                        break;
                    default :
                        loadPage('./admin/MenuTree', 'RenderMenuItems');
                        break;
                }
            }, 5000);
        } else if (typeof data.error !== "undefined") {
            showErrors(data.error);
        }
    }
<?php
    if (isset($menuPointData)) {
?>
    function shareOnFacebook() {
        FB.ui({
            method: 'share',
            display: 'popup',
            href: '<?php print $_SESSION['prefix'] . '://' . $_SERVER['HTTP_HOST'] . '/' . $menuPointData[0]['Link']; ?>'
        }, function(response){});
    }
<?php
    }
?>
</script>
<div class="row-fluid">
    <div class="col-sm-12">
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active">
                <a href="#menuContainer" role="tab" data-toggle="tab"><?php print $menuJson->labels->headLabel; ?></a>
            </li>
<?php
            if (isset($controllerCollection)) {
                for ($i = 0; $i <= count($controllerCollection) - 1; $i++) {
?>
            <li role="presentation">
                <a href="#<?php print $controllerCollection[$i]; ?>Container" role="tab" data-toggle="tab">
                    <?php print $controllerCollection[$i]; ?>
                </a>
            </li>
<?php
                }
            }
?>
        </ul>
        <div class="tab-content">
        <div id="menuContainer" role="tabpanel" class="tab-pane active">
            <h1>Menüadatok</h1>

            <form class="form-horizontal" enctype="multipart/form-data" role="form" id="MenuForm" method="post" action="./admin/Menu">

                <div class="form-group">
                    <label for="Felirat" class="col-sm-2 control-label"><?php print $menuJson->labels->caption; ?></label>
                    <div class="col-sm-10"><input class="form-control" type="text" <?php if (isset($menuPointData)) { print 'value="' . $menuPointData[0]['Caption'] . '"'; }?> id="Felirat" name="Felirat"></div>
                </div>

                <div class="form-group">
                    <label for="Cim" class="col-sm-2 control-label"><?php print $menuJson->labels->title; ?></label>
                    <div class="col-sm-10"><input class="form-control" type="text" <?php if (isset($menuPointData)) { print 'value="' . $menuPointData[0]['Title'] . '"'; }?> id="Cim" name="Cim"></div>
                </div>

                <div class="form-group">
                    <label for=Cimsor" class="col-sm-2 control-label"><?php print $menuJson->labels->heading; ?></label>
                    <div class="col-sm-10"><input class="form-control" type="text" <?php if (isset($menuPointData)) { print 'value="' . $menuPointData[0]['Heading'] . '"'; }?> id="Cimsor" name="Cimsor"></div>
                </div>

                <div class="form-group">
                    <label for="Kulcsszavak" class="col-sm-2 control-label"><?php print $menuJson->labels->keywords; ?></label>
                    <div class="col-sm-10"><input class="form-control" type="text" <?php if (isset($menuPointData)) { print 'value="' . $menuPointData[0]['Keywords'] . '"'; }?> id="Kulcsszavak" name="Kulcsszavak"></div>
                </div>

                <div class="form-group">
                    <label for="Link" class="col-sm-2 control-label"><?php print $menuJson->labels->link; ?></label>
                    <div class="col-sm-10"><input class="form-control" type="text" <?php if (isset($menuPointData)) { print 'value="' . $menuPointData[0]['Link'] . '"'; }?> id="Link" name="Link"></div>
                </div>

                <div class="form-group">
                    <label for="Target" class="col-sm-2 control-label"><?php print $menuJson->labels->target; ?></label>
                    <div class="col-sm-10">
                        <select id="Target" class="form-control" name="Target">
<?php
                            foreach ($menuJson->targets as $targets2) {
?>
                                <option value="<?php print $targets2->value; ?>" <?php if (isset($menuPointData) && $targets2->value == $menuPointData[0]['Target']) { print "selected"; } ?>><?php print $targets2->label; ?></option>
<?php
                            }
?>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="MainPage" class="col-sm-2 control-label"><?php print $menuJson->labels->mainpage; ?></label>
                    <div class="col-sm-10"><input type="checkbox" id="MainPage" name="MainPage" <?php if (isset($menuPointData) && $menuPointData[0]['MainPage'] == 1) { print "checked"; } ?> value="1"></div>
                </div>

                <div class="form-group">
                    <label for="Nyelv" class="col-sm-2 control-label"><?php print $menuJson->labels->language; ?></label>
                    <div class="col-sm-10">
                        <select class="form-control" id="Nyelv" name="Nyelv">
<?php
                        foreach ($languages as $languages2) {
?>
                            <option value="<?php print $languages2['LanguageSign']; ?>" <?php if (isset($menuPointData) && $menuPointData[0]['Language'] == $languages2['LanguageSign']) { print ' selected="selected"'; } ?>><?php print $languages2['Description']; ?></option>
<?php
                        }
?>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="Kommentezheto" class="col-sm-2 control-label"><?php print $menuJson->labels->commentable; ?></label>
                    <div class="col-sm-10"><input type="checkbox" id="Kommentezheto" name="Kommentezheto" <?php if (isset($menuPointData) && $menuPointData[0]['Commentable'] == 1) { print "checked"; } ?> value="1" /></div>
                </div>

                <div class="form-group">
                    <label for="User_In" class="col-sm-2 control-label"><?php print $menuJson->labels->loggedin; ?></label>
                    <div class="col-sm-10"><input type="checkbox" id="User_In" name="User_In" <?php if (isset($menuPointData) && $menuPointData[0]['UserIn'] == 1) { print "checked"; } ?> value="1"></div>
                </div>
                <div class="form-group">
                    <label for="Module" class="col-sm-2 control-label"><?php print $menuJson->labels->modul; ?></label>
                    <div class="col-sm-10">
                        <select id="Module" name="Module" class="form-control">
                            <option value=""><?php print $menuJson->targets->choose->label; ?></option>
<?php
                        //for ($i=0; $i<=count($moduleList)-1; $i++) {
?>
                            <option value="<?php //print $moduleList[$i]['Link']; ?>" <?php //if (isset($menuPointData) && $moduleList[$i]['Link'] == $menuPointData[0]['Module']) { print 'selected'; } ?>><?php //print $moduleList[$i]['Title']; ?></option>
<?php
                        //}
?>
                        </select>
                    </div>
                </div>

<?php
                if (isset($menuPointData)) {
                    switch ($menuPointData[0]['Role']) {
                        case 4 :
?>
                <div class="form-group">
                    <label for="GalleryType" class="col-sm-2 control-label"><?php print $menuJson->labels->gallerytype; ?></label>
                    <div class="col-sm-10">
                        <select id="GalleryType" class="form-control" name="GalleryType">
                            <option value=""><?php print $menuJson->targets->choose->label; ?></option>
                            <option <?php if ($menuPointData[0]['AdditionalField'] == 0) { print 'selected'; } ?> value="0"><?php print $menuJson->gallerytypes->gallery->label; ?></option>
                            <option <?php if ($menuPointData[0]['AdditionalField'] == 1) { print 'selected'; } ?> value="1"><?php print $menuJson->gallerytypes->coverslider->label; ?></option>
                            <option <?php if ($menuPointData[0]['AdditionalField'] == 2) { print 'selected'; } ?> value="2"><?php print $menuJson->gallerytypes->slider->label; ?></option>
                        </select>
                    </div>
                </div>
<?php
                            break;
                        
                        case 6 :
                            $tableData = json_decode($menuPointData[0]['AdditionalField']);
?>
                <div class="form-group">
                    <label for="Tabellakod" class="col-sm-2 control-label">Tabellakód</label>
                    <div class="col-sm-10">
                        <input class="form-control" type="text" id="Tabellakod" name="Tabellakod" value="<?php if (isset($tableData->Tabellakod)) { print $tableData->Tabellakod; } ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label for="Csapatszam" class="col-sm-2 control-label">Csapatszám</label>
                    <div class="col-sm-10">
                        <input class="form-control" type="text" id="Csapatszam" name="Csapatszam" value="<?php if (isset($tableData->Csapatszam)) { print $tableData->Csapatszam; } ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label for="Fejszoveg" class="col-sm-2 control-label">Fejszöveg</label>
                    <div class="col-sm-10">
                        <input class="form-control" type="text" id="Fejszoveg" name="Fejszoveg" value="<?php if (isset($tableData->Fejszoveg)) { print $tableData->Fejszoveg; } ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label for="Ideny" class="col-sm-2 control-label">Idény</label>
                    <div class="col-sm-10">
                        <input class="form-control" type="text" id="Ideny" name="Ideny" value="<?php if (isset($tableData->Ideny)) { print $tableData->Ideny; } ?>">
                    </div>
                </div>
<?php
                            break;
                        case 7 :
?>
                <div class="form-group">
                    <label for="Feltoltendo" class="col-sm-2 control-label">File</label>
                    <div class="col-sm-10">
                        <input class="form-control" type="file" id="Feltoltendo" name="Feltoltendo[]">
                        <input type="hidden" name="oldFile" id="oldFile" value="<?php if (isset($menuPointData) && $menuPointData[0]['FileName'] != '') { print $menuPointData[0]['FileName']; } ?>">
                    </div>
                </div>
<?php
                            break;
                    }
                } else if (!isset($menuPointData)) {
?>
                    <div class="form-group">
                        <label for="Szerep" class="col-sm-2 control-label"><?php print $menuJson->labels->role; ?>:</label>
                        <div class="col-sm-10">
                            <select class="form-control" id="Szerep" name="Szerep">
<?php
                                foreach ($menuRoles as $menuRoles2) {
?>
                                <option <?php if (isset($menuPointData) && $menuRoles2['RoleId'] == $menuPointData[0]['Role']) { print 'selected="selected"'; } ?> value="<?php print $menuRoles2['RoleId']; ?>"><?php print $menuRoles2['RoleName']; ?></option>
<?php
                                }
?>
                            </select>
                        </div>
                    </div>
<?php
                }
?>
                <div id="additionalWrapper" style="display:none;"></div>
                <div>
                    <button type="button" class="btn btn-default" onclick="javascript: $('#MenuForm').submit();" name="feltoltes" id="feltoltes"><?php if (!isset($menuPointData)) { print $menuJson->labels->upload; } else if (isset($menuPointData)) { print $menuJson->labels->update; }?></button>
                    <input type="hidden" name="ParentId" id="ParentId" value="<?php if (isset($menuPointData)) { print $menuPointData[0]['ParentId']; } else if (!isset($menuPointData)) { print $_POST['menuObject']['parentId']; } ?>" />
                    <input type="hidden" name="ParentNode" id="ParentNode" value="<?php if (isset($menuPointData)) { print $menuPointData[0]['MainNode']; } else if (!isset($menuPointData)) { print $_POST['menuObject']['parentNode']; } ?>" />
                    <input type="hidden" name="MoreFlag" id="MoreFlag" value="0" />
                    <input type="hidden" name="event" id="event" value="<?php if (isset($menuPointData)) { print 'updateMenu'; } else if (!isset($menuPointData)) { print 'newMenu'; } ?>" />
                    <input type="hidden" name="popupHidden" id="popupHidden" value="0" />
<?php
                    if (isset($menuPointData)) {
?>
                    <button type="button" class="btn btn-facebook" onclick="javascript: shareOnFacebook();" id="facebookShare" name="facebookShare"><?php print $menuJson->labels->facebookShare; ?></button>
                    <input type="hidden" name="MainHeaderId" id="MainHeaderId" value="<?php print $menuPointData[0]['MainHeaderId']; ?>" />
                    <input type="hidden" name="LangHeaderId" id="LangHeaderId" value="<?php print $menuPointData[0]['LangHeaderId']; ?>" />
                    <input type="hidden" name="RankHidden" id="RankHidden" value="<?php print $menuPointData[0]['Rank']; ?>" />  
                    <input type="hidden" name="Szerep" id="Szerep" value="<?php print $menuPointData[0]['Role']; ?>" />
<?php
                    }
?>
                </div>
            </form>
        </div>

<?php
        if (isset($controllerCollection)) {
            for ($i=0; $i<=count($controllerCollection)-1; $i++) {
?>
                <div id="<?php print $controllerCollection[$i]; ?>Container" role="tabpanel" class="tab-pane">
<?php
                    $dataArray = array();
                    $dataArray[0]['MainHeaderId'] = $menuPointData[0]['MainHeaderId'];
                    $controllerName = $controllerCollection[$i] . 'Controller';
                    $controller = new $controllerName($dataArray, $this->db);
?>
                </div>
<?php
            }
        }
?>
        </div>
    </div>
</div>