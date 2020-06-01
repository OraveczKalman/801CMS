<?php
include_once(SITE_MODEL_PATH . '/NewsModel.php');

class NewsCollectionController {
    private $newsData;
    private $db;
    
    public function __construct($newsData, $db) {
        $this -> newsData = $newsData;
        $this -> db = $db;
        $this -> getNewsData();
    }

    private function getNewsData() {
        $this -> newsData['page'] = 0;
        $this -> newsData['limit'] = 5;
        $news = new NewsModel($this->db, $this->newsData);
        $news -> getNewsData();

        include_once('./' . SITE_VIEW_PATH . '/NewsTemplate.php');
    }
}
