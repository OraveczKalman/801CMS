<div class="card shadow mb-12">
    <div class="card-header py-3 form-inline">
        <h6 class="m-0 font-weight-bold text-primary" style="padding-right:1rem;">Nyelvek</h6>
        <button class="btn btn-primary" onclick="javascript: addNewLanguage();">Új nyelv</button>
    </div>
    <div class="card-body">
        <table class="table">
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