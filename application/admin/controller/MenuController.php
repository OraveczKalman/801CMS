<?php
include_once(MODEL_PATH . 'MenuModel.php');

class MenuController {
    private $dataArray;
    private $db;

    public function __construct($dataArray, $db) {
        $this->dataArray = $dataArray;
        $this->db = $db;
        call_user_func(array($this, $this->dataArray[0]['event']));
    }

    public function setDataArray($dataArray) {
        $this->dataArray = $dataArray;
    }
    
    public function setDb($db) {
        $this->db = $db;
    }
    
    private function GetMenuRoleData() {
        $roleDataArray = array();
        $roleDataArray['roleId'] = $this->dataArray[0]['MenuRole'];

        $menu = new MenuModel($this->db, $roleDataArray);
        $menu_roles = $menu->getMenuRoles();
        return $menu_roles;
    }

    private function ValidateMenuFormFull() {
        include_once(CORE_PATH . 'Validator.php');
        $validateInfo = array(
            array('function'=>'validateText', 'data'=>$this->dataArray[0]['Caption'], 'controllId'=>'Caption'),
            array('function'=>'validateText', 'data'=>$this->dataArray[0]['Title'], 'controllId'=>'Title'),
            array('function'=>'validateText', 'data'=>$this->dataArray[0]['Heading'], 'controllId'=>'Heading'),
            array('function'=>'validateText', 'data'=>$this->dataArray[0]['Keywords'], 'controllId'=>'Keywords'),
            array('function'=>'validateText', 'data'=>$this->dataArray[0]['Link'], 'controllId'=>'Link'),
            array('function'=>'validateText', 'data'=>$this->dataArray[0]['Target'], 'controllId'=>'Target'),     
            array('function'=>'validateInt', 'data'=>$this->dataArray[0]['Role'], 'controllId'=>'Role'),
            array('function'=>'validateInt', 'data'=>$this->dataArray[0]['ParentId'], 'controllId'=>'ParentId'),
            array('function'=>'validateInt', 'data'=>$this->dataArray[0]['MoreFlag'], 'controllId'=>'MoreFlag')
        );
        if (isset($this->dataArray[0]['MainPage'])) {
            $validateInfo[] = array('function'=>'validateInt', 'data'=>$this->dataArray[0]['MainPage'], 'controllId'=>'MainPage');
        }
        if (isset($this->dataArray[0]['Commentable'])) {
            $validateInfo[] = array('function'=>'validateInt', 'data'=>$this->dataArray[0]['Commentable'], 'controllId'=>'Commentable');
        }
        if (isset($this->dataArray[0]['UserIn'])) {
            $validateInfo[] = array('function'=>'validateInt', 'data'=>$this->dataArray[0]['UserIn'], 'controllId'=>'UserIn');
        }
        if (isset($this->dataArray[0]['Slider'])) {
            $validateInfo[] = array('function'=>'validateInt', 'data'=>$this->dataArray[0]['Slider'], 'controllId'=>'Slider');
        }
        $validator = new mainValidator($validateInfo);
        $errorArray = $validator -> validateCore();
        if (empty($errorArray)) {
            return '';
        } else if (!empty($errorArray)) {
            return json_encode($errorArray);
        }
    }

    private function ValidateField() {
        include_once(CORE_PATH . 'Validator.php');
        $validateInfo = array();
        $validateInfo[] = array('function'=>$this->dataArray[0]['function'], 'data'=>$this->dataArray[0]['data'], 'controllId'=>$this->dataArray[0]['controllId']);
        $validator = new mainValidator($validateInfo);
        $errorArray = $validator -> validateCore();
        if (!empty($errorArray)) {
            print json_encode($errorArray);
        }
    }

    private function getArtistData() {
        $artist = new Artist_Model(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);
        $artistData = $artist->getArtistsMenu(array('where' => 'menu_artist.Menu_Id = ' . $this->dataArray['getVars']['menu_id'] . ' AND menu_artist.Active = 1'));
        return $artistData;       
    }
    
    private function getGenreData() {
        $genre = new Genre_Model(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);
        $genreData = $genre->getGenresMenu(array('where' => 'menu_genre.Menu_Id = ' . $this->dataArray['getVars']['menu_id'] . ' AND menu_artist.Active = 1'));
        return $genreData;
    }
        
