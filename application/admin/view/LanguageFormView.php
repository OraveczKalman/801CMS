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
            sendOneField('validateText', 'admin/ContactForm', $('#Language').val(), 'Language');
        });

        $('#LanguageSign').on('blur', function () {
            sendOneField('validateText', 'admin/ContactForm', $('#LanguageSign').val(), 'LanguageSign');
        });
    });

    function processError(data) {
        data = JSON.parse(data);
        if (typeof data.good !== "undefined") {
            $('#MessageBox #MessageBody').html('<div style="text-align: center;"><?php print $languageLabels->labels->language; ?></div>');
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
</div>