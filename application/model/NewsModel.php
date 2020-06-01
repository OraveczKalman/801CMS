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
        return $newsData;
    }   
    
    private function getNews() {
        $getNewsDataArray = array(
            "fields"=>"main_header.*, lang_header.Link, lang_header.Title, text.Text, cimlap_Kep.ProfilePicture",
            "tableName"=>"main_header",
            "joins"=>array(
                "LEFT JOIN lang_header ON main_header.MainHeaderId = lang_header.MainHeaderId ",
                "LEFT JOIN text ON main_header.MainHeaderId = text.SuperiorId ",
                "LEFT JOIN (SELECT picture.Name AS ProfilePicture, gallery_picture.MainHeaderId FROM picture LEFT JOIN gallery_picture ON gallery_picture.PictureId = picture.PictureId WHERE gallery_picture.Cover=1) AS cimlap_Kep ON cimlap_Kep.MainHeaderId = main_header.MainHeaderId"
            ),
            "where"=>" lang_header.ParentId=:parentId AND lang_header.Language=:lang AND text.Type = 1 AND main_header.`Active` = 1 ORDER BY Created DESC LIMIT :page, :limit",
            "parameters"=>array(
                array("paramName"=>"parentId", "paramVal"=>$this->dataArray[0]['MainHeaderId'], "paramType"=>1),
                array("paramName"=>"page", "paramVal"=>$this->dataArray[0]['page'], "paramType"=>1),
                array("paramName"=>"limit", "paramVal"=>(int)$this->dataArray[0]['limit'], "paramType"=>1),
                array("paramName"=>"lang", "paramVal"=>$_SESSION["setupData"]["languageSign"], "paramType"=>2)
            )
        );
        $result = $this->db->selectQueryBuilder($getNewsDataArray);
        return $result;
    }
    
    public function getNewsCountByParent() {
        $getNewsCountDataArray = array(
            "fields"=>"COUNT(main_header.MainHeaderId) AS actNewsCount",
            "tableName"=>"main_header",
            "joins"=>array(
                "INNER JOIN lang_header ON main_header.MainHeaderId = lang_header.MainHeaderId "
            ),
            "where"=>" lang_header.ParentId=:parentId AND lang_header.Language=:lang AND lang_header.Active = 1",
            "parameters"=>array(
                array("paramName"=>"parentId", "paramVal"=>$this->dataArray[0]['MainHeaderId'], "paramType"=>1),
                array("paramName"=>"lang", "paramVal"=>$_SESSION["setupData"]["languageSign"], "paramType"=>2)
            )
        );
        $result = $this->db->selectQueryBuilder($getNewsCountDataArray);
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
        $getNewsPictureDataArray = array(
            "fields"=>"picture.*",
            "tableName"=>"picture, gallery_picture", 
            "where"=>"gallery_picture.MainHeaderId=:docId AND gallery_picture.PictureId = picture.PictureId AND gallery_picture.Active = 1",
            "parameters"=>array(
                array("paramName"=>"docId", "paramVal"=>$docId, "paramType"=>1)
            )
        );
        $result = $this->db->selectQueryBuilder($getNewsPictureDataArray);
        return $result;
    }    
}