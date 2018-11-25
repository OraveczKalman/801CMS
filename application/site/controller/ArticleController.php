<?php
include_once(SITE_MODEL_PATH . '/ArticleModel.php');

class ArticleController {
    private $docData;
    private $db;

    public function __construct($docData, $db) {
        $this->dataArray = $docData;
        $this->db = $db;
        $this->docModel = new ArticleModel($this->db, $this->dataArray);
        $this->renderDocument();
    }
    
    public function renderDocument() {
        $this->mediaData = $this->docModel->getDocumentPicture($this->dataArray[0]['MainHeaderId']);
        $documentData = $this->getDocumentData();
        include_once(SITE_VIEW_PATH . 'ArticleView.php');
    }
    
    private function getDocumentData() {
        $documentData['CoverPicture'] = $this->docModel->getCoverPicture($this->dataArray[0]['MainHeaderId']);
        $documentData['Header'] = $this->docModel->getDocumentArticles($this->dataArray[0]['MainHeaderId'], 1);
        $documentData['Body'] = $this->docModel->getDocumentArticles($this->dataArray[0]['MainHeaderId'], 2);
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
}
