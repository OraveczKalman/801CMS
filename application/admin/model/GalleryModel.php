<?php 
class GalleryModel {
    private $dataArray;
    private $db;

    public function __construct($db, $dataArray=null) {
        if (!is_null($dataArray)) {
            $this->setDataArray($dataArray);
        }
        $this->setDb($db);
    }
    
    public function setDb($db) {
        $this->db = $db;
    }

    public function setDataArray($dataArray) {
        $this->dataArray = $dataArray;
    }

    /**
     * 
     * @return type
     * @author Oravecz Kálmán
     * Generate form elements to manipulate gallery elements
     */
    public function getGalleryData() {
        $galleryPictures = $this -> getGalleryObjects($this->dataArray[0]['MainHeaderId']);
        for ($i=0; $i<=count($galleryPictures)-1; $i++) {
            switch ($galleryPictures[$i]['MediaType']) {
                case 1 :
                    $galleryPictures[$i]['buttons'] = '<div class="btn-group" role="group">
                        <button class="btn btn-default" type="button" onclick="javascript: insertAtCursor(\'#kep_bal_' . $galleryPictures[$i]['PictureId'] . '#\');">B</button>
                        <button class="btn btn-default" type="button" onclick="javascript: insertAtCursor(\'#kep_kozep_' . $galleryPictures[$i]['PictureId'] . '#\');">K</button>
                        <button class="btn btn-default" type="button" onclick="javascript: insertAtCursor(\'#kep_jobb_' . $galleryPictures[$i]['PictureId'] . '#\');">J</button>
                    </div>';
                    $galleryPictures[$i]['kep_nev_big'] = UPLOADED_MEDIA_PATH . $galleryPictures[$i]['kep_nev_big'];
                    $galleryPictures[$i]['kep_nev'] = UPLOADED_MEDIA_PATH . $galleryPictures[$i]['kep_nev'];
                    break;
                case 2 :
                    $galleryPictures[$i]['buttons'] = '<div class="btn-group" role="group">
                        <button class="btn btn-default" type="button" onclick="javascript: insertAtCursor(\'#youtube_' . $galleryPictures[$i]['PictureId'] . '#\');">Youtube</button>
                    </div>';
                    break;
                case 3 :
                    $galleryPictures[$i]['buttons'] = '<div class="btn-group" role="group">
                        <button class="btn btn-default" type="button" onclick="javascript: insertAtCursor(\'#video_' . $galleryPictures[$i]['PictureId'] . '#\');">Video</button>
                    </div>';
                    $galleryPictures[$i]['kep_nev_big'] = UPLOADED_MEDIA_PATH . $galleryPictures[$i]['kep_nev_big'];
                    $galleryPictures[$i]['kep_nev'] = UPLOADED_MEDIA_PATH . $galleryPictures[$i]['kep_nev'];
                    break;
                case 4 :
                    $galleryPictures[$i]['buttons'] = '<div class="btn-group" role="group">
                        <button class="btn btn-default" type="button" onclick="javascript: insertAtCursor(\'#zene_bal_' . $galleryPictures[$i]['PictureId'] . '#\');">B</button>
                        <button class="btn btn-default" type="button" onclick="javascript: insertAtCursor(\'#zene_kozep_' . $galleryPictures[$i]['PictureId'] . '#\');">K</button>
                        <button class="btn btn-default" type="button" onclick="javascript: insertAtCursor(\'#zene_jobb_' . $galleryPictures[$i]['PictureId'] . '#\');">J</button>
                    </div>';
                    $galleryPictures[$i]['kep_nev_big'] = UPLOADED_MEDIA_PATH . $galleryPictures[$i]['kep_nev_big'];
                    $galleryPictures[$i]['kep_nev'] = UPLOADED_MEDIA_PATH . $galleryPictures[$i]['kep_nev'];
                    break;
            }
            $galleryPictures[$i]['descriptions'] = $this -> getGalleryObjectText($galleryPictures[$i]['PictureId']);
        }
        return $galleryPictures;
    }
    
    public function getPicture() {
        $getMenuQuery = $this->db->selectBuilder($this->dataArray);
        return $getMenuQuery;
    }
    
    /**
     * 
     * @param type $menuId
     * @return type
     * @author Oravecz Kálmán
     * Get all elements to gallery
     */
    public function getGalleryObjects($menuId) {
        $getGalleryObjectQueryString = 'SELECT picture.PictureId, picture.Name AS kep_nev_big, ' .
            'picture.ThumbName AS kep_nev, ' .
            'picture.MediaType, ' .
            '(SELECT main_header.Role FROM main_header WHERE gallery_picture.MainHeaderId = main_header.MainHeaderId) AS Szerep, ' .
            'gallery_picture.MainHeaderId, gallery_picture.Rank ' .
            'FROM gallery_picture ' .
            'INNER JOIN picture ON gallery_picture.PictureId = picture.PictureId ' .
            'WHERE gallery_picture.MainHeaderId = ' . $menuId . ' AND gallery_picture.Active = 1 ' .
            'ORDER BY gallery_picture.Rank ASC';

        $getGalleryObjectsQuery = $this->db->selectQuery($getGalleryObjectQueryString);
        return $getGalleryObjectsQuery;
    }
    
