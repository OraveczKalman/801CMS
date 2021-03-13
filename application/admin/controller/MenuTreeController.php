<?php
include_once(MODEL_PATH . 'MenuModel.php');
include_once(MODEL_PATH . 'LanguageModel.php');

class MenuTreeController {
    private $dataArray;
    private $db;

    public function __construct($dataArray, $db) {
        $this -> dataArray = $dataArray;
        $this -> db = $db;
        if (!isset($this->dataArray[0]['event'])) {
            $this->dataArray[0]['event'] = 'RenderMenuItems';
        }
        call_user_func(array($this, $this->dataArray[0]['event']));
    }

    public function RenderMenuItems() {
        $menuDataArray = array();
        $menuItems = array();
        $languageModel = new LanguageModel($this->db, array("where"=>" Active=1"));
        $languageList = $languageModel->getLanguage();
        for ($i=0; $i<=count($languageList)-1; $i++) {
            for ($j=0; $j<=$_SESSION['setupData']['mainMenus']-1; $j++) {
                $menuItems[$languageList[$i]["LanguageSign"]][$j] = array();
                $menuItems[$languageList[$i]["LanguageSign"]][$j]["Caption"] = "Főmenü" . $j;
                $menuItems[$languageList[$i]["LanguageSign"]][$j]["MainNode"] = $j;
                $this->dataArray[0]['level'] = $j;
                $menu = new MenuModel($this->db, $menuDataArray);
                $menuItems[$languageList[$i]["LanguageSign"]][$j]["items"] = $menu->GenerateMenuTree(0, $j, $languageList[$i]["LanguageSign"]);
            }
        }
        include_once(ADMIN_VIEW_PATH . 'MenuTreeView.php');
    }
    
    public function getFooter() {
        include_once(ADMIN_VIEW_PATH . "footers/MenuTreeFooter.php");
    }
}