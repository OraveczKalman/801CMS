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
        $enterQueryString = "SELECT * FROM user WHERE " . $this->dataArray[0]['where'];
        $enterQuery = $this->db->SelectQuery($enterQueryString);
        return $enterQuery;
    }

    /**
     * 
     * @return array $getAllUserQuery
     * @author Oravecz Kálmán
     * Function for get all users in database
     */
    public function getAllUser() {
        $getAllUserQueryString = "SELECT * FROM user ORDER BY RightId";
        $getAllUserQuery = $this->db->selectQuery($getAllUserQueryString);

        return $getAllUserQuery;
    }
    
    
    public function getUserCount() {
        $getUserCountByRightQueryString = "SELECT COUNT(UserId) AS userIdCount FROM user WHERE " . $this->dataArray[0]['where'];
        $getUserCountByRightQuery = $this->db->selectQuery($getUserCountByRightQueryString);
        
        return $getUserCountByRightQuery;
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
        $newUserQuery = array();
        $newUserQuery['sql'] = "INSERT INTO user SET 
            Name=:Name, 
            UserName=:UserName, 
            Password=SHA2(:Password, 512), 
            Pwdr=:Pwdr, 
            Email=:Email, 
            RightId=:RightId, 
            News=:News, 
            Created = NOW(), 
            CreatedBy=:UserId, 
            Active = 1";
        $newUserQuery["parameters"][0] = array("paramName"=>"Name", "paramVal"=>$this->dataArray['Name'], "paramType"=>PDO::PARAM_STR); 
        $newUserQuery["parameters"][1] = array("paramName"=>"UserName", "paramVal"=>$this->dataArray['UserName'], "paramType"=>PDO::PARAM_STR); 
        $newUserQuery["parameters"][2] = array("paramName"=>"Password", "paramVal"=>$this->dataArray['Password'], "paramType"=>PDO::PARAM_STR); 
        $newUserQuery["parameters"][3] = array("paramName"=>"Pwdr", "paramVal"=>$this->dataArray['Pwdr'], "paramType"=>PDO::PARAM_STR); 
        $newUserQuery["parameters"][4] = array("paramName"=>"Email", "paramVal"=>$this->dataArray['Email'], "paramType"=>PDO::PARAM_STR); 
        $newUserQuery["parameters"][5] = array("paramName"=>"RightId", "paramVal"=>$this->dataArray['RightId'], "paramType"=>PDO::PARAM_INT); 
        $newUserQuery["parameters"][6] = array("paramName"=>"News", "paramVal"=>$this->dataArray['News'], "paramType"=>PDO::PARAM_STR); 
        $newUserQuery["parameters"][7] = array("paramName"=>"UserId", "paramVal"=>$_SESSION['admin']['dataArray']['UserId'], "paramType"=>PDO::PARAM_INT); 
        $result = $this->db->parameterInsert($newUserQuery);
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
        $updateUserQuery = array();
        $updateUserQuery["sql"] = "UPDATE user SET 
            Name=:Name, 
            UserName=:UserName, 
            Password=SHA2(:Password, 512), 
            Pwdr=:Pwdr, 
            Email=:Email, 
            RightId=:RightId, 
            News=:News, 
            Modified = NOW(), 
            ModifiedBy=:UserId, 
            Active=:Active 
            WHERE UserId=:UpdatedUserId";
        $updateUserQuery["parameters"][0] = array("paramName"=>"Name", "paramVal"=>$this->dataArray['Name'], "paramType"=>PDO::PARAM_STR); 
        $updateUserQuery["parameters"][1] = array("paramName"=>"UserName", "paramVal"=>$this->dataArray['UserName'], "paramType"=>PDO::PARAM_STR); 
        $updateUserQuery["parameters"][2] = array("paramName"=>"Password", "paramVal"=>$this->dataArray['Password'], "paramType"=>PDO::PARAM_STR); 
        $updateUserQuery["parameters"][3] = array("paramName"=>"Pwdr", "paramVal"=>$this->dataArray['Pwdr'], "paramType"=>PDO::PARAM_STR); 
        $updateUserQuery["parameters"][4] = array("paramName"=>"Email", "paramVal"=>$this->dataArray['Email'], "paramType"=>PDO::PARAM_STR); 
        $updateUserQuery["parameters"][5] = array("paramName"=>"RightId", "paramVal"=>$this->dataArray['RightId'], "paramType"=>PDO::PARAM_INT); 
        $updateUserQuery["parameters"][6] = array("paramName"=>"News", "paramVal"=>$this->dataArray['News'], "paramType"=>PDO::PARAM_STR); 
        $updateUserQuery["parameters"][7] = array("paramName"=>"UserId", "paramVal"=>$_SESSION['admin']['dataArray']['UserId'], "paramType"=>PDO::PARAM_INT); 
        $updateUserQuery["parameters"][8] = array("paramName"=>"Active", "paramVal"=>$this->dataArray['active'], "paramType"=>PDO::PARAM_INT); 
        $updateUserQuery["parameters"][9] = array("paramName"=>"UpdatedUserId", "paramVal"=>$this->dataArray['UserId'], "paramType"=>PDO::PARAM_INT); 
        $result = $this->db->parameterUpdate($updateUserQuery);
        return $result;
    }

    /**
     * 
     * @return int
     * @author Oravecz Kálmán
     * User deactivate function
     */
    public function deleteUser() {
        $deleteUserQuery = array();
        $deleteUserQuery = "UPDATE user SET 
            Modified=NOW(), 
            ModifiedBy=:UserId " . $_SESSION['admin']['userData']['UserId'] . ", 
            Active=:Active" . $this->dataArray['active'] . " 
            WHERE UserId=:ModifiedUserId";
        $deleteUserQuery["parameters"][0] = array("paramName"=>"UserId", "paramVal"=>$_SESSION['admin']['userData']['UserId'], "paramType"=>PDO::PARAM_INT); 
        $deleteUserQuery["parameters"][1] = array("paramName"=>"Active", "paramVal"=>$this->dataArray['active'], "paramType"=>PDO::PARAM_INT); 
        $deleteUserQuery["parameters"][2] = array("paramName"=>"ModifiedUserId", "paramVal"=>$this->dataArray['UserId'], "paramType"=>PDO::PARAM_INT); 
        $result = $this->db->parameterUpdate($deleteUserQuery);
        return $result;
    }
    
    /**
     * 
     * @return type
     * @author Oravecz Kálmán
     * Function for get all user rights from table
     */
    public function getUserRights() {
        $getUserRightsQueryString = "SELECT * FROM user_rights ";
        if (isset($this->dataArray['where'])) {
            $getUserRightsQueryString .= $this->dataArray['where'];
        }
        $getUserRightsQuery = $this->db->selectQuery($getUserRightsQueryString);
        return $getUserRightsQuery;
    }
}