    /**
     * 
     * @param type $galleryObjectId
     * @return type
     * @author Oravecz Kálmán
     * Get textual informations for gallery element
     */
    public function getGalleryObjectText($galleryObjectId) {
        $getGalleryObjectTextQueryString = 'SELECT text.Text, text.TextId FROM text ' . 
            'WHERE SuperiorId = ' . $galleryObjectId . ' ' .
            'AND Type = 3';
        $getGalleryObjectText = $this->db->selectQuery($getGalleryObjectTextQueryString);
        return $getGalleryObjectText;
    }

    /**
     * @author Oravecz Kálmán
     * Insert element to gallery
     */
    public function insertGalleryImages() {
        foreach ($this->dataArray['images'] as $pictureData) {
            switch ($this->dataArray['mediaType']) {
                case 3 :
                    $pictureData['thumbFileName'] = 'videoholder.png';
                    break;
                case 4 :
                    $pictureData['thumbFileName'] = 'musicholder.png';
                    break;
                case 5 :
                    $pictureData['thumbFileName'] = '';
                    break;
            }
            $kepFeltoltQueryString = 'INSERT INTO `picture` SET ' .
                'Name = "' . $pictureData['fileName'] . '", ' .
                'ThumbName = "' . $pictureData['thumbFileName'] . '", ' .
                'MediaType = ' . $this->dataArray['mediaType'] . ', ' .
                'Created = NOW(), ' .
                'CreatedBy = ' . $_SESSION['admin']['userData']['UserId'] . ', ' .
                'Modified = NOW(), ' .
                'ModifiedBy = ' . $_SESSION['admin']['userData']['UserId'] . ', ' .
                'Active = 1';
            $kepFeltoltQuery = $this->db->insertQuery($kepFeltoltQueryString);
            $insertGalTopicQueryString = "INSERT INTO gallery_picture SET " .
                "MainHeaderId = " . $this->dataArray['MainHeaderId'] . ", " .
                "PictureId = " . $kepFeltoltQuery['lastInsert'] . ", " .
                "Rank = 0, " .
                "Active = 1";
            $insertGalTopicQuery = $this->db->insertQuery($insertGalTopicQueryString);
        }
    }

    public function getGalleryCovers($parent) {
        $get_gallery_covers_query_string = "SELECT menu.Link, menu.Felirat, menu.Profile_Picture, menu.Menu_Id " .
            "FROM menu " .
            "LEFT JOIN rank ON menu.Menu_Id = rank.Point_id " .
            "WHERE rank.ParentId = " . $parent . " AND menu.Szerep = 3 AND menu.Active = 1";
        $get_gallery_covers_query = $this -> select_query($get_gallery_covers_query_string);
        return $get_gallery_covers_query;
    }

    public function deletePictureFromGallery($gallery_info) {
        $delete_picture_query_string = 'UPDATE galeria_kep SET ' .
            'Active = ' . $gallery_info['active'] . ' WHERE ' .
            'Menu_id  = ' . $gallery_info['menu_id'] . ' AND ' .
            'KepId  IN (' . $gallery_info['KepId'] . ')';
        $delete_picture_query = $this -> update_query($delete_picture_query_string);
        return $delete_picture_query;
    }
    
    /**
     * 
     * @return type
     * @author Oravecz Kálmán
     * Function for delete elements from gallery
     */
    public function deleteFromGallery() {
        $retArray = array();
        $deleteGalleryPictureQueryString = 'DELETE FROM gallery_picture WHERE MainHeaderId = ' .
            $this->dataArray['MainHeaderId'] . ' AND PictureId = ' . $this->dataArray['PictureId'];
        $deleteGalleryPictureQuery = $this->db->updateQuery($deleteGalleryPictureQueryString);
        if (!isset($deleteGalleryPictureQuery['error'])) {
            $deletePictureQueryString = 'DELETE FROM picture WHERE PictureId = ' . $this->dataArray['PictureId'];
            $deletePictureQuery = $this->db->updateQuery($deletePictureQueryString);
            if (isset($deletePictureQuery['error'])) {
                $retArray['error'] = $deleteGalleryPictureQuery['error'];
            }
        } else {
            $retArray['error'] = $deleteGalleryPictureQuery['error'];
        }
        return $retArray;
    }
    
    /**
     * 
     * @return type
     * @author Oravecz Kálmán
     * Update function for sequence of elments in gallery 
     */
    public function updateGallery() {
        $updatePicturesQueryString = 'UPDATE `gallery_picture` SET ' .
            '`Rank` = ' . $this->dataArray['rank'] . ' ' .
            'WHERE `PictureId` = ' . $this->dataArray['pic_id'];
        $updatePicturesQuery = $this->db->updateQuery($updatePicturesQueryString);
        return $updatePicturesQuery;
    }
    
    /**
     * 
     * @return type
     * @author Oravecz Kálmán
     * Update gallery element thumbnail database function
     */
    public function updatePictureThumbnail() {
        $updateThumbnailsQueryString = 'UPDATE `Picture` SET ' .
            'ThumbName = "' . $this->dataArray['thumbKepnev'] . '" ' .
            'WHERE `PictureId` = "' . $this->dataArray['picId'] . '"';
        $updateThumbnailsQuery = $this->db->updateQuery($updateThumbnailsQueryString);
        return $updateThumbnailsQuery;
    }
}