    private function newMenuForm() {
        include_once(MODEL_PATH . 'LanguageModel.php');
        $menu = new MenuModel($this->db);
        $moduleList = $menu->getModules();
        $languageDataArray = array('where'=>' Active=1');
        $languageModel = new LanguageModel($this->db, $languageDataArray);
        $languages = $languageModel->getLanguage();
        if (!isset($this->dataArray[0]['menuObject']['parentRole'])) {
            $this->dataArray[0]['menuObject']['parentRole'] = 0;
        }
        if (!isset($_REQUEST['ParentId'])) {
            $_REQUEST['ParentId'] = 0;
        }
        switch ($this->dataArray[0]['menuObject']['parentRole']) {
            case 1:
                $this->dataArray[0]['MenuRole'] = 3;
                break;
            default:
                $this->dataArray[0]['MenuRole'] = null;
                break;
        }

        $menuRoles = $this -> GetMenuRoleData();
        $menuJson = json_decode(file_get_contents(ADMIN_RESOURCE_PATH . '/lang/' . $_SESSION['setupData']['languageSign'] . '/NewMenuForm.json'));
        include_once(ADMIN_VIEW_PATH . 'MenuForm.php');
    }
        
    private function newMenu() {
        $errors = $this->ValidateMenuFormFull();
        if ($errors == "") {
            $this->db->beginTran();
            include_once(MODEL_PATH . "MenuModel.php");
            
            if (!isset($this->dataArray[0]["Commentable"])) {
                $this->dataArray[0]["Commentable"] = 0;
            }
            if (!isset($this->dataArray[0]["UserIn"])) {
                $this->dataArray[0]["UserIn"] = 0;
            }
            $this->dataArray[0]["AdditionalField"] = null;
            switch ($this->dataArray[0]["Role"]) {
                case 4:
                    $this->dataArray[0]["AdditionalField"] = $this->dataArray[0]["GalleryType"];
                    break;
                case 5:
                    $this->dataArray[0]["AdditionalField"] = $this->tableData();
                    break;
            }
            $this->dataArray[0]["Counter"] = 0;
            $this->dataArray[0]["Popup"] = 0;
            $this->dataArray[0]["Created"] = date("Y-m-d H:i:s");
            $this->dataArray[0]["CreatedBy"] = $_SESSION["admin"]["userData"]["UserId"];
            $this->dataArray[0]["Active"] = 1;
            $menuModel = new MenuModel($this->db, $this->dataArray[0]);
            $result = $menuModel->insertMenu();
            if (isset($result["error"])) {
                $this->db->rollBack();
            } else {
                if (isset($result['lastInsert'])) {
                    switch ($this->dataArray[0]['Role']) {
                        case 3:
                            include_once(MODEL_PATH . "ArticleModel.php");
                            $newArticleDataArray = array();
                            $newArticleDataArray[0]["SuperiorId"] = $menuData["lastInsert"];
                            $newArticleDataArray[0]["Type"] = 1;
                            $newArticleDataArray[0]["Title"] = "";
                            $newArticleDataArray[0]["Text"] = "";
                            $newArticleDataArray[0]["Language"] = $this->dataArray[0]["Lang"][0];
                            $articleModel = new ArticleModel($this->db, $newArticleDataArray);
                            $articleResult = $articleModel->insertArticle();
                            break;
                        case 5:
                            include_once(CORE_PATH . 'UploadController.php');
                            include_once(MODEL_PATH . 'GalleryModel.php');
                            $uploadDataArray = array();
                            $uploadDataArray[0]['fileArrayName'] = 'Feltoltendo';
                            $uploadDataArray[0]['uploadPath'] = UPLOADED_MEDIA_PATH;
                            $uploadDataArray[0]['rename'] = 0;
                            $uploadObject = new UploadController($uploadDataArray);
                            $uploadedFiles = $uploadObject->uploadFiles();
                            if (!empty($uploadedFiles['successfulUpload'])) {
                                $uploadInsertArray = array();
                                $uploadInsertArray['MainHeaderId'] = $menuData['lastInsert'];
                                $uploadInsertArray['mediaType'] = 5;
                                $uploadInsertArray['images'][0]['fileName'] = $uploadedFiles['successfulUpload'][0]['fileName'];
                                $uploadInsertObject = new GalleryModel($this->db, $uploadInsertArray);
                                $uploadInsert = $uploadInsertObject->insertGalleryImages();
                            }
                            break;
                    }                
                    $this->db->commit();
                }
            }
        } else {
            
        }
    }

