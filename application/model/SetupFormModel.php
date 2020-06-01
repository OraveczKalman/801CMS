<?php
class SetupFormModel {
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

    public function getSetupData() {
        $getSetupDataQuery = array();
        $getSetupDataQuery['sql'] = "SELECT * FROM setupdata WHERE SetupId=:setupId";
        $getSetupDataQuery['parameters'][0] = array("paramName"=>"setupId", "paramVal"=>$this->dataArray['setupId'], "paramType"=>PDO::PARAM_INT);
        $getSetupDataQueryResult = $this->db->parameterSelect($getSetupDataQuery);
        return $getSetupDataQueryResult;
    }

    public function updateSetupData() {
        $updateSetupDataQuery = array();
        $updateSetupDataQuery['sql'] = "REPLACE INTO setupdata SET 
            SetupId=:setupId, 
            SetupData=:setupData";
        $updateSetupDataQuery['parameters'][0] = array("paramName"=>"setupId", "paramVal"=>$this->dataArray['id'], "paramType"=>PDO::PARAM_INT);
        $updateSetupDataQuery['parameters'][1] = array("paramName"=>"setupData", "paramVal"=>$this->dataArray['data'], "paramType"=>PDO::PARAM_STR);
        $updateSetupDataResult = $this->db->parameterUpdate($updateSetupDataQuery);
        return $updateSetupDataResult;
    }
}