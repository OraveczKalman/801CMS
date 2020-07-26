<?php
class ArticleModel {
    private $dataArray;
    private $db;
    
    /**
     * 
     * @param type $db
     * @param type $dataArray
     * @author Oravecz Kálmán
     * Constructor for ArticleModel
     */
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

    /**
     * 
     * @return type
     * @author Oravecz Kálmán
     * Function for get articles to document
     */
    public function getDocumentArticles() {
        $getDocumentArticlesDataArray = array(
            'fields'=>'text.*',
            'tableName'=>'text',
            'where'=>' text.SuperiorId=:superiorId AND text.Type=:role',
            'parameters'=>array(
                array("paramName"=>"superiorId", "paramVal"=>$this->dataArray['MainHeaderId'], "paramType"=>1),
                array("paramName"=>"role", "paramVal"=>$this->dataArray['Role'], "paramType"=>1)
            )
        );
        $result = $this->db->selectQueryBuilder($getDocumentArticlesDataArray);
        return $result;
    }
    
    public function getDocumentPicture() {
        $getDocumentPictureDataArray = array(
            "fields"=>"t1.*, t3.Text",
            "tableName"=>"picture t1",
            "joins"=>array(
                "LEFT JOIN gallery_picture t2 ON t2.PictureId = t1.PictureId ",
                "LEFT JOIN (SELECT SuperiorId, Text FROM text WHERE `Type` = 3) t3 ON t3.SuperiorId = t2.PictureId "),
            "where"=>" t2.MainHeaderId=:mainHeaderId AND t2.Active = 1",
            "parameters"=>array(
                array("paramName"=>"mainHeaderId", "paramVal"=>$this->dataArray["MainHeaderId"], "paramType"=>1)
            ),
            "from"=>"documentPicture"
        );
        $result = $this->db->selectQueryBuilder($getDocumentPictureDataArray);
        return $result;
    }

    public function getDocumentPictureSite() {
        $getDocumentPictureDataArray = array(
            "fields"=>"t1.*, t3.Text",
            "tableName"=>"picture t1",
            "joins"=>array(
                "LEFT JOIN gallery_picture t2 ON t2.PictureId = t1.PictureId ",
                "LEFT JOIN (SELECT SuperiorId, Text FROM text WHERE `Type` = 3) t3 ON t3.SuperiorId = t2.PictureId "),
            "where"=>" t2.MainHeaderId=:mainHeaderId AND t2.Active = 1",
            "parameters"=>array(
                array("paramName"=>"mainHeaderId", "paramVal"=>$this->dataArray["MainHeaderId"], "paramType"=>1)
            ),
            "from"=>"documentPicture"
        );
        $result = $this->db->selectQueryBuilder($getDocumentPictureDataArray);
        return $result;
    }
    
    public function getCoverPicture() {
        $getCoverDataArray = array(
            "fields"=>"t2.Name",
            "tableName"=>"gallery_picture t1",
            "joins"=>array(
                "LEFT JOIN picture t2 ON t1.PictureId = t2.PictureId"
            ),
            "where"=>" t1.MainHeaderId=:mainHeaderId AND t1.Cover = 1",
            "parameters"=>array(
                array("paramName"=>"mainHeaderId", "paramVal"=>$this->dataArray["MainHeaderId"], "paramType"=>1)
            )
        );
        $data = $this->db->selectQueryBuilder($getCoverDataArray);
        if (!empty($data)) {
            $result = $data[0]["Name"];
        } else {
            $result = "";
        }
        return $result;
    }   
    
    /**
     * 
     * @return type
     * @author Oravecz Kálmán
     * Function for get specified chapter from article
     */
    public function getArticle() {
        $getArticleDataArray = array(
            'tableName'=>'text',
            'fields'=>'text.*',
            'where'=>' text.TextId=:textId',
            'parameters'=>array(
                array("paramName"=>"textId", "paramVal"=>$this->dataArray['textId'], "paramType"=>1)
            )
        );
        $result = $this->db->selectQueryBuilder($getArticleDataArray);
        return $result;
    }
    
