<?php
include_once('AncestorClass.php');
class DbCore extends AncestorClass {
    private $databaseConfig;
    private $dbLink;

    public function __construct($databaseConfig) { //Konstruktor: felépíti a kapcsolatot az adatbázissal
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
        $selectQuery = $this->selectQuery($selectQueryString);
        return $selectQuery;
    }
	
    public function selectQuery($sql) { //SELECT típusú lekérdezések függvénye
        try {
            $stmt = $this->dbLink->prepare($sql);
            $stmt = $this->dbLink->query($sql);
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        } catch (PDOException $e) {
            $result['error'] = $e -> errorInfo;
            $this->logWriter($e->getMessage() . ': ' . $sql);
            return $result;
        }
    }

    public function insertQueryBuilder($dataArray) {
        $insertQueryString = "INSERT INTO " . $dataArray['table'] . " SET ";
        foreach ($dataArray['fields'] as $key => $fields) {
            $insertQueryString .= $key . "='" . $fields . "', ";
        }
        $insertQueryString = trim($insertQueryString, ', ');
        $insertQuery = $this->insertQuery($insertQueryString);
        return $insertQuery;
    }
    
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

    public function insertQuery($sql) { //INSERT típusú lekérdezések függvénye
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

    public function updateQuery($sql) { //UPDATE típusú lekérdezések függvénye
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