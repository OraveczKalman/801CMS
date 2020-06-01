<?php
class LanguageModel {
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
     * function returns with language data
     */
    public function getLanguage() {
        $getLanguageDataArray = array(
            "fields"=>"*",
            "tableName"=>"language",
            "from"=>"getLanguage");
        if (isset($this->dataArray["where"])) {
            $getLanguageDataArray["where"] = $this->dataArray['where'];
        }
        $result = $this->db->selectQueryBuilder($getLanguageDataArray);
        return $result;
    }

    /**
     * 
     * @return type
     * @author Oravecz Kálmán
     * New language upload
     */
    public function newLanguage() {
        $newLanguageDataArray = array(
            "tableName"=>"`language`", 
            "fields"=>"Description=:language, 
                LanguageSign=:languageSign,
                Created=NOW(), 
                CreatedBy=:userId, 
                Active = 1",
            "parameters"=>array(
                    array("paramName"=>"language", "paramVal"=>$this->dataArray["Language"], "paramType"=>PDO::PARAM_STR),
                    array("paramName"=>"languageSign", "paramVal"=>$this->dataArray["LanguageSign"], "paramType"=>PDO::PARAM_STR),
                    array("paramName"=>"userId", "paramVal"=>$_SESSION['admin']['userData']['UserId'], "paramType"=>PDO::PARAM_INT),
                )
            );
        $newLanguageQuery = $this->db->insertQueryBuilder($newLanguageDataArray);
        return $newLanguageQuery;
    }

    /**
     * 
     * @return type
     * @author Oravecz Kálmán
     * Update language data
     */
    public function updateLanguage() {
        $updateLanguageQueryString = "UPDATE `language` SET ";
        if (isset($this->dataArray['fields'])) {
            $updateLanguageQueryString .= $this->dataArray['fields'];
            if (isset($this->dataArray['where'])) {
                $updateLanguageQueryString .= $this->dataArray['where'];
            }
            $updateLanguageQuery = $this->db->updateQuery($updateLanguageQueryString);
        } else {
            $updateLanguageQuery = array('error'=>'updateLanguage: Fields not set to this query.');
            $this->db->logWriter($updateLanguageQuery['error']);
        }
        if (!isset($updateLanguageQuery['error'])) {
            return 0;
        } else {
            return $updateLanguageQuery;
        }
    }

    /**
     * 
     * @return int
     * @author Oravecz Kálmán
     * User deactivate function
     */
    public function deleteLanguage() {
        //var_dump($this->dataArray);
        $deleteLanguageQueryString = "UPDATE `language` SET Modified = NOW(),
            ModifiedBy = " . $_SESSION['admin']['userData']['UserId'] . ", 
            Active = 0 " . $this->dataArray['where'];
        //var_dump($deleteLanguageQueryString);
        $deleteLanguageQuery = $this->db->updateQuery($deleteLanguageQueryString);

        if (!isset($deleteLanguageQuery['error'])) {
            return 0;
        } else {
            return $deleteLanguageQuery;
        }
    }
}