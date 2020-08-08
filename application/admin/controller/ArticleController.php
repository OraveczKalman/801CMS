<?php
include_once(MODEL_PATH . 'ArticleModel.php');

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

    private function RenderNewArticleForm() {
        include_once(ADMIN_VIEW_PATH . "ArticleEditor.php");
    }
    
    private function RenderEditArticleForm() {
        $getArticleDataArray = array();
        $getArticleDataArray['textId'] = $this->dataArray[0]['chapterId'];
        $articleModel = new ArticleModel($this->db, $getArticleDataArray);
        $chapterData = $articleModel->getArticle();
        //var_dump($chapterData);
        include_once(ADMIN_VIEW_PATH . "ArticleEditor.php");
    }
    
    private function editArticleForm() {
        $articleFormObject = json_decode(file_get_contents(ADMIN_RESOURCE_PATH . 'lang/' . $_SESSION['setupData']['languageSign'] . '/NewArticleForm.json'));
        $headData = array();
        $headData['MainHeaderId'] = $this->dataArray[0]['MainHeaderId'];
        $headData['Role'] = 1;
        $articleData = array();
        $articleData['MainHeaderId'] = $this->dataArray[0]['MainHeaderId'];
        $articleData['Role'] = 2;
        $articleModel = new ArticleModel($this->db, $headData);
        $documentData['Header'] = $articleModel->getDocumentArticles();
        $articleModel->setDataArray($articleData);
        $documentData['Article'] = $articleModel->getDocumentArticles();
        include_once(ADMIN_VIEW_PATH . 'ArticleForm.php');
    }

    private function ChapterInsert() {
        $errors = $this->ValidateChapterFormFull();
        if (empty($errors)) {
            $articleModel = new ArticleModel($this->db, $this->dataArray);
            $articleModel->insertArticle();
        } else {
            print $errors;
        }
    }
    
    private function ChapterUpdate() {
        $errors = $this->ValidateChapterFormFull();
        if (empty($errors)) {
            //var_dump($this->dataArray);
            include_once(MODEL_PATH . "GalleryModel.php");
            $galleryModel = new GalleryModel($this->db);
            $pictureIds = explode(",", $this->dataArray[0]["pictureHidden"]);
            for ($i=0; $i<=count($pictureIds)-1; $i++) {
                $newPictureDataArray = array(
                    "MainHeaderId"=>$this->dataArray[0]["SuperiorId"],
                    "pictureId"=>$pictureIds[$i]
                );
                $galleryModel->setDataArray($newPictureDataArray);
                $insertNewPictureResult = $galleryModel->insertGalleryLink();
            }
            $articleModel = new ArticleModel($this->db, $this->dataArray);
            $articleModel->updateArticle();
        } else {
            print $errors;
        }
    }
    
    private function updateArticle() {
        $articleModel = new ArticleModel($this->db, $this->dataArray);
        $articleModel->chapterAssorter();
    }
    
    private function newArticleItemHead($articleCounter, $articleArray=null) {
        $articleFormObject = json_decode(file_get_contents(ADMIN_RESOURCE_PATH . 'lang/' . $_SESSION['setupData']['languageSign'] . '/NewArticleForm.json'));
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
    
    private function ValidateChapterFormFull() {
        include_once(CORE_PATH . 'Validator.php');
        $validateInfo = array();
        $validateInfo[] = array('function'=>'validateText', 'data'=>$this->dataArray[0]['Title'], 'controllId'=>'Title');
        $validateInfo[] = array('function'=>'validateText', 'data'=>$this->dataArray[0]['Text'], 'controllId'=>'Text');
        $validator = new mainValidator($validateInfo);
        $errorArray = $validator->validateCore();
        if (empty($errorArray)) {
            return '';
        } else if (!empty($errorArray)) {
            return json_encode($errorArray);
        }
    }
}
