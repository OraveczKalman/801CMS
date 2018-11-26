<?php
include_once(CORE_PATH . 'AncestorClass.php');
include_once(CORE_PATH . '/YoutubeClass.php');

class ArticleModel extends AncestorClass {
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

    public function getDocumentArticles($parentId, $role) {
        $result = array();
        $getDocumentArticlesDataArray = array();
        $getDocumentArticlesDataArray["sql"] = 'SELECT * FROM text WHERE SuperiorId=:mainHeaderId AND Type=:role';
        $getDocumentArticlesDataArray["parameters"][0] = array("paramName"=>"mainHeaderId", "paramVal"=>$parentId, "paramType"=>1);
        $getDocumentArticlesDataArray["parameters"][1] = array("paramName"=>"role", "paramVal"=>$role, "paramType"=>1);
        $result = $this->db->parameterSelect($getDocumentArticlesDataArray);
        return $result;
    }

    public function getDocumentPicture($docId) {
        $result = array();
        $getDocumentPictureDataArray = array();
        $getDocumentPictureDataArray["sql"] = 'SELECT picture.* FROM picture, gallery_picture WHERE gallery_picture.MainHeaderId=:mainHeaderId
            AND gallery_picture.PictureId = picture.PictureId AND gallery_picture.Active = 1';
        $getDocumentPictureDataArray["parameters"][0] = array("paramName"=>"mainHeaderId", "paramVal"=>$docId, "paramType"=>1);
        $result = $this->db->parameterSelect($getDocumentPictureDataArray);
        return $result;
    }
    
    public function getCoverPicture($docId) {
        $result = '';
        $getCoverDataArray = array();
        $getCoverDataArray["sql"] = 'SELECT t2.Name FROM gallery_picture t1 
            LEFT JOIN picture t2 ON t1.PictureId = t2.PictureId
            WHERE t1.MainHeaderId=:mainHeaderId AND t1.Cover = 1';
        $getCoverDataArray["parameters"][0] = array("paramName"=>"mainHeaderId", "paramVal"=>$docId, "paramType"=>1);
        $data = $this->db->parameterSelect($getCoverDataArray);
        if (!empty($data)) {
            $result = $data[0]["Name"];
        } else {
            $result = "";
        }
        return $result;
    } 
}
