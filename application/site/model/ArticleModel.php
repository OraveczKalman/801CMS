<?php
include_once(CORE_PATH . 'AncestorClass.php');
include_once(CORE_PATH . '/YoutubeClass.php');

class ArticleModel extends AncestorClass {
    private $dataArray;
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
        $documentData['CoverPicture'] = $this->getCoverPicture($this->dataArray[0]['MainHeaderId']);
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
        $result = array();
        $getDocumentArticlesDataArray = array();
        $getDocumentArticlesDataArray["sql"] = 'SELECT * FROM text WHERE SuperiorId=:mainHeaderId AND Type=:role';
        $getDocumentArticlesDataArray["parameters"][0] = array("paramName"=>"mainHeaderId", "paramVal"=>$parentId, "paramType"=>1);
        $getDocumentArticlesDataArray["parameters"][1] = array("paramName"=>"role", "paramVal"=>$role, "paramType"=>1);
        $result = $this->db->parameterSelect($getDocumentArticlesDataArray);
        return $result;
    }

    public function getDocumentPicture($docId) {
        $result = array();
        $getDocumentPictureDataArray = array();
        $getDocumentPictureDataArray["sql"] = 'SELECT picture.* FROM picture, gallery_picture WHERE gallery_picture.MainHeaderId=:mainHeaderId
            AND gallery_picture.PictureId = picture.PictureId AND gallery_picture.Active = 1';
        $getDocumentPictureDataArray["parameters"][0] = array("paramName"=>"mainHeaderId", "paramVal"=>$docId, "paramType"=>1);
        $result = $this->db->parameterSelect($getDocumentPictureDataArray);
        return $result;
    }
    
    public function getCoverPicture($docId) {
        $result = '';
        $getCoverDataArray = array();
        $getCoverDataArray["sql"] = 'SELECT t2.Name FROM gallery_picture t1 
            LEFT JOIN picture t2 ON t1.PictureId = t2.PictureId
            WHERE t1.MainHeaderId=:mainHeaderId AND t1.Cover = 1';
        $getCoverDataArray["parameters"][0] = array("paramName"=>"mainHeaderId", "paramVal"=>$docId, "paramType"=>1);
        $data = $this->db->parameterSelect($getCoverDataArray);
        $result = $data[0]["Name"];
        return $result;
    } 
}
