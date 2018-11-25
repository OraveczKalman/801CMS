<script type="text/javascript">
    $(document).ready(function() {
        $('.alert').css('display', 'none');

        $().tooltip({
            'placement': 'right',
            'trigger': 'manual'
        });     


        $('#language_form').ajaxForm({
            datatype: 'json',
            success: processError
        });

        $('#Language').on('blur', function () {
            sendOneField('validateText', 'admin/LanguageForm', $('#Language').val(), 'Language');
        });

        $('#LanguageSign').on('blur', function () {
            sendOneField('validateText', 'admin/LanguageForm', $('#LanguageSign').val(), 'LanguageSign');
        });
    });

    function processError(data) {
        data = JSON.parse(data);
        if (typeof data.good !== "undefined") {
            $('#MessageBox #MessageBody').html('<div style="text-align: center;"><?php print $languageLabels->labels->language; ?></div>');
            $('#MessageBox').modal('show');
            setTimeout(function () {               
                $('#MessageBox').modal('hide');
                loadPage('admin/LanguageForm', 'RenderLanguageForm');
            }, 5000);
        } else if (typeof data.error !== "undefined") {
            showErrors(data.error);
        }
    }
    
    function deleteLanguage(languageId) {
        $.post('admin/LanguageForm', { event:'DeleteLanguage', languageId: languageId }, function (data) {
            data = JSON.parse(data);
            if (typeof data.good !== "undefined") {
                $('#MessageBox #MessageBody').html('<div style="text-align: center;">A nyelv törlése sikeres volt!</div>');
                $('#MessageBox').modal('show');
                setTimeout(function () {               
                    $('#MessageBox').modal('hide');
                    loadPage('admin/LanguageForm', 'RenderLanguageForm');
                }, 5000);
            } else if (typeof data.error !== "undefined") {
                showErrors(data.error);
            }            
        });
    }
    
    function setDefaultLanguage(languageId) {
        $.post('admin/LanguageForm', { event:'SetDefaultLanguage', languageId: languageId }, function (data) {
            data = JSON.parse(data);
            if (typeof data.good !== "undefined") {
                $('#MessageBox #MessageBody').html('<div style="text-align: center;">Az alapértelmezett nyelv beállítása sikeres volt!</div>');
                $('#MessageBox').modal('show');
                setTimeout(function () {               
                    $('#MessageBox').modal('hide');
                    loadPage('admin/LanguageForm', 'RenderLanguageForm');
                }, 5000);
            } else if (typeof data.error !== "undefined") {
                showErrors(data.error);
            }            
        });       
    }
</script>
<div class="row-fluid">
    <div class="col-sm-12">
        <div class="row-fluid">
            <h1><?php print $languageLabels->labels->headLabel; ?></h1>
            <form id="language_form" role="form" class="form-horizontal" method="post" action="admin/LanguageForm">
                <div class="form-group">
                    <label for="Name" class="col-sm-2 control-label"><?php print $languageLabels->labels->language; ?>:</label>
                    <div class="col-sm-5"><input class="form-control" name="Language" id="Language" type="text" value=""></div>
                </div>
                <div class="form-group">
                    <label for="TargetMail" class="col-sm-2 control-label"><?php print $languageLabels->labels->languageSign; ?>:</label>
                    <div class="col-sm-5"><input class="form-control" name="LanguageSign" id="LanguageSign" type="text" value=""></div>
                </div>
                <div class="form-group">
                    <input name="event" id="event" type="hidden" value="LanguageInsert" />
                    <button name="send_form" id="send_form" class="btn btn-default" type="submit"><?php print $languageLabels->labels->send; ?></button>
                </div>
            </form>
        </div>
        <div class="row-fluid">
            <table class="table table-condensed">
                <thead>
                    <th>Nyelv</th>
                    <th>Jel</th>
                    <th>Alapértelmezett</th>
                    <th>&nbsp;</th>
                </thead>
                <tbody>
<?php
    for ($i=0; $i<=count($languageList)-1; $i++) {
?>
                    <tr>
                        <td><?php print $languageList[$i]['Description']; ?></td>
                        <td><?php print $languageList[$i]['LanguageSign']; ?></td>
                        <td><?php if ($languageList[$i]['Default'] == 0) { print "Nem"; } else if ($languageList[$i]['Default'] == 1)  { print "Igen"; } ?></td>
                        <td>
                            <a href="javascript: void(0);" onclick="javascript: deleteLanguage(<?php print $languageList[$i]['LanguageId']; ?>);">
                                <i class="fa fa-eraser" title="Nyelv törlése"></i>
                            </a>|
<?php
        if ($languageList[$i]['Default'] == 1) {
?>
                            <i class="fa fa-check" title="Alapértelmezett nyelv"></i>
<?php
        } else {
?>
                            <a href="javascript: void(0);" onclick="javascript: setDefaultLanguage(<?php print $languageList[$i]['LanguageId']; ?>)">
                                <i class="fa fa-play" title="Beállítás alapértelmezett nyelvnek"></i>
                            </a>
<?php
        }
?>
                        </td>
                    </tr>
<?php
    }
?>
                </tbody>
            </table>
        </div>
    </div>
</div>