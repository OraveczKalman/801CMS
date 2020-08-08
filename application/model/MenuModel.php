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
            if ($menuItems[$i]['Role'] == 1) {
                $subDataArray = array();
                $subDataArray['parentNode'] = $level;
                $subDataArray['parentId'] =  $menuItems[$i]['MainHeaderId'];
                $subDataArray['languages'] = $languages;
                $menuItems[$i]['subItems'] = $this->getMenuItems($subDataArray);
            }
        }
        return $menuItems;
    }

    public function GenerateMenuTreeSite() {
        $dataArray = array();
        $dataArray['parentNode'] = $this->dataArray[0]['level'];
        $dataArray['parentId'] = 0;
        $menuItems = $this->getMenuItemsSite($dataArray);
        for ($i=0; $i<=count($menuItems)-1; $i++) {
            if ($menuItems[$i]['Role'] == 2) {
                $subDataArray = array();
                $subDataArray['parentNode'] = $this->dataArray['level'];
                $subDataArray['parentId'] =  $menuItems[$i]['MainHeaderId'];
                $menuItems[$i]['subItems'] = $this->getMenuItemsSite($subDataArray);
            }
        }
        return $menuItems;
    }
    
    private function getMenuItems($dataArray) {
        $dataArray['fields'] = '';
        $dataArray['joins'] = array("LEFT JOIN lang_header t2 ON t2.MainHeaderId = t1.MainHeaderId");
        for ($i=0; $i<=count($dataArray['languages'])-1; $i++) {
            $dataArray['fields'] .= ', t' . $dataArray['languages'][$i]['LanguageSign'] . '.HeadersCount' . $dataArray['languages'][$i]['LanguageSign'];
            array_push($dataArray['joins'], " LEFT JOIN (SELECT MainHeaderId, `Language`, COUNT(MainHeaderId) AS HeadersCount" . $dataArray['languages'][$i]['LanguageSign'] . " FROM lang_header) t" . $dataArray['languages'][$i]['LanguageSign'] . " ON t1.MainHeaderId = t" . $dataArray['languages'][$i]['LanguageSign'] . ".MainHeaderId AND t" . $dataArray['languages'][$i]['LanguageSign'] . ".`Language` = '" . $dataArray['languages'][$i]['LanguageSign'] . "'");
        }
        $getMenuItems = array(
            "tableName"=>"main_header t1",
            "fields"=>"t1.MainHeaderId, t2.Caption, t1.Role, t1.MainNode" . $dataArray["fields"],
            "where"=>"t2.ParentId=:parentId AND t1.MainNode=:parentNode AND t1.Active = 1",
            "joins"=>$dataArray["joins"],
            "parameters"=>array(
                array("paramName"=>"parentId", "paramVal"=>$dataArray['parentId'], "paramType"=>1),
                array("paramName"=>"parentNode", "paramVal"=>$dataArray['parentNode'], "paramType"=>1)
            )
        );
        $menuItems = $this->db->selectQueryBuilder($getMenuItems);
        return $menuItems;
    }

    private function getMenuItemsSite($dataArray) {
        $getMenuItemsQuery = array(
            "tableName"=>"main_header t1",
            "fields"=>"t1.MainHeaderId, t1.Target, t2.Caption, t2.Link, t1.Role, t1.MainNode",
            "joins"=>array(
                "LEFT JOIN lang_header t2 on t2.MainHeaderId = t1.MainHeaderId"
            ),
            "where"=>"t2.ParentId=:parentId and t1.MainNode=:parentNode and t1.MainHeaderId NOT IN 
                (SELECT MainHeaderId FROM main_header where Role = 4 AND AdditionalField = 1)",
            "parameters"=>array(
                array("paramName"=>"parentId", "paramVal"=>$dataArray["parentId"], "paramType"=>1),
                array("paramName"=>"parentNode", "paramVal"=>$dataArray["parentNode"], "paramType"=>1)
            )
        );
        $result = $this->db->selectQueryBuilder($getMenuItemsQuery);
        return $result;
    }
    
    public function getMenu($menuId) {
        $getMenuData = array(
            "tableName"=>"main_header t1",
            "fields"=>"*",
            "joins"=>array(
                "LEFT JOIN lang_header t2 ON t1.MainHeaderId = t2.MainHeaderId"
            ),
            "where"=>"t1.MainHeaderId=:mainHeaderId",
            "parameters"=>array(
                array("paramName"=>"mainHeaderId", "paramVal"=>$menuId, "paramType"=>1)
            )
        );
        $getMenuQuery = $this->db->selectQueryBuilder($getMenuData);
        return $getMenuQuery;
    }

    public function getModules() {
        $getModulesQuery = array(
            "tableName"=>"main_header",
            "fields"=>"lang_header.Title, lang_header.Link",
            "joins"=>array(
                "LEFT JOIN lang_header ON main_header.MainHeaderId = lang_header.MainHeaderId"
            ),
            "where"=>"main_header.MainHeaderId NOT IN (SELECT MainHeaderId FROM lang_header)"
        );
        $result = $this->db->selectQueryBuilder($getModulesQuery);
        return $result;
    }
    
    public function getMenuRoles() {
        if (!is_null($this->dataArray['roleId'])) {
            $getMenuRolesQuery = array(
                "tableName"=>"role",
                "fields"=>"*",
                "where"=>"role.RoleId=:roleId ORDER BY RoleId",
                "parameters"=>array(
                    array("paramName"=>"roleId", "paramVal"=>$this->dataArray['roleId'], "paramType"=>PDO::PARAM_INT)
                )
            );
        } else {
            $getMenuRolesQuery = array(
                "tableName"=>"role",
                "fields"=>"*",
                "order"=>"RoleId"
            );           
        }
        $result = $this->db->selectQueryBuilder($getMenuRolesQuery);
        return $result;
    }

    private function getMaxRank($parentId) {
        $getMaxRankQuery = array(
            "tableName"=>"lang_header",
            "fields"=>"MAX(`Rank`)+1 AS maxRank",
            "where"=>"ParentId=:parentId",
            "parameters"=>array(
                array("paramName"=>"parentId", "paramVal"=>$parentId, "paramType"=>1)
            )
        );
        $result = $this->db->selectQueryBuilder($getMaxRankQuery);
        return $result;
    }
    
    public function insertMenu() {
        $mainHeaderDataArray = array(
            "AdditionalField"=>$this->dataArray['AdditionalField'],
            "Role"=>$this->dataArray['Role'],
            "MainPage"=>$this->dataArray['MainPage'],
            "MainNode"=>$this->dataArray['MainNode'],
            "MoreFlag"=>$this->dataArray['MoreFlag'],
            "Target"=>$this->dataArray['Target'],
            "UserIn"=>$this->dataArray['UserIn'],
            "Popup"=>$this->dataArray['Popup'],
            "Commentable"=>$this->dataArray['Commentable']
        );
        $mainHeaderData = $this->insertMainHeader($mainHeaderDataArray);
        if (!isset($mainHeaderData['error'])) {
            $maxRank = $this->getMaxRank($this->dataArray['ParentId']);
            if (is_null($maxRank[0]['maxRank'])) {
                $maxRank[0]['maxRank'] = 0;
            }
            $rankArray = array(
                "MainHeaderId"=>$mainHeaderData['lastInsert'],
                "ParentId"=>$this->dataArray['ParentId'],
                "Caption"=>$this->dataArray['Caption'],
                "Title"=>$this->dataArray['Title'],
                "Heading"=>$this->dataArray['Heading'],
                "Keywords"=>$this->dataArray['Keywords'],
                "Link"=>$this->dataArray['Link'],
                "Language"=>$this->dataArray['Language'],
                "Counter"=>$this->dataArray['Counter'],
                "Rank"=>$maxRank[0]['maxRank']
            );
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
        $insertMainHeaderQuery = array(
        "tableName"=>"main_header",
        "fields"=>"AdditionalField=:AdditionalField,
            Target=:Target,
            Role=:Role,
            MainPage=:MainPage,
            MainNode=:MainNode,
            MoreFlag=:MoreFlag,          
            UserIn=:UserIn,
            Popup=:Popup,
            Commentable=:Commentable,
            Created=NOW(),
            CreatedBy=:UserId,
            Active = 1");
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
        $insertMainHeaderQuery['parameters'][9] = array("paramName"=>"UserId", "paramVal"=>$_SESSION['admin']['userData']['UserId'], "paramType"=>PDO::PARAM_INT);

        $insertMainHeaderResult = $this->db->insertQueryBuilder($insertMainHeaderQuery);
        return $insertMainHeaderResult;
    }
    
    private function insertLangHeader($dataArray) {
        $insertLangHeaderQuery = array(
            "tableName"=>"lang_header",
            "fields"=>"MainHeaderId=:mainHeaderId,
                ParentId=:parentId,
                `Rank`=:rank,
                Caption=:caption,
                Title=:title,
                Heading=:heading,
                Keywords=:keywords,
                Link=:link,
                Language=:language,
                Counter=:counter,
                Created=NOW(),
                CreatedBy=:createdBy,
                Active = 1",
            "parameters"=>array(
                array("paramName"=>"mainHeaderId", "paramVal"=>$dataArray['MainHeaderId'], "paramType"=>PDO::PARAM_INT),
                array("paramName"=>"parentId", "paramVal"=>$dataArray['ParentId'], "paramType"=>PDO::PARAM_INT),
                array("paramName"=>"rank", "paramVal"=>$dataArray['Rank'], "paramType"=>PDO::PARAM_INT),
                array("paramName"=>"caption", "paramVal"=>$dataArray['Caption'], "paramType"=>PDO::PARAM_STR),
                array("paramName"=>"title", "paramVal"=>$dataArray['Title'], "paramType"=>PDO::PARAM_STR),
                array("paramName"=>"heading", "paramVal"=>$dataArray['Heading'], "paramType"=>PDO::PARAM_STR),
                array("paramName"=>"keywords", "paramVal"=>$dataArray['Keywords'], "paramType"=>PDO::PARAM_STR),
                array("paramName"=>"link", "paramVal"=>$dataArray['Link'], "paramType"=>PDO::PARAM_STR),
                array("paramName"=>"language", "paramVal"=>$dataArray['Language'], "paramType"=>PDO::PARAM_STR),
                array("paramName"=>"counter", "paramVal"=>$dataArray['Counter'], "paramType"=>PDO::PARAM_INT),
                array("paramName"=>"createdBy", "paramVal"=>$_SESSION['admin']['userData']['UserId'], "paramType"=>PDO::PARAM_INT)
            )
        );
        $result = $this->db->insertQueryBuilder($insertLangHeaderQuery);
        return $result;
    }

    public function updateMenu() {
        $mainHeaderDataArray = array(
            "AdditionalField"=>$this->dataArray['AdditionalField'],
            "Role"=>$this->dataArray['Role'],
            "MainPage"=>$this->dataArray['MainPage'],
            "MainNode"=>$this->dataArray['MainNode'],
            "MoreFlag"=>$this->dataArray['MoreFlag'],
            "Target"=>$this->dataArray['Target'],
            "UserIn"=>$this->dataArray['UserIn'],
            "Popup"=>$this->dataArray['Popup'],
            "Commentable"=>$this->dataArray['Commentable'],
            "MainHeaderId"=>$this->dataArray['MainHeaderId']
        );
        $mainHeaderData = $this->updateMainHeader($mainHeaderDataArray);
        if (!isset($mainHeaderData['error'])) {
            $rankArray = array(
                "LangHeaderId"=>$this->dataArray['LangHeaderId'],
                "MainHeaderId"=>$this->dataArray['MainHeaderId'],
                "ParentId"=>$this->dataArray['ParentId'],
                "Caption"=>$this->dataArray['Caption'],
                "Title"=>$this->dataArray['Title'],
                "Heading"=>$this->dataArray['Heading'],
                "Keywords"=>$this->dataArray['Keywords'],
                "Link"=>$this->dataArray['Link'],
                "Language"=>$this->dataArray['Language'],
                "Rank"=>$this->dataArray['Rank']
            );
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
        $updateMainHeaderQuery = array(
            "tableName"=>"main_header",
            "fields"=>"AdditionalField=:AdditionalField,
                Role=:Role,
                MainPage=:MainPage,
                MainNode=:MainNode,
                MoreFlag=:MoreFlag,
                Target=:Target,
                UserIn=:UserIn,
                Popup=:Popup,
                Commentable=:Commentable,
                Modified=NOW(),
                ModifiedBy=:UserId,
                Active=1",
            "where"=>"MainHeaderId=:MainHeaderId",
            "parameters"=>array(
                array("paramName"=>"AdditionalField", "paramVal"=>$dataArray['AdditionalField'], "paramType"=>PDO::PARAM_STR),
                array("paramName"=>"Role", "paramVal"=>$dataArray['Role'], "paramType"=>PDO::PARAM_INT),
                array("paramName"=>"MainPage", "paramVal"=>$dataArray['MainPage'], "paramType"=>PDO::PARAM_INT),
                array("paramName"=>"MainNode", "paramVal"=>$dataArray['MainNode'], "paramType"=>PDO::PARAM_INT),
                array("paramName"=>"MoreFlag", "paramVal"=>$dataArray['MoreFlag'], "paramType"=>PDO::PARAM_INT),
                array("paramName"=>"Target", "paramVal"=>$dataArray['Target'], "paramType"=>PDO::PARAM_INT),
                array("paramName"=>"UserIn", "paramVal"=>$dataArray['UserIn'], "paramType"=>PDO::PARAM_INT),
                array("paramName"=>"Popup", "paramVal"=>$dataArray['Popup'], "paramType"=>PDO::PARAM_INT),
                array("paramName"=>"Commentable", "paramVal"=>$dataArray['Commentable'], "paramType"=>PDO::PARAM_INT),
                array("paramName"=>"UserId", "paramVal"=>$_SESSION['admin']['userData']['UserId'], "paramType"=>PDO::PARAM_INT),
                array("paramName"=>"MainHeaderId", "paramVal"=>$dataArray['MainHeaderId'], "paramType"=>PDO::PARAM_INT)
            )
        );        
        $updateMainHeaderResult = $this->db->updateQueryBuilder($updateMainHeaderQuery);
        return $updateMainHeaderResult;       
    }
    
    private function updateLangHeader($dataArray) {
        $updateLangHeaderQuery = array(
            "tableName"=>"lang_header",
            "fields"=>"MainHeaderId=:MainHeaderId,
                ParentId=:ParentId,
                `Rank`=:Rank,
                Caption=:Caption,
                Title=:Title,
                Heading=:Heading,
                Keywords=:Keywords,
                Link=:Link,
                Language=:Language,
                Modified=NOW(),
                ModifiedBy=:UserId,
                Active=1",
            "where"=>"LangHeaderId=:LangHeaderId",
            "parameters"=>array(
                array("paramName"=>"MainHeaderId", "paramVal"=>$dataArray['MainHeaderId'], "paramType"=>PDO::PARAM_INT),
                array("paramName"=>"ParentId", "paramVal"=>$dataArray['ParentId'], "paramType"=>PDO::PARAM_INT),
                array("paramName"=>"Rank", "paramVal"=>$dataArray['Rank'], "paramType"=>PDO::PARAM_INT),
                array("paramName"=>"Caption", "paramVal"=>$dataArray['Caption'], "paramType"=>PDO::PARAM_STR),
                array("paramName"=>"Title", "paramVal"=>$dataArray['Title'], "paramType"=>PDO::PARAM_STR),
                array("paramName"=>"Heading", "paramVal"=>$dataArray['Heading'], "paramType"=>PDO::PARAM_STR),
                array("paramName"=>"Keywords", "paramVal"=>$dataArray['Keywords'], "paramType"=>PDO::PARAM_STR),
                array("paramName"=>"Link", "paramVal"=>$dataArray['Link'], "paramType"=>PDO::PARAM_STR),
                array("paramName"=>"Language", "paramVal"=>$dataArray['Language'], "paramType"=>PDO::PARAM_STR),
                array("paramName"=>"UserId", "paramVal"=>$_SESSION['admin']['userData']['UserId'], "paramType"=>PDO::PARAM_INT),
                array("paramName"=>"LangHeaderId", "paramVal"=>$dataArray['LangHeaderId'], "paramType"=>PDO::PARAM_INT)
            )
        );
        $updateLangHeaderResult = $this->db->updateQueryBuilder($updateLangHeaderQuery);
        return $updateLangHeaderResult;
    }
    
    public function deleteMenu() {
        $mainHeaderDataArray = array("Active"=>0,
            "MainHeaderId"=>$this->dataArray["MainHeaderId"]);
        $mainHeaderData = $this->deleteMainHeader($mainHeaderDataArray);
        $langHeaderDataArray = array("Active"=>0,
            "MainHeaderId"=>$this->dataArray["MainHeaderId"]);
        $langHeaderData = $this->deleteLangHeader($langHeaderDataArray);
    }
    
    public function deleteMainHeader($dataArray) {
        $deleteMainHeaderQuery = array(
            "tableName"=>"main_header",
            "fields"=>"Active=:Active",
            "where"=>"MainHeaderId=:MainHeaderId",
            "parameters"=>array(
                array("paramName"=>"Active", "paramVal"=>$dataArray["Active"], "paramType"=>PDO::PARAM_INT),
                array("paramName"=>"MainHeaderId", "paramVal"=>$dataArray["MainHeaderId"], "paramType"=>PDO::PARAM_INT)
            )
        );
        $deleteMainHeaderResult = $this->db->updateQueryBuilder($deleteMainHeaderQuery);
        return $deleteMainHeaderResult;
    }

    public function deleteLangHeader($dataArray) {
        $deleteLangHeaderQuery = array(
            "tableName"=>"lang_header",
            "fields"=>"Active=:Active",
            "where"=>"MainHeaderId=:MainHeaderId",
            "parameters"=>array(
                array("paramName"=>"Active", "paramVal"=>$dataArray["Active"], "paramType"=>PDO::PARAM_INT),
                array("paramName"=>"MainHeaderId", "paramVal"=>$dataArray["MainHeaderId"], "paramType"=>PDO::PARAM_INT)
            )
        );
        $deleteLangHeaderResult = $this->db->parameterUpdate($deleteLangHeaderQuery);
        return $deleteLangHeaderResult;
    }
}