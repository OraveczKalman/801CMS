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
        $articlesArray = array();
        $articlesArray['table'] = 'text';
        $articlesArray['fields'] = 'text.*';
        $articlesArray['where'] = 'text.SuperiorId = ' . $this->dataArray['MainHeaderId'] . ' AND text.Type = ' . $this->dataArray['Role'];
        $getDocumentArticlesQuery = $this->db->selectBuilder($articlesArray);
        return $getDocumentArticlesQuery;
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
                            $insertChapterQuery = $this->db->dbLink->prepare("INSERT INTO text SET
                                SuperiorId = :superiorId, 
                                Type = :type, 
                                Title = :title, 
                                Text = :text, 
                                Language = :language, 
                                Created = NOW(), 
                                CreatedBy = :createdBy, 
                                Modified = NOW(), 
                                ModifiedBy = :modifiedBy, 
                                Active = 1");
                            $szovegek["Cim"] = "";
                            $insertChapterQuery->bindParam(":superiorId", $szovegek["FelettesId"], PDO::PARAM_INT);
                            $insertChapterQuery->bindParam(":type", $szovegek["Tipus"], PDO::PARAM_INT);
                            $insertChapterQuery->bindParam(":title", $szovegek["Cim"], PDO::PARAM_STR);
                            $insertChapterQuery->bindParam(":text", $szovegek["Szoveg"], PDO::PARAM_STR);
                            $insertChapterQuery->bindParam(":language", $szovegek["Nyelv"], PDO::PARAM_STR);
                            $insertChapterQuery->bindParam(":createdBy", $_SESSION['admin']['userData']['UserId'], PDO::PARAM_INT);
                            $insertChapterQuery->bindParam(":modifiedBy", $_SESSION['admin']['userData']['UserId'], PDO::PARAM_INT);
                            $insertChapterQuery->execute();
                        }
                        break;
                    case 2 :
                        $updateChapterQuery = $this->db->dbLink->prepare("UPDATE text SET 
                            SuperiorId = :superiorId, 
                            Type = :type, 
                            Title = :title, 
                            Text = :text, 
                            Language = :language, 
                            Created = NOW(), 
                            CreatedBy = :createdBy, 
                            Modified = NOW(), 
                            ModifiedBy = :modifiedBy 
                            WHERE TextId = :textId");
                        $szovegek["Cim"] = "";
                        $updateChapterQuery->bindParam(":textId", $szovegek["SzovegId"], PDO::PARAM_INT);
                        $updateChapterQuery->bindParam(":superiorId", $szovegek["FelettesId"], PDO::PARAM_INT);
                        $updateChapterQuery->bindParam(":type", $szovegek["Tipus"], PDO::PARAM_INT);
                        $updateChapterQuery->bindParam(":title", $szovegek["Cim"], PDO::PARAM_STR);
                        $updateChapterQuery->bindParam(":text", $szovegek["Szoveg"], PDO::PARAM_STR);
                        $updateChapterQuery->bindParam(":language", $szovegek["Nyelv"], PDO::PARAM_STR);
                        $updateChapterQuery->bindParam(":createdBy", $_SESSION['admin']['userData']['UserId'], PDO::PARAM_INT);
                        $updateChapterQuery->bindParam(":modifiedBy", $_SESSION['admin']['userData']['UserId'], PDO::PARAM_INT);
                        $updateChapterQuery->execute();
                        break;
                }
            }
            $data["good"] = 0;
            print json_encode($data);            
        } catch (PDOException $e) {
            $this->db->logWriter($e->errorInfo);
        }
    }
}
