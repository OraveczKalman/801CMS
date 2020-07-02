<?php
include_once('AncestorClass.php');
class DbCore extends AncestorClass {
    private $databaseConfig;
    public $dbLink;

    /**
     * 
     * @param type $databaseConfig
     * @return type
     * @author Oravecz Kálmán
     * Constructor for DbCore class
     */
    public function __construct($databaseConfig) {
        $this -> databaseConfig = $databaseConfig;
        try {
            $this->dbLink = new PDO("mysql" .
                ':host=' . $this->databaseConfig['host'] .
                ';port=' . $this->databaseConfig['port'] .
                ';dbname=' . $this->databaseConfig['db'],
                $this->databaseConfig['user'], $this->databaseConfig['pwd']);
            $this->dbLink->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->otherQuery('SET NAMES utf8');
        } catch (PDOException $e) {
            $this->logWriter($e->errorInfo);
            return $e->errorInfo;
        }
    }

    /**
     * 
     * Function selectQueryBuilder
     */
    public function selectQueryBuilder($dataArray) {
        $dataArray['sql'] = "SELECT " . $dataArray["fields"] . " FROM " . $dataArray["tableName"];
        if (isset($dataArray["joins"])) {
            for ($i=0; $i<=count($dataArray["joins"])-1; $i++) {
                $dataArray['sql'] .= " " . $dataArray["joins"][$i];
            }
        }
        if (isset($dataArray["where"])) {
            $dataArray['sql'] .= " WHERE " . $dataArray["where"];
        }
        if (isset($dataArray["group"])) {
            $dataArray['sql'] .= " GROUP BY " . $dataArray["group"];
        }
        if (isset($dataArray["having"])) {
            $dataArray['sql'] .= " HAVING " . $dataArray["having"];
        }
        if (isset($dataArray["order"])) {
            $dataArray['sql'] .= " ORDER BY " . $dataArray["order"];
        }
        $result = $this->parameterSelect($dataArray);
        return $result;
    }
    
    
    /**
     * 
     * @param type $dataArray
     * members:
     * sql: this member contains the query text of select statement
     * parameters: array: this member contains all parameter values of select statement 
     * @return type
     */
    public function parameterSelect($dataArray) {
        try {          
            $stmt = $this->dbLink->prepare($dataArray["sql"]);
            if (isset($dataArray['parameters'])) {
                for ($i=0; $i<=count($dataArray["parameters"])-1; $i++) {
                    $stmt->bindParam(':' . $dataArray["parameters"][$i]["paramName"], $dataArray["parameters"][$i]["paramVal"], $dataArray["parameters"][$i]["paramType"]);
                }
            }
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $result['error'] = $e->errorInfo;
            $this->logWriter($e->getMessage() . ': ' . $dataArray["sql"]);        
        }
        return $result;
    }
    
    /**
     * 
     * @param type $sql
     * @return type
     * @author Oravecz Kálmán
     * Function for execute select queries
     */
    public function selectQuery($sql) { //SELECT típusú lekérdezések függvénye
        try {
            $stmt = $this->dbLink->prepare($sql);
            $stmt = $this->dbLink->query($sql);
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $result['error'] = $e -> errorInfo;
            $this->logWriter($e->getMessage() . ': ' . $sql);
        }
        return $result;
    }

    /**
     * Query builder for insert queries
     */    
    public function insertQueryBuilder($dataArray) {
        $dataArray["sql"] = "INSERT INTO " . $dataArray["tableName"] . " SET " . $dataArray["fields"];
        $result = $this->parameterInsert($dataArray);
        return $result;
    }
    
    
    /**
     * @param type $dataArray
     * @return boolean
     * @author Oravecz Kálmán
     * This function executes insert queries with parameters
     * input: $dataArray
     * Input items
     * sql: The sql string of query
     * parameters: parameter values for the sql query
     */
    public function parameterInsert($dataArray) {
        $result = array();
        try {
            if (isset($dataArray['parameters'])) {
                $stmt = $this->dbLink->prepare($dataArray["sql"]);
                for ($i=0; $i<=count($dataArray["parameters"])-1; $i++) {
                    $stmt->bindParam(':' . $dataArray["parameters"][$i]["paramName"], $dataArray["parameters"][$i]["paramVal"], $dataArray["parameters"][$i]["paramType"]);
                }
                
                $stmt->execute();
                $result['lastInsert'] = $this->dbLink->lastInsertId();
                return $result;
            } else {
                $result['error'] = "No parameters given for insert.";
                $this->logWriter($result['error'] . ': ' . $dataArray['sql']);
                return $result;
            }
        } catch(PDOException $e) {
            $result['error'] = $e->errorInfo;
            $this->logWriter($e->getMessage() . ': ' . $dataArray['sql']);
            return $result;
        }
    }
    
