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
    
    public function getPicture($pictureId) {
        $getPicture = array();
        $getPicture['sql'] = "SELECT Name, ThumbName FROM picture WHERE PictureId=:pictureId";
        $getPicture['parameters'][0] = array("paramName"=>"pictureId", "paramVal"=>$pictureId, "paramType"=>PDO::PARAM_INT);
        $getPictureResult = $this->db->parameterSelect($getPicture);
        return $getPictureResult;
    }
    
    /**
     * 
     * @param type $menuId
     * @return type
     * @author Oravecz Kálmán
     * Get all elements to gallery
     */
    public function getGalleryObjects($menuId) {
        $getGalleryObjectQuery['sql'] = 'SELECT picture.PictureId, picture.Name AS kep_nev_big, 
            picture.ThumbName AS kep_nev, 
            picture.MediaType, 
            (SELECT main_header.Role FROM main_header WHERE gallery_picture.MainHeaderId = main_header.MainHeaderId) AS Szerep, 
            gallery_picture.MainHeaderId, gallery_picture.Rank 
            FROM gallery_picture 
            INNER JOIN picture ON gallery_picture.PictureId = picture.PictureId 
            WHERE gallery_picture.MainHeaderId = :menuId AND gallery_picture.Active = 1 
            ORDER BY gallery_picture.Rank ASC';
        $getGalleryObjectQuery['parameters'][0] = array('paramName'=>'menuId', 'paramVal'=>$menuId, 'paramType'=>PDO::PARAM_INT);
        $result = $this->db->parameterSelect($getGalleryObjectQuery);
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
        $getGalleryObjectTextQuery = array();
        $getGalleryObjectTextQuery['sql'] = "SELECT text.Text, text.TextId FROM text  
            WHERE SuperiorId = :galleryObjectId
            AND Type = 3";
        $getGalleryObjectTextQuery["parameters"][0] = array('paramName'=>'galleryObjectId', 'paramVal'=>$galleryObjectId, 'paramType'=>PDO::PARAM_INT);
        $result = $this->db->parameterSelect($getGalleryObjectTextQuery);
        return $result;
    }

    /**
     * @author Oravecz Kálmán
     * Insert element to gallery
     */
    public function insertGalleryImages() {
        $this->db->beginTran();
        $fullResult = true;
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
            $pictureUploadQuery = array();
            $pictureUploadQuery['sql'] = "INSERT INTO `picture` SET 
                Name = :fileName,
                ThumbName = :thumbFileName,
                MediaType = :mediaType,
                Created = NOW(),
                CreatedBy = :userId,
                Modified = NOW(),
                ModifiedBy = :userId,
                Active = 1";
            $pictureUploadQuery['parameters'][0] = array("paramName"=>"fileName", "paramVal"=>$pictureData["fileName"], "paramType"=>PDO::PARAM_STR);
            $pictureUploadQuery['parameters'][1] = array("paramName"=>"thumbFileName", "paramVal"=>$pictureData["thumbFileName"], "paramType"=>PDO::PARAM_STR);
            $pictureUploadQuery['parameters'][2] = array("paramName"=>"mediaType", "paramVal"=>$this->dataArray["mediaType"], "paramType"=>PDO::PARAM_INT);
            $pictureUploadQuery['parameters'][3] = array("paramName"=>"userId", "paramVal"=>$_SESSION['admin']['userData']['UserId'], "paramType"=>PDO::PARAM_INT);
            $pictureUploadResult = $this->db->parameterInsert($pictureUploadQuery);
            if (!$pictureUploadResult) {
                $fullResult = false;
            } else {
                $insertGalTopicQuery = array();
                $insertGalTopicQuery['sql'] = "INSERT INTO gallery_picture SET 
                    MainHeaderId = :mainHeaderId,
                    PictureId = :pictureId,
                    Rank = 0,
                    Active = 1";
                $insertGalTopicQuery["parameters"][0] = array("paramName"=>"mainHeaderId", "paramVal"=>$this->dataArray['MainHeaderId'], "paramType"=>PDO::PARAM_INT);
                $insertGalTopicQuery["parameters"][1] = array("paramName"=>"pictureId", "paramVal"=>$pictureUploadResult['lastInsert'], "paramType"=>PDO::PARAM_INT);
                $insertGalTopicResult = $this->db->parameterInsert($insertGalTopicQuery);
            }
        }
        if (!$fullResult) {
            $this->db->rollBack();
        } else {
            $this->db->commit();
        }
        return $fullResult;
    }

    public function getGalleryCovers($parent) {
        $getGalleryCoversQuery = array();
        $getGalleryCoversQuery['sql'] = "SELECT menu.Link, menu.Felirat, menu.Profile_Picture, menu.Menu_Id 
            FROM menu 
            LEFT JOIN rank ON menu.Menu_Id = rank.Point_id 
            WHERE rank.ParentId = :parentId AND menu.Szerep = 3 AND menu.Active = 1";
        $getGalleryCoversQuery['parameters'][0] = array("paramName"=>":parentId", "paramVal"=>$parent, "paramType"=>PDO::PARAM_INT);
        $result = $this->db->parameterSelect($getGalleryCoversQuery);
        return $result;
    }
    
    /**
     * 
     * @return type
     * @author Oravecz Kálmán
     * Function for delete elements from gallery
     */
    public function deleteFromGallery() {
        $this->db->beginTran();
        $fullResult = true;
        $deleteGalleryPictureQuery = array();
        $deleteGalleryPictureQuery['sql'] = "DELETE FROM gallery_picture WHERE MainHeaderId=:mainHeaderId AND PictureId=:pictureId";
        $deleteGalleryPictureQuery["parameters"][0] = array("paramName"=>"mainHeaderId", "paramVal"=>$this->dataArray["MainHeaderId"], "paramType"=>PDO::PARAM_INT);
        $deleteGalleryPictureQuery["parameters"][1] = array("paramName"=>"pictureId", "paramVal"=>$this->dataArray["PictureId"], "paramType"=>PDO::PARAM_INT);
        $deleteGalleryPictureResult = $this->db->parameterUpdate($deleteGalleryPictureQuery);
        var_dump($deleteGalleryPictureResult);
        if (!$deleteGalleryPictureResult) {
            $fullResult = false;
        } else {
            $deletePictureQuery = array();
            $deletePictureQuery['sql'] = "DELETE FROM picture WHERE PictureId=:pictureId";
            $deletePictureQuery['parameters'][0] = array("paramName"=>"pictureId", "paramVal"=>$this->dataArray["PictureId"], "paramType"=>PDO::PARAM_INT);
            $deletePictureResult = $this->db->parameterUpdate($deletePictureQuery);
            if (!$deletePictureResult) {
                $fullResult = false;
            }
        }
        if (!$fullResult) {
            $this->db->rollBack();
        } else {
            $this->db->commit();
        }
        return $fullResult;
    }
    
    /**
     * 
     * @return type
     * @author Oravecz Kálmán
     * Update function for sequence of elments in gallery 
     */
    public function updateGallery() {
        $this->db->beginTran();
        $updatePicturesQuery = array();
        $updatePicturesQuery['sql'] = "UPDATE `gallery_picture` SET 
            `Rank`=:rank WHERE `PictureId`=:pictureId";
        $updatePicturesQuery['parameters'][0] = array("paramName"=>"rank", "paramVal"=>$this->dataArray['rank'], "paramType"=>PDO::PARAM_INT);
        $updatePicturesQuery['parameters'][1] = array("paramName"=>"pictureId", "paramVal"=>$this->dataArray['pic_id'], "paramType"=>PDO::PARAM_INT);
        $result = $this->db->parameterUpdate($updatePicturesQuery);
        if (!$result) {
            $this->db->rollBack();
        } else {
            $this->db->commit();
        }
        return $result;
    }
    
    /**
     * 
     * @return type
     * @author Oravecz Kálmán
     * Update gallery element thumbnail database function
     */
    public function updatePictureThumbnail() {
        $this->db->beginTran();
        $updateThumbnailsQuery = array();
        $updateThumbnailsQuery['sql'] = "UPDATE `picture` SET 
            ThumbName=:thumbName WHERE `PictureId`=:pictureId";
        $updateThumbnailsQuery["parameters"][0] = array("paramName"=>"thumbName", "paramVal"=>$this->dataArray["thumbKepnev"], "paramType"=>PDO::PARAM_STR);
        $updateThumbnailsQuery["parameters"][1] = array("paramName"=>"pictureId", "paramVal"=>$this->dataArray["picId"], "paramType"=>PDO::PARAM_INT);
        $result = $this->db->parameterUpdate($updateThumbnailsQuery);
        if (!$result) {
            $this->db->rollBack();
        } else {
            $this->db->commit();
        }
        return $result;
    }
    
    public function makeCoverImage() {
        $this->db->beginTran();
        $fullResult = true;
        $resetCoverImageQuery = array();
        $resetCoverImageQuery['sql'] = "UPDATE gallery_picture SET cover=0 WHERE MainHeaderId=:mainHeaderId";
        $resetCoverImageQuery['parameters'][0] = array("paramName"=>"mainHeaderId", "paramVal"=>$this->dataArray["gallery"], "paramType"=>PDO::PARAM_INT);
        $resetCoverImageResult = $this->db->parameterUpdate($resetCoverImageQuery);
        if (!$resetCoverImageResult) { 
            $fullResult = false;
        } else {
            $updateCoverImageQuery = array();
            $updateCoverImageQuery['sql'] = "UPDATE gallery_picture SET cover=1 WHERE MainHeaderId=:mainHeaderId AND PictureId=:mediaId";
            $updateCoverImageQuery['parameters'][0] = array("paramName"=>"mainHeaderId", "paramVal"=>$this->dataArray["gallery"], "paramType"=>PDO::PARAM_INT);
            $updateCoverImageQuery['parameters'][1] = array("paramName"=>"mediaId", "paramVal"=>$this->dataArray["mediaId"], "paramType"=>PDO::PARAM_INT);           
            $updateCoverImageResult = $this->db->parameterUpdate($updateCoverImageQuery);
            if (!$updateCoverImageResult) {
                $fullResult = false;
            }
        }
        if (!$fullResult) {
            $this->db->rollBack();
        } else {
            $this->db->commit();
        }
        return $fullResult;
    }
}
