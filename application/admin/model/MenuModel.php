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

    public function GenerateMenuTree($parentId, $level) {
        $dataArray = array();
        $dataArray['parentNode'] = $level;
        $dataArray['parentId'] = $parentId;
        $menuItems = $this->getMenuItems($dataArray);
        for ($i=0; $i<=count($menuItems)-1; $i++) {
            if ($menuItems[$i]['Role'] == 1 || $menuItems[$i]['Role'] == 2 || $menuItems[$i]['Role'] == 5 || $menuItems[$i]['Role'] == 21) {
                $subDataArray = array();
                $subDataArray['parentNode'] = $level;
                $subDataArray['parentId'] =  $menuItems[$i]['MainHeaderId'];
                $menuItems[$i]['subItems'] = $this->getMenuItems($subDataArray);
            }
        }
        return $menuItems;
    }

    private function getMenuItems($dataArray) {
        $dataArray['table'] = 'main_header';
        $dataArray['fields'] = 'main_header.MainHeaderId, lang_header.Caption, main_header.Role, main_header.MainNode';
        $dataArray['joins'] = 'left join lang_header on lang_header.MainHeaderId = main_header.MainHeaderId';
        $dataArray['where'] = ' lang_header.ParentId = ' . $dataArray['parentId'] . ' and main_header.MainNode = ' . $dataArray['parentNode'] . ' and main_header.Active = 1';
        $menuItems = $this->db->selectBuilder($dataArray);
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
        $mainHeaderDataArray = array();
        $mainHeaderDataArray['AdditionalField'] = $this->dataArray['AdditionalField'];
        $mainHeaderDataArray['Role'] = $this->dataArray['Role'];
        $mainHeaderDataArray['MainPage'] = $this->dataArray['MainPage'];
        $mainHeaderDataArray['MainNode'] = $this->dataArray['MainNode'];
        $mainHeaderDataArray['MoreFlag'] = $this->dataArray['MoreFlag'];
        $mainHeaderDataArray['Target'] = $this->dataArray['Target'];
        $mainHeaderDataArray['UserIn'] = $this->dataArray['UserIn'];
        $mainHeaderDataArray['Popup'] = $this->dataArray['Popup'];
        $mainHeaderDataArray['Commentable'] = $this->dataArray['Commentable'];
        $mainHeaderDataArray['Module'] = $this->dataArray['Module'];
        $mainHeaderData = $this->insertMainHeader($mainHeaderDataArray);
        if (!isset($mainHeaderData['error'])) {
            $rankArray = array();
            $maxRankArray = array('table' => 'lang_header',
                'fields' => 'MAX(Rank)+1 AS maxRank',
                'where' => 'lang_header.ParentId = ' . $this->dataArray['ParentId']);
            $maxRank = $this->db->selectBuilder($maxRankArray);
            if (is_null($maxRank[0]['maxRank'])) {
                $maxRank[0]['maxRank'] = 0;
            }
            $rankArray['MainHeaderId'] = $mainHeaderData['lastInsert'];
            $rankArray['ParentId'] = $this->dataArray['ParentId'];
            $rankArray['Caption'] = $this->dataArray['Caption'];
            $rankArray['Title'] = $this->dataArray['Title'];
            $rankArray['Heading'] = $this->dataArray['Heading'];
            $rankArray['Keywords'] = $this->dataArray['Keywords'];
            $rankArray['Link'] = $this->dataArray['Link'];
            $rankArray['Language'] = $this->dataArray['Language'];
            $rankArray['Counter'] = $this->dataArray['Counter'];
            $rankArray['Rank'] = $maxRank[0]['maxRank'];
            $langHeaderData = $this->insertLangHeader($rankArray);
            if (isset($langHeaderData['error'])) {
                print $langHeaderData['error'];
            }
            return $mainHeaderData;
        } else if (isset($mainHeaderData['error'])) {
            return $mainHeaderData;
        }
    }
    
    private function insertMainHeader($dataArray) {
        $nowDate = date('Y-m-d H:i:s');
        $insertMainHeaderQueryString = "INSERT INTO main_header SET
            AdditionalField = '" . $dataArray['AdditionalField'] . "',
            Role = '" . $dataArray['Role'] . "',
            MainPage = " . $dataArray['MainPage'] . ",
            MainNode = " . $dataArray['MainNode'] . ",
            MoreFlag = " . $dataArray['MoreFlag'] . ",
            Target = '" . $dataArray['Target'] . "',
            UserIn = " . $dataArray['UserIn'] . ",
            Popup = " . $dataArray['Popup'] . ",
            Commentable = " . $dataArray['Commentable'] . ",
            Module = '" . $dataArray['Module'] .  "',
            Created = '" . $nowDate . "',
            CreatedBy = " . $_SESSION['admin']['userData']['UserId'] . ",
            Modified = '" . $nowDate . "',
            ModifiedBy = " . $_SESSION['admin']['userData']['UserId'] . ",
            Active = 1";
        $insertMainHeaderQuery = $this->db->insertQuery($insertMainHeaderQueryString);
        if (isset($insertMainHeaderQuery['error'])) {
            $insertMainHeaderQuery['error'] = $insertMainHeaderQuery['error'] . ': ' . $insertMainHeaderQueryString;
        }
        return $insertMainHeaderQuery;
    }
    
    private function insertLangHeader($dataArray) {
        try {
            $insertLangHeaderQuery = $this->db->dbLink->prepare("INSERT INTO lang_header SET
                MainHeaderId = :mainHeaderId,
                ParentId = :parentId,
                Rank = :rank,
                Caption = :caption,
                Title = :title,
                Heading = :heading,
                Keywords = :keywords,
                Link = :link,
                Language = :language,
                Counter = :counter,
                Created = NOW(),
                CreatedBy = :createdBy,
                Modified = NOW(),
                ModifiedBy = :modifiedBy,
                Active = 1");
            //print $insertLangHeaderQuery->queryString;
            $insertLangHeaderQuery->bindParam(":mainHeaderId", $dataArray['MainHeaderId'], PDO::PARAM_INT);
            $insertLangHeaderQuery->bindParam(":parentId", $dataArray['ParentId'], PDO::PARAM_INT);
            $insertLangHeaderQuery->bindParam(":rank", $dataArray['Rank'], PDO::PARAM_INT);
            $insertLangHeaderQuery->bindParam(":caption", $dataArray['Caption'], PDO::PARAM_STR);
            $insertLangHeaderQuery->bindParam(":title", $dataArray['Title'], PDO::PARAM_STR);
            $insertLangHeaderQuery->bindParam(":heading", $dataArray['Heading'], PDO::PARAM_STR);
            $insertLangHeaderQuery->bindParam(":keywords", $dataArray['Keywords'], PDO::PARAM_STR);
            $insertLangHeaderQuery->bindParam(":link", $dataArray['Link'], PDO::PARAM_STR);
            $insertLangHeaderQuery->bindParam(":language", $dataArray['Language'], PDO::PARAM_STR);
            $insertLangHeaderQuery->bindParam(":counter", $dataArray['Counter'], PDO::PARAM_INT);
            $insertLangHeaderQuery->bindParam(":createdBy", $_SESSION['admin']['userData']['UserId'], PDO::PARAM_INT);
            $insertLangHeaderQuery->bindParam(":modifiedBy", $_SESSION['admin']['userData']['UserId'], PDO::PARAM_INT);
            $insertLangHeaderQuery->execute();
        } catch (PDOException $ex) {
            $this->db->logWriter($ex->errorInfo);
        }
    }

    public function updateMenu() {
        $mainHeaderDataArray = array();
        $mainHeaderDataArray['AdditionalField'] = $this->dataArray['AdditionalField'];
        $mainHeaderDataArray['Role'] = $this->dataArray['Role'];
        $mainHeaderDataArray['MainPage'] = $this->dataArray['MainPage'];
        $mainHeaderDataArray['MainNode'] = $this->dataArray['MainNode'];
        $mainHeaderDataArray['MoreFlag'] = $this->dataArray['MoreFlag'];
        $mainHeaderDataArray['Target'] = $this->dataArray['Target'];
        $mainHeaderDataArray['UserIn'] = $this->dataArray['UserIn'];
        $mainHeaderDataArray['Popup'] = $this->dataArray['Popup'];
        $mainHeaderDataArray['Commentable'] = $this->dataArray['Commentable'];
        $mainHeaderDataArray['Module'] = $this->dataArray['Module'];
        $mainHeaderDataArray['MainHeaderId'] = $this->dataArray['MainHeaderId'];
        $mainHeaderData = $this->updateMainHeader($mainHeaderDataArray);
        if (!isset($mainHeaderData['error'])) {
            $rankArray['LangHeaderId'] = $this->dataArray['LangHeaderId'];
            $rankArray['MainHeaderId'] = $this->dataArray['MainHeaderId'];
            $rankArray['ParentId'] = $this->dataArray['ParentId'];
            $rankArray['Caption'] = $this->dataArray['Caption'];
            $rankArray['Title'] = $this->dataArray['Title'];
            $rankArray['Heading'] = $this->dataArray['Heading'];
            $rankArray['Keywords'] = $this->dataArray['Keywords'];
            $rankArray['Link'] = $this->dataArray['Link'];
            $rankArray['Language'] = $this->dataArray['Language'];
            $rankArray['Rank'] = $this->dataArray['Rank'];
            $langHeaderData = $this->updateLangHeader($rankArray);
            if (isset($langHeaderData['error'])) {
                print $langHeaderData['error'];
            }
            return $mainHeaderData;
        } else if (isset($mainHeaderData['error'])) {
            return $mainHeaderData;
        }
    }
    
    private function updateMainHeader($dataArray) {
        $nowDate = date('Y-m-d H:i:s');
        $updateMainHeaderQueryString = "UPDATE main_header SET
            AdditionalField = '" . $dataArray['AdditionalField'] . "',
            Role = '" . $dataArray['Role'] . "',
            MainPage = " . $dataArray['MainPage'] . ",
            MainNode = " . $dataArray['MainNode'] . ",
            MoreFlag = " . $dataArray['MoreFlag'] . ",
            Target = '" . $dataArray['Target'] . "',
            UserIn = " . $dataArray['UserIn'] . ",
            Popup = " . $dataArray['Popup'] . ",
            Commentable = " . $dataArray['Commentable'] . ",
            Module = '" . $dataArray['Module'] .  "',
            Created = '" . $nowDate . "',
            CreatedBy = " . $_SESSION['admin']['userData']['UserId'] . ",
            Modified = '" . $nowDate . "',
            ModifiedBy = " . $_SESSION['admin']['userData']['UserId'] . ",
            Active = 1 WHERE MainHeaderId = " . $dataArray['MainHeaderId'];
        $updateMainHeaderQuery = $this->db->insertQuery($updateMainHeaderQueryString);
        if (isset($updateMainHeaderQuery['error'])) {
            $updateMainHeaderQuery['error'] = $updateMainHeaderQuery['error'] . ': ' . $updateMainHeaderQueryString;
        }
        return $updateMainHeaderQuery;       
    }
    
    private function updateLangHeader($dataArray) {
        $nowDate = date('Y-m-d H:i:s');
        $updateLangHeaderQueryString = "UPDATE lang_header SET
            MainHeaderId = " . $dataArray['MainHeaderId'] . ",
            ParentId = " . $dataArray['ParentId'] . ",
            Rank = " . $dataArray['Rank'] . ",
            Caption = '" . $dataArray['Caption'] . "',
            Title = '" . $dataArray['Title'] . "',
            Heading = '" . $dataArray['Heading'] . "',
            Keywords = '" . $dataArray['Keywords'] . "',
            Link = '" . $dataArray['Link'] . "',
            Language = '" . $dataArray['Language'] . "',
            Created = '" . $nowDate . "',
            CreatedBy = " . $_SESSION['admin']['userData']['UserId'] . ",
            Modified = '" . $nowDate . "',
            ModifiedBy = " . $_SESSION['admin']['userData']['UserId'] . ",
            Active = 1 WHERE LangHeaderId = " . $dataArray['LangHeaderId'];
        $updateLangHeaderQuery = $this->db->insertQuery($updateLangHeaderQueryString);
        if (isset($updateLangHeaderQuery['error'])) {
            $updateLangHeaderQuery['error'] = $updateLangHeaderQuery['error'] . ': ' . $updateLangHeaderQueryString;
        }
        return $updateLangHeaderQuery;
    }
    
    public function updateMainHeaderField() {
        $updateField = $this->db->updateQueryBuilder($this->dataArray);
        return $updateField;
    }

    public function updateLangHeaderField() {
        $updateField = $this->db->updateQueryBuilder($this->dataArray);
        return $updateField;
    }
}