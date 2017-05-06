<?php
class ContactModel {
    private $db;
    private $dataArray;

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
    /**
     * 
     * @return boolean
     * @author Oravecz Kálmán
     * Function for get present contact information on site
     */
    public function GetContactInformation() {
        $getInformationQueryString = 'SELECT * FROM kontakt_form';
        $getInformationQuery = $this->db->SelectQuery($getInformationQueryString);
        if (!isset($getInformationQuery['error'])) {
            return $getInformationQuery;
        } else if (!isset($getInformationQuery['error'])) {
            return false;
        }
    }

    /**
     * 
     * @return boolean
     * @author Oravecz Kálmán
     * Function for insert Contact information
     */
    public function InsertContactInformation() {
        $insertContactQueryString = 'INSERT INTO kontakt_form SET ' .
            'Name = "' . $this->dataArray['Name'] . '", ' .
            'Address = "' . $this->dataArray['Address'] . '" , ' .
            'Phone = "' . $this->dataArray['Phone'] . '", ' .
            'Fax = ' . $this->dataArray['Fax'] . ', ' .
            'Mobile = "' . $this->dataArray['Mobile'] . '", '.
            'TargetMail = "' . $this->dataArray['TargetMail'] . '", ' .
            'SmtpPassword = "' . $this->dataArray['SmtpPassword'] . '" , ' .
            'SmtpServer = "' . $this->dataArray['SmtpServer'] . '", ' .
            'Port = ' . $this->dataArray['Port'] . ', ' .
            'UserName = "' . $this->dataArray['UserName'] . '", '.
            'Created = NOW(), ' .
            'Created_By = "' . $_SESSION['admin']['userData']['UserId'] . '", ' .
            'Modified = NOW(), ' .
            'Modified_By = "' . $_SESSION['admin']['userData']['UserId'] . '", ' .
            'Active = 1';
        $insertContactQuery = $this->db->InsertQuery($insertContactQueryString);
        if (isset($insertContactQuery['error'])) {
            return false;
        } else if (!isset($insertContactQuery['error'])) {
            return $insertContactQuery;
        }
    }

    /**
     * 
     * @return boolean
     * @author Oravecz Kálmán
     * Function for update contact information on site
     */
    public function UpdateContactInformation() {
        $updateContactQueryString = 'UPDATE kontakt_form SET ' .
            'Name = "' . $this->dataArray['Name'] . '", ' .
            'Address = "' . $this->dataArray['Address'] . '" , ' .
            'Phone = "' . $this->dataArray['Phone'] . '", ' .
            'Fax = ' . $this->dataArray['Fax'] . ', ' .
            'Mobile = "' . $this->dataArray['Mobile'] . '", '.
            'TargetMail = "' . $this->dataArray['TargetMail'] . '", ' .
            'SmtpPassword = "' . $this->dataArray['SmtpPassword'] . '" , ' .
            'SmtpServer = "' . $this->dataArray['SmtpServer'] . '", ' .
            'Port = ' . $this->dataArray['Port'] . ', ' .
            'UserName = "' . $this->dataArray['UserName'] . '", ' .
            'Modified = NOW(), ' .
            'Modified_By = "' . $_SESSION['admin']['userData']['UserId'] . '", ' .
            'Active = 1 ' .
            'WHERE ContactId = ' . $this->dataArray['cid_hidden'];
        $updateContactQuery = $this->db->UpdateQuery($updateContactQueryString);
        if (isset($updateContactQuery['error'])) {
            return false;
        } else if (!isset($updateContactQuery['error'])) {
            return $updateContactQuery;
        }
    }
}