    /**
     * @author Oravecz Kálmán
     * Function for insert single article
     */
    public function insertArticle() {
        $dbError = 0;
        $this->db->beginTran();
        $insertChapterQuery = array(
            'tableName'=>'text',
            'fields'=>"SuperiorId=:superiorId, 
                Type=:type, 
                Title=:title, 
                Text=:text, 
                Language=:language,
                Created=NOW(), 
                CreatedBy=:createdBy, 
                Active=1",
            "parameters"=>array(
                array("paramName"=>"superiorId", "paramVal"=>$this->dataArray[0]["SuperiorId"], "paramType"=>PDO::PARAM_INT),
                array("paramName"=>"type", "paramVal"=>$this->dataArray[0]["Type"], "paramType"=>PDO::PARAM_INT),
                array("paramName"=>"title", "paramVal"=>$this->dataArray[0]["Title"], "paramType"=>PDO::PARAM_STR),
                array("paramName"=>"text", "paramVal"=>$this->dataArray[0]["Text"], "paramType"=>PDO::PARAM_STR),
                array("paramName"=>"language", "paramVal"=>$this->dataArray[0]["Language"], "paramType"=>PDO::PARAM_STR),
                array("paramName"=>"createdBy", "paramVal"=>$_SESSION['admin']['userData']['UserId'], "paramType"=>PDO::PARAM_INT))
            );
        $result = $this->db->insertQueryBuilder($insertChapterQuery);
        if (!$result) {
            $dbError = 1;
        }
        if ($dbError == 1) {
            $this->db->rollBack();
            $data["error"] = "Db error";
        } else {
            $this->db->commit();
            $data["good"] = $this->dataArray[0]["SuperiorId"];
        }
        print json_encode($data);
    }
    
    /**
     * @author Oravecz Kálmán
     * Function for update single article
     */
    public function updateArticle() {
        //var_dump($this->dataArray);
        $dbError = 0;
        $this->db->beginTran();
        $updateChapterQuery = array(
            "tableName"=>"text", 
            "fields"=>"SuperiorId =:superiorId, 
                Type =:type, 
                Title =:title, 
                Text =:text, 
                Language =:language, 
                Modified = NOW(), 
                ModifiedBy =:modifiedBy",
            "where"=>" TextId =:textId",
            "parameters"=>array(
                array("paramName"=>"textId", "paramVal"=>$this->dataArray[0]["TextId"], "paramType"=>PDO::PARAM_INT),
                array("paramName"=>"superiorId", "paramVal"=>$this->dataArray[0]["SuperiorId"], "paramType"=>PDO::PARAM_INT),
                array("paramName"=>"type", "paramVal"=>$this->dataArray[0]["Type"], "paramType"=>PDO::PARAM_INT),
                array("paramName"=>"title", "paramVal"=>$this->dataArray[0]["Title"], "paramType"=>PDO::PARAM_STR),
                array("paramName"=>"text", "paramVal"=>$this->dataArray[0]["Text"], "paramType"=>PDO::PARAM_STR),
                array("paramName"=>"language", "paramVal"=>$this->dataArray[0]["Language"], "paramType"=>PDO::PARAM_STR),
                array("paramName"=>"modifiedBy", "paramVal"=>$_SESSION['admin']['userData']['UserId'], "paramType"=>PDO::PARAM_INT))
        );
        $result = $this->db->updateQueryBuilder($updateChapterQuery);
        if (!$result) {
            $dbError = 1;
        }  
        if ($dbError == 1) {
            $this->db->rollBack();
            $data["error"] = "Db error";
        } else {
            $this->db->commit();
            $data["good"] = $this->dataArray[0]["SuperiorId"];
        }
        print json_encode($data);
    }
}