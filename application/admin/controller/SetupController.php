<?php
include_once(MODEL_PATH . 'SetupFormModel.php');

class SetupController {
    private $dataArray;
    private $db;

    public function __construct($dataArray, $db) {
        $this->dataArray = $dataArray;
        $this->db = $db;
        if (!isset($this->dataArray[0]['event'])) {
            $this->dataArray[0]['event'] = 'RenderSetupForm';
        }
        call_user_func(array($this, $this->dataArray[0]['event']));
    }

    private function RenderSetupForm() {
        $setupLabels = json_decode(file_get_contents(ADMIN_RESOURCE_PATH . 'lang/' . $_SESSION['setupData']['languageSign'] . '/SetupForm.json'));
        $setupDataArray = array();
        $setupDataArray['setupId'] = 1;
        $setup = new SetupFormModel($this->db, $setupDataArray);
        $setupData = $setup -> getSetupData();
        if (!empty($setupData)) {
            $setupData = json_decode($setupData[0]['SetupData']);
        } else {
            unset($setupData);
        }
        include_once(ADMIN_VIEW_PATH . 'SetupFormView.php');
    }

    private function SaveSetupForm() {
        $errors = $this->ValidateSetupFormFull();
        if ($errors == '') {
            
            $setupData['id'] = 1;

            $setupJson = '{';
            $setupJson .= '"galleryThumb":{"width":"' . $_POST['setup']['galleryThumb']['width'] . '","height":"' . $_POST['setup']['galleryThumb']['height'] . '"},';
            $setupJson .= '"galleryPic":{"width":"' . $_POST['setup']['galleryPic']['width'] . '","height":"' . $_POST['setup']['galleryPic']['height'] . '"},';
            $setupJson .= '"galleryHeader":{"width":"' . $_POST['setup']['galleryHeader']['width'] . '","height":"' . $_POST['setup']['galleryHeader']['height'] . '"},';
            $setupJson .= '"articleThumb":{"width":"' . $_POST['setup']['articleThumb']['width'] . '","height":"' . $_POST['setup']['articleThumb']['height'] . '"},';
            $setupJson .= '"articlePic":{"width":"' . $_POST['setup']['articlePic']['width'] . '","height":"' . $_POST['setup']['articlePic']['height'] . '"},';
            $setupJson .= '"articleHeader":{"width":"' . $_POST['setup']['articleHeader']['width'] . '","height":"' . $_POST['setup']['articleHeader']['height'] . '"},';
            $setupJson .= '"ytPlayer":{"width":"' . $_POST['setup']['ytPlayer']['width'] . '","height":"' . $_POST['setup']['ytPlayer']['height'] . '"},';
            $setupJson .= '"vPlayer":{"width":"' . $_POST['setup']['vPlayer']['width'] . '","height":"' . $_POST['setup']['vPlayer']['height'] . '"},';
            $setupJson .= '"mainMenus":"' . $_POST['setup']['mainMenus'] . '",';
            $setupJson .= '"siteTitle":"' . $_POST['setup']['siteTitle'] . '",';
            $setupJson .= '"adminTitle":"' . $_POST['setup']['adminTitle'] . '",';
            $setupJson .= '"siteAuthor":"' . $_POST['setup']['siteAuthor'] . '",';
            $setupJson .= '"maxPicText":"' . $_POST['setup']['maxPicText'] . '",';
            $setupJson .= '"newsCount":"' . $_POST['setup']['newsCount'] . '",';
            $setupJson .= '"messageWallType":"' . $_POST['setup']['messageWallType'] . '",';
            $setupJson .= '"siteType":"' . $_POST['setup']['siteType'] . '"';
            $setupJson .= '}';

            $setupData['data'] = $setupJson;
            $setup = new SetupFormModel($this->db, $setupData);
            $setupSuccess = $setup->updateSetupData();
            if (!isset($setupSuccess['error'])) {
                print json_encode($goodArray = array('good'=>1));
            } else {
                print json_encode($errorArray = array('error'=>$setupSuccess['error']));
            } 
            unset($_SESSION['setupData']);
        } else {
            print $errors;
        }
    }

