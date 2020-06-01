<div class="card shadow mb-12">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary"><?php print $contactLabels->labels->headLabel; ?></h6>
    </div>
    <form id="contactForm" role="form" method="post" action="ContactForm">
        <div class="card-body">
            <div class="form-group">
                <label for="Name"><?php print $contactLabels->labels->name; ?>:</label>
                <input class="form-control" name="Name" id="Name" type="text" value="<?php if (!empty($contactData)) { print $contactData[0]['Name']; } ?>">
            </div>
            <div class="form-group">
                <label for="TargetMail"><?php print $contactLabels->labels->email; ?>:</label>
                <input class="form-control" name="TargetMail" id="TargetMail" type="text" value="<?php if (!empty($contactData)) { print $contactData[0]['TargetMail']; } ?>">
            </div>
            <div class="form-group">
                <label for="Address"><?php print $contactLabels->labels->address; ?>:</label>
                <input class="form-control" name="Address" id="Address" type="text" value="<?php if (!empty($contactData)) { print $contactData[0]['Address']; } ?>">
            </div>
            <div class="form-group">
                <label for="Phone"><?php print $contactLabels->labels->phone; ?>:</label>
                <input class="form-control" name="Phone" id="Phone" type="text" value="<?php if (!empty($contactData)) { print $contactData[0]['Phone']; } ?>">
            </div>
            <div class="form-group">
                <label for="Fax"><?php print $contactLabels->labels->fax; ?>:</label>
                <input class="form-control" name="Fax" id="Fax" type="text" value="<?php if (!empty($contactData)) { print $contactData[0]['Fax']; } ?>">
            </div>
            <div class="form-group">
                <label for="mobile"><?php print $contactLabels->labels->cellPhone; ?>:</label>
                <input class="form-control" name="Mobile" id="Mobile" type="text" value="<?php if (!empty($contactData)) { print $contactData[0]['Mobile']; } ?>">
            </div>
            <div class="form-group">
                <label for="SmtpServer"><?php print $contactLabels->labels->smtpServer; ?>:</label>
                <input class="form-control" name="SmtpServer" id="SmtpServer" type="text" value="<?php if (!empty($contactData)) { print $contactData[0]['SmtpServer']; } ?>">
            </div>
            <div class="form-group">
                <label for="SmtpPassword"><?php print $contactLabels->labels->smtpPassword; ?>:</label>
                <input class="form-control" name="SmtpPassword" id="SmtpPassword" type="password" value="<?php if (!empty($contactData)) { print $contactData[0]['SmtpPassword']; } ?>">
            </div>
            <div class="form-group">
                <label for="Port"><?php print $contactLabels->labels->smtpPort; ?>:</label>
                <input class="form-control" name="Port" id="Port" type="text" value="<?php if (!empty($contactData)) { print $contactData[0]['Port']; } ?>">
            </div>
            <div class="form-group">
                <label for="UserName"><?php print $contactLabels->labels->smtpUsername; ?>:</label>
                <input class="form-control" name="UserName" id="UserName" type="text" value="<?php if (!empty($contactData)) { print $contactData[0]['UserName']; } ?>">
            </div>            
        </div>
        <div class="card-footer">
            <input name="event" id="event" type="hidden" value="ContactUpdate" />
            <input name="cidHidden" id="cidHidden" type="hidden" value="<?php if (empty($contactData)) { print 0; } else { print $contactData[0]['ContactId']; } ?>" />
            <button name="sendForm" id="sendForm" class="btn btn-primary" type="button" onclick="javascript:$('#contactForm').submit();"><?php print $contactLabels->labels->send; ?></button>
        </div>
    </form>
</div>
