<?php
class GalleryController {
    private $dataArray;
    private $db;
    
    public function __construct($dataArray, $db) {
        $this -> dataArray = $dataArray;
        if (!isset($this->dataArray[0]['event'])) {
            $this->dataArray[0]['event'] = 'RenderGallery';
        }
        $this -> db = $db;
        call_user_func(array($this, $this->dataArray[0]['event']));
    }
    
    private function RenderGallery() {
        include_once(SITE_MODEL_PATH . 'GalleryModel.php');
        $this->articleLabels = json_decode(file_get_contents(SITE_RESOURCE_PATH . 'lang/' . $_SESSION['setupData']['languageSign'] . '/ArticleViewLabels.json'));
        $gallery = new GalleryModel($this->db, $this->dataArray[0]);
        $galleryObjects = $gallery -> getGalleryObjects();
        switch ($this->dataArray[0]['AdditionalField']) {
            case 0 :
                if (!empty($galleryObjects)) {
                    include_once(SITE_VIEW_PATH . 'GalleryView.php');
                } else {
                    print '<p>Feltöltés alatt!</p>';
                }
                break;
            case 1 :
                for ($i=0; $i<=count($galleryObjects)-1; $i++) {
                    $galleryTextArray = array();
                    $galleryTextArray['galleryObjectId'] = $galleryObjects[$i]['PictureId'];
                    $gallery->setDataArray($galleryTextArray);
                    $galleryObjects[$i]['GalleryTexts'] = $gallery->getGalleryObjectText();
                }
                include_once(SITE_VIEW_PATH . 'SliderView.php');               
                break;
        }
    }
}