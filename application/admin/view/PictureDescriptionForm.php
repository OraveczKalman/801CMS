<script type="text/javascript">
    $(document).ready(function() {
        $('#pictureDescriptionForm').ajaxForm({
            success: processError
        });
        
        $('#saveButton').on('click', function () {
            $('#pictureDescriptionForm').submit();
        });
    });
    
    function descriptionStateChange(where) {
        if ($('#' + where).val() === 0) {
            $('#' + where).val() = 2;
        }
    }
    
    function processError(data) {
        if (data == '') {
            $('#modalContainer').modal('hide');
        }
    }
</script>

<div class="modal-dialog">
    <form id="pictureDescriptionForm" method="post" action="./admin/Gallery">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Képaláírások</h4>
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
                <button type="button" id="saveButton" name="saveButton" class="btn btn-default">Mentés</button>				
            </div>
        </div>
    </form>
</div>