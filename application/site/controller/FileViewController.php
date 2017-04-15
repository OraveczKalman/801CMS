<?php
class FileViewController {
    private $dataArray;
    private $db;
    
    public function __construct($dataArray, $db) {
        $this->dataArray = $dataArray;
        $this->db = $db;
        $linkExploded = explode('.', $this->dataArray[0]['Link']);
        if (isset($linkExploded[1])) {
            switch ($linkExploded[1]) {
                case 'pdf' :
                    $this->pdfViewer();
                    break;
            }
        }
    }
    
    private function pdfViewer() {
        include_once(SITE_MODEL_PATH . 'GalleryModel.php');
        $fileDataArray = array('MainHeaderId' => $this->dataArray[0]['MainHeaderId']);
        $galleryModel = new galleryModel($this->db, $fileDataArray);
        $fileName = $galleryModel->getPicture2();
        include_once(SITE_VIEW_PATH . 'PdfViewer.php');
    }
}
