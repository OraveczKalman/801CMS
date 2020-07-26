<?php
include_once(MODEL_PATH . 'LanguageModel.php');

class LanguageFormController /*extends FormController*/ {
    private $dataArray;
    private $db;

    public function __construct($dataArray, $db) {
        $this -> dataArray = $dataArray;
        $this -> db = $db;
        if (!isset($this->dataArray[0]['event'])) {
            $this->dataArray[0]['event'] = 'RenderLanguageList';
        }
        call_user_func(array($this, $this->dataArray[0]['event']));
    }

    private function LanguageInsert() {
        $errors = $this->ValidateFormFull();
        if ($errors == '') {
            $languageObj = new LanguageModel($this->db, $this->dataArray[0]);
            $languageData = $languageObj->newLanguage();
            if (!isset($languageData['error'])) {
                print json_encode($goodArray = array('good'=>1));
            } else {
                print json_encode($errorArray = array('error'=>$languageData['error']));
            }
        } else {
            print $errors;
        }
    }

    private function RenderLanguageList() {
        $languageLabels = json_decode(file_get_contents(ADMIN_RESOURCE_PATH . 'lang/' . $_SESSION['setupData']['languageSign'] . '/LanguageForm.json'));
        $languageDataArray = array("where"=>" Active=1");
        $languageModel = new LanguageModel($this->db, $languageDataArray);
        $languageList = $languageModel->getLanguage();
        include_once(ADMIN_VIEW_PATH . 'LanguageListView.php');
    }
    
    private function RenderLanguageForm() {
        $languageLabels = json_decode(file_get_contents(ADMIN_RESOURCE_PATH . 'lang/' . $_SESSION['setupData']['languageSign'] . '/LanguageForm.json'));
        include_once(ADMIN_VIEW_PATH . 'LanguageFormView.php');
    }
    
    private function DeleteLanguage() {
        $deleteLanguageDataArray = array();
        $deleteLanguageDataArray['languageId'] = $this->dataArray[0]['languageId'];
        $languageModel = new LanguageModel($this->db, $deleteLanguageDataArray);
        $languageData = $languageModel->deleteLanguage();
        if ($languageData != 0) {
            print json_encode($errorArray = array('error'=>$languageData['error']));
        } else {
            print json_encode($goodArray = array('good'=>1));
        }
    }

    private function SetDefaultLanguage() {
        $setDefaultLanguageDataArray = array("fields"=>"`Default`=0");
        $languageModel = new LanguageModel($this->db, $setDefaultLanguageDataArray);
        $languageData = $languageModel->updateLanguage();
        if ($languageData != 0) {
            print json_encode($errorArray = array('error'=>$languageData['error']));
        } else {
            $setDefaultLanguageDataArray = array("fields"=>"`Default`=1", "where"=>" WHERE LanguageId=" . $this->dataArray[0]["languageId"]);
            $languageModel->setDataArray($setDefaultLanguageDataArray);
            $languageData = $languageModel->updateLanguage();
            if ($languageData != 0) {
                print json_encode($errorArray = array('error'=>$languageData['error']));
            } else {
                print json_encode($goodArray = array('good'=>1));
            }
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

    private function ValidateFormFull() {
        include_once(CORE_PATH . 'Validator.php');
        $validateInfo = array();
        $validateInfo[] = array('function'=>'validateText', 'data'=>$this->dataArray[0]['Language'], 'controllId'=>'Language');
        $validateInfo[] = array('function'=>'validateText', 'data'=>$this->dataArray[0]['LanguageSign'], 'controllId'=>'LanguageSign');
        $validator = new mainValidator($validateInfo);
        $errorArray = $validator -> validateCore();
        if (empty($errorArray)) {
            return '';
        } else if (!empty($errorArray)) {
            return json_encode($errorArray);
        }
    }
    
    public function GetFooter() {
        $languageLabels = json_decode(file_get_contents(ADMIN_RESOURCE_PATH . 'lang/' . $_SESSION['setupData']['languageSign'] . '/LanguageForm.json'));
        include_once(ADMIN_VIEW_PATH . "footers/LanguageFormFooter.php");
    }
}