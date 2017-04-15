<?php
$i = 0;
foreach ($galleryObjects as $galleryPicture) {
?>
    <tr id="sort_<?php print $i; ?>">
        <td id="pic<?php print $i; ?>">
            <img class="img-thumbnail img-responsive" src="<?php print $galleryPicture['kep_nev']; ?>">
        </td>
        <td>
            <?php print $galleryPicture['kep_nev_big']; ?>
            <button type="button" class="btn btn-default" id="deleteImage<?php print $i; ?>" name="deleteImage<?php print $i; ?>" onclick="javascript: deletePicture(<?php print $galleryPicture['PictureId']; ?>, <?php print $galleryPicture['MainHeaderId']; ?>);"><?php print $pictureListLabels->labels->delete; ?></button>
<?php
            if ($galleryPicture['MediaType'] == 1) {
?>
            <button type="button" class="btn btn-default" onclick="javascript: cropForm( { fileName:'<?php print $galleryPicture['kep_nev_big']; ?>', thumbFileName:'<?php print $galleryPicture['kep_nev']; ?>', reloadTag:'pic<?php print $i; ?>', picId:<?php print $galleryPicture['PictureId']; ?>, galleryId:<?php print $galleryPicture['MainHeaderId']; ?>, targW:<?php print $_SESSION['setupData']['galleryHeader']['width']; ?>, targH:<?php print $_SESSION['setupData']['galleryHeader']['height']; ?>, galleryReload:1, mode:0 });"><?php print $pictureListLabels->labels->cropThumbnail; ?></button>
<?php
            }
?>
            <button type="button" class="btn btn-default" onclick="javascript: descriptionForm( { pictureId:<?php print $galleryPicture['PictureId']; ?> } );"><?php print $pictureListLabels->labels->captions; ?></button>
            <button type="button" class="btn btn-default" onclick="javascript: makeCimlap({ media:'<?php if ($galleryPicture['MediaType'] == 2) { print $galleryPicture['kep_nev']; } else { print $galleryPicture['kep_nev_big']; } ?>', mediaType:<?php print $galleryPicture['MediaType']; ?>, mediaId:<?php print $galleryPicture['PictureId']; ?>, galleryId:<?php print $this->dataArray[0]['MainHeaderId']; ?> });"><?php print $pictureListLabels->labels->cover; ?></button>
            <input type="hidden" value="<?php print $galleryPicture['PictureId']; ?>" id="pic_id<?php print $i; ?>" name="pic_id[]">
            <input type="hidden" value="<?php if ($galleryPicture['Rank'] > 0) { print $galleryPicture['Rank']; } else { print $i; } ?>" id="rank<?php print $i; ?>" name="rank[]">
        </td>
    </tr>
<?php
    $i++;
}