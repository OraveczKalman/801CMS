<?php
class MenuModel {
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

    public function GenerateMenuTree() {
        $dataArray = array();
        $dataArray['parentNode'] = $this->dataArray[0]['level'];
        $dataArray['parentId'] = 0;
        $menuItems = $this->getMenuItems($dataArray);
        for ($i=0; $i<=count($menuItems)-1; $i++) {
            if ($menuItems[$i]['Role'] == 1 || $menuItems[$i]['Role'] == 2 || $menuItems[$i]['Role'] == 5) {
                $subDataArray = array();
                $subDataArray['parentNode'] = $this->dataArray[0]['level'];
                $subDataArray['parentId'] =  $menuItems[$i]['MainHeaderId'];
                $menuItems[$i]['subItems'] = $this->getMenuItems($subDataArray);
            }
        }
        return $menuItems;
    }

    private function getMenuItems($dataArray) {
        $getMenuItemsDataArray = array();
        $getMenuItemsDataArray["sql"] = "SELECT main_header.MainHeaderId, main_header.Target, lang_header.Caption, lang_header.Link, main_header.Role, main_header.MainNode 
            FROM main_header LEFT JOIN lang_header on lang_header.MainHeaderId = main_header.MainHeaderId 
            WHERE lang_header.ParentId=:parentId and main_header.MainNode=:parentNode and main_header.MainHeaderId NOT IN 
            (SELECT MainHeaderId FROM main_header where Role = 4 AND AdditionalField = 1)";
        $getMenuItemsDataArray["parameters"][0] = array("paramName"=>"parentId", "paramVal"=>$dataArray["parentId"], "paramType"=>1);
        $getMenuItemsDataArray["parameters"][1] = array("paramName"=>"parentNode", "paramVal"=>$dataArray["parentNode"], "paramType"=>1);
        $result = $this->db->parameterSelect($getMenuItemsDataArray);
        return $result;
    }

    public function getMenu() {
        $getMenuQuery = $this->db->selectBuilder($this->dataArray);
        return $getMenuQuery;
    }
}