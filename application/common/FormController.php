<?php
include_once(CORE_PATH . 'AncestorClass.php');

class FormController extends AncestorClass {
    private function ValidateField() {
        include_once(CORE_PATH . 'Validator.php');
        $validateInfo = array();
        $validateInfo[] = array('function'=>$this->dataArray['function'], 'data'=>$this->dataArray['data'], 'controllId'=>$this->dataArray['controllId']);
        $validator = new mainValidator($validateInfo);
        $errorArray = $validator -> validateCore();
        if (!empty($errorArray)) {
            print json_encode($errorArray);
        }
    }
}