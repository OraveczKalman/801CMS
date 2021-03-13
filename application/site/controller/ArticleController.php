<?php
include_once(MODEL_PATH . '/ArticleModel.php');

class ArticleController {
    private $dataArray;
    private $mediaData;
    private $db;
    private $articleLabels;

    public function __construct($db, $docData=null) {
        $this->dataArray = $docData;
        $this->db = $db;
        $this->docModel = new ArticleModel($this->db, $this->dataArray);
        $this->renderDocument();
    }
    
    public function renderDocument() {
        $this->articleLabels = json_decode(file_get_contents(SITE_RESOURCE_PATH . 'lang/' . $_SESSION['setupData']['languageSign'] . '/ArticleViewLabels.json'));
        $documentPictureDataArray = array(
            "MainHeaderId"=>$this->dataArray["MainHeaderId"]
        );
        $this->docModel->setDataArray($documentPictureDataArray);
        $this->mediaData = $this->docModel->getDocumentPictureSite();
        $documentData = $this->getDocumentData();
        include_once(SITE_VIEW_PATH . 'ArticleView.php');
    }
    
    private function getDocumentData() {
        $coverPictureDataArray = array(
            "MainHeaderId"=>$this->dataArray['MainHeaderId']
        );
        $this->docModel->setDataArray($coverPictureDataArray);
        $documentData['CoverPicture'] = $this->docModel->getCoverPicture();
        $headerDataArray = array(
            "MainHeaderId"=>$this->dataArray['MainHeaderId'],
            "Role"=>1
        );
        $this->docModel->setDataArray($headerDataArray);
        $documentData['Header'] = $this->docModel->getDocumentArticles();
        $documentData['Header'][0]["Text"] = str_replace("<p>", '<p class="lead">', $documentData["Header"][0]["Text"]);
        $bodyDataArray = array(
            "MainHeaderId"=>$this->dataArray['MainHeaderId'],
            "Role"=>2
        );
        $this->docModel->setDataArray($bodyDataArray);
        $documentData['Body'] = $this->docModel->getDocumentArticles();
        if (!empty($documentData)) {
            for ($i=0; $i<=count($documentData['Body'])-1; $i++) {
                if (!empty($this -> mediaData)) {
                    $documentData['Body'][$i]['Text'] = $this->mediaChanger($documentData['Body'][$i]['Text']);
                }
            }
            return $documentData;
        } else if(empty($documentData)) {
            return $this->articleLabels->labels->notFoundLabel;
        }
    }

    private function mediaChanger($textData) {
        foreach ($this->mediaData as $mediaData2) {
            switch ($mediaData2['MediaType']) {
                case 1 :
                    $iPod  = stripos($_SERVER['HTTP_USER_AGENT'],"iPod");
                    $iPhone  = stripos($_SERVER['HTTP_USER_AGENT'],"iPhone");
                    $iPad = stripos($_SERVER['HTTP_USER_AGENT'],"iPad");
                    $Android = stripos($_SERVER['HTTP_USER_AGENT'],"Android");
                    $webOS = stripos($_SERVER['HTTP_USER_AGENT'],"webOS");

                    if ($iPod || $iPhone || $iPad) {
                        $ext = $mediaData2["OriginalExtension"];
                    } else {
                        $ext = "webp";
                    }

                    $textData = str_replace('#kep_bal_' . $mediaData2['PictureId'] . '#', '<img src="' . UPLOADED_MEDIA_PATH . $mediaData2['Name'] . "." . $ext . '" class="img-fluid rounded">', $textData);
                    $textData = str_replace('#kep_jobb_' . $mediaData2['PictureId'] . '#', '<img src="' . UPLOADED_MEDIA_PATH . $mediaData2['Name'] . "." . $ext . '" class="img-fluid rounded">', $textData);
                    $textData = str_replace('#kep_kozep_' . $mediaData2['PictureId'] . '#', '<img src="' . UPLOADED_MEDIA_PATH . $mediaData2['Name'] . "." . $ext . '" class="img-fluid rounded">', $textData);
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
