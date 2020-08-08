<?php
class LinkModel {
    private $db;
    private $getLinkDataArray = null;
    private $dataArray;
            
    public function __construct($db, $dataArray = null) {
        
        if (!is_null($dataArray)) {
            $this->setDataArray = $dataArray;
        }
        
        $this->getLinkDataArray = array("fields"=>"main_header.*, lang_header.*, role.ControllerName, cimlap_kep.ProfilePicture, user.Name",
            "tableName"=>"main_header",
            "joins"=>array(
                "INNER JOIN role ON main_header.Role = role.RoleId", 
                "LEFT JOIN lang_header ON lang_header.MainHeaderId = main_header.MainHeaderId", 
                "LEFT JOIN (SELECT picture.ThumbName AS ProfilePicture, gallery_picture.LangHeaderId FROM picture LEFT JOIN gallery_picture 
                    ON gallery_picture.PictureId = picture.PictureId WHERE gallery_picture.Cover=1) AS cimlap_kep 
                    ON cimlap_kep.LangHeaderId = lang_header.LangHeaderId", 
                "LEFT JOIN user ON user.UserId = main_header.CreatedBy ")
            );
        $this->db = $db;
    }

    public function setDb($db) {
        $this->db = $db;
    }

    public function setDataArray($dataArray) {
        $this->dataArray = $dataArray;
    }
    
    public function getRole() {
        $getRoleQuery = array(
            "tableName"=>"main_header t1",
            "fields"=>"t1.*, t2.ControllerName",
            "joins"=>array(
                array("INNER JOIN role t2 ON t1.Role = t2.RoleId")
            ),
            "where"=>"main_header.MainPage = 1"
        );        
        $role = $this->db->selectQueryBuilder($getRoleQuery);
        return $role;
    }
    
    public function getRoleCommon() {
        $this->getLinkDataArray["where"] = " lang_header.Link LIKE :cmd AND main_header.Active = :active";
        $this->getLinkDataArray["parameters"] = array(
            array("paramName"=>"cmd", "paramVal"=>$this->dataArray["cmd"], "paramType"=>PDO::PARAM_STR),
            array("paramName"=>"active", "paramVal"=>$this->dataArray["active"], "paramType"=>PDO::PARAM_INT)
        );
        $result = $this->db->selectQueryBuilder($this->getLinkDataArray);
        return $result;
    }

    public function getRoleMain() {
        $this->getLinkDataArray["where"] = " main_header.MainPage = :mainPage AND main_header.Active = :active";
        $this->getLinkDataArray["parameters"] = array(
            array("paramName"=>"mainPage", "paramVal"=>$this->dataArray["mainPage"], "paramType"=>PDO::PARAM_INT),
            array("paramName"=>"active", "paramVal"=>$this->dataArray["active"], "paramType"=>PDO::PARAM_INT)
        );
        $result = $this->db->selectQueryBuilder($this->getLinkDataArray);
        return $result;
    }    
}
