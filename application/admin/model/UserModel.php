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
        $newUserQueryString = "INSERT INTO user SET " .
            "Name = '" . $this->dataArray['Name'] . "', " .
            "UserName = '" . $this->dataArray['UserName'] . "', " .
            "Password = SHA2('" . $this->dataArray['Password'] . "', 512), " .
            "Pwdr = '" . $this->dataArray['Pwdr'] . "', " .
            "Email = '" . $this->dataArray['Email'] . "', " .
            "RightId = '" . $this->dataArray['RightId'] . "', " .
            "News = '" . $this->dataArray['News'] . "', " .
            "Created = NOW(), " .
            "CreatedBy = " . $_SESSION['admin']['dataArray']['UserId'] . ", " .
            "Modified = NOW(), " .
            "ModifiedBy = " . $_SESSION['admin']['dataArray']['UserId'] . ", " .
            "Active = 1";
        $newUserQuery = $this->db->insertQuery($newUserQueryString);

        return $newUserQuery;
    }

    /**
     * 
     * @return type
     * @author Oravecz Kálmán
     * Update user data
     */
    public function updateUser() {
        $updateUserQueryString = "UPDATE user SET " .
            "Name = '" . $this->dataArray['Name'] . "', " .
            "UserName = '" . $this->dataArray['UserName'] . "', " .
            "Password = SHA2('" . $this->dataArray['Password'] . "', 512), " .
            "Pwdr = '" . $this->dataArray['Pwdr'] . "', " .
            "Email = '" . $this->dataArray['Email'] . "', " .
            "RightId = " . $this->dataArray['RightId'] . ", " .
            "News = " . $this->dataArray['News'] . ", " .
            "Created = NOW(), " .
            "CreatedBy = " . $_SESSION['admin']['userData']['UserId'] . ", " .
            "Modified = NOW(), " .
            "ModifiedBy = " . $_SESSION['admin']['userData']['UserId'] . ", " .
            "Active = " . $this->dataArray['active'] . " " .
            "WHERE UserId = " . $this->dataArray['UserId'];
        print $updateUserQueryString;
        $updateUserQuery = $this->db->updateQuery($updateUserQueryString);

        return $updateUserQuery;
    }

    /**
     * 
     * @return int
     * @author Oravecz Kálmán
     * User deactivate function
     */
    public function deleteUser() {
        $deleteUserQueryString = "UPDATE user SET " .
            "Modified = NOW(), " .
            "Modified_By = " . $_SESSION['admin']['userData']['UserId'] . ", " .
            "Active = " . $this->dataArray['active'] . " " .
            "WHERE User_Id = " . $this->dataArray['userid'];

        $deleteUserQuery = $this->db->updateQuery($deleteUserQueryString);

        if ($error == '') {
            return 0;
        } else if ($error != '') {
            return $error;
        }
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