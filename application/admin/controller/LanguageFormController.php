<?php
include_once(DATABASE_PATH . 'LanguageModel.php');

class LanguageFormController /*extends FormController*/ {
    private $dataArray;
    private $db;

    public function __construct($dataArray, $db) {
        $this -> dataArray = $dataArray;
        $this -> db = $db;
        if (!isset($this->dataArray[0]['event'])) {
            $this->dataArray['event'] = 'RenderLanguageForm';
        }
        call_user_func(array($this, $this->dataArray[0]['event']));
    }

    private function LanguageInsert() {
        $errors = $this->ValidateLanguageFormFull();
        if ($errors == '') {
            $languageObj = new LanguageModel($this->db, $_POST);
            $languageData = $languageObj ->newLanguage();
            if (!isset($languageData['error'])) {
                print json_encode($goodArray = array('good'=>1));
            } else {
                print json_encode($errorArray = array('error'=>$languageData['error']));
            }                
        } else {
            print $errors;
        }
    }

    private function RenderLanguageForm() {
        $languageLabels = json_decode(file_get_contents(ADMIN_RESOURCE_PATH . 'lang/' . $_SESSION['setupData']['languageSign'] . '/LanguageForm.json'));
        include_once(ADMIN_VIEW_PATH . 'LanguageFormView.php');
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

    private function ValidateLanguageFormFull() {
        include_once(CORE_PATH . 'Validator.php');
        $validateInfo = array();
        $validateInfo[] = array('function'=>'validateText', 'data'=>$_POST['Language'], 'controllId'=>'Language');
        $validateInfo[] = array('function'=>'validateText', 'data'=>$_POST['LanguageSign'], 'controllId'=>'LanguageSign');
        $validator = new mainValidator($validateInfo);
        $errorArray = $validator -> validateCore();
        if (empty($errorArray)) {
            return '';
        } else if (!empty($errorArray)) {
            return json_encode($errorArray);
        }
    }
}