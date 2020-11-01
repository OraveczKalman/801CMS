<?php
class MainCoverModel {
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

    public function getMainCoverList() {
        $getMainCoverDataArray = array(
            "fields"=>"t1.LangHeaderId, t1.MainHeaderId, t1.Link, t1.Title, t1.Heading, t3.Name, t3.OriginalExtension",
            "tableName"=>"lang_header t1", 
            "joins"=>array("LEFT JOIN gallery_picture t2 ON t1.LangHeaderId = t2.LangHeaderId",
                "LEFT JOIN picture t3 ON t2.PictureId = t3.PictureId"),
            "where"=>"t1.ParentId IN (SELECT MainHeaderId FROM main_header WHERE role = 1) AND t2.Cover = 1",
            "order"=>" t1.Created DESC");
        $result = $this->db->selectQueryBuilder($getMainCoverDataArray);
        return $result;
    }
}