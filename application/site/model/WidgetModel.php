<?php
include_once(CORE_PATH . 'AncestorClass.php');

class WidgetModel extends AncestorClass {
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

    public function getWidgets($mainHeaderId) {
        $result = array();
        $getDocumentArticlesDataArray = array();
        $getDocumentArticlesDataArray["sql"] = 'SELECT t1.* FROM widget t1
            LEFT JOIN main_header_widget t2 ON t1.WidgetId = t2.WidgetId
            WHERE t2.MainHeaderId=:mainHeaderId';
        $getDocumentArticlesDataArray["parameters"][0] = array("paramName"=>"mainHeaderId", "paramVal"=>$mainHeaderId, "paramType"=>PDO::PARAM_INT);
        $result = $this->db->parameterSelect($getDocumentArticlesDataArray);
        return $result;
    }
}

