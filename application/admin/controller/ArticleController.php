<?php
include_once(ADMIN_MODEL_PATH . 'ArticleModel.php');

class ArticleController {
    private $dataArray;
    private $db;

    public function __construct($dataArray, $db) {
        $this->dataArray = $dataArray;
        if (!isset($this->dataArray[0]['event'])) {
            $this->dataArray[0]['event'] = 'editArticleForm';
        }
        $this->db = $db;
        if (!isset($this->dataArray[0]['counter'])) {
            call_user_func(array($this, $this->dataArray[0]['event']));
        } else if (isset($this->dataArray[0]['counter'])) {
            call_user_func(array($this, $this->dataArray[0]['event']), $this->dataArray[0]['counter']);
        }
    }

    private function editArticleForm() {
        $articleFormObject = json_decode(file_get_contents(ADMIN_RESOURCE_PATH . 'NewArticleFormHu.json'));
        $bevezetoData = array();
        $bevezetoData['MainHeaderId'] = $this->dataArray[0]['MainHeaderId'];
        $bevezetoData['Role'] = 1;
        $articleData = array();
        $articleData['MainHeaderId'] = $this->dataArray[0]['MainHeaderId'];
        $articleData['Role'] = 2;
        $articleModel = new ArticleModel($this->db, $bevezetoData);
        $documentData['Bevezeto'] = $articleModel->getDocumentArticles();
        $articleModel->setDataArray($articleData);
        $documentData['Cikk'] = $articleModel->getDocumentArticles();
        include_once(ADMIN_VIEW_PATH . 'ArticleForm.php');
    }

    private function updateArticle() {
        $articleModel = new ArticleModel($this->db, $this->dataArray);
        $articleModel->chapterAssorter();
    }
    
    private function newArticleItemHead($articleCounter, $articleArray=null) {
        $counter = $articleCounter;
        if (is_null($articleArray)) {
            $articleCount = 0;
            $articleArray = array();
        } else if (!is_null($articleArray)) {
            $articleCount = count($articleArray)-1;
        }
        include_once(ADMIN_VIEW_PATH . 'ArticleItemHead.php');
    }

    private function newArticleItem($articleCounter, $articleArray = null) {
        $counter = $articleCounter;
        if (is_null($articleArray)) {
            $articleCount = 0;
            $articleArray = array();
        } else if (!is_null($articleArray)) {
            $articleCount = count($articleArray)-1;
        }
        include_once(ADMIN_VIEW_PATH . 'ArticleItem.php');
    }
}
