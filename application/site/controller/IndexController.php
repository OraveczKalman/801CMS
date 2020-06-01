<?php
class IndexController {
    private $dataArray;
    private $db;
    
    public function __construct($dataArray, $db) {
        $this -> dataArray = $dataArray;
        if (!isset($this->dataArray[0]['event'])) {
            $this->dataArray[0]['event'] = 'RenderIndex';
        }
        $this -> db = $db;
        call_user_func(array($this, $this->dataArray[0]['event']));
    }
    
    private function RenderIndex() {
        include_once(DATABASE_PATH . 'LinkModel.php');
        $menu = new LinkModel($this->db);
        $indexPoints = $menu->getRole();
        //var_dump($indexPoints);
        /*for ($i=0; $i<=count($indexPoints)-1; $i++) {
            $controllerName = $indexPoints[$i]['ControllerName'] . 'Controller';
            include_once(SITE_CONTROLLER_PATH . $controllerName . '.php');
            $dataArray = array();
            $dataArray[0] = $indexPoints[$i];
            $controllerRout = new $controllerName($dataArray, $this->db);
        }*/
    }
}