    private function editMenuForm() {
        include_once(MODEL_PATH . 'LanguageModel.php');
        $languageDataArray = array('where'=>' Active=1');
        $languageModel = new LanguageModel($this->db, $languageDataArray);
        $languages = $languageModel->getLanguage();
        $menu = new MenuModel($this->db);      
        $menuPointData = $menu->getMenu($this->dataArray[0]['menuObject']['menuId']);
        //var_dump($menuPointData);
        $moduleList = $menu->getModules();        
        switch ($menuPointData[0]['Role']) {
            case 3 :
                include_once(ADMIN_CONTROLLER_PATH . 'ArticleController.php');
                include_once(ADMIN_CONTROLLER_PATH . 'GalleryController.php');
                $controllerCollection = array();
                $controllerCollection[0] = 'Article';
                $controllerCollection[1] = 'Gallery';
                break;
            case 4 :
                include_once(ADMIN_CONTROLLER_PATH . 'GalleryController.php');
                $controllerCollection = array();
                $controllerCollection[0] = 'Gallery';
                break;
            case 5 :
                include_once(MODEL_PATH . 'GalleryModel.php');
                $fileDataArray = array();
                $fileDataArray['table'] = 'gallery_picture';
                $fileDataArray['fields'] = 'picture.PictureId, picture.Name';
                $fileDataArray['joins'] = 'LEFT JOIN picture ON gallery_picture.PictureId = picture.PictureId';
                $fileDataArray['where'] = 'gallery_picture.MainHeaderId = ' . $menuPointData[0]['MainHeaderId'];
                $fileObject = new GalleryModel($this->db, $fileDataArray);
                $file = $fileObject->getPicture();
                $menuPointData[0]['FileName'] =  $file[0]['PictureId'] . '|' . $file[0]['Name'];
                break;
        }
        $menuJson = json_decode(file_get_contents(ADMIN_RESOURCE_PATH . '/lang/' . $_SESSION['setupData']['languageSign'] . '/NewMenuForm.json'));
        include_once(ADMIN_VIEW_PATH . 'MenuForm.php');
    }

    private function updateMenu() {
        $errors = $this->ValidateMenuFormFull();
        if ($errors == "") {

        } else {
            
        }
    }

    public function deleteMenu() {
        $mainHeaderInfo = array();

        $mainHeaderInfo['fields'] = array('Active' => 0);
        $mainHeaderInfo['MainHeaderId'] = $this->dataArray[0]['menuObject']['menuId'];
        $menu = new MenuModel($this->db, $mainHeaderInfo);
        $menuDelete = $menu->deleteMenu();
    }

    private function tableData() {
        $tableJson = '{';
        $tableJson .= '"Tabellakod":"' . $this->dataArray[0]['Tabellakod'] . '",';
        $tableJson .= '"Csapatszam":"' . $this->dataArray[0]['Csapatszam'] . '",';
        $tableJson .= '"Fejszoveg":"' . $this->dataArray[0]['Fejszoveg'] . '",';
        $tableJson .= '"Ideny":"' . $this->dataArray[0]['Ideny'] . '"';
        $tableJson .= '}';
        return $tableJson;  
    } 
    
    public function rearrangeMenu() {
        $i = 1;
        foreach ($this -> dataArray['postVars']['rank'] as $ranks) {
            $rankInfo = array();
            $rankInfo['Rank'] = $i;
            $rankInfo['PointId'] = $ranks;
            $rankInfo['ParentId'] = $this->dataArray['postVars']['parent'];
            $menu = new MenuModel($this->db, $rankInfo);
            $rankUpdate = $menu->UpdateRank();
            $i++;
        }	
    }
}
