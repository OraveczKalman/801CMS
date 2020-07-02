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
        $getInformationQuery = array(
            'fields'=>'*',
            'tableName'=>'contact_form'
        );
        $result = $this->db->selectQueryBuilder($getInformationQuery);
        return $result;
    }

    /**
     * 
     * @return boolean
     * @author Oravecz Kálmán
     * Function for insert Contact information
     */
    public function InsertContactInformation() {
        $this->db->beginTran();
        $insertContactQuery = array(
            'tableName'=>'contact_form',
            'fields'=>'Name=:name,
                Address=:address,
                Phone=:phone,
                Fax=:fax,
                Mobile=:mobile,
                TargetMail=:targetMail,
                SmtpPassword=:smtpPassword,
                SmtpServer=:smtpServer,
                Port=:port,
                UserName=:userName,
                Created=NOW(),
                CreatedBy=:userId,
                Active=1');
        if ($this->dataArray["Name"] != "") {
            $insertContactQuery["parameters"][0] = array("paramName"=>"name", "paramVal"=>$this->dataArray['Name'], "paramType"=>PDO::PARAM_STR);
        } else {
            $insertContactQuery["parameters"][0] = array("paramName"=>"name", "paramVal"=>null, "paramType"=>PDO::PARAM_NULL);
        }
        if ($this->dataArray["Address"] != "") {
            $insertContactQuery["parameters"][1] = array("paramName"=>"address", "paramVal"=>$this->dataArray['Address'], "paramType"=>PDO::PARAM_STR);
        } else {
            $insertContactQuery["parameters"][1] = array("paramName"=>"address", "paramVal"=>null, "paramType"=>PDO::PARAM_NULL);
        }
        if ($this->dataArray["Phone"] != "") {
            $insertContactQuery["parameters"][2] = array("paramName"=>"phone", "paramVal"=>$this->dataArray['Phone'], "paramType"=>PDO::PARAM_STR);
        } else {
            $insertContactQuery["parameters"][2] = array("paramName"=>"phone", "paramVal"=>null, "paramType"=>PDO::PARAM_NULL);
        }
        if ($this->dataArray["Fax"] != "") {
            $insertContactQuery["parameters"][3] = array("paramName"=>"fax", "paramVal"=>$this->dataArray['Fax'], "paramType"=>PDO::PARAM_STR);
        } else {
            $insertContactQuery["parameters"][3] = array("paramName"=>"fax", "paramVal"=>null, "paramType"=>PDO::PARAM_NULL);
        }
        if ($this->dataArray["Mobile"] != "") {
            $insertContactQuery["parameters"][4] = array("paramName"=>"mobile", "paramVal"=>$this->dataArray['Mobile'], "paramType"=>PDO::PARAM_STR);
        } else {
            $insertContactQuery["parameters"][4] = array("paramName"=>"mobile", "paramVal"=>null, "paramType"=>PDO::PARAM_NULL);
        }
        if ($this->dataArray["TargetMail"] != "") {
            $insertContactQuery["parameters"][5] = array("paramName"=>"targetMail", "paramVal"=>$this->dataArray['TargetMail'], "paramType"=>PDO::PARAM_STR);
        } else {
            $insertContactQuery["parameters"][5] = array("paramName"=>"targetMail", "paramVal"=>null, "paramType"=>PDO::PARAM_NULL);
        }
        if ($this->dataArray["SmtpPassword"] != "") {
            $insertContactQuery["parameters"][6] = array("paramName"=>"smtpPassword", "paramVal"=>$this->dataArray['SmtpPassword'], "paramType"=>PDO::PARAM_STR);
        } else {
            $insertContactQuery["parameters"][6] = array("paramName"=>"smtpPassword", "paramVal"=>null, "paramType"=>PDO::PARAM_NULL);
        }
        if ($this->dataArray["SmtpServer"] != "") {
            $insertContactQuery["parameters"][7] = array("paramName"=>"smtpServer", "paramVal"=>$this->dataArray['SmtpServer'], "paramType"=>PDO::PARAM_STR);
        } else {
            $insertContactQuery["parameters"][7] = array("paramName"=>"smtpServer", "paramVal"=>null, "paramType"=>PDO::PARAM_NULL);
        }
        if ($this->dataArray["Port"] != "") {
            $insertContactQuery["parameters"][8] = array("paramName"=>"port", "paramVal"=>$this->dataArray['Port'], "paramType"=>PDO::PARAM_INT);
        } else {
            $insertContactQuery["parameters"][8] = array("paramName"=>"port", "paramVal"=>null, "paramType"=>PDO::PARAM_NULL);
        }
        if ($this->dataArray["UserName"] != "") {
            $insertContactQuery["parameters"][9] = array("paramName"=>"userName", "paramVal"=>$this->dataArray['UserName'], "paramType"=>PDO::PARAM_STR);
        } else {
            $insertContactQuery["parameters"][9] = array("paramName"=>"userName", "paramVal"=>null, "paramType"=>PDO::PARAM_NULL);
        }
        $insertContactQuery["parameters"][10] = array("paramName"=>"userId", "paramVal"=>$_SESSION['admin']['userData']['UserId'], "paramType"=>PDO::PARAM_INT);
        $result = $this->db->insertQueryBuilder($insertContactQuery);
        if (!$result) {
            $this->db->rollBack();
        } else {
            $this->db->commit();
        }
        return $result;
    }

    /**
     * 
     * @return boolean
     * @author Oravecz Kálmán
     * Function for update contact information on site
     */
    public function UpdateContactInformation() {
        $this->db->beginTran();
        $updateContactQuery = array(
            "tableName"=>"contact_form",
            "fields"=>"Name=:name,
                Address=:address,
                Phone=:phone,
                Fax=:fax,
                Mobile=:mobile,
                TargetMail=:targetMail,
                SmtpPassword=:smtpPassword,
                SmtpServer=:smtpServer,
                Port=:port,
                UserName=:userName,
                Modified=NOW(),
                ModifiedBy=:userId,
                Active = 1", 
            "where"=>"ContactId=:contactId");
        if ($this->dataArray["Name"] != "") {
            $updateContactQuery["parameters"][0] = array("paramName"=>"name", "paramVal"=>$this->dataArray['Name'], "paramType"=>PDO::PARAM_STR);
        } else {
            $updateContactQuery["parameters"][0] = array("paramName"=>"name", "paramVal"=>null, "paramType"=>PDO::PARAM_NULL);
        }
        if ($this->dataArray["Address"] != "") {
            $updateContactQuery["parameters"][1] = array("paramName"=>"address", "paramVal"=>$this->dataArray['Address'], "paramType"=>PDO::PARAM_STR);
        } else {
            $updateContactQuery["parameters"][1] = array("paramName"=>"address", "paramVal"=>null, "paramType"=>PDO::PARAM_NULL);
        }
        if ($this->dataArray["Phone"] != "") {
            $updateContactQuery["parameters"][2] = array("paramName"=>"phone", "paramVal"=>$this->dataArray['Phone'], "paramType"=>PDO::PARAM_STR);
        } else {
            $updateContactQuery["parameters"][2] = array("paramName"=>"phone", "paramVal"=>null, "paramType"=>PDO::PARAM_NULL);
        }
        if ($this->dataArray["Fax"] != "") {
            $updateContactQuery["parameters"][3] = array("paramName"=>"fax", "paramVal"=>$this->dataArray['Fax'], "paramType"=>PDO::PARAM_STR);
        } else {
            $updateContactQuery["parameters"][3] = array("paramName"=>"fax", "paramVal"=>null, "paramType"=>PDO::PARAM_NULL);
        }
        if ($this->dataArray["Mobile"] != "") {
            $updateContactQuery["parameters"][4] = array("paramName"=>"mobile", "paramVal"=>$this->dataArray['Mobile'], "paramType"=>PDO::PARAM_STR);
        } else {
            $updateContactQuery["parameters"][4] = array("paramName"=>"mobile", "paramVal"=>null, "paramType"=>PDO::PARAM_NULL);
        }
        if ($this->dataArray["TargetMail"] != "") {
            $updateContactQuery["parameters"][5] = array("paramName"=>"targetMail", "paramVal"=>$this->dataArray['TargetMail'], "paramType"=>PDO::PARAM_STR);
        } else {
            $updateContactQuery["parameters"][5] = array("paramName"=>"targetMail", "paramVal"=>null, "paramType"=>PDO::PARAM_NULL);
        }
        if ($this->dataArray["SmtpPassword"] != "") {
            $updateContactQuery["parameters"][6] = array("paramName"=>"smtpPassword", "paramVal"=>$this->dataArray['SmtpPassword'], "paramType"=>PDO::PARAM_STR);
        } else {
            $updateContactQuery["parameters"][6] = array("paramName"=>"smtpPassword", "paramVal"=>null, "paramType"=>PDO::PARAM_NULL);
        }
        if ($this->dataArray["SmtpServer"] != "") {
            $updateContactQuery["parameters"][7] = array("paramName"=>"smtpServer", "paramVal"=>$this->dataArray['SmtpServer'], "paramType"=>PDO::PARAM_STR);
        } else {
            $updateContactQuery["parameters"][7] = array("paramName"=>"smtpServer", "paramVal"=>null, "paramType"=>PDO::PARAM_NULL);
        }
        if ($this->dataArray["Port"] != "") {
            $updateContactQuery["parameters"][8] = array("paramName"=>"port", "paramVal"=>$this->dataArray['Port'], "paramType"=>PDO::PARAM_INT);
        } else {
            $updateContactQuery["parameters"][8] = array("paramName"=>"port", "paramVal"=>null, "paramType"=>PDO::PARAM_NULL);
        }
        if ($this->dataArray["UserName"] != "") {
            $updateContactQuery["parameters"][9] = array("paramName"=>"userName", "paramVal"=>$this->dataArray['UserName'], "paramType"=>PDO::PARAM_STR);
        } else {
            $updateContactQuery["parameters"][9] = array("paramName"=>"userName", "paramVal"=>null, "paramType"=>PDO::PARAM_NULL);
        }
        $updateContactQuery["parameters"][10] = array("paramName"=>"userId", "paramVal"=>$_SESSION['admin']['userData']['UserId'], "paramType"=>PDO::PARAM_INT);
        $updateContactQuery["parameters"][11] = array("paramName"=>"contactId", "paramVal"=>$this->dataArray['cidHidden'], "paramType"=>PDO::PARAM_INT);
        $result = $this->db->updateQueryBuilder($updateContactQuery);
        if (!$result) {
            $this->db->rollBack();
        } else {
            $this->db->commit();
        }
        return $result;
    }
}
