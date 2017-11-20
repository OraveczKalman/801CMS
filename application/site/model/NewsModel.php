<?php
class NewsModel {
    private $dataArray;
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

    public function getNewsData() {
        $newsData = $this->getNews();
        $newsDataCount = $this->getNewsCountByParent();
        if (!isset($_SESSION['actNewsCount']) || $_SESSION['actNewsCount'] != $newsDataCount[0]['actNewsCount']) {
            $_SESSION['actNewsCount'] = $newsDataCount[0]['actNewsCount'];
        }
        include_once('./' . SITE_VIEW_PATH . '/NewsTemplate.php');
    }   
    
    private function getNews() {
        $getNewsQueryString = 'SELECT main_header.*, lang_header.Link, lang_header.Title, text.Text, cimlap_Kep.ProfilePicture FROM main_header 
            LEFT JOIN lang_header ON main_header.MainHeaderId = lang_header.MainHeaderId 
            LEFT JOIN text ON main_header.MainHeaderId = text.SuperiorId 
            LEFT JOIN (SELECT picture.ThumbName AS ProfilePicture, gallery_picture.MainHeaderId FROM picture 
            LEFT JOIN gallery_picture ON gallery_picture.PictureId = picture.PictureId WHERE gallery_picture.Cover=1) AS cimlap_Kep ON cimlap_Kep.MainHeaderId = main_header.MainHeaderId 
            WHERE lang_header.ParentId = ' . $this->dataArray[0]['MainHeaderId'] . ' 
            AND text.Type = 1 AND main_header.`Active` = 1 ORDER BY Created DESC LIMIT ' . $this->dataArray[0]['page'] . ', ' . $this->dataArray[0]['limit'];
        $getNewsQuery = $this->db->selectQuery($getNewsQueryString);
        return $getNewsQuery;
    }
    
    public function getNewsCountByParent() {
        $getDocumentCountQueryString = 'SELECT COUNT(main_header.MainHeaderId) AS actNewsCount FROM main_header ' .
            'INNER JOIN lang_header ON main_header.MainHeaderId = lang_header.MainHeaderId ' .
            'WHERE lang_header.ParentId = "' . $this->dataArray[0]['MainHeaderId'] . '" AND lang_header.Active = 1';
        $getDocumentCountQuery = $this->db->selectQuery($getDocumentCountQueryString);
        return $getDocumentCountQuery;
    }
    
    private function mediaChanger($mediaData, $textData) {
        foreach ($mediaData as $mediaData2) {
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
    
    public function getNewsPicture($docId) {
        $getNewsPictureQueryString = 'SELECT picture.* FROM picture, gallery_picture WHERE gallery_picture.MainHeaderId = ' . $docId . ' AND gallery_picture.PictureId = picture.PictureId AND gallery_picture.Active = 1';
        $getNewsPictureQuery = $this->db->selectQuery($getNewsPictureQueryString);
        return $getNewsPictureQuery;
    }    
}