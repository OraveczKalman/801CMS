<?php
include_once(ADMIN_MODEL_PATH . 'GalleryModel.php');
include_once(CORE_PATH . 'PictureFunctions.php');
include_once(CORE_PATH . 'YoutubeClass.php');

class GalleryController {
    private $dataArray;
    private $db;

    public function __construct($dataArray, $db) {
        $this -> dataArray = $dataArray;
        if (!isset($this->dataArray[0]['event'])) {
            $this->dataArray[0]['event'] = 'editGalleryForm';
        }
        $this -> db = $db;
        call_user_func(array($this, $this->dataArray[0]['event']));
    }
    
    private function PictureUpload() {
        $uploadDataArray = array();
        $uploadDataArray[0]['fileArrayName'] = 'pictureArray';
        $uploadDataArray[0]['uploadPath'] = UPLOADED_MEDIA_PATH;
        $uploadDataArray[0]['rename'] = 1;
        $uploadDataArray[0]['newName'] = 'galeria';
        $uploadObject = new UploadController($uploadDataArray);
        $uploadedFiles = $uploadObject->uploadFiles();

        $pictureDataArray = array();
        $pictureDataArray['widthTarget'] = $_SESSION['setupData']['galleryPic']['width'];
        $pictureDataArray['heightTarget'] = $_SESSION['setupData']['galleryPic']['height'];
        $pictureDataArray['thumbWidthTarget'] = $_SESSION['setupData']['galleryThumb']['width'];
        $pictureDataArray['thumbHeightTarget'] = $_SESSION['setupData']['galleryThumb']['height'];
        $pictureDataArray['uploadedFiles'] = $uploadedFiles['successfulUpload'];

        $pictureUpload = new ImageHandling($pictureDataArray);
        $pictureData = array();
        $pictureData['images'] = $pictureUpload -> uploadGallery();
        $pictureData['MainHeaderId'] = $_POST['MainHeaderId'];
        $pictureData['mediaType'] = 1;
        $galleryUpload = new GalleryModel($this->db, $pictureData);
        $galleryUpload->insertGalleryImages();
    }

    private function YoutubeUpload() {
        foreach ($this->dataArray['postVars']['video'] as $video2) {
            $ytObject = new youtube;
            $ytObject->url = $video2['url'];
            $thumbName = $ytObject->thumb_url('maior');
            $video_model->insertGalleryImages($video2['url'], $thumbName, $this->dataArray['postVars']['gal_id_hidden'], 2);
        }
    }

    private function FileUpload() {
        $uploadDataArray = array();
        $uploadDataArray[0]['fileArrayName'] = 'media';
        $uploadDataArray[0]['uploadPath'] = UPLOADED_MEDIA_PATH;
        $uploadDataArray[0]['rename'] = 1;
        $uploadDataArray[0]['newName'] = 'galeria';
        $uploadObject = new UploadController($uploadDataArray);
        $uploadedFiles = $uploadObject->uploadFiles();

        $fileData = array();
        $fileData['images'] = $uploadedFiles['successfulUpload'];
        $fileData['MainHeaderId'] = $_POST['MainHeaderId'];
        $fileData['mediaType'] = $_POST['mediaTypeHidden'];
        $galleryUpload = new GalleryModel($fileData, $this->db);
        $galleryUpload->insertGalleryImages();
    }

    protected function UpdatePictureData() {
        $pictureInfo = array();
        for ($i=0; $i<=count($_POST['pic_id'])-1; $i++) {
            /*$pictureInfo['caption'] = $_POST['caption'][$i];
            $pictureInfo['caption_2'] = $_POST['caption2'][$i];*/
            $pictureInfo['rank'] = $i;
            $pictureInfo['pic_id'] = $_POST['pic_id'][$i];
            $pictureModel = new GalleryModel($this->db, $pictureInfo);            
            $pictureModel->updateGallery();
        }
    }
    
    private function editGalleryForm() {
        $galleryLabels = json_decode(file_get_contents(ADMIN_RESOURCE_PATH . 'lang/NewGalleryFormHu.json'));
        include_once(ADMIN_VIEW_PATH . 'GalleryForm.php');
    }

    private function getGalleryList() {
        $pictureListLabels = json_decode(file_get_contents(ADMIN_RESOURCE_PATH . 'lang/NewPictureListHu.json'));
        $gallery = new GalleryModel($this->db, $this->dataArray);
        $galleryObjects = $gallery -> getGalleryData();
        include_once(ADMIN_VIEW_PATH . 'PictureList.php');
    }

    private function RenderDescriptionForm() {
        include_once(ADMIN_MODEL_PATH . 'ArticleModel.php');
        $getCaptionsArray = array();
        $getCaptionsArray['MainHeaderId'] = $this->dataArray[0]['pictureId'];
        $getCaptionsArray['Role'] = 3;
        $captionObject = new ArticleModel($this->db, $getCaptionsArray);
        $captions = $captionObject->getDocumentArticles();
        include_once(ADMIN_VIEW_PATH . 'PictureDescriptionForm.php');
    }
    
    private function NewDescription($descriptionCounter, $descriptionArray = null) {
        $counter = $descriptionCounter;
        if (is_null($descriptionArray)) {
            $descriptionCount = $counter;
            $descriptionArray = array();
        } else if (!is_null($descriptionArray)) {
            $descriptionCount = count($descriptionArray)-1;
        }
        include_once(ADMIN_VIEW_PATH . 'DescriptionListItem.php');
    }
    
    private function SaveDescription() {
        $descriptionsArray = array();
        $descriptionsArray[0]['cikk'] = array();
        for ($i=0; $i<=count($this->dataArray[0]['descriptions'])-1; $i++) {
            $descriptions = array();
            $descriptions['Szoveg'] = $this->dataArray[0]['descriptions'][$i]['Text'];
            $descriptions['Tipus'] = 3;
            $descriptions['Nyelv'] = 'hu';
            $descriptions['FelettesId'] = $this->dataArray[0]['picId'];
            $descriptions['chapterState'] = $this->dataArray[0]['descriptions'][$i]['descriptionState'];
            array_push($descriptionsArray[0]['cikk'], $descriptions);
        }
        include_once(ADMIN_MODEL_PATH . 'ArticleModel.php');
        $captions = new ArticleModel($this->db, $descriptionsArray);
        $ret = $captions->chapterAssorter();
    }
    
    private function GetInsertList() {
        $gallery = new GalleryModel($this->db, $this->dataArray);
        $galleryObjects = $gallery -> getGalleryData();
        include_once(ADMIN_VIEW_PATH . 'ArticlePictureList.php');	
    }
    
    private function DeletePicture() {
        $picturesDataArray = array();
        $picturesDataArray['table'] = 'picture';
        $picturesDataArray['fields'] = 'Name, ThumbName';
        $picturesDataArray['where'] = 'PictureId = ' . $this->dataArray[0]['PictureId'];
        $galleryModel = new GalleryModel($picturesDataArray, $this->db);
        $picturesToDelete = $galleryModel->getPicture();
        unlink(UPLOADED_MEDIA_PATH . $picturesToDelete[0]['Name']);
        unlink(UPLOADED_MEDIA_PATH . $picturesToDelete[0]['ThumbName']);
        $galleryModel->setDataArray($this->dataArray[0]);
        $delResult = $galleryModel->deleteFromGallery();
    }
    
    private function makeCover() {
        $menu_model = new Menu_Model(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);
        $menu_model -> UpdateOneField(array('Profile_Picture' => $this-> dataArray['postVars']['mediaName'], 'PointId' => $this-> dataArray['postVars']['gallery']));
    }
}
