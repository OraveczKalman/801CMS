<?php
include_once(ADMIN_MODEL_PATH . '/MenuModel.php');

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
        for ($i=0; $i<=$_SESSION['setupData']['mainMenus']-1; $i++) {
            $this->dataArray[0]['level'] = $i;
            $menu = new MenuModel($this->db, $menuDataArray);
            $menuItems[$i] = $menu->GenerateMenuTree(0,$i);
        }
        include_once(ADMIN_VIEW_PATH . 'MenuTreeView.php');
    }
}