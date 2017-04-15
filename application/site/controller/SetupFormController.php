<?php
include_once(CORE_PATH . 'FormController.php');

class SetupFormController extends FormController {
    private $dataArray;
    private $db;

    public function __construct($db, $dataArray=null) {
        if (!is_null($dataArray)) {
            $this->dataArray = $dataArray;
        }
        $this->db = $db;
        if (!isset($this->dataArray[0]['event'])) {
            $this->dataArray[0]['event'] = "RenderSetupForm";
        }
        call_user_func(array($this, $this->dataArray[0]['event']));
    }
    
    private function RenderSetupForm() {
        include_once(SITE_VIEW_PATH . "SetupForm.php");
    }
    
    private function SaveSetupForm()
    {
        $errors = $this->ValidateSetupFormFull();
        if ($errors == '') {
            $setupJson = '{';
            $setupJson .= '"host":"' . $this->dataArray[0]['host'] . '",';
            $setupJson .= '"db":"' . $this->dataArray[0]['db'] . '",';
            $setupJson .= '"port":"' . $this->dataArray[0]['port'] . '",';
            $setupJson .= '"charset":"' . $this->dataArray[0]['charset'] . '",';
            $setupJson .= '"user":"' . $this->dataArray[0]['user'] . '",';
            $setupJson .= '"pwd":"' . $this->dataArray[0]['pwd'] . '"';
            $setupJson .= '}';
            file_put_contents(CORE_PATH . 'DbConfig.json', $setupJson);
        } else {
            print $errors;
        }
    }
    
    private function ValidateSetupFormFull() {
        include_once(CORE_PATH . 'Validator.php');
        $validateInfo = array();
        $validateInfo[] = array('function'=>'validateText', 'data'=>$_POST['host'], 'controllId'=>'host');
        $validateInfo[] = array('function'=>'validateText', 'data'=>$_POST['db'], 'controllId'=>'db');
        $validateInfo[] = array('function'=>'validateInt', 'data'=>$_POST['port'], 'controllId'=>'port');
        $validateInfo[] = array('function'=>'validateText', 'data'=>$_POST['charset'], 'controllId'=>'charset');
        $validateInfo[] = array('function'=>'validateText', 'data'=>$_POST['user'], 'controllId'=>'user');
        $validateInfo[] = array('function'=>'validateText', 'data'=>$_POST['pwd'], 'controllId'=>'pwd');
        $validator = new mainValidator($validateInfo);
        $errorArray = $validator -> validateCore();
        if (empty($errorArray)) {
            return '';
        } else if (!empty($errorArray)) {
            return json_encode($errorArray);
        }
    }
}