    private function ValidateSetupFormFull() {
        include_once(CORE_PATH . 'Validator.php');
        $validateInfo = array();

        $validateInfo[] = array('function'=>'validateInt', 'data'=>$_POST['setup']['galleryThumb']['width'], 'controllId'=>'galleryThumbWidth');
        $validateInfo[] = array('function'=>'validateInt', 'data'=>$_POST['setup']['galleryThumb']['height'], 'controllId'=>'galleryThumbHeight');
        $validateInfo[] = array('function'=>'validateInt', 'data'=>$_POST['setup']['galleryPic']['width'], 'controllId'=>'galleryPicWidth');
        $validateInfo[] = array('function'=>'validateInt', 'data'=>$_POST['setup']['galleryPic']['height'], 'controllId'=>'galleryPicHeight');
        $validateInfo[] = array('function'=>'validateInt', 'data'=>$_POST['setup']['galleryHeader']['width'], 'controllId'=>'galleryHeaderWidth');
        $validateInfo[] = array('function'=>'validateInt', 'data'=>$_POST['setup']['galleryHeader']['height'], 'controllId'=>'galleryHeaderHeight');
        $validateInfo[] = array('function'=>'validateInt', 'data'=>$_POST['setup']['articleThumb']['width'], 'controllId'=>'articleThumbWidth');
        $validateInfo[] = array('function'=>'validateInt', 'data'=>$_POST['setup']['articleThumb']['height'], 'controllId'=>'articleThumbHeight');
        $validateInfo[] = array('function'=>'validateInt', 'data'=>$_POST['setup']['articlePic']['width'], 'controllId'=>'articlePicWidth');
        $validateInfo[] = array('function'=>'validateInt', 'data'=>$_POST['setup']['articlePic']['height'], 'controllId'=>'articlePicHeight');
        $validateInfo[] = array('function'=>'validateInt', 'data'=>$_POST['setup']['articleHeader']['width'], 'controllId'=>'articleHeaderWidth');
        $validateInfo[] = array('function'=>'validateInt', 'data'=>$_POST['setup']['articleHeader']['height'], 'controllId'=>'articleHeaderHeight');
        $validateInfo[] = array('function'=>'validateInt', 'data'=>$_POST['setup']['ytPlayer']['width'], 'controllId'=>'ytPlayerWidth');
        $validateInfo[] = array('function'=>'validateInt', 'data'=>$_POST['setup']['ytPlayer']['height'], 'controllId'=>'ytPlayerHeight');
        $validateInfo[] = array('function'=>'validateInt', 'data'=>$_POST['setup']['vPlayer']['width'], 'controllId'=>'vPlayerWidth');
        $validateInfo[] = array('function'=>'validateInt', 'data'=>$_POST['setup']['vPlayer']['height'], 'controllId'=>'vPlayerHeight');
        $validateInfo[] = array('function'=>'validateInt', 'data'=>$_POST['setup']['mainMenus'], 'controllId'=>'mainMenus');
        $validateInfo[] = array('function'=>'validateText', 'data'=>$_POST['setup']['siteTitle'], 'controllId'=>'siteTitle');
        $validateInfo[] = array('function'=>'validateText', 'data'=>$_POST['setup']['adminTitle'], 'controllId'=>'adminTitle');
        $validateInfo[] = array('function'=>'validateText', 'data'=>$_POST['setup']['siteAuthor'], 'controllId'=>'siteAuthor');
        $validateInfo[] = array('function'=>'validateInt', 'data'=>$_POST['setup']['maxPicText'], 'controllId'=>'maxPicText');
        $validateInfo[] = array('function'=>'validateInt', 'data'=>$_POST['setup']['messageWallType'], 'controllId'=>'messageWallType');
        $validateInfo[] = array('function'=>'validateInt', 'data'=>$_POST['setup']['newsCount'], 'controllId'=>'newsCount');
        $validateInfo[] = array('function'=>'validateInt', 'data'=>$_POST['setup']['siteType'], 'controllId'=>'siteType');

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
        print json_encode($errorArray);
    }
    
    public function GetFooter() {
        $setupLabels = json_decode(file_get_contents(ADMIN_RESOURCE_PATH . 'lang/' . $_SESSION['setupData']['languageSign'] . '/SetupForm.json'));
        include_once(ADMIN_VIEW_PATH . "footers/SetupFormFooter.php");
    }
}