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
        $getInformationQueryString = "SELECT * FROM kontakt_form";
        $getInformationQuery = $this->db->selectQuery($getInformationQueryString);
        return $getInformationQuery;
    }

    /**
     * 
     * @return boolean
     * @author Oravecz Kálmán
     * Function for insert Contact information
     */
    public function InsertContactInformation() {
        $insertContactQuery = array();
        $insertContactQuery['sql'] = "INSERT INTO kontakt_form SET
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
            Active = 1";
        $insertContactQuery["parameters"][0] = array("paramName"=>"name", "paramVal"=>$this->dataArray['Name'], "paramType"=>PDO::PARAM_STR);
        $insertContactQuery["parameters"][1] = array("paramName"=>"address", "paramVal"=>$this->dataArray['Address'], "paramType"=>PDO::PARAM_STR);
        $insertContactQuery["parameters"][2] = array("paramName"=>"phone", "paramVal"=>$this->dataArray['Phone'], "paramType"=>PDO::PARAM_STR);
        $insertContactQuery["parameters"][3] = array("paramName"=>"fax", "paramVal"=>$this->dataArray['Fax'], "paramType"=>PDO::PARAM_STR);
        $insertContactQuery["parameters"][4] = array("paramName"=>"mobile", "paramVal"=>$this->dataArray['Mobile'], "paramType"=>PDO::PARAM_STR);
        $insertContactQuery["parameters"][5] = array("paramName"=>"targetMail", "paramVal"=>$this->dataArray['TargetMail'], "paramType"=>PDO::PARAM_STR);
        $insertContactQuery["parameters"][6] = array("paramName"=>"smtpPassword", "paramVal"=>$this->dataArray['SmtpPassword'], "paramType"=>PDO::PARAM_STR);
        $insertContactQuery["parameters"][7] = array("paramName"=>"smtpServer", "paramVal"=>$this->dataArray['SmtpServer'], "paramType"=>PDO::PARAM_STR);
        $insertContactQuery["parameters"][8] = array("paramName"=>"port", "paramVal"=>$this->dataArray['Port'], "paramType"=>PDO::PARAM_INT);
        $insertContactQuery["parameters"][9] = array("paramName"=>"userName", "paramVal"=>$this->dataArray['UserName'], "paramType"=>PDO::PARAM_STR);
        $insertContactQuery["parameters"][10] = array("paramName"=>"userId", "paramVal"=>$_SESSION['admin']['userData']['UserId'], "paramType"=>PDO::PARAM_INT);
        $result = $this->db->parameterInsert($insertContactQuery);
        return $result;
    }

    /**
     * 
     * @return boolean
     * @author Oravecz Kálmán
     * Function for update contact information on site
     */
    public function UpdateContactInformation() {
        $updateContactQuery = array();
        $updateContactQuery["sql"] = "UPDATE kontakt_form SET
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
            WHERE ContactId = :contactId";
        $updateContactQuery["parameters"][0] = array("paramName"=>"name", "paramVal"=>$this->dataArray['Name'], "paramType"=>PDO::PARAM_STR);
        $updateContactQuery["parameters"][1] = array("paramName"=>"address", "paramVal"=>$this->dataArray['Address'], "paramType"=>PDO::PARAM_STR);
        $updateContactQuery["parameters"][2] = array("paramName"=>"phone", "paramVal"=>$this->dataArray['Phone'], "paramType"=>PDO::PARAM_STR);
        $updateContactQuery["parameters"][3] = array("paramName"=>"fax", "paramVal"=>$this->dataArray['Fax'], "paramType"=>PDO::PARAM_STR);
        $updateContactQuery["parameters"][4] = array("paramName"=>"mobile", "paramVal"=>$this->dataArray['Mobile'], "paramType"=>PDO::PARAM_STR);
        $updateContactQuery["parameters"][5] = array("paramName"=>"targetMail", "paramVal"=>$this->dataArray['TargetMail'], "paramType"=>PDO::PARAM_STR);
        $updateContactQuery["parameters"][6] = array("paramName"=>"smtpPassword", "paramVal"=>$this->dataArray['SmtpPassword'], "paramType"=>PDO::PARAM_STR);
        $updateContactQuery["parameters"][7] = array("paramName"=>"smtpServer", "paramVal"=>$this->dataArray['SmtpServer'], "paramType"=>PDO::PARAM_STR);
        $updateContactQuery["parameters"][8] = array("paramName"=>"port", "paramVal"=>$this->dataArray['Port'], "paramType"=>PDO::PARAM_INT);
        $updateContactQuery["parameters"][9] = array("paramName"=>"userName", "paramVal"=>$this->dataArray['UserName'], "paramType"=>PDO::PARAM_STR);
        $updateContactQuery["parameters"][10] = array("paramName"=>"userId", "paramVal"=>$_SESSION['admin']['userData']['UserId'], "paramType"=>PDO::PARAM_INT);
        $updateContactQuery["parameters"][11] = array("paramName"=>"contactId", "paramVal"=>$this->dataArray['cid_hidden'], "paramType"=>PDO::PARAM_INT);
        $result = $this->db->parameterUpdate($updateContactQuery);
        return $result;
    }
}
