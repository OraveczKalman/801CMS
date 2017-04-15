<?php
/**
 * Created by PhpStorm.
 * User: Oravecz Kálmán
 * Date: 2015.03.04.
 * Time: 21:49
 */

class NewsCoverModel {
    private $docData;
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

    public function getNewsStreams() {
        $getNewsStreamsQueryString = 'SELECT main_header.* FROM rank ' .
          'INNER JOIN main_header ON main_header.MainHeaderId = rank.MainHeaderId ' .
          'WHERE rank.ParentId = ' . $this->docData[0]['MainHeaderId'];
        $getNewsStreamsQuery = $this->db->selectQuery($getNewsStreamsQueryString, $error);
        return $getNewsStreamsQuery;
    }
}