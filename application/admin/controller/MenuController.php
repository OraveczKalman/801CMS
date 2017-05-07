<?php
include_once(ADMIN_MODEL_PATH . 'MenuModel.php');

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
        $roleDataArray['where'] = $this->dataArray[0]['MenuRoleWhere'];

        $menu = new MenuModel($this->db, $roleDataArray);
        $menu_roles = $menu->getMenuRoles();
        return $menu_roles;
    }

    private function ValidateMenuFormFull() {
        include_once(CORE_PATH . 'Validator.php');
        $validateInfo = array();
        $validateInfo[] = array('function'=>'validateText', 'data'=>$_POST['Felirat'], 'controllId'=>'Felirat');
        $validateInfo[] = array('function'=>'validateText', 'data'=>$_POST['Cim'], 'controllId'=>'Cim');
        $validateInfo[] = array('function'=>'validateText', 'data'=>$_POST['Cimsor'], 'controllId'=>'Cimsor');
        $validateInfo[] = array('function'=>'validateText', 'data'=>$_POST['Kulcsszavak'], 'controllId'=>'Kulcsszavak');
        $validateInfo[] = array('function'=>'validateText', 'data'=>$_POST['Link'], 'controllId'=>'Link');
        $validateInfo[] = array('function'=>'validateText', 'data'=>$_POST['Target'], 'controllId'=>'Target');
        $validateInfo[] = array('function'=>'validateText', 'data'=>$_POST['Nyelv'], 'controllId'=>'Nyelv');
        $validateInfo[] = array('function'=>'validateText', 'data'=>$_POST['Module'], 'controllId'=>'Module');       
        $validateInfo[] = array('function'=>'validateInt', 'data'=>$_POST['Szerep'], 'controllId'=>'Szerep');
        $validateInfo[] = array('function'=>'validateInt', 'data'=>$_POST['ParentId'], 'controllId'=>'ParentId');
        $validateInfo[] = array('function'=>'validateInt', 'data'=>$_POST['MoreFlag'], 'controllId'=>'MoreFlag');
        if (isset($_POST['MainPage'])) {
            $validateInfo[] = array('function'=>'validateInt', 'data'=>$_POST['MainPage'], 'controllId'=>'MainPage');
        }
        if (isset($_POST['Kommentezheto'])) {
            $validateInfo[] = array('function'=>'validateInt', 'data'=>$_POST['Kommentezheto'], 'controllId'=>'Kommentezheto');
        }
        if (isset($_POST['User_In'])) {
            $validateInfo[] = array('function'=>'validateInt', 'data'=>$_POST['User_In'], 'controllId'=>'User_In');
        }
        if (isset($_POST['Slider'])) {
            $validateInfo[] = array('function'=>'validateInt', 'data'=>$_POST['Slider'], 'controllId'=>'Slider');
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
        $validateInfo[] = array('function'=>$_POST['function'], 'data'=>$_POST['data'], 'controllId'=>$_POST['controllId']);
        $validator = new mainValidator($validateInfo);
        $errorArray = $validator -> validateCore();
        if (!empty($errorArray)) {
            print json_encode($errorArray);
        }
    }

    private function getArtistData() {
        $artist = new Artist_Model(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);
        $artistData = $artist -> getArtistsMenu(array('where' => 'menu_artist.Menu_Id = ' . $this->dataArray['getVars']['menu_id'] . ' AND menu_artist.Active = 1'));
        return $artistData;       
    }
    
    private function getGenreData() {
        $genre = new Genre_Model(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);
        $genreData = $genre -> getGenresMenu(array('where' => 'menu_genre.Menu_Id = ' . $this->dataArray['getVars']['menu_id'] . ' AND menu_artist.Active = 1'));
        return $genreData;
    }
        
    private function newMenuForm() {
        $moduleDataArray = array();
        $moduleDataArray['table'] = 'main_header';
        $moduleDataArray['fields'] = 'main_header.Title, main_header.Link';
        $moduleDataArray['where'] = 'main_header.MainHeaderId NOT IN (SELECT MainHeaderId FROM Rank)';
        $menu = new MenuModel( $this->db, $moduleDataArray);
        $moduleList = $menu->getMenu();     
        if (!isset($this->dataArray[0]['ParentRole'])) {
            $this->dataArray[0]['ParentRole'] = 0;
        }
        if (!isset($_REQUEST['ParentId'])) {
            $_REQUEST['ParentId'] = 0;
        }     
        switch ($this->dataArray[0]['ParentRole']) {
            case 2:
                $this->dataArray[0]['MenuRoleWhere'] = 'WHERE role.RoleId = 3';
                break;
            case 5:
                $this->dataArray[0]['MenuRoleWhere'] = 'WHERE role.RoleId = 4';
                break;
            case 15:
                $this->dataArray[0]['MenuRoleWhere'] = 'WHERE role.RoleId = 3';
                break;
            default:
                $this->dataArray[0]['MenuRoleWhere'] = '';
                break;
        }

        $menuRoles = $this -> GetMenuRoleData();
        $menuJson = json_decode(file_get_contents(ADMIN_RESOURCE_PATH . '/lang/NewMenuFormHu.json'));
        include_once(ADMIN_VIEW_PATH . 'MenuForm.php');
    }
        
    private function newMenu() {
        $errors = $this->ValidateMenuFormFull();
        if ($errors == '') {
            $menuDataArray = array();
            $menuDataArray['Caption'] = $_POST['Felirat'];
            $menuDataArray['Title'] = $_POST['Cim'];
            $menuDataArray['Heading'] = $_POST['Cimsor'];
            $menuDataArray['Keywords'] = $_POST['Kulcsszavak'];
            $menuDataArray['Link'] = $_POST['Link'];
            $menuDataArray['Target'] = $_POST['Target'];
            if (isset($_POST['MainPage'])) {
                $menuDataArray['MainPage'] = $_POST['MainPage'];
            } else if (!isset($_POST['MainPage'])) { 
                $menuDataArray['MainPage'] = 0;
            }
            $menuDataArray['Language'] = $_POST['Nyelv'];
            if (isset($_POST['Kommentezheto'])) {        
                $menuDataArray['Commentable'] = $_POST['Kommentezheto'];
            } else if (!isset($_POST['Kommentezheto'])) {
                $menuDataArray['Commentable'] = 0;
            }
            if (isset($_POST['User_In'])) {
                $menuDataArray['UserIn'] = $_POST['User_In'];
            } else if (!isset($_POST['User_In'])) {
                $menuDataArray['UserIn'] = 0;
            }
            if (isset($_POST['Szerep'])) {
                $menuDataArray['Role'] = $_POST['Szerep'];
            }
            $menuDataArray['AdditionalField'] = 'NULL';
            if ($_POST['Szerep'] == 4) {
                $menuDataArray['AdditionalField'] = $_POST['GalleryType'];
            }
            if ($_POST['Szerep'] == 6) {
                $tableJson = '{';
                $tableJson .= '"Tabellakod":"' . $_POST['Tabellakod'] . '",';
                $tableJson .= '"Csapatszam":"' . $_POST['Csapatszam'] . '",';
                $tableJson .= '"Fejszoveg":"' . $_POST['Fejszoveg'] . '",';
                $tableJson .= '"Ideny":"' . $_POST['Ideny'] . '"';
                $tableJson .= '}';
                $menuDataArray['AdditionalField'] = $tableJson;
            }
            $menuDataArray['ParentId'] = $_POST['ParentId'];
            $menuDataArray['MainNode'] = $_POST['ParentNode'];
            $menuDataArray['MoreFlag'] = $_POST['MoreFlag'];
            if ($_POST['Module'] != '') {
                $menuDataArray['Module'] = $_POST['Module'];
            } else if ($_POST['Module'] == '') {
                $menuDataArray['Module'] = null;
            }
            $menuDataArray['Counter'] = 0;
            $menuDataArray['Popup'] = 0;
            $menuDataArray['Created'] = date('Y-m-d H:i:s');
            $menuDataArray['CreatedBy'] = $_SESSION['admin']['userData']['UserId'];
            $menuDataArray['Active'] = 1;
            $menu = new MenuModel($this->db, $menuDataArray);
            $menuData = $menu->insertMenu();
            if (isset($menuData['lastInsert'])) {
                if ($menuDataArray['Role'] == 7) {
                    include_once(CORE_PATH . 'UploadController.php');
                    include_once(ADMIN_MODEL_PATH . 'GalleryModel.php');
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
        $menuDataArray = array();
        $menuDataArray['table'] = 'main_header';
        $menuDataArray['fields'] = '*';
        $menuDataArray['joins'] = 'LEFT JOIN lang_header ON main_header.MainHeaderId = lang_header.MainHeaderId';
        $menuDataArray['where'] = 'main_header.MainHeaderId = ' . $_REQUEST['menuObject']['menuId'];
        $moduleDataArray = array();
        $moduleDataArray['table'] = 'main_header';
        $moduleDataArray['fields'] = 'main_header.Title, main_header.Link';
        $moduleDataArray['where'] = 'main_header.MainHeaderId NOT IN (SELECT MainHeaderId FROM lang_header)';
        $menu = new MenuModel($this->db, $menuDataArray);      
        $menuPointData = $menu->getMenu();
        $menu->setDataArray($moduleDataArray);
        $moduleList = $menu->getMenu();        
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
            case 7 :
                include_once(ADMIN_MODEL_PATH . 'GalleryModel.php');
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
        $menuJson = json_decode(file_get_contents(ADMIN_RESOURCE_PATH . '/lang/NewMenuFormHu.json'));
        include_once(ADMIN_VIEW_PATH . 'MenuForm.php');
    }

    private function updateMenu() {
        $errors = $this->ValidateMenuFormFull();      
        if ($errors == '') {
            $menuDataArray = array();
            $menuDataArray['Caption'] = $_POST['Felirat'];
            $menuDataArray['Title'] = $_POST['Cim'];
            $menuDataArray['Heading'] = $_POST['Cimsor'];
            $menuDataArray['Keywords'] = $_POST['Kulcsszavak'];
            $menuDataArray['Link'] = $_POST['Link'];
            $menuDataArray['Target'] = $_POST['Target'];
            if (isset($_POST['MainPage'])) {
                $menuDataArray['MainPage'] = $_POST['MainPage'];
            } else if (!isset($_POST['MainPage'])) { 
                $menuDataArray['MainPage'] = 0;
            }
            $menuDataArray['Language'] = $_POST['Nyelv'];
            if (isset($_POST['Kommentezheto'])) {        
                $menuDataArray['Commentable'] = $_POST['Kommentezheto'];
            } else if (!isset($_POST['Kommentezheto'])) {
                $menuDataArray['Commentable'] = 0;
            }
            if (isset($_POST['User_In'])) {
                $menuDataArray['UserIn'] = $_POST['User_In'];
            } else if (!isset($_POST['User_In'])) {
                $menuDataArray['UserIn'] = 0;
            }
            if (isset($_POST['Szerep'])) {
                $menuDataArray['Role'] = $_POST['Szerep'];
            }
            $menuDataArray['AdditionalField'] = 'NULL';
            if ($_POST['Szerep'] == 4) {
                $menuDataArray['AdditionalField'] = $_POST['GalleryType'];
            }           
            if ($_POST['Szerep'] == 6) {
                $tableJson = '{';
                $tableJson .= '"Tabellakod":"' . $_POST['Tabellakod'] . '",';
                $tableJson .= '"Csapatszam":"' . $_POST['Csapatszam'] . '",';
                $tableJson .= '"Fejszoveg":"' . $_POST['Fejszoveg'] . '",';
                $tableJson .= '"Ideny":"' . $_POST['Ideny'] . '"';
                $tableJson .= '}';
                $menuDataArray['AdditionalField'] = $tableJson;
            }
            $menuDataArray['ParentId'] = $_POST['ParentId'];
            $menuDataArray['MainNode'] = $_POST['ParentNode'];
            $menuDataArray['MoreFlag'] = $_POST['MoreFlag'];
            if ($_POST['Module'] != '') {
                $menuDataArray['Module'] = $_POST['Module'];
            } else if ($_POST['Module'] == '') {
                $menuDataArray['Module'] = null;
            }
            $menuDataArray['Popup'] = $_POST['popupHidden'];
            $menuDataArray['Active'] = 1;
            $menuDataArray['MainHeaderId'] = $_POST['MainHeaderId'];
            $menuDataArray['LangHeaderId'] = $_POST['LangHeaderId'];
            $menuDataArray['Rank'] = $_POST['RankHidden'];
            $menu = new MenuModel($this->db, $menuDataArray);
            $menuData = $menu->updateMenu();
            if ($menuData == true) {
                if ($menuDataArray['Role'] == 7 && !empty($_FILES)) {
                    include_once(CORE_PATH . 'UploadController.php');
                    include_once(ADMIN_MODEL_PATH . 'GalleryModel.php');
                    $oldFileData = explode('|', $_POST['oldFile']);
                    $deleteDataArray = array();
                    $deleteDataArray['MainHeaderId'] = $_POST['MainHeaderId'];
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
                            $uploadInsertArray['MainHeaderId'] = $_POST['MainHeaderId'];
                            $uploadInsertArray['mediaType'] = 5;
                            $uploadInsertArray['images'][0]['fileName'] = $uploadedFiles['successfulUpload'][0]['fileName'];
                            $mediaDataObject->setDataArray($uploadInsertArray);
                            $uploadInsert = $mediaDataObject->insertGalleryImages();
                        }
                    }
                }
                $retArray = array();
                $retArray['good']['menuId'] = $_POST['MainHeaderId'];
                $retArray['good']['parentId'] = $_POST['ParentId'];
                $retArray['good']['parentNode'] = $_POST['ParentNode'];
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
        $mainHeaderInfo['table'] = 'main_header';
        $mainHeaderInfo['fields'] = array('Active' => 0);
        $mainHeaderInfo['where'] = 'MainHeaderId = ' . $this->dataArray[0]['menuObject']['menuId'];
        $menu = new MenuModel($this->db, $mainHeaderInfo);
        $menuDelete = $menu->updateMainHeaderField();
        if (!isset($menuDelete['error'])) {
            $langHeaderInfo = array();
            $langHeaderInfo['table'] = 'lang_header';
            $langHeaderInfo['fields'] = array('Active' => 0);
            $langHeaderInfo['where'] = 'MainHeaderId = ' . $this->dataArray[0]['menuObject']['menuId'];
            $menu->setDataArray($langHeaderInfo);
            $langDelete = $menu->updateLangHeaderField();            
        }
    }

    public function rearrangeMenu() {
        $i = 1;
        foreach ($this -> dataArray['postVars']['rank'] as $ranks) {
            $rankInfo = array();
            $rankInfo['Rank'] = $i;
            $rankInfo['PointId'] = $ranks;
            $rankInfo['ParentId'] = $this->dataArray['postVars']['parent'];
            $menu = new Menu_Model($this->db, $rankInfo);
            $rankUpdate = $menu->UpdateRank();
            $i++;
        }	
    }
}
