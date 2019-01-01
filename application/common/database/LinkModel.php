<?php
class LinkModel {
    private $db;
    private $getLinkQueryString = null;
    private $dataArray;
            
    public function __construct($db, $dataArray = null) {
        
        if (!is_null($dataArray)) {
            $this->setDataArray = $dataArray;
        }
        $this->getLinkQueryString = "SELECT main_header.*, lang_header.*, role.ControllerName, cimlap_kep.ProfilePicture, user.Name
            FROM main_header
            INNER JOIN role ON main_header.Role = role.RoleId 
            LEFT JOIN lang_header ON lang_header.MainHeaderId = main_header.MainHeaderId 
            LEFT JOIN (SELECT picture.ThumbName AS ProfilePicture, gallery_picture.MainHeaderId FROM picture LEFT JOIN gallery_picture 
            ON gallery_picture.PictureId = picture.PictureId WHERE gallery_picture.Cover=1) AS cimlap_kep 
            ON cimlap_kep.MainHeaderId = main_header.MainHeaderId 
            LEFT JOIN user ON user.UserId = main_header.CreatedBy ";
        $this->db = $db;
    }

    public function setDb($db) {
        $this->db = $db;
    }

    public function setDataArray($dataArray) {
        $this->dataArray = $dataArray;
    }
    
    public function getRole($dataArray) {
        $role = $this->db->selectBuilder($dataArray);
        return $role;
    }
    
    public function getRoleCommon() {
        $retVal = array();
        $this->getLinkQueryString .= "WHERE lang_header.Link LIKE :cmd AND main_header.Active = :active";
        try {
            $getLinkQuery = $this->db->dbLink->prepare($this->getLinkQueryString);
            $getLinkQuery->bindParam(":cmd", $this->dataArray["cmd"], PDO::PARAM_STR);
            $getLinkQuery->bindParam(":active", $this->dataArray["active"], PDO::PARAM_INT);
            $getLinkQuery->execute();
            $retVal = $getLinkQuery->fetchAll();
        } catch (PDOException $e) {
            $this->db->logWriter($e->errorInfo);
        }
        return $retVal;
    }

    public function getRoleMain() {
        $retVal = array();
        $this->getLinkQueryString .= "WHERE main_header.MainPage = :mainPage AND main_header.Active = :active";
        try {
            $getLinkQuery = $this->db->dbLink->prepare($this->getLinkQueryString);
            $getLinkQuery->bindParam(":mainPage", $this->dataArray["mainPage"], PDO::PARAM_INT);
            $getLinkQuery->bindParam(":active", $this->dataArray["active"], PDO::PARAM_INT);
            $getLinkQuery->execute();
            $retVal = $getLinkQuery->fetchAll();
        } catch (PDOException $e) {
            $this->db->logWriter($e->errorInfo);
        }
        return $retVal;
    }    
}
