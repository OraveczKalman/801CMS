<?php 
class WidgetModel {
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
    
    public function getAllWidgets() {
        $getAllWidgetsQuery = array('tableName'=>'widget',
            'fields'=>'*');
        $result = $this->db->selectQueryBuilder($getAllWidgetsQuery);
        if (isset($result['error'])) {
            return false;
        } else {
            return $result;
        }
    }

    public function getMenuPointWidgets() {
        $getAllWidgetsQuery = array(
            'tableName'=>'widget',
            'fields'=>'*',
            'where'=>'LangHeaderId = ' . $this->dataArray['MainHeaderId']);
        $result = $this->db->selectQueryBuilder($getAllWidgetsQuery);
        if (isset($result['error'])) {
            return false;
        } else {
            return $result;
        }
    }
    
    public function getWidgetPlaces() {
        $query = array(
            "tableName"=>"widget_containers",
            "fields"=>"*"
        );
        $result = $this->db->selectQueryBuilder($query);
        return $result;
    }
    
    public function bindWidgetsToMenuPoint() {
        $this->db->beginTran();
        $error = false;
        for ($i=0; $i<=count($this->dataArray['widget'])-1; $i++) {
            $bindResult = $this->insertMenuPointWidget($this->dataArray['MainHeaderId'], $this->dataArray['widget'][$i], $this->dataArray['widgetPlace'][$i]);
            if ($bindResult == false) {
                $error = true;
            }
        }
        if ($error) {
            $this->db->rollBack();
        } else if (!$error) {
            $this->db->commit();
        }
        return $error;
    }
    
    private function insertMenuPointWidget($mainHeaderId, $widgetId, $widgetContainerId) {
        $insertMenuPointWidget = array(
            'tableName'=>'main_header_widget',
            'fields'=>'
                LangHeaderId=:mainHeaderId,
                WidgetId=:widgetId,
                WidgetContainerId=:widgetContainerId',
            'parameters'=>array(
                array("paramName"=>"mainHeaderId", "paramVal"=>(int)$mainHeaderId, "paramType"=>PDO::PARAM_INT),
                array("paramName"=>"widgetId", "paramVal"=>(int)$widgetId, "paramType"=>PDO::PARAM_INT),
                array("paramName"=>"widgetContainerId", "paramVal"=>(int)$widgetContainerId, "paramType"=>PDO::PARAM_INT)
            )
        );
        $result = $this->db->insertQueryBuilder($insertMenuPointWidget);
        return $result;
    }
    
    public function deleteMenuPointWidget($mainHeaderId, $widgetId) {
        $deleteMenuPointWidget = array(
            'tableName'=>'main_header_widget',
            'where'=>' LangHeaderId=:mainHeaderId AND WidgetId=:widgetId',
            'parameters'=>array(
                array("paramName"=>"mainHeaderId", "paramVal"=>(int)$mainHeaderId, "paramType"=>PDO::PARAM_INT),
                array("paramName"=>"widgetId", "paramVal"=>(int)$widgetId, "paramType"=>PDO::PARAM_INT)
            )
        );
        $result = $this->db->insertQueryBuilder($deleteMenuPointWidget);
        return $result;
    }
}