<?php
include_once(CORE_PATH . 'AncestorClass.php');
include_once(CORE_PATH . '/YoutubeClass.php');

class ArticleModel extends AncestorClass {
    private $docData;
    private $mediaData;
    private $db;

    public function __construct($db, $dataArray=null) {
        if (!is_null($dataArray)) {
            $this->setDataArray($dataArray);
        }
        $this->setDb($db);
    }
    
    public function setDb($db) {
        $this->db = $db;
    }

    public function setDataArray($dataArray) {
        $this->dataArray = $dataArray;
    }

    public function renderDocument() {
        $this->mediaData = $this->getDocumentPicture($this->dataArray[0]['MainHeaderId']);
        $documentData = $this->getDocumentData();
        include_once(SITE_VIEW_PATH . 'ArticleView.php');
    }
    
    private function getDocumentData() {
        $documentData['Header'] = $this -> getDocumentArticles($this->dataArray[0]['MainHeaderId'], 1);
        $documentData['Body'] = $this -> getDocumentArticles($this->dataArray[0]['MainHeaderId'], 2);
        if (!empty($documentData)) {
            $documentData['Header'][0]['Szoveg'] = $this->mediaChanger($documentData['Header'][0]['Text']);
            for ($i=0; $i<=count($documentData['Body'])-1; $i++) {
                if (!empty($this -> mediaData)) {
                    $documentData['Body'][$i]['Text'] = $this->mediaChanger($documentData['Body'][$i]['Text']);
                }
            }
            return $documentData;
        } else if(empty($documentData)) {
            return 'A kért dokumentum nem található!';
        }
    }

    private function mediaChanger($textData) {
        foreach ($this -> mediaData as $mediaData2) {
            switch ($mediaData2['MediaType']) {
                case 1 :
                    $textData = str_replace('#kep_bal_' . $mediaData2['PictureId'] . '#', '<img src="' . UPLOADED_MEDIA_PATH . $mediaData2['Name'] . '" class="kep_bal">', $textData);
                    $textData = str_replace('#kep_jobb_' . $mediaData2['PictureId'] . '#', '<img src="' . UPLOADED_MEDIA_PATH . $mediaData2['Name'] . '" class="kep_jobb">', $textData);
                    $textData = str_replace('#kep_kozep_' . $mediaData2['PictureId'] . '#', '<img src="' . UPLOADED_MEDIA_PATH . $mediaData2['Name'] . '" class="kep_kozep">', $textData);
                    break;
                case 2 :
                    include_once(CORE_PATH . '/YoutubeClass.php');
                    $youtubeObject = new youtube;
                    $youtubeObject -> url = $mediaData2['Name'];
                    $player = $youtubeObject -> iframePlayer($_SESSION['setupData']['ytPlayer']['width'], $_SESSION['setupData']['ytPlayer']['height']);
                    $textData = str_replace('#youtube_' . $mediaData2['PictureId'] . '#', $player, $textData);
                    break;
            }
        }
        return $textData;
    }

    public function getDocumentArticles($parentId, $role) {
        $getDocumentArticlesQueryString = 'SELECT * FROM text WHERE SuperiorId = ' . $parentId . ' AND Type = ' . $role;
        $getDocumentArticlesQuery = $this->db->selectQuery($getDocumentArticlesQueryString);
        return $getDocumentArticlesQuery;
    }

    public function getDocumentPicture($docId) {
        $getDocumentPictureQueryString = 'SELECT picture.* FROM picture, gallery_picture WHERE gallery_picture.MainHeaderId = ' . $docId . ' AND gallery_picture.PictureId = picture.PictureId AND gallery_picture.Active = 1';
        $getDocumentPictureQuery = $this->db->selectQuery($getDocumentPictureQueryString);
        return $getDocumentPictureQuery;
    }
}
