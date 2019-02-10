<?php
include_once(CORE_PATH . 'AncestorClass.php');
include_once(CORE_PATH . '/YoutubeClass.php');

class SearchModel extends AncestorClass {
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
}
