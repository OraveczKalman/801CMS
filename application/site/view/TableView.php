<div class="col-md-8" id="szoveges">
    <script type="text/javascript">
        $(document).ready(function () {
            betolto(1);
        });    
        
        function betolto(fordulo) {
            $('#tabellaDiv').load('<?php print $this->dataArray[0]['Link']; ?>', { 'event':'RenderTable', Fordulo:fordulo });	
        }
    </script>
    <h1><?php print $tableData->Fejszoveg; ?></h1>
    <form class="form-horizontal">
        <div class="row-fluid">
            <div class="form-group">
                <label for="fordulo" class="col-sm-2 control-label">Forduló:</label>
                <div class="col-sm-2">
                    <select id="fordulo" class="form-control" onchange="javascript: betolto($('#fordulo option:selected').val());">
<?php
        for ($i=1; $i<=($tableData->Csapatszam-1)*2; $i++) {
?>
                        <option value="<?php print $i; ?>"><?php print $i; ?>.</option>
<?php
        }
?>
                    </select>
                </div>
            </div>
        </div>
    </form>
    <div id="tabellaDiv"></div>
</div>
<!-- Blog Sidebar Widgets Column -->
<div class="col-md-4">
<?php
    $likeBoxDataArray = array();
    $likeBoxDataArray[0]['event'] = 'RenderLikeBox';
    include_once(SITE_CONTROLLER_PATH . 'LikeBoxController.php');
    $likeBox = new LikeBoxController($likeBoxDataArray, $this->db);
    $sponsorsDataArray = array();
    $sponsorsDataArray[0]['event'] = 'RenderSponsors';
    include_once(SITE_CONTROLLER_PATH . 'SponsorController.php');
    $sponsors = new SponsorController($sponsorsDataArray, $this->db);
?>
</div>