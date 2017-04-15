<?php
include_once(SITE_MODEL_PATH . '/NewsModel.php');

class NewsController {
    private $newsData;
    private $db;

    public function __construct($newsData, $db) {
        $this->newsData = $newsData;
        $this->db = $db;
        if (!isset($this->newsData[0]['event'])) {
            $this->newsData[0]['event'] = 'newsPageSwitch';
            $this->newsData[0]['fullReload'] = 1;
        }
        call_user_func(array($this, $this->newsData[0]['event']));
    }

    private function newsPageSwitch() {
        if (!isset($this->newsData[0]['page'])) {
            $this->newsData[0]['page'] = 0;
        }
        $this->newsData[0]['limit'] = $_SESSION['setupData']['newsCount'];
        $news = new NewsModel($this->db, $this->newsData);
        $news->getNewsData();
    }
}