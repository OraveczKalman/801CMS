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
        try {
            $getInformationQuery = $this->db->dbLink->prepare("SELECT * FROM kontakt_form");
            $getInformationQuery->execute();
        } catch (PDOException $e) {
            $this->db->logWriter($e->errorInfo);
        }
    }

    /**
     * 
     * @return boolean
     * @author Oravecz Kálmán
     * Function for insert Contact information
     */
    public function InsertContactInformation() {
        try {
            $insertContactQuery = $this->db->dbLink->prepare("INSERT INTO kontakt_form SET
                Name = :name,
                Address = :address,
                Phone = :phone,
                Fax = :fax,
                Mobile = :mobile,
                TargetMail = :targetMail,
                SmtpPassword = :smtpPassword,
                SmtpServer = :smtpServer,
                Port = :port,
                UserName = :userName,
                Created = NOW(),
                Created_By = :userId,
                Modified = NOW(),
                Modified_By = :userId,
                Active = 1");
            $insertContactQuery->bindParam(":name", $this->dataArray['Name'], PDO::PARAM_STR);
            $insertContactQuery->bindParam(":address", $this->dataArray['Address'], PDO::PARAM_STR);
            $insertContactQuery->bindParam(":phone", $this->dataArray['Phone'], PDO::PARAM_STR);
            $insertContactQuery->bindParam(":fax", $this->dataArray['Fax'], PDO::PARAM_STR);
            $insertContactQuery->bindParam(":mobile", $this->dataArray['Mobile'], PDO::PARAM_STR);
            $insertContactQuery->bindParam(":targetMail", $this->dataArray['TargetMail'], PDO::PARAM_STR);
            $insertContactQuery->bindParam(":smtpPassword", $this->dataArray['SmtpPassword'], PDO::PARAM_STR);
            $insertContactQuery->bindParam(":smtpServer", $this->dataArray['SmtpServer'], PDO::PARAM_STR);
            $insertContactQuery->bindParam(":port", $this->dataArray['Port'], PDO::PARAM_INT);
            $insertContactQuery->bindParam(":userName", $this->dataArray['UserName'], PDO::PARAM_STR);
            $insertContactQuery->bindParam(":userId", $_SESSION['admin']['userData']['UserId'], PDO::PARAM_INT);
            $insertContactQuery->execute();
        } catch(PDOException $e) {
            $this->db->logWriter($e->errorInfo);
        }
    }

    /**
     * 
     * @return boolean
     * @author Oravecz Kálmán
     * Function for update contact information on site
     */
    public function UpdateContactInformation() {
        try {
            $updateContactQuery = $this->db->dbLink->prepare("UPDATE kontakt_form SET
                Name = :name,
                Address = :address,
                Phone = :phone,
                Fax = :fax,
                Mobile = :mobile,
                TargetMail = :targetMail,
                SmtpPassword = :smtpPassword,
                SmtpServer = :smtpServer,
                Port = :port,
                UserName = :userName,
                Modified = NOW(),
                Modified_By = :userId,
                Active = 1 
                WHERE ContactId = :contactId");
            $updateContactQuery->bindParam(":name", $this->dataArray['Name'], PDO::PARAM_STR);
            $updateContactQuery->bindParam(":address", $this->dataArray['Address'], PDO::PARAM_STR);
            $updateContactQuery->bindParam(":phone", $this->dataArray['Phone'], PDO::PARAM_STR);
            $updateContactQuery->bindParam(":fax", $this->dataArray['Fax'], PDO::PARAM_STR);
            $updateContactQuery->bindParam(":mobile", $this->dataArray['Mobile'], PDO::PARAM_STR);
            $updateContactQuery->bindParam(":targetMail", $this->dataArray['TargetMail'], PDO::PARAM_STR);
            $updateContactQuery->bindParam(":smtpPassword", $this->dataArray['SmtpPassword'], PDO::PARAM_STR);
            $updateContactQuery->bindParam(":smtpServer", $this->dataArray['SmtpServer'], PDO::PARAM_STR);
            $updateContactQuery->bindParam(":port", $this->dataArray['Port'], PDO::PARAM_INT);
            $updateContactQuery->bindParam(":userName", $this->dataArray['UserName'], PDO::PARAM_STR);
            $updateContactQuery->bindParam(":userId", $_SESSION['admin']['userData']['UserId'], PDO::PARAM_INT);
            $updateContactQuery->bindParam(":contactId", $this->dataArray['cid_hidden'], PDO::PARAM_INT);
            $updateContactQuery->execute();
        } catch (PDOException $e) {
            $this->db->logWriter($e->errorInfo);
        }
    }
}
