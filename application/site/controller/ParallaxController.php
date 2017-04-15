<?php
class ParallaxController {
    private $dataArray;
    private $db;
    
    public function __construct($dataArray, $db) {
        $this->dataArray = $dataArray;
        $this->db = $db;
        if (!isset($this->dataArray[0]['event'])) {
            $this->dataArray[0]['event'] = 'GetParallaxItems';
        }
        call_user_func(array($this, $this->dataArray[0]['event']));
    }
    
    private function GetParallaxItems() {
        include_once(SITE_MODEL_PATH . 'ParallaxModel.php');
        $getParallaxItemsDataArray = array();
        $getParallaxItemsDataArray['table'] = "main_header t1";
        $getParallaxItemsDataArray['fields'] = "t1.*, t2.*, t3.ControllerName";
        $getParallaxItemsDataArray['joins'] = "LEFT JOIN lang_header t2 ON t1.MainHeaderId = t2.MainHeaderId
            LEFT JOIN role t3 ON t1.Role = t3.RoleId";
        $getParallaxItemsDataArray['where'] = " t2.ParentId = 1 AND t2.Active = 1";
        $getParallaxItemsDataArray['order'][] = array('field' => "t2.Rank", 'direction' => "ASC");
        $parallaxModel = new ParallaxModel($this->db, $getParallaxItemsDataArray);
        $parallaxItems = $parallaxModel->getParallaxHeaders();
        for ($i=0; $i<=count($parallaxItems)-1; $i++) {
            $controllerName = $parallaxItems[$i]['ControllerName'] . 'Controller';
            include_once(SITE_CONTROLLER_PATH . $controllerName . '.php');
            $parallaxArray[0] = $parallaxItems[$i];
            $controllerRout = new $controllerName($parallaxArray, $this->db);
        }
    }
}