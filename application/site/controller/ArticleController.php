<?php
include_once(SITE_MODEL_PATH . '/ArticleModel.php');

class ArticleController {
    private $docData;
    private $db;

    public function __construct($docData, $db) {
        $this->docData = $docData;
        $this->db = $db;
        $this->docModel = new ArticleModel($this->db, $this->docData);
        $this->docModel->renderDocument();
    }
}
