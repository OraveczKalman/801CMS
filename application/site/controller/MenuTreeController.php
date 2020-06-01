<?php
include_once(MODEL_PATH . '/MenuModel.php');

class MenuTreeController {
    private $dataArray;
    private $db;

    public function __construct($dataArray, $db) {
        $this -> dataArray = $dataArray;
        $this -> db = $db;
        call_user_func(array($this, $this->dataArray[0]['event']));
    }

    public function RenderMenuItems() {
        $menuDataArray = array();
        $menuItems = array();
        $menuDataArray[0]['level'] = $this->dataArray[0]['mainPointId'];
        $menu = new MenuModel($this->db, $menuDataArray);
        $menuItems = $menu->GenerateMenuTreeSite();
        include_once(SITE_VIEW_PATH . 'MenuTreeViewHorizontal.php');
    }
}
