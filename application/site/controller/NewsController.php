<?php
include_once(MODEL_PATH . '/NewsModel.php');

class NewsController {
    private $dataArray;
    private $db;

    public function __construct($db, $dataArray=null) {
        $this->dataArray = $dataArray;
        $this->db = $db;
        if (!isset($this->dataArray[0]['event'])) {
            $this->dataArray[0]['event'] = 'NewsPageSwitch';
            $this->dataArray[0]['fullReload'] = 1;
        }
        call_user_func(array($this, $this->dataArray[0]['event']));
    }

    private function NewsPageSwitch() {
        if (!isset($this->dataArray[0]['page'])) {
            $this->dataArray[0]['page'] = 0;
        }
        $this->dataArray[0]['limit'] = $_SESSION['setupData']['newsCount'];
        $news = new NewsModel($this->db, $this->dataArray);
        $newsData = $news->getNewsData();
        $blogLang = json_decode(file_get_contents('./' . SITE_RESOURCE_PATH . 'lang/' . $_SESSION["setupData"]["languageSign"] . "/BlogViewLabels.json"));
        include_once('./' . SITE_VIEW_PATH . '/NewsTemplate.php');
    }
}