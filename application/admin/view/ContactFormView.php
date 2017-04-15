<script type="text/javascript">
    $(document).ready(function() {
        $('.alert').css('display', 'none');

        $().tooltip({
            'placement': 'right',
            'trigger': 'manual'
        });     


        $('#contact_form').ajaxForm({
            datatype: 'json',
            success: processError
        });

        $('#Name').on('blur', function () {
            sendOneField('validateText', 'admin/ContactForm', $('#Name').val(), 'Name');
        });

        $('#TargetMail').on('blur', function () {
            sendOneField('validateEmail', 'admin/ContactForm', $('#TargetMail').val(), 'TargetMail');
        });

        $('#Address').on('blur', function () {
            sendOneField('validateText', 'admin/ContactForm', $('#Address').val(), 'Address');
        });

        $('#Phone').on('blur', function () {
            sendOneField('validatePhone', 'admin/ContactForm', $('#Phone').val(), 'Phone');
        });

        $('#Fax').on('blur', function () {
            sendOneField('validatePhone', 'admin/ContactForm', $('#Fax').val(), 'Fax');
        });

        $('#Mobile').on('blur', function () {
            sendOneField('validatePhone', 'admin/ContactForm', $('#Mobile').val(), 'Mobile');
        });

        $('#SmtpServer').on('blur', function () {
            sendOneField('validateText', 'admin/ContactForm', $('#SmtpServer').val(), 'SmtpServer');
        });

        $('#SmtpPassword').on('blur', function () {
            sendOneField('validateText', 'admin/ContactForm', $('#SmtpPassword').val(), 'SmtpPassword');
        });

        $('#Port').on('blur', function () {
            sendOneField('validateInt', 'admin/ContactForm', $('#Port').val(), 'Port');
        });

        $('#UserName').on('blur', function () {
            sendOneField('validateText', 'admin/ContactForm', $('#UserName').val(), 'UserName');
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
        <h1>Kontakt form beállításai</h1>
        <form id="contact_form" role="form" class="form-horizontal" method="post" action="admin/ContactForm">
            <div class="form-group">
                <label for="Name" class="col-sm-2 control-label">Név:</label>
                <div class="col-sm-5"><input class="form-control" name="Name" id="Name" type="text" value="<?php if (!empty($contactData)) { print $contactData[0]['Name']; } ?>"></div>
            </div>
            <div class="form-group">
                <label for="TargetMail" class="col-sm-2 control-label">E-mail:</label>
                <div class="col-sm-5"><input class="form-control" name="TargetMail" id="TargetMail" type="text" value="<?php if (!empty($contactData)) { print $contactData[0]['TargetMail']; } ?>"></div>
            </div>
            <div class="form-group">
                <label for="Address" class="col-sm-2 control-label">Cím:</label>
                <div class="col-sm-5"><input class="form-control" name="Address" id="Address" type="text" value="<?php if (!empty($contactData)) { print $contactData[0]['Address']; } ?>"></div>
            </div>
            <div class="form-group">
                <label for="Phone" class="col-sm-2 control-label">Telefonszám:</label>
                <div class="col-sm-5"><input class="form-control" name="Phone" id="Phone" type="text" value="<?php if (!empty($contactData)) { print $contactData[0]['Phone']; } ?>"></div>
            </div>
            <div class="form-group">
                <label for="Fax" class="col-sm-2 control-label">Fax:</label>
                <div class="col-sm-5"><input class="form-control" name="Fax" id="Fax" type="text" value="<?php if (!empty($contactData)) { print $contactData[0]['Fax']; } ?>"></div>
            </div>
            <div class="form-group">
                <label for="mobile" class="col-sm-2 control-label">Mobiltelefon:</label>
                <div class="col-sm-5"><input class="form-control" name="Mobile" id="Mobile" type="text" value="<?php if (!empty($contactData)) { print $contactData[0]['Mobile']; } ?>"></div>
            </div>
            <div class="form-group">
                <label for="SmtpServer" class="col-sm-2 control-label">Smtp Server:</label>
                <div class="col-sm-5"><input class="form-control" name="SmtpServer" id="SmtpServer" type="text" value="<?php if (!empty($contactData)) { print $contactData[0]['SmtpServer']; } ?>"></div>
            </div>
            <div class="form-group">
                <label for="SmtpPassword" class="col-sm-2 control-label">Smtp Password:</label>
                <div class="col-sm-5"><input class="form-control" name="SmtpPassword" id="SmtpPassword" type="text" value="<?php if (!empty($contactData)) { print $contactData[0]['SmtpPassword']; } ?>"></div>
            </div>
            <div class="form-group">
                <label for="Port" class="col-sm-2 control-label">Smtp Port:</label>
                <div class="col-sm-5"><input class="form-control" name="Port" id="Port" type="text" value="<?php if (!empty($contactData)) { print $contactData[0]['Port']; } ?>"></div>
            </div>
            <div class="form-group">
                <label for="UserName" class="col-sm-2 control-label">Smtp Username:</label>
                <div class="col-sm-5"><input class="form-control" name="UserName" id="UserName" type="text" value="<?php if (!empty($contactData)) { print $contactData[0]['UserName']; } ?>"></div>
            </div>
            <div class="form-group">
                <input name="event" id="event" type="hidden" value="ContactUpdate" />
                <input name="cid_hidden" id="cid_hidden" type="hidden" value="<?php if (empty($contactData)) { print 0; } else {print $contactData[0]['ContactId']; } ?>" />
                <button name="send_form" id="send_form" class="btn btn-default" type="submit">Adatok küldése</button>
            </div>
        </form>
    </div>
</div>