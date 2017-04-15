<?php
class UserModel {
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

    public function getUser() {
        $enterQueryString = 'SELECT * FROM user WHERE ' . $this->dataArray[0]['where'];
        $enterQuery = $this->db->SelectQuery($enterQueryString);
        return $enterQuery;
    }

    public function getAllUser() {
        $getAllUserQueryString = 'SELECT * FROM user ORDER BY RightId';
        $getAllUserQuery = $this->db->SelectQuery($getAllUserQueryString);

        return $getAllUserQuery;
    }
    
    public function getUserCount() {
        $getUserCountByRightQueryString = "SELECT COUNT(UserId) AS userIdCount FROM user WHERE " . $this->dataArray[0]['where'];
        $getUserCountByRightQuery = $this->db->selectQuery($getUserCountByRightQueryString);
        
        return $getUserCountByRightQuery;
    }

    public function newUser() {
        if (!isset($_SESSION['admin']['dataArray']['UserId'])) {
            $_SESSION['admin']['dataArray']['UserId'] = 0;
        }
        $newUserQueryString = "INSERT INTO user SET " .
            "Name = '" . $this->dataArray['Name'] . "', " .
            "UserName = '" . $this->dataArray['UserName'] . "', " .
            "Password = '" . $this->dataArray['Password'] . "', " .
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

    public function updateUser() {
        $updateUserQueryString = "UPDATE user SET " .
            "Name = " . $this->dataArray['Name'] . ", " .
            "UserName = " . $this->dataArray['UserName'] . ", " .
            "Password" . $this->dataArray['Password'] . ", " .
            "Pwdr = " . $this->dataArray['Pwdr'] . ", " .
            "Email = " . $this->dataArray['Email'] . ", " .
            "RightId = " . $this->dataArray['RightId'] . ", " .
            "News = " . $this->dataArray['News'] . ", " .
            "Created = NOW(), " .
            "CreatedBy = " . $_SESSION['admin']['userData']['UserId'] . ", " .
            "Modified = NOW(), " .
            "ModifiedBy = " . $_SESSION['admin']['userData']['UserId'] . ", " .
            "Active = " . $this->dataArray['active'] . " " .
            "WHERE UserId = " . $this->dataArray['UserId'];
        $updateUserQuery = $this->db->updateQuery($updateUserQueryString);

        return $updateUserQuery;
    }

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
    
    public function getUserRights() {
        $getUserRightsQueryString = "SELECT * FROM user_rights ";
        if (isset($this->dataArray['where'])) {
            $getUserRightsQueryString .= $this->dataArray['where'];
        }
        $getUserRightsQuery = $this->db->selectQuery($getUserRightsQueryString);
        return $getUserRightsQuery;
    }
}