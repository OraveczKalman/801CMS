<?php
class UserModel {
    private $dataArray;
    private $db;
    
    /**
     * 
     * @param type $db
     * @param type $dataArray
     * @author Oravecz Kálmán
     * Constructor for User handling database object.
     */
    public function __construct($db, $dataArray=null) {
        if (!is_null($dataArray)) {
            $this->setDataArray($dataArray);
        }
        $this->setDb($db);
    }
    
    /**
     * 
     * @param type $db
     * @author Oravecz Kálmán
     * Setter function for database connection object
     */
    public function setDb($db) {
        $this->db = $db;
    }
    
    /**
     * 
     * @param type $dataArray
     * @author Oravecz Kálmán
     * Setter function for user data array
     */
    public function setDataArray($dataArray) {
        $this->dataArray = $dataArray;
    }

    /**
     * 
     * @return array enter query
     * @author Oravecz Kálmán
     * User query function returns with user data
     */
    public function getUser() {
        $enterQuery = array(
            "tableName"=>"user",
            "fields"=>"*",
            "where"=>$this->dataArray['where']
        );
        $result = $this->db->selectQueryBuilder($enterQuery);
        return $result;
    }

    /**
     * 
     * @return array $getAllUserQuery
     * @author Oravecz Kálmán
     * Function for get all users in database
     */
    public function getAllUser() {
        $getAllUserQuery = array(
            "tableName"=>"user",
            "fields"=>"*",
            "order"=>"RightId");
        $result = $this->db->selectQueryBuilder($getAllUserQuery);
        return $result;
    }
    
    
    public function getUserCount() {
        $getUserCountByRightQuery = array(
            "tableName"=>"user",
            "fields"=>"COUNT(UserId) AS userIdCount",
            "where"=>$this->dataArray['where']
        );
        $result = $this->db->selectQueryBuilder($getUserCountByRightQuery);       
        return $result;
    }

    /**
     * 
     * @return type
     * @author Oravecz Kálmán
     * New user upload
     */
    public function newUser() {
        if (!isset($_SESSION['admin']['dataArray']['UserId'])) {
            $_SESSION['admin']['dataArray']['UserId'] = 0;
        }
        $this->db->beginTran();
        $newUserQuery = array(
            "tableName"=> "user", 
            "fields"=>"Name=:Name, 
                UserName=:UserName, 
                Password=SHA2(:Password, 512), 
                Pwdr=:Pwdr, 
                Email=:Email, 
                RightId=:RightId, 
                News=:News, 
                Created = NOW(), 
                CreatedBy=:UserId, 
                Active = 1",
            "parameters"=>array(
                array("paramName"=>"Name", "paramVal"=>$this->dataArray['Name'], "paramType"=>PDO::PARAM_STR), 
                array("paramName"=>"UserName", "paramVal"=>$this->dataArray['UserName'], "paramType"=>PDO::PARAM_STR),
                array("paramName"=>"Password", "paramVal"=>$this->dataArray['Password'], "paramType"=>PDO::PARAM_STR), 
                array("paramName"=>"Pwdr", "paramVal"=>$this->dataArray['Pwdr'], "paramType"=>PDO::PARAM_STR),
                array("paramName"=>"Email", "paramVal"=>$this->dataArray['Email'], "paramType"=>PDO::PARAM_STR), 
                array("paramName"=>"RightId", "paramVal"=>$this->dataArray['RightId'], "paramType"=>PDO::PARAM_INT), 
                array("paramName"=>"News", "paramVal"=>$this->dataArray['News'], "paramType"=>PDO::PARAM_STR), 
                array("paramName"=>"UserId", "paramVal"=>$_SESSION['admin']['dataArray']['UserId'], "paramType"=>PDO::PARAM_INT)
            )
        ); 
        $result = $this->db->insertQueryBuilder($newUserQuery);
        if (!$result) {
            $this->db->rollBack();
        } else {
            $this->db->commit();
        }
        return $result;
    }

    /**
     * 
     * @return type
     * @author Oravecz Kálmán
     * Update user data
     */
    public function updateUser() {
        $updateUserQuery = array(
            "tableName"=>"user", 
            "fields"=>"Name=:Name, 
                UserName=:UserName, 
                Password=SHA2(:Password, 512), 
                Pwdr=:Pwdr, 
                Email=:Email, 
                RightId=:RightId, 
                News=:News, 
                Modified = NOW(), 
                ModifiedBy=:UserId, 
                Active=:Active", 
            "where"=>" UserId=:UpdatedUserId",
            "parameters"=>array(
                array("paramName"=>"Name", "paramVal"=>$this->dataArray['Name'], "paramType"=>PDO::PARAM_STR),
                array("paramName"=>"UserName", "paramVal"=>$this->dataArray['UserName'], "paramType"=>PDO::PARAM_STR), 
                array("paramName"=>"Password", "paramVal"=>$this->dataArray['Password'], "paramType"=>PDO::PARAM_STR),
                array("paramName"=>"Pwdr", "paramVal"=>$this->dataArray['Pwdr'], "paramType"=>PDO::PARAM_STR),
                array("paramName"=>"Email", "paramVal"=>$this->dataArray['Email'], "paramType"=>PDO::PARAM_STR),
                array("paramName"=>"RightId", "paramVal"=>$this->dataArray['RightId'], "paramType"=>PDO::PARAM_INT),
                array("paramName"=>"News", "paramVal"=>$this->dataArray['News'], "paramType"=>PDO::PARAM_STR),
                array("paramName"=>"UserId", "paramVal"=>$_SESSION['admin']['userData']['UserId'], "paramType"=>PDO::PARAM_INT),
                array("paramName"=>"Active", "paramVal"=>1, "paramType"=>PDO::PARAM_INT), 
                array("paramName"=>"UpdatedUserId", "paramVal"=>$this->dataArray['UserId'], "paramType"=>PDO::PARAM_INT)
            )
        ); 
        $result = $this->db->updateQueryBuilder($updateUserQuery);
        return $result;
    }

    /**
     * 
     * @return int
     * @author Oravecz Kálmán
     * User deactivate function
     */
    public function deleteUser() {
        $deleteUserQuery = array(
            "tableName"=>"user", 
            "fields"=>"Modified=NOW(), 
                ModifiedBy=:UserId, 
                Active=:Active",
            "where"=>" UserId=:ModifiedUserId",
            "parameters"=>array(
                array("paramName"=>"UserId", "paramVal"=>$_SESSION['admin']['userData']['UserId'], "paramType"=>PDO::PARAM_INT),
                array("paramName"=>"Active", "paramVal"=>$this->dataArray['active'], "paramType"=>PDO::PARAM_INT), 
                array("paramName"=>"ModifiedUserId", "paramVal"=>$this->dataArray['UserId'], "paramType"=>PDO::PARAM_INT)
            )
        ); 
        $result = $this->db->updateQueryBuilder($deleteUserQuery);
        return $result;
    }
    
    /**
     * 
     * @return type
     * @author Oravecz Kálmán
     * Function for get all user rights from table
     */
    public function getUserRights() {
        $getUserRightsQuery = array(
            "tableName"=>"user_rights",
            "fields"=>"*",
            "where"=>$this->dataArray["where"]);
        $result = $this->db->selectQueryBuilder($getUserRightsQuery);
        return $result;
    }
}