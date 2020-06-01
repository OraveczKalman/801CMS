<script type="text/javascript">
    $(document).ready(function() {
        $('#pictureDescriptionForm').ajaxForm({
            success: processError
        });
        
        /*$('#saveButton').click(function () {
            $('#pictureDescriptionForm').submit();
        });*/
    });
    
    function descriptionStateChange(where) {
        if ($('#' + where).val() === 0) {
            $('#' + where).val() = 2;
        }
    }
    
    function processError(data) {
        data = JSON.parse(data);
        //alert(data.good);
        if (typeof data.good !== 'undefined') {
            $('#formModal').modal('hide');
        }
    }
</script>

<form id="pictureDescriptionForm" method="post" action="Gallery">
    <div class="modal-header">
        <h5 class="modal-title">Képaláírások</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    </div>
    <div class="modal-body">
<?php
    $counter = 0;
    if (!empty($captions)) {
        $this->newDescription($counter, $captions);
    } else {
        $this->newDescription($counter);
    }
?>
    </div>
    <div class="modal-footer">
        <input type="hidden" id="event" name="event" value="SaveDescription" />
        <input type="hidden" id="picId" name="picId" value="<?php print $this->dataArray[0]['pictureId']; ?>" />
        <button type="button" id="saveButton" name="saveButton" onclick="javascript:$('#pictureDescriptionForm').submit();" class="btn btn-primary">Mentés</button>				
    </div>
</form>