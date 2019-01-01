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

    public function GenerateMenuTree($parentId, $level, $languages) {
        $dataArray = array();
        $dataArray['parentNode'] = $level;
        $dataArray['parentId'] = $parentId;
        $dataArray['languages'] = $languages;
        $menuItems = $this->getMenuItems($dataArray);
        for ($i=0; $i<=count($menuItems)-1; $i++) {
            if ($menuItems[$i]['Role'] == 1 || $menuItems[$i]['Role'] == 2 || $menuItems[$i]['Role'] == 5 || $menuItems[$i]['Role'] == 21) {
                $subDataArray = array();
                $subDataArray['parentNode'] = $level;
                $subDataArray['parentId'] =  $menuItems[$i]['MainHeaderId'];
                $subDataArray['languages'] = $languages;
                $menuItems[$i]['subItems'] = $this->getMenuItems($subDataArray);
            }
        }
        return $menuItems;
    }

    private function getMenuItems($dataArray) {
        $dataArray['fields'] = '';
        $dataArray['joins'] = '';
        for ($i=0; $i<=count($dataArray['languages'])-1; $i++) {
            $dataArray['fields'] .= ', t' . $dataArray['languages'][$i]['LanguageSign'] . '.HeadersCount' . $dataArray['languages'][$i]['LanguageSign'];
            $dataArray['joins'] .= " LEFT JOIN (SELECT MainHeaderId, `Language`, COUNT(MainHeaderId) AS HeadersCount" . $dataArray['languages'][$i]['LanguageSign'] . " FROM lang_header) t" . $dataArray['languages'][$i]['LanguageSign'] . " ON t1.MainHeaderId = t" . $dataArray['languages'][$i]['LanguageSign'] . ".MainHeaderId AND t" . $dataArray['languages'][$i]['LanguageSign'] . ".`Language` = '" . $dataArray['languages'][$i]['LanguageSign'] . "'";
        }
        $getMenuItemsDataArray['sql'] = "SELECT t1.MainHeaderId, t2.Caption, t1.Role, t1.MainNode";
        $getMenuItemsDataArray['sql'] .= $dataArray['fields'];
        $getMenuItemsDataArray['sql'] .= " FROM main_header t1 LEFT JOIN lang_header t2 ON t2.MainHeaderId = t1.MainHeaderId ";
        $getMenuItemsDataArray['sql'] .= $dataArray['joins'];
        $getMenuItemsDataArray['sql'] .= " WHERE t2.ParentId=:parentId AND t1.MainNode=:parentNode AND t1.Active = 1";
        $getMenuItemsDataArray['parameters'][0] = array("paramName"=>"parentId", "paramVal"=>$dataArray['parentId'], "paramType"=>1);
        $getMenuItemsDataArray['parameters'][1] = array("paramName"=>"parentNode", "paramVal"=>$dataArray['parentNode'], "paramType"=>1);
        $menuItems = $this->db->parameterSelect($getMenuItemsDataArray);
        return $menuItems;
    }

    public function getMenu($menuId) {
        $getMenuDataArray['sql'] = "SELECT * FROM main_header 
            LEFT JOIN lang_header ON main_header.MainHeaderId = lang_header.MainHeaderId WHERE main_header.MainHeaderId = 1";
        $getMenuDataArray['parameters'][0] = array("paramName"=>"mainHeaderId", "paramVal"=>$menuId, "paramType"=>1);
        $getMenuQuery = $this->db->parameterSelect($getMenuDataArray);
        return $getMenuQuery;
    }

    public function getModules() {
        $getModulesQueryString = "SELECT lang_header.Title, lang_header.Link FROM main_header 
            LEFT JOIN lang_header ON main_header.MainHeaderId = lang_header.MainHeaderId 
            WHERE main_header.MainHeaderId NOT IN (SELECT MainHeaderId FROM lang_header)";
        $getModulesQuery = $this->db->selectQuery($getModulesQueryString);
        return $getModulesQuery;
    }
    
    public function getMenuRoles() {
        $getMenuRolesQueryString = 'SELECT * FROM role ' . $this->dataArray['where'] . ' ORDER BY RoleId';
        $getMenuRolesQuery = $this->db->selectQuery($getMenuRolesQueryString);
        return $getMenuRolesQuery;
    }

    private function getMaxRank($parentId) {
        $getMaxRankQuery = array();
        $getMaxRankQuery['sql'] = "SELECT MAX(Rank)+1 AS maxRank FROM lang_header WHERE ParentId=:parentId";
        $getMaxRankQuery['parameters'][0] = array("paramName"=>"parentId", "paramVal"=>$parentId, "paramType"=>1);
        $result = $this->db->parameterSelect($getMaxRankQuery);
        return $result;
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
        //var_dump($mainHeaderData);
        if (!isset($mainHeaderData['error'])) {
            $maxRank = $this->getMaxRank($this->dataArray['ParentId']);
            $rankArray = array();
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
        $insertMainHeaderQuery = array();
        $insertMainHeaderQuery['sql'] = "INSERT INTO main_header SET
            AdditionalField=:AdditionalField,
            Target=:Target,
            Module=:Module,
            Role=:Role,
            MainPage=:MainPage,
            MainNode=:MainNode,
            MoreFlag=:MoreFlag,          
            UserIn=:UserIn,
            Popup=:Popup,
            Commentable=:Commentable,
            Created=NOW(),
            CreatedBy=:UserId,
            Active = 1";
        if (!is_null($dataArray['AdditionalField'])) {
            $insertMainHeaderQuery['parameters'][0] = array("paramName"=>"AdditionalField", "paramVal"=>$dataArray['AdditionalField'], "paramType"=>PDO::PARAM_STR);
        } else {
            $insertMainHeaderQuery['parameters'][0] = array("paramName"=>"AdditionalField", "paramVal"=>null, "paramType"=>PDO::PARAM_STR);
        }
        $insertMainHeaderQuery['parameters'][1] = array("paramName"=>"Role", "paramVal"=>$dataArray['Role'], "paramType"=>PDO::PARAM_INT);
        $insertMainHeaderQuery['parameters'][2] = array("paramName"=>"MainPage", "paramVal"=>$dataArray['MainPage'], "paramType"=>PDO::PARAM_INT);
        $insertMainHeaderQuery['parameters'][3] = array("paramName"=>"MainNode", "paramVal"=>$dataArray['MainNode'], "paramType"=>PDO::PARAM_INT);
        $insertMainHeaderQuery['parameters'][4] = array("paramName"=>"MoreFlag", "paramVal"=>$dataArray['MoreFlag'], "paramType"=>PDO::PARAM_INT);
        if (!is_null($dataArray['Target'])) {
            $insertMainHeaderQuery['parameters'][5] = array("paramName"=>"Target", "paramVal"=>$dataArray['Target'], "paramType"=>PDO::PARAM_STR);
        } else {
            $insertMainHeaderQuery['parameters'][5] = array("paramName"=>"Target", "paramVal"=>null, "paramType"=>PDO::PARAM_STR);
        }
        $insertMainHeaderQuery['parameters'][6] = array("paramName"=>"UserIn", "paramVal"=>$dataArray['UserIn'], "paramType"=>PDO::PARAM_INT);
        $insertMainHeaderQuery['parameters'][7] = array("paramName"=>"Popup", "paramVal"=>$dataArray['Popup'], "paramType"=>PDO::PARAM_INT);
        $insertMainHeaderQuery['parameters'][8] = array("paramName"=>"Commentable", "paramVal"=>$dataArray['Commentable'], "paramType"=>PDO::PARAM_INT);
        if (!is_null($dataArray['Module'])) {
            $insertMainHeaderQuery['parameters'][9] = array("paramName"=>"Module", "paramVal"=>$dataArray['Module'], "paramType"=>PDO::PARAM_STR);
        } else {
            $insertMainHeaderQuery['parameters'][9] = array("paramName"=>"Module", "paramVal"=>null, "paramType"=>PDO::PARAM_STR);
        }
        $insertMainHeaderQuery['parameters'][10] = array("paramName"=>"UserId", "paramVal"=>$_SESSION['admin']['userData']['UserId'], "paramType"=>PDO::PARAM_INT);

        $insertMainHeaderResult = $this->db->parameterInsert($insertMainHeaderQuery);
        return $insertMainHeaderResult;
    }
    
    private function insertLangHeader($dataArray) {
        $insertLangHeaderQuery = array();
        $insertLangHeaderQuery['sql'] = "INSERT INTO lang_header SET
            MainHeaderId=:mainHeaderId,
            ParentId=:parentId,
            Rank=:rank,
            Caption=:caption,
            Title=:title,
            Heading=:heading,
            Keywords=:keywords,
            Link=:link,
            Language=:language,
            Counter=:counter,
            Created=NOW(),
            CreatedBy=:createdBy,
            Active = 1";
        $insertLangHeaderQuery["parameters"][0] = array("paramName"=>"mainHeaderId", "paramVal"=>$dataArray['MainHeaderId'], "paramType"=>PDO::PARAM_INT);
        $insertLangHeaderQuery["parameters"][1] = array("paramName"=>"parentId", "paramVal"=>$dataArray['ParentId'], "paramType"=>PDO::PARAM_INT);
        $insertLangHeaderQuery["parameters"][2] = array("paramName"=>"rank", "paramVal"=>$dataArray['Rank'], "paramType"=>PDO::PARAM_INT);
        $insertLangHeaderQuery["parameters"][3] = array("paramName"=>"caption", "paramVal"=>$dataArray['Caption'], "paramType"=>PDO::PARAM_STR);
        $insertLangHeaderQuery["parameters"][4] = array("paramName"=>"title", "paramVal"=>$dataArray['Title'], "paramType"=>PDO::PARAM_STR);
        $insertLangHeaderQuery["parameters"][5] = array("paramName"=>"heading", "paramVal"=>$dataArray['Heading'], "paramType"=>PDO::PARAM_STR);
        $insertLangHeaderQuery["parameters"][6] = array("paramName"=>"keywords", "paramVal"=>$dataArray['Keywords'], "paramType"=>PDO::PARAM_STR);
        $insertLangHeaderQuery["parameters"][7] = array("paramName"=>"link", "paramVal"=>$dataArray['Link'], "paramType"=>PDO::PARAM_STR);
        $insertLangHeaderQuery["parameters"][8] = array("paramName"=>"language", "paramVal"=>$dataArray['Language'], "paramType"=>PDO::PARAM_STR);
        $insertLangHeaderQuery["parameters"][9] = array("paramName"=>"counter", "paramVal"=>$dataArray['Counter'], "paramType"=>PDO::PARAM_INT);
        $insertLangHeaderQuery["parameters"][10] = array("paramName"=>"createdBy", "paramVal"=>$_SESSION['admin']['userData']['UserId'], "paramType"=>PDO::PARAM_INT);
        $result = $this->db->parameterInsert($insertLangHeaderQuery);
        return $result;
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
        $updateMainHeaderQuery['sql'] = "UPDATE main_header SET
            AdditionalField=:AdditionalField,
            Role=:Role,
            MainPage=:MainPage,
            MainNode=:MainNode,
            MoreFlag=:MoreFlag,
            Target=:Target,
            UserIn=:UserIn,
            Popup=:Popup,
            Commentable=:Commentable,
            Module=:Module,
            Modified=NOW(),
            ModifiedBy=:UserId,
            Active=1 WHERE MainHeaderId=:MainHeaderId";

        $updateMainHeaderQuery['parameters'][0] = array("paramName"=>"AdditionalField", "paramVal"=>$dataArray['AdditionalField'], "paramType"=>PDO::PARAM_STR);
        $updateMainHeaderQuery['parameters'][1] = array("paramName"=>"Role", "paramVal"=>$dataArray['Role'], "paramType"=>PDO::PARAM_INT);
        $updateMainHeaderQuery['parameters'][2] = array("paramName"=>"MainPage", "paramVal"=>$dataArray['MainPage'], "paramType"=>PDO::PARAM_INT);
        $updateMainHeaderQuery['parameters'][3] = array("paramName"=>"MainNode", "paramVal"=>$dataArray['MainNode'], "paramType"=>PDO::PARAM_INT);
        $updateMainHeaderQuery['parameters'][4] = array("paramName"=>"MoreFlag", "paramVal"=>$dataArray['MoreFlag'], "paramType"=>PDO::PARAM_INT);
        $updateMainHeaderQuery['parameters'][5] = array("paramName"=>"Target", "paramVal"=>$dataArray['Target'], "paramType"=>PDO::PARAM_INT);
        $updateMainHeaderQuery['parameters'][6] = array("paramName"=>"UserIn", "paramVal"=>$dataArray['UserIn'], "paramType"=>PDO::PARAM_INT);
        $updateMainHeaderQuery['parameters'][7] = array("paramName"=>"Popup", "paramVal"=>$dataArray['Popup'], "paramType"=>PDO::PARAM_INT);
        $updateMainHeaderQuery['parameters'][8] = array("paramName"=>"Commentable", "paramVal"=>$dataArray['Commentable'], "paramType"=>PDO::PARAM_INT);
        $updateMainHeaderQuery['parameters'][9] = array("paramName"=>"Module", "paramVal"=>$dataArray['Module'], "paramType"=>PDO::PARAM_STR);
        $updateMainHeaderQuery['parameters'][10] = array("paramName"=>"UserId", "paramVal"=>$_SESSION['admin']['userData']['UserId'], "paramType"=>PDO::PARAM_INT);
        $updateMainHeaderQuery['parameters'][11] = array("paramName"=>"MainHeaderId", "paramVal"=>$dataArray['MainHeaderId'], "paramType"=>PDO::PARAM_INT);
        
        $updateMainHeaderResult = $this->db->parameterUpdate($updateMainHeaderQuery);
        return $updateMainHeaderResult;       
    }
    
    private function updateLangHeader($dataArray) {
        $updateLangHeaderQuery = array();
        $updateLangHeaderQuery['sql'] = "UPDATE lang_header SET
            MainHeaderId=:MainHeaderId,
            ParentId=:ParentId,
            Rank=:Rank,
            Caption=:Caption,
            Title=:Title,
            Heading=:Heading,
            Keywords=:Keywords,
            Link=:Link,
            Language=:Language,
            Modified=NOW(),
            ModifiedBy=:UserId,
            Active=1 WHERE LangHeaderId=:LangHeaderId";
        $updateLangHeaderQuery["parameters"][0] = array("paramName"=>"MainHeaderId", "paramVal"=>$dataArray['MainHeaderId'], "paramType"=>PDO::PARAM_INT);
        $updateLangHeaderQuery["parameters"][1] = array("paramName"=>"ParentId", "paramVal"=>$dataArray['ParentId'], "paramType"=>PDO::PARAM_INT);
        $updateLangHeaderQuery["parameters"][2] = array("paramName"=>"Rank", "paramVal"=>$dataArray['Rank'], "paramType"=>PDO::PARAM_INT);
        $updateLangHeaderQuery["parameters"][3] = array("paramName"=>"Caption", "paramVal"=>$dataArray['Caption'], "paramType"=>PDO::PARAM_STR);
        $updateLangHeaderQuery["parameters"][4] = array("paramName"=>"Title", "paramVal"=>$dataArray['Title'], "paramType"=>PDO::PARAM_STR);
        $updateLangHeaderQuery["parameters"][5] = array("paramName"=>"Heading", "paramVal"=>$dataArray['Heading'], "paramType"=>PDO::PARAM_STR);
        $updateLangHeaderQuery["parameters"][6] = array("paramName"=>"Keywords", "paramVal"=>$dataArray['Keywords'], "paramType"=>PDO::PARAM_STR);
        $updateLangHeaderQuery["parameters"][7] = array("paramName"=>"Link", "paramVal"=>$dataArray['Link'], "paramType"=>PDO::PARAM_STR);
        $updateLangHeaderQuery["parameters"][8] = array("paramName"=>"Language", "paramVal"=>$dataArray['Language'], "paramType"=>PDO::PARAM_STR);
        $updateLangHeaderQuery["parameters"][9] = array("paramName"=>"UserId", "paramVal"=>$_SESSION['admin']['userData']['UserId'], "paramType"=>PDO::PARAM_INT);
        $updateLangHeaderQuery["parameters"][10] = array("paramName"=>"LangHeaderId", "paramVal"=>$dataArray['LangHeaderId'], "paramType"=>PDO::PARAM_INT);
        $updateLangHeaderResult = $this->db->parameterUpdate($updateLangHeaderQuery);
        return $updateLangHeaderResult;
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