<script type="text/javascript" src="<?php print ADMIN_JS_PATH; ?>formScripts/LanguageForm.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        initLanguageForm("<?php print $languageLabels->labels->language; ?>");
    });
</script>
<div class="modal-header">
    <h5 class="modal-title">Új nyelv</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>   
</div>
<form id="languageForm" role="form" method="post" action="LanguageForm">
    <div class="modal-body">
        <div id="MessageBody" style="display:none;"></div>
        <div class="row">
            <div class="col-lg-12">
                <div class="form-group">
                    <label><?php print $languageLabels->labels->language; ?>:</label>
                    <input class="form-control" name="Language" id="Language" type="text" value="">             
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">        
                <div class="form-group">
                    <label><?php print $languageLabels->labels->languageSign; ?>:</label>
                    <input class="form-control" name="LanguageSign" id="LanguageSign" type="text" value="">
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <input name="event" id="event" type="hidden" value="LanguageInsert" />
        <button name="send_form" id="send_form" class="btn btn-primary" type="button" onclick="javscript: $('#languageForm').submit();"><?php print $languageLabels->labels->send; ?></button>
    </div>
</form>

