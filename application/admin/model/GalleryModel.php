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
        $result = array();
        try {
            $getGalleryObjectQuery = $this->db->dbLink->prepare('SELECT picture.PictureId, picture.Name AS kep_nev_big, ' .
                'picture.ThumbName AS kep_nev, ' .
                'picture.MediaType, ' .
                '(SELECT main_header.Role FROM main_header WHERE gallery_picture.MainHeaderId = main_header.MainHeaderId) AS Szerep, ' .
                'gallery_picture.MainHeaderId, gallery_picture.Rank ' .
                'FROM gallery_picture ' .
                'INNER JOIN picture ON gallery_picture.PictureId = picture.PictureId ' .
                'WHERE gallery_picture.MainHeaderId = :menuId AND gallery_picture.Active = 1 ' .
                'ORDER BY gallery_picture.Rank ASC');
            $getGalleryObjectQuery->bindParam(':menuId', $menuId, PDO::PARAM_INT);
            $getGalleryObjectQuery->execute();
            $result = $getGalleryObjectQuery->fetchAll();
        } catch (PDOException $e) {
            $this->db->logWriter($e->errorInfo);
        }
        return $result;
    }
    
    /**
     * 
     * @param type $galleryObjectId
     * @return type
     * @author Oravecz Kálmán
     * Get textual informations for gallery element
     */
    public function getGalleryObjectText($galleryObjectId) {
        $result = array();
        try {
            $getGalleryObjectTextQuery = $this->db->dbLink->prepare("SELECT text.Text, text.TextId FROM text  
                WHERE SuperiorId = :galleryObjectId
                AND Type = 3");
            $getGalleryObjectTextQuery->bindParam(':galleryObjectId', $galleryObjectId, PDO::PARAM_INT);
            $getGalleryObjectTextQuery->execute();
            $result = $getGalleryObjectTextQuery->fetchAll();
        } catch (PDOException $e) {
            $this->db->logWriter($e->errorInfo);
        }
        return $result;
    }

    /**
     * @author Oravecz Kálmán
     * Insert element to gallery
     */
    public function insertGalleryImages() {
        try {
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
                $kepFeltoltQuery = $this->db->dbLink->prepare("INSERT INTO `picture` SET 
                    Name = :fileName,
                    ThumbName = :thumbFileName,
                    MediaType = :mediaType,
                    Created = NOW(),
                    CreatedBy = :userId,
                    Modified = NOW(),
                    ModifiedBy = :userId,
                    Active = 1");
                $kepFeltoltQuery->bindParam(":fileName", $pictureData["fileName"], PDO::PARAM_STR);
                $kepFeltoltQuery->bindParam(":thumbFileName", $pictureData["thumbFileName"], PDO::PARAM_STR);
                $kepFeltoltQuery->bindParam(":mediaType", $this->dataArray["mediaType"], PDO::PARAM_INT);
                $kepFeltoltQuery->bindParam(":userId", $_SESSION['admin']['userData']['UserId'], PDO::PARAM_INT);
                $kepFeltoltQuery->execute();
                $lastInsert = $this->db->dbLink->lastInsertId();
                $insertGalTopicQuery = $this->db->dbLink->prepare("INSERT INTO gallery_picture SET 
                    MainHeaderId = :mainHeaderId,
                    PictureId = :pictureId,
                    Rank = 0,
                    Active = 1");
                $insertGalTopicQuery->bindParam(":mainHeaderId", $this->dataArray['MainHeaderId'], PDO::PARAM_INT);
                $insertGalTopicQuery->bindParam(":pictureId", $lastInsert, PDO::PARAM_INT);
                $insertGalTopicQuery->execute();
            }
        } catch (PDOException $e) {
            $this->db->logWriter($e->errorInfo);
        }
    }

    public function getGalleryCovers($parent) {
        $result = array();
        try {
            $getGalleryCoversQuery = $this->db->dbLink->prepare("SELECT menu.Link, menu.Felirat, menu.Profile_Picture, menu.Menu_Id 
                FROM menu 
                LEFT JOIN rank ON menu.Menu_Id = rank.Point_id 
                WHERE rank.ParentId = :parentId AND menu.Szerep = 3 AND menu.Active = 1");
            $getGalleryCoversQuery->bindParam(":parentId", $parent, PDO::PARAM_INT);
            $getGalleryCoversQuery->execute();
            $result = $getGalleryCoversQuery->fetchAll();
        } catch (PDOException $e) {
            $this->db->logWriter($e->errorInfo);          
        }
        return $result;
    }
    
    /**
     * 
     * @return type
     * @author Oravecz Kálmán
     * Function for delete elements from gallery
     */
    public function deleteFromGallery() {
        try {
            $retArray = array();
            $deleteGalleryPictureQuery = $this->db->dbLink->prepare("DELETE FROM gallery_picture WHERE MainHeaderId = :mainHeaderId
                AND PictureId = :pictureId");
            $deleteGalleryPictureQuery->bindParam(":mainHeaderId", $this->dataArray["mainHeaderId"], PDO::PARAM_INT);
            $deleteGalleryPictureQuery->bindParam(":pictureId", $this->dataArray["pictureId"], PDO::PARAM_INT);
            $deleteGalleryPictureQuery->execute();
            $deletePictureQuery = $this->db->dbLink->prepare("DELETE FROM picture WHERE PictureId = :pictureId");
            $deletePictureQuery->bindParam(":pictureId", $this->dataArray["pictureId"], PDO::PARAM_INT);
            $deletePictureQuery->execute();
        } catch (PDOException $e) {
            $this->db->logWriter($e->errorInfo);
        }
    }
    
    /**
     * 
     * @return type
     * @author Oravecz Kálmán
     * Update function for sequence of elments in gallery 
     */
    public function updateGallery() {
        try {
            $updatePicturesQuery = $this->db->dbLink->prepare("UPDATE `gallery_picture` SET 
                `Rank` = :rank 
                WHERE `PictureId` = :pictureId");
            $updatePicturesQuery->bindParam(":rank", $this->dataArray['rank'], PDO::PARAM_INT);
            $updatePicturesQuery->bindParam(":pictureId", $this->dataArray['pic_id'], PDO::PARAM_INT);
            $updatePicturesQuery->execute();
        } catch (PDOException $e) {
            $this->db->logWriter($e->errorInfo);
        }
        return $updatePicturesQuery;
    }
    
    /**
     * 
     * @return type
     * @author Oravecz Kálmán
     * Update gallery element thumbnail database function
     */
    public function updatePictureThumbnail() {
        try {
            $updateThumbnailsQuery = $this->db->dbLink->prepare("UPDATE `Picture` SET 
                ThumbName = :thumbName
                WHERE `PictureId` = :pictureId");
            $updateThumbnailsQuery->bindParam(":thumbName", $this->dataArray["thumbKepnev"], PDO::PARAM_STR);
            $updateThumbnailsQuery->bindParam(":pictureId", $this->dataArray["picId"], PDO::PARAM_INT);
            $updateThumbnailsQuery->execute();
        } catch (PDOException $e) {
            $this->db->logWriter($e->errorInfo);
        }
    }
}