    /**
     * 
     * Deprecated and deleted function insertQueryBuilder2
     */

    /**
     * 
     * @param type $sql
     * @return type
     * @author Oravecz Kálmán
     * This function executes insert queries
     */
    public function insertQuery($sql) {
        $result = array();
        $stmt = $this->dbLink->prepare($sql);
        try {
            $stmt->execute();
            $result['lastInsert'] = $this->dbLink->lastInsertId();
            return $result;
        } catch(PDOException $e) {
            $result['error'] = $e->errorInfo;
            $this->logWriter($e->getMessage() . ': ' . $sql);
            return $result;
        }
    }

    /**
     * Query builder for update queries
     */
    public function updateQueryBuilder($dataArray) {
        $dataArray['sql'] = "UPDATE " . $dataArray["tableName"] . " SET " . $dataArray["fields"];
        if (isset($dataArray["where"])) {
            $dataArray['sql'] .= " WHERE " . $dataArray['where'];
        }
        if (isset($dataArray["having"])) {
            $dataArray['sql'] .= " HAVING " . $dataArray['having'];
        }
        $result = $this->parameterUpdate($dataArray);
        return $result;
    } 

    /**
     * Query builder for Delete queries
     */
    public function deleteQueryBuilder($dataArray) {
        $dataArray['sql'] = "DELETE FROM " . $dataArray["tableName"];
        if (isset($dataArray["where"])) {
            $dataArray['sql'] .= " WHERE " . $dataArray['where'];
        }
        $result = $this->parameterUpdate($dataArray);
        return $result;
    }    
    
    /**
     * 
     * @param type $dataArray
     * @return boolean
     * @author Oravecz Kálmán
     * This function executes update queries with parameters
     * input: $dataArray
     * Input items
     * sql: The sql string of query
     * parameters: parameter values for the sql query
     */
    public function parameterUpdate($dataArray) {
        $result = array();
        try {
            if (isset($dataArray['parameters'])) {
                $stmt = $this->dbLink->prepare($dataArray["sql"]);
                for ($i=0; $i<=count($dataArray["parameters"])-1; $i++) {
                    $stmt->bindParam(':' . $dataArray["parameters"][$i]["paramName"], $dataArray["parameters"][$i]["paramVal"], $dataArray["parameters"][$i]["paramType"]);
                }
                $stmt->execute();
                return true;
            } else {
                $result['error'] = "No parameters given for update.";
                $this->logWriter($result['error'] . ': ' . $dataArray['sql']);
                return false;
            }
        } catch(PDOException $e) {
            $result['error'] = $e->errorInfo;
            $this->logWriter($e->getMessage() . ': ' . $dataArray['sql']);
            return false;
        }
    }
    
    /**
     * 
     * @param type $sql
     * @return type
     * @author Oravecz Kálmán
     * Function for execute update type queries
     */
    public function updateQuery($sql) {
        try {
            $stmt = $this->dbLink->prepare($sql);
            $result = $stmt->execute();
            return $result;
        } catch(PDOException $e) {
            $result['error'] = $e->errorInfo;
            $this->logWriter($e->getMessage() . ': ' . $sql);
            return $result;
        }
    }
    
    /**
     * 
     * @param type $sql
     * @return type
     */
    public function otherQuery($sql) {
        try {
            $this->dbLink->exec($sql);
        } catch (PDOException $e) {
            $result = array();
            $result['error'] = $e->getMessage();
            $this->logWriter($e->getMessage() . ': ' . $sql);
            return $result;
        }
    }
    
    /**
     * Function for transaction start
     */
    public function beginTran() {
        $this->dbLink->beginTransaction();
    }

    /**
     * Rollback function
     */
    
    public function rollBack() {
        $this->dbLink->rollback();
    }

    /**
     * Commit function
     */
    public function commit() {
        $this->dbLink->commit();
    }    

    
    public function logWriter($message) {
        $message = "[" . date("Y-m-d H:i:s") . "]" . $message;
        file_put_contents(CORE_PATH . "logs/log" . date("Ymd") . ".txt", $message);
    }
}
