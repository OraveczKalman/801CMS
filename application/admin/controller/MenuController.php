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
        $validateInfo = array();
        $validateInfo[] = array('function'=>'validateText', 'data'=>$this->dataArray[0]['Felirat'], 'controllId'=>'Felirat');
        $validateInfo[] = array('function'=>'validateText', 'data'=>$this->dataArray[0]['Cim'], 'controllId'=>'Cim');
        $validateInfo[] = array('function'=>'validateText', 'data'=>$this->dataArray[0]['Cimsor'], 'controllId'=>'Cimsor');
        $validateInfo[] = array('function'=>'validateText', 'data'=>$this->dataArray[0]['Kulcsszavak'], 'controllId'=>'Kulcsszavak');
        $validateInfo[] = array('function'=>'validateText', 'data'=>$this->dataArray[0]['Link'], 'controllId'=>'Link');
        $validateInfo[] = array('function'=>'validateText', 'data'=>$this->dataArray[0]['Target'], 'controllId'=>'Target');
        $validateInfo[] = array('function'=>'validateText', 'data'=>$this->dataArray[0]['Nyelv'], 'controllId'=>'Nyelv');      
        $validateInfo[] = array('function'=>'validateInt', 'data'=>$this->dataArray[0]['Szerep'], 'controllId'=>'Szerep');
        $validateInfo[] = array('function'=>'validateInt', 'data'=>$this->dataArray[0]['ParentId'], 'controllId'=>'ParentId');
        $validateInfo[] = array('function'=>'validateInt', 'data'=>$this->dataArray[0]['MoreFlag'], 'controllId'=>'MoreFlag');
        if (isset($this->dataArray[0]['MainPage'])) {
            $validateInfo[] = array('function'=>'validateInt', 'data'=>$this->dataArray[0]['MainPage'], 'controllId'=>'MainPage');
        }
        if (isset($this->dataArray[0]['Kommentezheto'])) {
            $validateInfo[] = array('function'=>'validateInt', 'data'=>$this->dataArray[0]['Kommentezheto'], 'controllId'=>'Kommentezheto');
        }
        if (isset($this->dataArray[0]['User_In'])) {
            $validateInfo[] = array('function'=>'validateInt', 'data'=>$this->dataArray[0]['User_In'], 'controllId'=>'User_In');
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
        if ($errors == '') {
            $menuDataArray = array();
            $menuDataArray['Caption'] = $this->dataArray[0]['Felirat'];
            $menuDataArray['Title'] = $this->dataArray[0]['Cim'];
            $menuDataArray['Heading'] = $this->dataArray[0]['Cimsor'];
            $menuDataArray['Keywords'] = $this->dataArray[0]['Kulcsszavak'];
            $menuDataArray['Link'] = $this->dataArray[0]['Link'];
            if ($this->dataArray[0]['Target'] != '') {
                $menuDataArray['Target'] = $this->dataArray[0]['Target'];
            } else {
                $menuDataArray['Target'] = null;
            }
            if (isset($this->dataArray[0]['MainPage'])) {
                $menuDataArray['MainPage'] = $this->dataArray[0]['MainPage'];
            } else if (!isset($this->dataArray[0]['MainPage'])) { 
                $menuDataArray['MainPage'] = 0;
            }
            $menuDataArray['Language'] = $this->dataArray[0]['Nyelv'];
            if (isset($this->dataArray[0]['Kommentezheto'])) {        
                $menuDataArray['Commentable'] = $this->dataArray[0]['Kommentezheto'];
            } else if (!isset($this->dataArray[0]['Kommentezheto'])) {
                $menuDataArray['Commentable'] = 0;
            }
            if (isset($this->dataArray[0]['User_In'])) {
                $menuDataArray['UserIn'] = $this->dataArray[0]['User_In'];
            } else if (!isset($this->dataArray[0]['User_In'])) {
                $menuDataArray['UserIn'] = 0;
            }
            $menuDataArray['AdditionalField'] = null;
            if (isset($this->dataArray[0]['Szerep'])) {
                $menuDataArray['Role'] = $this->dataArray[0]['Szerep'];
                switch ($menuDataArray['Role']) {
                    case 4:
                        $menuDataArray['AdditionalField'] = $this->dataArray[0]['GalleryType'];
                        break;
                    case 6:
                        $tableJson = '{';
                        $tableJson .= '"Tabellakod":"' . $this->dataArray[0]['Tabellakod'] . '",';
                        $tableJson .= '"Csapatszam":"' . $this->dataArray[0]['Csapatszam'] . '",';
                        $tableJson .= '"Fejszoveg":"' . $this->dataArray[0]['Fejszoveg'] . '",';
                        $tableJson .= '"Ideny":"' . $this->dataArray[0]['Ideny'] . '"';
                        $tableJson .= '}';
                        $menuDataArray['AdditionalField'] = $tableJson;                        
                        break;
                }
            }
            $menuDataArray['ParentId'] = $this->dataArray[0]['ParentId'];
            $menuDataArray['MainNode'] = $this->dataArray[0]['ParentNode'];
            $menuDataArray['MoreFlag'] = $this->dataArray[0]['MoreFlag'];       

            $menuDataArray['Counter'] = 0;
            $menuDataArray['Popup'] = 0;
            $menuDataArray['Created'] = date('Y-m-d H:i:s');
            $menuDataArray['CreatedBy'] = $_SESSION['admin']['userData']['UserId'];
            $menuDataArray['Active'] = 1;
            $menu = new MenuModel($this->db, $menuDataArray);
            $menuData = $menu->insertMenu();
            if (isset($menuData['lastInsert'])) {
                switch ($menuDataArray['Role']) {
                    case 3:
                        include_once(MODEL_PATH . "ArticleModel.php");
                        $newArticleDataArray = array();
                        $newArticleDataArray[0]["SuperiorId"] = $menuData["lastInsert"];
                        $newArticleDataArray[0]["Type"] = 1;
                        $newArticleDataArray[0]["Title"] = "";
                        $newArticleDataArray[0]["Text"] = "";
                        $newArticleDataArray[0]["Language"] = $menuDataArray['Language'];
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
                $retArray = array();
                $retArray['good']['menuId'] = $menuData['lastInsert'];
                $retArray['good']['parentId'] = $menuDataArray['ParentId'];
                $retArray['good']['parentNode'] = $menuDataArray['MainNode'];
                $retArray['good']['role'] = $menuDataArray['Role'];
                print json_encode($retArray);
            }     
        } else {
            print $errors;
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
        if ($errors == '') {
            $menuDataArray = array();
            $menuDataArray['Caption'] = $this->dataArray[0]['Felirat'];
            $menuDataArray['Title'] = $this->dataArray[0]['Cim'];
            $menuDataArray['Heading'] = $this->dataArray[0]['Cimsor'];
            $menuDataArray['Keywords'] = $this->dataArray[0]['Kulcsszavak'];
            $menuDataArray['Link'] = $this->dataArray[0]['Link'];
            $menuDataArray['Target'] = $this->dataArray[0]['Target'];
            if (isset($this->dataArray[0]['MainPage'])) {
                $menuDataArray['MainPage'] = $this->dataArray[0]['MainPage'];
            } else if (!isset($this->dataArray[0]['MainPage'])) { 
                $menuDataArray['MainPage'] = 0;
            }
            $menuDataArray['Language'] = $this->dataArray[0]['Nyelv'];
            if (isset($this->dataArray[0]['Kommentezheto'])) {        
                $menuDataArray['Commentable'] = $this->dataArray[0]['Kommentezheto'];
            } else if (!isset($this->dataArray[0]['Kommentezheto'])) {
                $menuDataArray['Commentable'] = 0;
            }
            if (isset($this->dataArray[0]['User_In'])) {
                $menuDataArray['UserIn'] = $this->dataArray[0]['User_In'];
            } else if (!isset($this->dataArray[0]['User_In'])) {
                $menuDataArray['UserIn'] = 0;
            }
            $menuDataArray['AdditionalField'] = 'NULL';
            if (isset($this->dataArray[0]['Szerep'])) {
                $menuDataArray['Role'] = $this->dataArray[0]['Szerep'];
                switch ($menuDataArray['Role']) {
                    case 3:
                        $menuDataArray['AdditionalField'] = $this->dataArray[0]['GalleryType'];
                        break;
                    case 4:
                        $tableJson = '{';
                        $tableJson .= '"Tabellakod":"' . $this->dataArray[0]['Tabellakod'] . '",';
                        $tableJson .= '"Csapatszam":"' . $this->dataArray[0]['Csapatszam'] . '",';
                        $tableJson .= '"Fejszoveg":"' . $this->dataArray[0]['Fejszoveg'] . '",';
                        $tableJson .= '"Ideny":"' . $this->dataArray[0]['Ideny'] . '"';
                        $tableJson .= '}';
                        $menuDataArray['AdditionalField'] = $tableJson;                        
                        break;
                }
            }
            $menuDataArray['ParentId'] = $this->dataArray[0]['ParentId'];
            $menuDataArray['MainNode'] = $this->dataArray[0]['ParentNode'];
            $menuDataArray['MoreFlag'] = $this->dataArray[0]['MoreFlag'];
            $menuDataArray['Popup'] = $this->dataArray[0]['popupHidden'];
            $menuDataArray['Active'] = 1;
            $menuDataArray['MainHeaderId'] = $this->dataArray[0]['MainHeaderId'];
            $menuDataArray['LangHeaderId'] = $this->dataArray[0]['LangHeaderId'];
            $menuDataArray['Rank'] = $this->dataArray[0]['RankHidden'];
            $menu = new MenuModel($this->db, $menuDataArray);
            $menuData = $menu->updateMenu();
            if ($menuData == true) {
                if ($menuDataArray['Role'] == 7 && !empty($_FILES)) {
                    include_once(CORE_PATH . 'UploadController.php');
                    include_once(MODEL_PATH . 'GalleryModel.php');
                    $oldFileData = explode('|', $this->dataArray[0]['oldFile']);
                    $deleteDataArray = array();
                    $deleteDataArray['MainHeaderId'] = $this->dataArray[0]['MainHeaderId'];
                    $deleteDataArray['PictureId'] = $oldFileData[0];
                    $mediaDataObject = new GalleryModel($deleteDataArray, $this->db);
                    $deleteSuccess = $mediaDataObject->deleteFromGallery();
                    if (!isset($deleteSuccess['error'])) {
                        unlink(UPLOADED_MEDIA_PATH . $oldFileData[1]);
                        $uploadDataArray = array();
                        $uploadDataArray[0]['fileArrayName'] = 'Feltoltendo';
                        $uploadDataArray[0]['uploadPath'] = UPLOADED_MEDIA_PATH;
                        $uploadDataArray[0]['rename'] = 0;
                        $uploadObject = new UploadController($uploadDataArray);
                        $uploadedFiles = $uploadObject->uploadFiles();
                        if (!empty($uploadedFiles['successfulUpload'])) {
                            $uploadInsertArray = array();
                            $uploadInsertArray['MainHeaderId'] = $this->dataArray[0]['MainHeaderId'];
                            $uploadInsertArray['mediaType'] = 5;
                            $uploadInsertArray['images'][0]['fileName'] = $uploadedFiles['successfulUpload'][0]['fileName'];
                            $mediaDataObject->setDataArray($uploadInsertArray);
                            $uploadInsert = $mediaDataObject->insertGalleryImages();
                        }
                    }
                }
                $retArray = array();
                $retArray['good']['menuId'] = $this->dataArray[0]['MainHeaderId'];
                $retArray['good']['parentId'] = $this->dataArray[0]['ParentId'];
                $retArray['good']['parentNode'] = $this->dataArray[0]['ParentNode'];
                $retArray['good']['role'] = $menuDataArray['Role'];
                print json_encode($retArray);
            }
        } else {
            print $errors;
        }
    }

    public function deleteMenu() {
        //var_dump('xxx');
        $mainHeaderInfo = array();

        $mainHeaderInfo['fields'] = array('Active' => 0);
        $mainHeaderInfo['MainHeaderId'] = $this->dataArray[0]['menuObject']['menuId'];
        $menu = new MenuModel($this->db, $mainHeaderInfo);
        $menuDelete = $menu->deleteMenu();
        /*if (!isset($menuDelete['error'])) {
            $langHeaderInfo = array();
            $langHeaderInfo['table'] = 'lang_header';
            $langHeaderInfo['fields'] = array('Active' => 0);
            $langHeaderInfo['where'] = 'MainHeaderId = ' . $this->dataArray[0]['menuObject']['menuId'];
            $menu->setDataArray($langHeaderInfo);
            $langDelete = $menu->deleteLangHeader();            
        }*/
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
