<?php
include_once(CORE_PATH . 'AncestorClass.php');
class ArticleModel extends AncestorClass {
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

    public function getDocumentArticles() {
        $articlesArray = array();
        $articlesArray['table'] = 'text';
        $articlesArray['fields'] = 'text.*';
        $articlesArray['where'] = 'text.SuperiorId = ' . $this->dataArray['MainHeaderId'] . ' AND text.Type = ' . $this->dataArray['Role'];
        $getDocumentArticlesQuery = $this->db->selectBuilder($articlesArray);
        return $getDocumentArticlesQuery;
    }

    public function chapterAssorter() {
        $insertChapterQueryString = "INSERT INTO text(SuperiorId, Type, Title, Text, Language, Created, CreatedBy, Modified, ModifiedBy, Active) VALUES ";
        $insertChapterQueryStringValues = '';
        $updateChapterQueryString = "";
        foreach ($this->dataArray[0]['cikk'] as $szovegek) {
            switch ($szovegek['chapterState']) {
                case 1 :
                    if ($szovegek['Szoveg'] != '') {
                        $insertChapterQueryStringValues .= "(" . $szovegek['FelettesId'] . ", "
                            . $szovegek['Tipus'] . ", '"
                            . "', '"
                            . $szovegek['Szoveg'] . "', '"
                            . $szovegek['Nyelv'] . "', "
                            . "NOW(), "
                            . $_SESSION['admin']['userData']['UserId'] . ", "
                            . "NOW(), "
                            . $_SESSION['admin']['userData']['UserId'] . ", 1), ";
                    }
                    break;
                case 2 :
                    $updateChapterQueryString .= "UPDATE text SET 
                        SuperiorId = " . $szovegek['FelettesId'] . ", 
                        Type = " . $szovegek['Tipus'] . ", 
                        Text = '" . $szovegek['Szoveg'] . "', 
                        Language = '" . $szovegek['Nyelv'] . "', 
                        Modified = NOW(), 
                        ModifiedBy = " . $_SESSION['admin']['userData']['UserId'] . " 
                        WHERE TextId = " . $szovegek['SzovegId'] . ";";
                    break;
            }
        }

        if ($insertChapterQueryStringValues != '') {
            $insertChapterQueryString = trim($insertChapterQueryString . $insertChapterQueryStringValues, ', ');
            $insertChapterQuery = $this->db->insertQuery($insertChapterQueryString);
        }
        if ($updateChapterQueryString != '') {
            $updateChapterQuery = $this->db->updateQuery($updateChapterQueryString);
        }

        if (!isset($insertChapterQuery['error']) && !isset($updateChapterQuery['error'])) {
            print json_encode($goodArray = array('good'=>$this->dataArray[0]['cikk'][0]['FelettesId']));
        } else {
            print json_encode($errorArray = array('error'=>$insertChapterQuery['error'] . ' ' . $updateChapterQuery['error']));
        }
    }
}