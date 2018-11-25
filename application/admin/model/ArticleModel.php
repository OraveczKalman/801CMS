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
     * Function for insert or update articles depends on it's living or not before form submit
     */
    public function chapterAssorter() {
        try
        {
            $data = array();
            $insertChapterQueryStringValues = '';
            $updateChapterQueryString = "";
            foreach ($this->dataArray[0]['cikk'] as $szovegek) {
                switch ($szovegek['chapterState']) {
                    case 1 :
                        if ($szovegek['Szoveg'] != '') {
                            $insertChapterQuery = array();
                            $insertChapterQuery['sql'] = "INSERT INTO text SET
                                SuperiorId = :superiorId, 
                                Type = :type, 
                                Title = :title, 
                                Text = :text, 
                                Language = :language, 
                                Created = NOW(), 
                                CreatedBy = :createdBy, 
                                Active = 1";
                            $szovegek["Cim"] = "";
                            $insertChapterQuery["parameters"][0] = array("paramName"=>"superiorId", "paramVal"=>$szovegek["FelettesId"], "paramType"=>PDO::PARAM_INT);
                            $insertChapterQuery["parameters"][1] = array("paramName"=>"type", "paramVal"=>$szovegek["Tipus"], "paramType"=>PDO::PARAM_INT);
                            $insertChapterQuery["parameters"][2] = array("paramName"=>"title", "paramVal"=>$szovegek["Cim"], "paramType"=>PDO::PARAM_STR);
                            $insertChapterQuery["parameters"][3] = array("paramName"=>"text", "paramVal"=>$szovegek["Szoveg"], "paramType"=>PDO::PARAM_STR);
                            $insertChapterQuery["parameters"][4] = array("paramName"=>"language", "paramVal"=>$szovegek["Nyelv"], "paramType"=>PDO::PARAM_STR);
                            $insertChapterQuery["parameters"][5] = array("paramName"=>"createdBy", "paramVal"=>$_SESSION['admin']['userData']['UserId'], "paramType"=>PDO::PARAM_INT);
                            $result = $this->db->parameterInsert($insertChapterQuery);
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
                        $szovegek["Cim"] = "";
                        $updateChapterQuery["parameters"][0] = array("paramName"=>"textId", "paramVal"=>$szovegek["SzovegId"], "paramType"=>PDO::PARAM_INT);
                        $updateChapterQuery["parameters"][1] = array("paramName"=>"superiorId", "paramVal"=>$szovegek["FelettesId"], "paramType"=>PDO::PARAM_INT);
                        $updateChapterQuery["parameters"][2] = array("paramName"=>"type", "paramVal"=>$szovegek["Tipus"], "paramType"=>PDO::PARAM_INT);
                        $updateChapterQuery["parameters"][3] = array("paramName"=>"title", "paramVal"=>$szovegek["Cim"], "paramType"=>PDO::PARAM_STR);
                        $updateChapterQuery["parameters"][4] = array("paramName"=>"text", "paramVal"=>$szovegek["Szoveg"], "paramType"=>PDO::PARAM_STR);
                        $updateChapterQuery["parameters"][5] = array("paramName"=>"language", "paramVal"=>$szovegek["Nyelv"], "paramType"=>PDO::PARAM_STR);
                        $updateChapterQuery["parameters"][6] = array("paramName"=>"modifiedBy", "paramVal"=>$_SESSION['admin']['userData']['UserId'], "paramType"=>PDO::PARAM_INT);
                        $result = $this->db->parameterUpdate($updateChapterQuery);
                        break;
                }
            }
            $data["good"] = $szovegek["FelettesId"];
            print json_encode($data);            
        } catch (PDOException $e) {
            $this->db->logWriter($e->errorInfo);
        }
    }
}
