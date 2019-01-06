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
        $getAllWidgetsQuery = array('sql'=>'SELECT * FROM widget');
        $result = $this->db->parameterSelect($getAllWidgetsQuery);
        if (isset($result['error'])) {
            return false;
        } else {
            return $result;
        }
    }
    
    public function bindWidgetsToMenuPoint() {
        $this->db->beginTran();
        $error = false;
        for ($i=0; $i<=count($this->dataArray['widget'])-1; $i++) {
            $bindResult = $this->insertMenuPointWidget($this->dataArray['MainHeaderId'], $this->dataArray['widget'][$i]);
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
    
    private function insertMenuPointWidget($mainHeaderId, $widgetId) {
        $insertMenuPointWidget = array();
        $insertMenuPointWidget['sql'] = "INSERT INTO main_header_widget SET 
            MainHeaderId=:mainHeaderId,
            WidgetId=:widgetId";
        $insertMenuPointWidget['parameters'][0] = array("paramName"=>"mainHeaderId", "paramVal"=>(int)$mainHeaderId, "paramType"=>PDO::PARAM_INT);
        $insertMenuPointWidget['parameters'][1] = array("paramName"=>"widgetId", "paramVal"=>(int)$widgetId, "paramType"=>PDO::PARAM_INT);
        $result = $this->db->parameterInsert($insertMenuPointWidget);
        return $result;
    }
    
    public function updateMenuPointWidget() {
        
    }
    
    public function deleteMenuPointWidget() {
        
    }
}