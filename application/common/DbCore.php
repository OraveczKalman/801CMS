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
     * @param type $dataArray
     * @return type
     * @authr Oravecz Kálmán
     * This function builds select queries from $dataArray parameter.
     */
    public function selectBuilder($dataArray) {
        $selectQueryString = 'SELECT ' . $dataArray['fields'] . ' FROM ' . $dataArray['table'] . ' ';

        if (isset($dataArray['joins'])) {
            $selectQueryString .= ' ' . $dataArray['joins'] . ' ';
        }

        if (isset($dataArray['where'])) {
            $selectQueryString .= 'WHERE ' . $dataArray['where'] . ' ';
        }

        if (isset($dataArray['group'])) {
            $selectQueryString .= 'GROUP BY ' . $dataArray['group'] . ' ';
        }

        if (isset($dataArray['having'])) {
            $selectQueryString .= 'HAVING ' . $dataArray['having'] . ' ';
        }

        if (isset($dataArray['order'])) {
            $selectQueryString .= 'ORDER BY ';
            foreach ($dataArray['order'] as $order) {
                $selectQueryString .= $order['field'] . ' ' . $order['direction'] . ', ';
            }
            $selectQueryString = trim($selectQueryString, ', ');
        }

        if (!empty($dataArray['limit'])) {
            $selectQueryString .= ' LIMIT ' . $dataArray['limit']['page'] . ', ' . $dataArray['limit']['limit'];
        }
        print '<pre>';
        print_r($selectQueryString);
        print '</pre>';
        $selectQuery = $this->selectQuery($selectQueryString);
        return $selectQuery;
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
            $result['error'] = $e -> errorInfo;
            $stmt->debugDumpParams();
            var_dump($e->errorInfo);
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
     * 
     * @param type $dataArray
     * @return type
     * @author Oravecz Kálmán
     * This function builds insert type queries and from $dataArray parameter and
     * executes them.
     */    
    public function insertQueryBuilder($dataArray) {
        $insertQueryString = "INSERT INTO " . $dataArray['table'] . " SET ";
        foreach ($dataArray['fields'] as $key => $fields) {
            $insertQueryString .= $key . "='" . $fields . "', ";
        }
        $insertQueryString = trim($insertQueryString, ', ');
        $insertQuery = $this->insertQuery($insertQueryString);
        return $insertQuery;
    }
    
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
                return false;
            }
        } catch(PDOException $e) {
            $result['error'] = $e->errorInfo;
            var_dump($e);
            $this->logWriter($e->getMessage() . ': ' . $dataArray['sql']);
            return false;
        }
    }
    
    /**
     * 
     * @param type $dataArray
     * @return type
     * @author Oravecz Kálmán
     * This function builds insert type queries and from $dataArray parameter and
     * executes them.
     */
    public function insertQueryBuilder2($dataArray) {
        $insertQueryString = "INSERT INTO " . $dataArray['table'] . " SET ";
        foreach ($dataArray['fields'] as $key=>$fields) {
            if (!$this->IsNullOrEmpty($fields)) {
                $insertQueryString .= $key . " = '" . $fields . "', ";
            }
        }
        $insertQueryString = trim($insertQueryString, ", ");
        $insertQuery = $this->insertQuery($insertQueryString);
        return $insertQuery;
    }

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
     * 
     * @param type $dataArray
     * @return type
     * @author Oravecz Kálmán
     * This function bulds update type queries from the $dataArray parameter and
     * executes them.
     */
    public function updateQueryBuilder($dataArray) {
        $updateQueryString = "UPDATE " . $dataArray['table'] . " SET ";
        foreach ($dataArray['fields'] as $key => $fields) {
            $updateQueryString .= $key . " = '" . $fields . "', ";
        }
        $updateQueryString .= "Modified = NOW(), " .
            "ModifiedBy = " . $_SESSION['admin']['userData']['UserId'];
        $updateQueryString .= " WHERE " . $dataArray['where'];
        $updateQuery = $this->updateQuery($updateQueryString);
        return $updateQuery;
    }

    
    public function parameterUpdate($dataArray) {
        $result = array();
        try {
            if (isset($dataArray['parameters'])) {
                $stmt = $this->dbLink->prepare($dataArray["sql"]);
                for ($i=0; $i<=count($dataArray["parameters"])-1; $i++) {
                    $stmt->bindParam(':' . $dataArray["parameters"][$i]["paramName"], $dataArray["parameters"][$i]["paramVal"], $dataArray["parameters"][$i]["paramType"]);
                }
                $stmt->execute();
                //$result['lastInsert'] = $this->dbLink->lastInsertId();
                return $result;
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
    
    public function logWriter($message) {
        $message = "[" . date("Y-m-d H:i:s") . "]" . $message;
        file_put_contents(CORE_PATH . "logs/log" . date("Ymd") . ".txt", $message);
    }
}