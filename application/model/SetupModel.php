<?php
class SetupModel {
    private $db;
    private $dataArray;
    
    public function __construct($db, $dataArray = null) {
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
    
    public function getSetupData() {
        $getSetupDataArray = array("fields"=>"*",
            "tableName"=>"setupdata",
            "where"=>" SetupId=:setupId",
            "parameters"=>array(array("paramName"=>"setupId", "paramVal"=>$this->dataArray["setupId"], "paramType"=>PDO::PARAM_INT))
        );
        $result = $this->db->selectQueryBuilder($getSetupDataArray);
        return $result;
    }
}