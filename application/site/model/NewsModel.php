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
        $result = array();
        $getNewsDataArray = array();
        $getNewsDataArray["sql"] = 'SELECT main_header.*, lang_header.Link, lang_header.Title, text.Text, cimlap_Kep.ProfilePicture FROM main_header 
            LEFT JOIN lang_header ON main_header.MainHeaderId = lang_header.MainHeaderId 
            LEFT JOIN text ON main_header.MainHeaderId = text.SuperiorId 
            LEFT JOIN (SELECT picture.ThumbName AS ProfilePicture, gallery_picture.MainHeaderId FROM picture 
            LEFT JOIN gallery_picture ON gallery_picture.PictureId = picture.PictureId WHERE gallery_picture.Cover=1) AS cimlap_Kep ON cimlap_Kep.MainHeaderId = main_header.MainHeaderId 
            WHERE lang_header.ParentId=:parentId AND text.Type = 1 AND main_header.`Active` = 1 ORDER BY Created DESC LIMIT :page, :limit';
        $getNewsDataArray["parameters"][0] = array("paramName"=>"parentId", "paramVal"=>$this->dataArray[0]['MainHeaderId'], "paramType"=>1);
        $getNewsDataArray["parameters"][1] = array("paramName"=>"page", "paramVal"=>$this->dataArray[0]['page'], "paramType"=>1);
        $getNewsDataArray["parameters"][2] = array("paramName"=>"limit", "paramVal"=>(int)$this->dataArray[0]['limit'], "paramType"=>1);
        $result = $this->db->parameterSelect($getNewsDataArray);
        return $result;
    }
    
    public function getNewsCountByParent() {
        $result = array();
        $getNewsCountDataArray = array();
        $getNewsCountDataArray["sql"] = 'SELECT COUNT(main_header.MainHeaderId) AS actNewsCount FROM main_header ' .
            'INNER JOIN lang_header ON main_header.MainHeaderId = lang_header.MainHeaderId ' .
            'WHERE lang_header.ParentId=:parentId AND lang_header.Active = 1';
        $getNewsCountDataArray["parameters"][0] = array("paramName"=>"parentId", "paramVal"=>$this->dataArray[0]['MainHeaderId'], "paramType"=>1);
        $result = $this->db->parameterSelect($getNewsCountDataArray);
        return $result;
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
        $result = array();
        $getNewsPictureDataArray = array();
        $getNewsPictureDataArray['sql'] = 'SELECT picture.* FROM picture, gallery_picture 
            WHERE gallery_picture.MainHeaderId=:docId
            AND gallery_picture.PictureId = picture.PictureId AND gallery_picture.Active = 1';
        $getNewsPictureDataArray['parameters'][0] = array("paramName"=>"docId", "paramVal"=>$docId, "paramType"=>1);
        $result = $this->db->parameterSelect($getNewsPictureDataArray);
        return $result;
    }    
}