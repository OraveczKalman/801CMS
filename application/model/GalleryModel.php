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
        
        if ($this->dataArray[0]["MainHeaderId"] > 0) {
            $galleryPictures = $this -> getGalleryObjects($this->dataArray[0]['MainHeaderId']);
        } else /*if ($this->dataArray[0]["MainHeaderId"] == 0)*/ {
            $galleryPictures = $this->getAllMedia();
        }
        for ($i=0; $i<=count($galleryPictures)-1; $i++) {
            switch ($galleryPictures[$i]['MediaType']) {
                case 1 :
                    $galleryPictures[$i]['buttons'] = '<div class="btn-group" role="group">
                        <button class="btn btn-primary" type="button" onclick="javascript: insertAtCursor(\'#kep_bal_' . $galleryPictures[$i]['PictureId'] . '#\');">B</button>
                        <button class="btn btn-primary" type="button" onclick="javascript: insertAtCursor(\'#kep_kozep_' . $galleryPictures[$i]['PictureId'] . '#\');">K</button>
                        <button class="btn btn-primary" type="button" onclick="javascript: insertAtCursor(\'#kep_jobb_' . $galleryPictures[$i]['PictureId'] . '#\');">J</button>
                    </div>';
                    //$galleryPictures[$i]['kep_nev_big'] = UPLOADED_MEDIA_PATH . $galleryPictures[$i]['kep_nev_big'];
                    $galleryPictures[$i]['kep_nev'] = UPLOADED_MEDIA_PATH . $galleryPictures[$i]['kep_nev'];
                    break;
                case 2 :
                    $galleryPictures[$i]['buttons'] = '<div class="btn-group" role="group">
                        <button class="btn btn-primary" type="button" onclick="javascript: insertAtCursor(\'#youtube_' . $galleryPictures[$i]['PictureId'] . '#\');">Youtube</button>
                    </div>';
                    break;
                case 3 :
                    $galleryPictures[$i]['buttons'] = '<div class="btn-group" role="group">
                        <button class="btn btn-primary" type="button" onclick="javascript: insertAtCursor(\'#video_' . $galleryPictures[$i]['PictureId'] . '#\');">Video</button>
                    </div>';
                    $galleryPictures[$i]['kep_nev_big'] = dirname(UPLOADED_PATH, 3) . '/' . $galleryPictures[$i]['kep_nev_big'];
                    $galleryPictures[$i]['kep_nev'] = dirname(UPLOADED_PATH, 3) . '/' . $galleryPictures[$i]['kep_nev'];
                    break;
                case 4 :
                    $galleryPictures[$i]['buttons'] = '<div class="btn-group" role="group">
                        <button class="btn btn-primary" type="button" onclick="javascript: insertAtCursor(\'#zene_bal_' . $galleryPictures[$i]['PictureId'] . '#\');">B</button>
                        <button class="btn btn-primary" type="button" onclick="javascript: insertAtCursor(\'#zene_kozep_' . $galleryPictures[$i]['PictureId'] . '#\');">K</button>
                        <button class="btn btn-primary" type="button" onclick="javascript: insertAtCursor(\'#zene_jobb_' . $galleryPictures[$i]['PictureId'] . '#\');">J</button>
                    </div>';
                    $galleryPictures[$i]['kep_nev_big'] = dirname(UPLOADED_PATH, 3) . '/' . UPLOADED_MEDIA_PATH . $galleryPictures[$i]['kep_nev_big'];
                    $galleryPictures[$i]['kep_nev'] = dirname(UPLOADED_PATH, 3) . '/' . UPLOADED_MEDIA_PATH . $galleryPictures[$i]['kep_nev'];
                    break;
            }
            $galleryPictures[$i]['descriptions'] = $this -> getGalleryObjectText($galleryPictures[$i]['PictureId']);
        }
        return $galleryPictures;
    }
    
    public function getPicture($pictureId) {
        $getPicture = array(
            "tableName"=>"picture",
            "fields"=>"Name, ThumbName",
            "where"=>" PictureId=:pictureId",
            "parameters"=>array(
                array(
                    "paramName"=>"pictureId", "paramVal"=>$pictureId, "paramType"=>PDO::PARAM_INT)
                )
            );
        $getPictureResult = $this->db->selectQueryBuilder($getPicture);
        return $getPictureResult;
    }
    
    /**
     * 
     * @param type $menuId
     * @return type
     * @author Oravecz Kálmán
     * Get all elements from gallery
     */
    public function getGalleryObjects($menuId) {
        $getGalleryObjectQuery = array(
            "tableName"=>"gallery_picture",
            "fields"=>"picture.PictureId, picture.Name AS kep_nev_big, 
                picture.ThumbName AS kep_nev, 
                picture.MediaType, 
                (SELECT main_header.Role FROM main_header WHERE gallery_picture.MainHeaderId = main_header.MainHeaderId) AS Szerep, 
                gallery_picture.MainHeaderId, gallery_picture.Rank",
            "joins"=>array(
                "INNER JOIN picture ON gallery_picture.PictureId = picture.PictureId"
            ),
            "where"=>"gallery_picture.MainHeaderId = :menuId AND gallery_picture.Active = 1",
            "order"=>"gallery_picture.Rank ASC",
            "parameters"=>array(
                array('paramName'=>'menuId', 'paramVal'=>$menuId, 'paramType'=>PDO::PARAM_INT)
            )
        );
        $result = $this->db->selectQueryBuilder($getGalleryObjectQuery);
        return $result;
    }
    
    public function getGalleryObjectsSite() {
        if (intval($this->dataArray['AdditionalField']) == 1) {
            $whereString = ' main_header.AdditionalField=:additionalField AND gallery_picture.Active = 1 ';
            $parameterArray = array("paramName"=>"additionalField", "paramVal"=>$this->dataArray['AdditionalField'], "paramType"=>1);
        } else {
            $whereString = ' gallery_picture.MainHeaderId=:mainHeaderId AND gallery_picture.Active = 1 ';
            $parameterArray = array("paramName"=>"mainHeaderId", "paramVal"=>$this->dataArray['MainHeaderId'], "paramType"=>1);
        }
        $getGalleryObjectQuery = array(
            'fields'=>'picture.PictureId, picture.Name AS kep_nev_big,
                picture.ThumbName AS kep_nev, picture.MediaType,
                (SELECT main_header.Role FROM main_header WHERE gallery_picture.MainHeaderId = main_header.MainHeaderId) AS Szerep,
                gallery_picture.MainHeaderId, gallery_picture.Rank',
            'tableName'=>'gallery_picture',
            'joins'=>array(
                'INNER JOIN picture ON gallery_picture.PictureId = picture.PictureId',
                'INNER JOIN main_header ON main_header.MainHeaderId = gallery_picture.MainHeaderId'
            ),
            'where'=>$whereString,
            'order'=>' gallery_picture.Rank ASC',
            'parameters'=>array($parameterArray)
        );
        
        $result = $this->db->selectQueryBuilder($getGalleryObjectQuery);
        return $result;
    }
    
    public function getAllMedia() {
        $getGalleryObjectDataArray = array(
            "fields"=>"picture.PictureId, picture.Name AS kep_nev_big, 
                picture.ThumbName AS kep_nev, 
                picture.MediaType, 
                (SELECT main_header.Role FROM main_header WHERE gallery_picture.MainHeaderId = main_header.MainHeaderId) AS Szerep, 
                gallery_picture.MainHeaderId, gallery_picture.Rank", 
            "tableName"=>"gallery_picture", 
            "joins"=>array("INNER JOIN picture ON gallery_picture.PictureId = picture.PictureId "),
            "where"=>" gallery_picture.Active = 1 ", 
            "order"=>" gallery_picture.Rank ASC");
        //$getGalleryObjectQuery['parameters'][0] = array('paramName'=>'menuId', 'paramVal'=>$menuId, 'paramType'=>PDO::PARAM_INT);
        $result = $this->db->selectQueryBuilder($getGalleryObjectDataArray);
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
        $getGalleryObjectTextQuery = array(
            "tableName"=>"text",
            "fields"=>"text.Text, text.TextId",
            "where"=>"SuperiorId = :galleryObjectId AND Type = 3",
            "parameters"=>array(
                array('paramName'=>'galleryObjectId', 'paramVal'=>$galleryObjectId, 'paramType'=>PDO::PARAM_INT)
            )
        );
        $result = $this->db->selectQueryBuilder($getGalleryObjectTextQuery);
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
            $pictureUploadQuery = array(
                "tableName"=>"`picture`",
                "fields"=>"Name = :fileName,
                    ThumbName = :thumbFileName,
                    MediaType = :mediaType,
                    Created = NOW(),
                    CreatedBy = :userId,
                    Modified = NOW(),
                    ModifiedBy = :userId,
                    Active = 1",
                "parameters"=>array(
                    array("paramName"=>"fileName", "paramVal"=>$pictureData["fileName"], "paramType"=>PDO::PARAM_STR),
                    array("paramName"=>"thumbFileName", "paramVal"=>$pictureData["thumbFileName"], "paramType"=>PDO::PARAM_STR),
                    array("paramName"=>"mediaType", "paramVal"=>$this->dataArray["mediaType"], "paramType"=>PDO::PARAM_INT),
                    array("paramName"=>"userId", "paramVal"=>$_SESSION['admin']['userData']['UserId'], "paramType"=>PDO::PARAM_INT)
                )
            );
            $pictureUploadResult = $this->db->insertQueryBuilder($pictureUploadQuery);
            if (!$pictureUploadResult) {
                $fullResult = false;
            } else {
                $insertGalTopicQuery = array(
                    "tableName"=>"gallery_picture", 
                    "fields"=>"MainHeaderId = :mainHeaderId,
                        PictureId = :pictureId,
                        `Rank` = 0,
                        Active = 1",
                    "parameters"=>array(
                        array("paramName"=>"mainHeaderId", "paramVal"=>$this->dataArray['MainHeaderId'], "paramType"=>PDO::PARAM_INT),
                        array("paramName"=>"pictureId", "paramVal"=>$pictureUploadResult['lastInsert'], "paramType"=>PDO::PARAM_INT)
                    )
                );
                $insertGalTopicResult = $this->db->insertQueryBuilder($insertGalTopicQuery);
                if (!$insertGalTopicResult) {
                    $fullResult = false;
                }
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
        $getGalleryCoversQuery = array(
            "tableName"=>"menu",
            "fields"=>"menu.Link, menu.Felirat, menu.Profile_Picture, menu.Menu_Id", 
            "joins"=>array( 
                "LEFT JOIN rank ON menu.Menu_Id = rank.Point_id"
            ),
            "where"=>"rank.ParentId = :parentId AND menu.Szerep = 3 AND menu.Active = 1",
            "parameters"=>array(
                array("paramName"=>":parentId", "paramVal"=>$parent, "paramType"=>PDO::PARAM_INT)
            )
        );
        $result = $this->db->selectQueryBuilder($getGalleryCoversQuery);
        return $result;
    }
    
    public function getGalleryCoversSite() {
        $getGalleryCoversQuery = array(
            "fields"=>"t2.Link, t2.Caption, t4.ThumbName",
            "tableName"=>"main_header t1",
            "joins"=>array(
                "LEFT JOIN lang_header t2 ON t1.MainHeaderId = t2.MainHeaderId",
                "LEFT JOIN gallery_picture t3 ON t1.MainHeaderId = t3.MainHeaderId",
                "LEFT JOIN picture t4 ON t3.PictureId = t4.PictureId"),
            "where"=>" t2.ParentId=:mainHeaderId AND t2.Language=:languageSign AND t3.Cover = 1",
            "parameters"=>array(
                array("paramName"=>"mainHeaderId", "paramVal"=>$this->dataArray['MainHeaderId'], "paramType"=>PDO::PARAM_INT),
                array("paramName"=>"languageSign", "paramVal"=>$_SESSION['setupData']['languageSign'], "paramType"=>PDO::PARAM_STR)
            )
        );
        $result = $this->db->selectQueryBuilder($getGalleryCoversQuery);
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
        $deleteGalleryPictureQuery = array(
            "tableName"=>"gallery_picture",
            "where"=>" MainHeaderId=:mainHeaderId AND PictureId=:pictureId",
            "parameters"=>array(
                array("paramName"=>"mainHeaderId", "paramVal"=>$this->dataArray["MainHeaderId"], "paramType"=>PDO::PARAM_INT),
                array("paramName"=>"pictureId", "paramVal"=>$this->dataArray["PictureId"], "paramType"=>PDO::PARAM_INT)
            )
        );
        $deleteGalleryPictureResult = $this->db->deleteQueryBuilder($deleteGalleryPictureQuery);
        if (!$deleteGalleryPictureResult) {
            $fullResult = false;
        } else {
            $deletePictureQuery = array(
                "tableName"=>"picture",
                "where"=>"PictureId=:pictureId",
                "parameters"=>array(
                    array("paramName"=>"pictureId", "paramVal"=>$this->dataArray["PictureId"], "paramType"=>PDO::PARAM_INT)
                )
            );
            $deletePictureResult = $this->db->deleteQueryBuilder($deletePictureQuery);
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
        $updatePicturesQuery = array(
            "tableName"=>"`gallery_picture`", 
            "fields"=>"`Rank`=:rank",
            "where"=>"`PictureId`=:pictureId",
            "parameters"=>array(
                array("paramName"=>"rank", "paramVal"=>$this->dataArray['rank'], "paramType"=>PDO::PARAM_INT),
                array("paramName"=>"pictureId", "paramVal"=>$this->dataArray['pic_id'], "paramType"=>PDO::PARAM_INT)
            )
        );
        $result = $this->db->updateQueryBuilder($updatePicturesQuery);
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
        $updateThumbnailsQuery = array(
            "tableName"=>"`picture`", 
            "fields"=>"ThumbName=:thumbName",
            "where"=>"`PictureId`=:pictureId",
            "parameters"=>array(
                array("paramName"=>"thumbName", "paramVal"=>$this->dataArray["thumbKepnev"], "paramType"=>PDO::PARAM_STR),
                array("paramName"=>"pictureId", "paramVal"=>$this->dataArray["picId"], "paramType"=>PDO::PARAM_INT)
            )
        );
        $result = $this->db->updateQueryBuilder($updateThumbnailsQuery);
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
