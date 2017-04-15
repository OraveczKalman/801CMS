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
        $dataArray['table'] = 'main_header';
        $dataArray['fields'] = 'main_header.MainHeaderId, main_header.Target, lang_header.Caption, lang_header.Link, main_header.Role, main_header.MainNode';
        $dataArray['joins'] = 'left join lang_header on lang_header.MainHeaderId = main_header.MainHeaderId';
        $dataArray['where'] = ' lang_header.ParentId = ' . $dataArray['parentId'] . ' and main_header.MainNode = ' . $dataArray['parentNode'] . 
            ' and main_header.MainHeaderId not in (select MainHeaderId from main_header where Role = 4 and AdditionalField = 1)';
        $menuItems = $this->db->selectBuilder($dataArray);
        //var_dump($menuItems);
        return $menuItems;
    }

    public function getMenu() {
        $getMenuQuery = $this->db->selectBuilder($this->dataArray);
        return $getMenuQuery;
    }

    public function getMenuRoles() {
        $getMenuRolesQueryString = 'SELECT * FROM role ' . $this->dataArray['where'] . ' ORDER BY RoleId';
        $getMenuRolesQuery = $this->db->selectQuery($getMenuRolesQueryString);
        return $getMenuRolesQuery;
    }

    public function insertMenu() {
        $rankArray = array();
        $rankArray['table'] = 'rank';
        $rankArray['fields']['ParentId'] = $this->dataArray['ParentId'];
        unset($this->dataArray['ParentId']);
        $menuDataArray = array();
        $menuDataArray['table'] = 'main_header';
        $menuDataArray['fields'] = $this->dataArray;
        $insertMenuQuery = $this->db->insertQueryBuilder($menuDataArray);
        if (!isset($insertMenuQuery['error'])) {
            $maxRankArray = array('table' => 'rank',
                'fields' => 'MAX(rank)+1 AS maxRank',
                'where' => 'rank.ParentId = ' . $rankArray['fields']['ParentId']);
            $maxRank = $this->db->selectBuilder($maxRankArray);
            $rankArray['fields']['Rank'] = $maxRank[0]['maxRank'];
            $rankArray['fields']['MainHeaderId'] = $insertMenuQuery['lastInsert'];
            $insertRankQuery = $this->db->insertQueryBuilder($rankArray);
            return $insertMenuQuery;
        } else if (isset($insertMenuQuery['error'])) {
            return $insertMenuQuery;
        }
    }

    public function updateMenu() {
        unset($this->dataArray['ParentId']);
        $menuArray = array();
        $menuArray['table'] = 'main_header';
        $menuArray['fields'] = $this->dataArray;
        $menuArray['where'] = 'main_header.MainHeaderId = ' . $this->dataArray['MainHeaderId'];
        $updateMenu = $this->db->updateQueryBuilder($menuArray);
        return $updateMenu;
    }
}