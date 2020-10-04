<?php
include_once(MODEL_PATH . 'WidgetModel.php');

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
        //var_dump($this->dataArray);
        $widgetModel = new WidgetModel($this->db);
        $widgetList = $widgetModel->getAllWidgets();
        $widgetPlaces = $widgetModel->getWidgetPlaces();
        $widgetsTurnedOnDataArray = array(
            "MainHeaderId"=>$this->dataArray[0]["mainHeaderId"]
        );
        $widgetModel->setDataArray($widgetsTurnedOnDataArray);
        $widgetsTurnedOn = $widgetModel->getMenuPointWidgets();
        $widgetsArray = array();
        for ($i=0; $i<=count($widgetList)-1; $i++) {
            $widgetsArray[$i]["checked"] = "";
            $widgetsArray[$i]["widgetPlaceOptions"] = "";
            for ($j=0; $j<=count($widgetsTurnedOn)-1; $j++) {
                if ($widgetList[$i]["WidgetId"] == $widgetsTurnedOn[$j]["WidgetId"]) {
                    $widgetsArray[$i]["checked"] = 'checked="checked"';
                    for ($l=0; $l<=count($widgetPlaces)-1; $l++) {
                        if ($widgetsTurnedOn[$j]["WidgetContainerId"] == $widgetPlaces[$l]["WidgetContainerId"]) {
                            $widgetsArray[$i]["widgetPlaceOptions"] .= '<option value="' . $widgetPlaces[$l]["WidgetContainerId"] . '" selected="selected">' . $widgetPlaces[$l]["WidgetContainerName"] . '</option>';
                        } else {
                            $widgetsArray[$i]["widgetPlaceOptions"] .= '<option value="' . $widgetPlaces[$l]["WidgetContainerId"] . '">' . $widgetPlaces[$l]["WidgetContainerName"] . '</option>';
                        }
                    }
                    break;
                } else {
                    for ($l=0; $l<=count($widgetPlaces)-1; $l++) {
                        $widgetsArray[$i]["widgetPlaceOptions"] .= '<option value="' . $widgetPlaces[$l]["WidgetContainerId"] . '">' . $widgetPlaces[$l]["WidgetContainerName"] . '</option>';
                    }
                }
            }
            $widgetsArray[$i]["widgetId"] = $widgetList[$i]["WidgetId"];
            $widgetsArray[$i]["controllerName"] = $widgetList[$i]["ControllerName"];
        }
        include_once(ADMIN_VIEW_PATH . 'WidgetList.php');
    }
    
    private function save() {
        //var_dump($this->dataArray);
        $widgetModel = new WidgetModel($this->db, $this->dataArray[0]);
        $widgetModel->bindWidgetsToMenuPoint();
    }
}
