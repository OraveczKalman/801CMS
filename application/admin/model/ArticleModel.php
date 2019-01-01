<?php
include_once(CORE_PATH . 'AncestorClass.php');
class ArticleModel extends AncestorClass {
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
        $result = array();
        $getDocumentArticlesDataArray = array();
        $getDocumentArticlesDataArray['sql'] = 'SELECT text.* FROM text WHERE text.SuperiorId=:superiorId AND text.Type=:role';
        $getDocumentArticlesDataArray['parameters'][0] = array("paramName"=>"superiorId", "paramVal"=>$this->dataArray['MainHeaderId'], "paramType"=>1);
        $getDocumentArticlesDataArray['parameters'][1] = array("paramName"=>"role", "paramVal"=>$this->dataArray['Role'], "paramType"=>1);
        $result = $this->db->parameterSelect($getDocumentArticlesDataArray);
        return $result;
    }

    /**
     * @author Oravecz Kálmán
     * Function for insert or update articles depends on it's exists or not before form submit
     */
    public function chapterAssorter() {
        $this->db->beginTran();
        $data = array();
        $insertChapterQueryStringValues = '';
        $updateChapterQueryString = "";
        $dbError = 0;
        foreach ($this->dataArray[0]['article'] as $texts) {
            switch ($texts['ChapterState']) {
                case 1 :
                    if ($texts['Text'] != '') {
                        $insertChapterQuery = array();
                        $insertChapterQuery['sql'] = "INSERT INTO text SET
                            SuperiorId=:superiorId, 
                            Type=:type, 
                            Title=:title, 
                            Text=:text, 
                            Language=:language, 
                            Created=NOW(), 
                            CreatedBy=:createdBy, 
                            Active=1";
                        $texts["Title"] = "";
                        $insertChapterQuery["parameters"][0] = array("paramName"=>"superiorId", "paramVal"=>$texts["SuperiorId"], "paramType"=>PDO::PARAM_INT);
                        $insertChapterQuery["parameters"][1] = array("paramName"=>"type", "paramVal"=>$texts["Type"], "paramType"=>PDO::PARAM_INT);
                        $insertChapterQuery["parameters"][2] = array("paramName"=>"title", "paramVal"=>$texts["Title"], "paramType"=>PDO::PARAM_STR);
                        $insertChapterQuery["parameters"][3] = array("paramName"=>"text", "paramVal"=>$texts["Text"], "paramType"=>PDO::PARAM_STR);
                        $insertChapterQuery["parameters"][4] = array("paramName"=>"language", "paramVal"=>$texts["Language"], "paramType"=>PDO::PARAM_STR);
                        $insertChapterQuery["parameters"][5] = array("paramName"=>"createdBy", "paramVal"=>$_SESSION['admin']['userData']['UserId'], "paramType"=>PDO::PARAM_INT);
                        $result = $this->db->parameterInsert($insertChapterQuery);
                        if (!$result) {
                            $dbError = 1;
                        }
                    }
                    break;
                case 2 :
                    $updateChapterQuery = array();
                    $updateChapterQuery['sql'] = "UPDATE text SET 
                        SuperiorId =:superiorId, 
                        Type =:type, 
                        Title =:title, 
                        Text =:text, 
                        Language =:language, 
                        Modified = NOW(), 
                        ModifiedBy =:modifiedBy 
                        WHERE TextId =:textId";
                    $texts["Title"] = "";
                    $updateChapterQuery["parameters"][0] = array("paramName"=>"textId", "paramVal"=>$texts["TextId"], "paramType"=>PDO::PARAM_INT);
                    $updateChapterQuery["parameters"][1] = array("paramName"=>"superiorId", "paramVal"=>$texts["SuperiorId"], "paramType"=>PDO::PARAM_INT);
                    $updateChapterQuery["parameters"][2] = array("paramName"=>"type", "paramVal"=>$texts["Type"], "paramType"=>PDO::PARAM_INT);
                    $updateChapterQuery["parameters"][3] = array("paramName"=>"title", "paramVal"=>$texts["Title"], "paramType"=>PDO::PARAM_STR);
                    $updateChapterQuery["parameters"][4] = array("paramName"=>"text", "paramVal"=>$texts["Text"], "paramType"=>PDO::PARAM_STR);
                    $updateChapterQuery["parameters"][5] = array("paramName"=>"language", "paramVal"=>$texts["Language"], "paramType"=>PDO::PARAM_STR);
                    $updateChapterQuery["parameters"][6] = array("paramName"=>"modifiedBy", "paramVal"=>$_SESSION['admin']['userData']['UserId'], "paramType"=>PDO::PARAM_INT);
                    $result = $this->db->parameterUpdate($updateChapterQuery);
                    if (!$result) {
                        $dbError = 1;
                    }
                    break;
                }
            }
            if ($dbError == 1) {
                $this->db->rollBack();
                $data["error"] = "Db error";
            } else {
                $this->db->commit();
                $data["good"] = $texts["SuperiorId"];
            }
            print json_encode($data);
    }
}
