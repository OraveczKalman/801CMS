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
        $getSetupDataQueryString = "SELECT * FROM setupdata WHERE SetupId = " . $this->dataArray['setupId'];
        $getSetupDataQuery = $this -> db -> selectQuery($getSetupDataQueryString);
        return $getSetupDataQuery;
    }

    public function updateSetupData() {
        $updateSetupDataQueryString = "REPLACE INTO setupdata SET " .
            "SetupId = " . $this->dataArray['id'] . ", " .
            "SetupData = '" . $this->dataArray['data'] . "'";

        $updateSetupDataQuery = $this -> db -> updateQuery($updateSetupDataQueryString);
        return $updateSetupDataQuery;
    }
}