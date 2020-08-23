<?php
$i = 0;
foreach ($galleryObjects as $galleryPicture) {
?>
    <div class="card" style="width:18rem; margin-right: 1rem; margin-bottom: 1rem;" id="sort_<?php print $i; ?>">
        <img class="card-img-top" src="<?php print PATH_LEVEL_UP2 . $galleryPicture['kep_nev']; ?>">
        <div class="card-body">
            <?php print $galleryPicture['kep_nev_big']; ?>
<?php
            if ($galleryPicture['MediaType'] == 1) {
?>
            <div class="row">
                <button type="button" class="btn btn-primary col-md-12 mb-sm-2" onclick="javascript: cropForm( { fileName:'<?php print $galleryPicture['kep_nev_big']; ?>', thumbFileName:'<?php print $galleryPicture['kep_nev']; ?>', reloadTag:'pic<?php print $i; ?>', picId:<?php print $galleryPicture['PictureId']; ?>, galleryId:<?php print $galleryPicture['LangHeaderId']; ?>, targW:<?php print $_SESSION['setupData']['galleryHeader']['width']; ?>, targH:<?php print $_SESSION['setupData']['galleryHeader']['height']; ?>, galleryReload:1, mode:0 });"><?php print $pictureListLabels->labels->imageData; ?></button>
            </div>
<?php
            }
?>
            <div class="row">
                <button type="button" class="btn btn-primary col-md-12" onclick="javascript: descriptionForm( { pictureId:<?php print $galleryPicture['PictureId']; ?> } );"><?php print $pictureListLabels->labels->captions; ?></button>
            </div>
            <input type="hidden" value="<?php print $galleryPicture['PictureId']; ?>" id="pic_id<?php print $i; ?>" name="pic_id[]">
            <input type="hidden" value="<?php if ($galleryPicture['Rank'] > 0) { print $galleryPicture['Rank']; } else { print $i; } ?>" id="rank<?php print $i; ?>" name="rank[]">
        </div>
    </div>
<?php
    $i++;
}