<?php
class GalleryCollectionController {
    private $dataArray;
    private $db;
    
    public function __construct($dataArray, $db) {
        $this -> dataArray = $dataArray;
        if (!isset($this->dataArray[0]['event'])) {
            $this->dataArray[0]['event'] = 'RenderGalleryCollection';
        }
        $this -> db = $db;
        call_user_func(array($this, $this->dataArray[0]['event']));
    }
    
    private function RenderGalleryCollection() {
        include_once(MODEL_PATH . 'GalleryModel.php');
        $this->articleLabels = json_decode(file_get_contents(SITE_RESOURCE_PATH . 'lang/' . $_SESSION['setupData']['languageSign'] . '/ArticleViewLabels.json'));
        $gallery = new GalleryModel($this->db, $this->dataArray[0]);
        $galleryCollectionObjects = $gallery->getGalleryCoversSite();
        //var_dump($galleryCollectionObjects);
        include_once(SITE_VIEW_PATH . 'GalleryCollectionView.php');
    }
}