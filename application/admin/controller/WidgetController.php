<?php
include_once(ADMIN_MODEL_PATH . 'WidgetModel.php');

class WidgetController {
    private $dataArray;
    private $db;

    public function __construct($dataArray, $db) {
        $this->dataArray = $dataArray;
        $this->db = $db;
        if (!isset($this->dataArray[0]['counter'])) {
            call_user_func(array($this, $this->dataArray[0]['event']));
        } else if (isset($this->dataArray[0]['counter'])) {
            call_user_func(array($this, $this->dataArray[0]['event']), $this->dataArray[0]['counter']);
        }
    }

    private function widgetList() {
        $widgetModel = new WidgetModel($this->db);
        $widgetList = $widgetModel->getAllWidgets();
        include_once(ADMIN_VIEW_PATH . 'WidgetList.php');
    }
    
    private function save() {
        //var_dump($this->dataArray);
        $widgetModel = new WidgetModel($this->db, $this->dataArray[0]);
        $widgetModel->bindWidgetsToMenuPoint();
    }
}