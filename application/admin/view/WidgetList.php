<script type="text/javascript">
    $(document).ready(function() {
        $('#widgetForm').ajaxForm({
            success: processError
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

<form id="widgetForm" method="post" action="../admin/Widget">
<?php
for ($i=0; $i<=count($widgetList)-1; $i++) {
?>
    <div>
        <input type="checkbox" value="<?php print $widgetList[$i]["WidgetId"]; ?>" name="widget[]" id="widget<?php print $i; ?>"><?php print $widgetList[$i]['ControllerName']; ?>
        <select class="form-control" id="widgetPlace<?php print $i; ?>" name="widgetPlace[]">
            <option value="">Válassz!</option>
<?php
    print $widgetPlaceOptions;
?>
        </select>
    </div>
<?php
}
?>
    <div>
        <button type="button" class="btn btn-default" name="saveButton" id="saveButton" onclick="javascript: $('#widgetForm').submit();">Mentés</button>
        <input type="hidden" name="event" id="event" value="save" />
        <input type="hidden" name="MainHeaderId" id="MainHeaderId" value="<?php print $this->dataArray[0]['mainHeaderId']; ?>" />
    </div>
</form>