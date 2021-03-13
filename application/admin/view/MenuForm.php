<script type="text/javascript">
    $(document).ready(function() {
        $('#MenuForm').ajaxForm({
            success: processError
        });

        $("#Felirat").on('blur', function() {
            sendOneField('validateText', 'Menu', $('#Felirat').val(), 'Felirat');
        });

        $("#Cim").on('blur', function() {
            sendOneField('validateText', 'Menu', $('#Cim').val(), 'Cim');
        });

        $("#Cimsor").on('blur', function() {
            sendOneField('validateText', 'Menu', $('#Cimsor').val(), 'Cimsor');
        });

        $("#Kulcsszavak").on('blur', function() {
            sendOneField('validateText', 'Menu', $('#Kulcsszavak').val(), 'Kulcsszavak');
        });

        $("#Link").on('blur', function() {
            sendOneField('validateText', 'Menu', $('#Link').val(), 'Link');
        });

        $("#Target").on('blur', function() {
            sendOneField('validateText', 'Menu', $('#Target').val(), 'Target');
        });

        $("#MainPage").on('blur', function() {
            sendOneField('validateInt', 'Menu', $('#MainPage').val(), 'MainPage');
        });

        $("#Kommentezheto").on('blur', function() {
            sendOneField('validateInt', 'Menu', $('#Kommentezheto').val(), 'Kommentezheto');
        });

        $("#Szerep").on('blur', function() {
            sendOneField('validateInt', 'Menu', $('#Szerep').val(), 'Szerep');
        });
        
        $('#Szerep').on('change', function() {
            var additionalHtml = '';
            switch (parseInt($('#Szerep option:selected').val(), 10)) {
                case 1 :
                    additionalHtml += '<div class="row">';
                    additionalHtml += '<div class="col-lg-6">';
                    additionalHtml += '<div class="form-group">';
                    additionalHtml += '<label for="DefaultCoverImage" class="form-control-label">Alap borítókép</label>';
                    additionalHtml += '<input type="file" name="defaultCoverImage" id="defaultCoverImage" class="form-control">';
                    additionalHtml += '</div>';
                    additionalHtml += '</div>';
                    additionalHtml += '</div>';
                    $('#additionalWrapper').html(additionalHtml);
                    $('#additionalWrapper').css('display', 'block');                    
                    break;
                case 4 :
                    additionalHtml += '<div class="row">';
                    additionalHtml += '<div class="col-lg-6">';
                    additionalHtml += '<div class="form-group">';
                    additionalHtml += '<label for="GalleryType" class="form-control-label"><?php print $menuJson->labels->gallerytype; ?></label>';                   
                    additionalHtml += '<select id="GalleryType" class="form-control" name="GalleryType">';
                    additionalHtml += '<option value="0"><?php print $menuJson->gallerytypes->gallery->label; ?></option>';
                    additionalHtml += '<option value="1"><?php print $menuJson->gallerytypes->coverslider->label; ?></option>';
                    additionalHtml += '<option value="2"><?php print $menuJson->gallerytypes->slider->label; ?></option>';
                    additionalHtml += '</select>';
                    additionalHtml += '</div>';
                    additionalHtml += '</div>';
                    additionalHtml += '</div>';
                    $('#additionalWrapper').html(additionalHtml);
                    $('#additionalWrapper').css('display', 'block');
                    break;
                case 5 :
                    additionalHtml += '<div class="row">';
                    additionalHtml += '<div class="col-lg-6">';
                    additionalHtml += '<div class="form-group">';
                    additionalHtml += '<label for="TableCode" class="form-control-label"><?php print $menuJson->labels->tableCode; ?></label>';
                    additionalHtml += '<input class="form-control" type="text" id="TableCode" name="TableCode">';
                    additionalHtml += '</div>';
                    additionalHtml += '</div>';
                    additionalHtml += '<div class="col-lg-6">';
                    additionalHtml += '<div class="form-group">';
                    additionalHtml += '<label for="TeamCount" class="form-control-label"><?php print $menuJson->labels->teamCount; ?></label>';
                    additionalHtml += '<input class="form-control" type="text" id="TeamCount" name="TeamCount">';
                    additionalHtml += '</div>';
                    additionalHtml += '</div>';
                    additionalHtml += '</div>';
                    additionalHtml += '<div class="row">';
                    additionalHtml += '<div class="col-lg-6">';
                    additionalHtml += '<div class="form-group">';
                    additionalHtml += '<label for="HeadText" class="form-control-label"><?php print $menuJson->labels->headText; ?></label>';
                    additionalHtml += '<input class="form-control" type="text" id="HeadText" name="HeadText">';
                    additionalHtml += '</div>';
                    additionalHtml += '</div>';
                    additionalHtml += '<div class="col-lg-6">';
                    additionalHtml += '<div class="form-group">';
                    additionalHtml += '<label for="Season" class="form-control-label"><?php print $menuJson->labels->season; ?></label>';
                    additionalHtml += '<input class="form-control" type="text" id="Season" name="Season">';
                    additionalHtml += '</div>';
                    additionalHtml += '</div>';
                    additionalHtml += '</div>';
                    $('#additionalWrapper').html(additionalHtml);
                    $('#additionalWrapper').css('display', 'block');                   
                    break;
                case 6 :
                case 13 :
                    additionalHtml += '<div class="row">';
                    additionalHtml += '<div class="col-lg-6">';
                    additionalHtml += '<div class="form-group">';
                    additionalHtml += '<label for="Feltoltendo" class="form-control-label"><?php print $menuJson->labels->fileLabel; ?></label>';
                    additionalHtml += '<input class="form-control" type="file" id="Feltoltendo" name="Feltoltendo[]">';
                    additionalHtml += '</div>';
                    additionalHtml += '</div>';
                    additionalHtml += '</div>';
                    $('#additionalWrapper').html(additionalHtml);
                    $('#additionalWrapper').css('display', 'block');
                    break;
                case 14 :
                    $('#MainPage').attr("checked", true);
                    $('#additionalWrapper').html('');
                    $('#additionalWrapper').css('display', 'none');                    
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
                if (typeof data.good.new !== "undefined") {
                    loadEditMenuForm({ menuId:data.good.menuId, parentId:data.good.parentId, parentNode:data.good.parentNode });
                }
                $('#MessageBox').modal('hide');
            }, 2000);
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
<div class="card shadow mb-12">
    <div class="card-header py-3 form-inline">
        <h6 class="m-0 font-weight-bold text-primary" style="padding-right:1rem;">Menüadatok</h6>
        <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" href="#menuContainer" role="tab" data-toggle="pill"><?php print $menuJson->labels->headLabel; ?></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#widgetContainer" role="tab" data-toggle="pill">Modulok</a>
            </li>
<?php
            if (isset($controllerCollection)) {
                for ($i = 0; $i <= count($controllerCollection) - 1; $i++) {
?>
            <li class="nav-item">
                <a class="nav-link" href="#<?php print $controllerCollection[$i]; ?>Container" role="tab" data-toggle="pill">
                    <?php print $controllerCollection[$i]; ?>
                </a>
            </li>
<?php
                }
            }
?>               
        </ul>
    </div>
    <div class="card-body">
        <div class="tab-content">
        <div id="menuContainer" role="tabpanel" class="tab-pane active">
            <form class="form-horizontal" enctype="multipart/form-data" role="form" id="MenuForm" method="post" action="Menu">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="Caption" class="form-control-label"><?php print $menuJson->labels->caption; ?></label>
                            <input class="form-control" type="text" <?php if (isset($menuPointData)) { print 'value="' . $menuPointData[0]['Caption'] . '"'; }?> id="Caption" name="Caption">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="Title" class="form-control-label"><?php print $menuJson->labels->title; ?></label>
                            <input class="form-control" type="text" <?php if (isset($menuPointData)) { print 'value="' . $menuPointData[0]['Title'] . '"'; }?> id="Title" name="Title">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for=Heading" class="form-control-label"><?php print $menuJson->labels->heading; ?></label>
                            <input class="form-control" type="text" <?php if (isset($menuPointData)) { print 'value="' . $menuPointData[0]['Heading'] . '"'; }?> id="Heading" name="Heading">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="Keywords" class="form-control-label"><?php print $menuJson->labels->keywords; ?></label>
                            <input class="form-control" type="text" <?php if (isset($menuPointData)) { print 'value="' . $menuPointData[0]['Keywords'] . '"'; }?> id="Keywords" name="Keywords">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="Link" class="form-control-label"><?php print $menuJson->labels->link; ?></label>
                            <input class="form-control" type="text" <?php if (isset($menuPointData)) { print 'value="' . $menuPointData[0]['Link'] . '"'; }?> id="Link" name="Link">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="Target" class="form-control-label"><?php print $menuJson->labels->target; ?></label>
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
                </div>
                <div class="row">
                    <div class="col-lg-12">Nyelvek</div>
                </div>
                <div class="row">
<?php
    if (!isset($menuPointData)) {
        for ($i=0; $i<=count($languages)-1; $i++) {
?>
                    <div class="col-lg-2">
                        <label class="form-control-label"><?php print $languages[$i]["Description"]; ?></label>
                        <input type="checkbox" id="Lang<?php print $i; ?>" name="Lang[]" value="<?php print $languages[$i]["LanguageSign"]; ?>" />
                    </div>
<?php
        }
    }
?>
                </div>
                <div class="row">
                    <div class="col-lg-12">Állapotok</div>
                </div>
                <div class="row">
                    <div class="col-lg-2">
                        <div class="form-group">
                            <label for="Commentable" class="form-control-label"><?php print $menuJson->labels->commentable; ?></label>
                            <input type="checkbox" id="Commentable" name="Commentable" <?php if (isset($menuPointData) && $menuPointData[0]['Commentable'] == 1) { print "checked"; } ?> value="1" />
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="form-group">
                            <label for="UserIn" class="form-control-label"><?php print $menuJson->labels->loggedin; ?></label>
                            <input type="checkbox" id="UserIn" name="UserIn" <?php if (isset($menuPointData) && $menuPointData[0]['UserIn'] == 1) { print "checked"; } ?> value="1">
                        </div>
                    </div>
                </div>
<?php
                if (isset($menuPointData)) {
                    switch ($menuPointData[0]['Role']) {
                        case 4 :
?>
                <div class="row">
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="GalleryType" class="form-control-label"><?php print $menuJson->labels->gallerytype; ?></label>
                            <select id="GalleryType" class="form-control" name="GalleryType">
                                <option value=""><?php print $menuJson->targets->choose->label; ?></option>
                                <option <?php if ($menuPointData[0]['AdditionalField'] == 0) { print 'selected'; } ?> value="0"><?php print $menuJson->gallerytypes->gallery->label; ?></option>
                                <option <?php if ($menuPointData[0]['AdditionalField'] == 1) { print 'selected'; } ?> value="1"><?php print $menuJson->gallerytypes->coverslider->label; ?></option>
                                <option <?php if ($menuPointData[0]['AdditionalField'] == 2) { print 'selected'; } ?> value="2"><?php print $menuJson->gallerytypes->slider->label; ?></option>
                            </select>
                        </div>
                    </div>
                </div>
<?php
                            break;
                        
                        case 5 :
                            $tableData = json_decode($menuPointData[0]['AdditionalField']);
?>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="TableCode" class="form-control-label">Tabellakód</label>
                            <input class="form-control" type="text" id="TableCode" name="TableCode" value="<?php if (isset($tableData->Tabellakod)) { print $tableData->Tabellakod; } ?>">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="TeamCount" class="form-control-label">Csapatszám</label>
                            <input class="form-control" type="text" id="TeamCount" name="TeamCount" value="<?php if (isset($tableData->Csapatszam)) { print $tableData->Csapatszam; } ?>">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="HeadText" class="form-control-label">Fejszöveg</label>
                            <input class="form-control" type="text" id="HeadText" name="HeadText" value="<?php if (isset($tableData->Fejszoveg)) { print $tableData->Fejszoveg; } ?>">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="Season" class="form-control-label">Idény</label>
                            <input class="form-control" type="text" id="Season" name="Season" value="<?php if (isset($tableData->Ideny)) { print $tableData->Ideny; } ?>">
                        </div>
                    </div>
                </div>
<?php
                            break;
                        case 6 :
                        case 13 :
?>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="Uploads" class="col-sm-2 control-label">File</label>
                            <input class="form-control" type="file" id="Feltoltendo" name="Uploads[]">
                            <input type="hidden" name="oldFile" id="oldFile" value="<?php if (isset($menuPointData) && $menuPointData[0]['FileName'] != '') { print $menuPointData[0]['FileName']; } ?>">
                        </div>
                    </div>
                </div>
<?php
                            break;
                    }
                } else if (!isset($menuPointData)) {
?>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                            <label for="Role" class="form-control-label"><?php print $menuJson->labels->role; ?>:</label>
                                <select class="form-control" id="Role" name="Role">
                                    <option value="">Válasszon</option>
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
                    </div>
<?php
                }
?>
                <div id="additionalWrapper" style="display:none;"></div>
                <div>
                    <button type="button" class="btn btn-primary" onclick="javascript: $('#MenuForm').submit();" name="feltoltes" id="feltoltes"><?php if (!isset($menuPointData)) { print $menuJson->labels->upload; } else if (isset($menuPointData)) { print $menuJson->labels->update; }?></button>
                    <input type="hidden" name="ParentId" id="ParentId" value="<?php if (isset($menuPointData)) { print $menuPointData[0]['ParentId']; } else if (!isset($menuPointData)) { print $_POST['menuObject']['parentId']; } ?>" />
                    <input type="hidden" name="MainNode" id="MainNode" value="<?php if (isset($menuPointData)) { print $menuPointData[0]['MainNode']; } else if (!isset($menuPointData)) { print $_POST['menuObject']['parentNode']; } ?>" />
                    <input type="hidden" name="MoreFlag" id="MoreFlag" value="0" />
                    <input type="hidden" name="event" id="event" value="<?php if (isset($menuPointData)) { print 'updateMenu'; } else if (!isset($menuPointData)) { print 'newMenu'; } ?>" />
                    <input type="hidden" name="Popup" id="Popup" value="0" />
<?php
                    if (isset($menuPointData)) {
?>
                    <button type="button" class="btn btn-facebook" onclick="javascript: shareOnFacebook();" id="facebookShare" name="facebookShare"><?php print $menuJson->labels->facebookShare; ?></button>
                    <input type="hidden" name="MainHeaderId" id="MainHeaderId" value="<?php print $menuPointData[0]['MainHeaderId']; ?>" />
                    <input type="hidden" name="LangHeaderId" id="LangHeaderId" value="<?php print $menuPointData[0]['LangHeaderId']; ?>" />
                    <input type="hidden" name="RankHidden" id="RankHidden" value="<?php print $menuPointData[0]['Rank']; ?>" />  
                    <input type="hidden" name="Role" id="Role" value="<?php print $menuPointData[0]['Role']; ?>" />
                    <input type="hidden" name="Lang" id="Lang" value="<?php print $menuPointData[0]['Language']; ?>" />
<?php
                    }
?>
                </div>
            </form>
        </div>
        <div id="widgetContainer" role="tabpanel" class="tab-pane">
<?php
            include_once(ADMIN_CONTROLLER_PATH . 'WidgetController.php');
            $widgetDataArray[] = array("mainHeaderId"=>$menuPointData[0]['MainHeaderId'], "event"=>"widgetList");
            $widgetController = new WidgetController($widgetDataArray, $this->db);
?>
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
<!--<div class="row-fluid">
    <div class="col-sm-12">
    </div>
</div>-->