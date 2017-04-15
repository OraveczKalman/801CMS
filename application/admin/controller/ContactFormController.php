<?php
include_once(CORE_PATH . 'FormController.php');
include_once(ADMIN_MODEL_PATH . 'ContactModel.php');

class ContactFormController extends FormController {
    private $dataArray;
    private $db;

    public function __construct($dataArray, $db) {
        $this -> dataArray = $dataArray;
        $this -> db = $db;
        if (!isset($this->dataArray[0]['event'])) {
            $this->dataArray['event'] = 'RenderContactForm';
        }
        call_user_func(array($this, $this->dataArray[0]['event']));
    }

    private function ContactUpdate() {
        $errors = $this->ValidateContactFormFull();
        if ($errors == '') {
            $contactObj = new ContactModel($this->db, $_POST);
            if ($_POST['cid_hidden'] > 0) {
                $contactData = $contactObj->updateContactInformation();
                if (!isset($contactData['error'])) {
                    print json_encode($goodArray = array('good'=>1));
                } else {
                    print json_encode($errorArray = array('error'=>$contactData['error']));
                }
            } else if ($_POST['cid_hidden'] == 0) {
                $contact_data = $contactObj -> insertContactInformation($_POST);
                if (!isset($contactData['error'])) {
                    print json_encode($goodArray = array('good'=>1));
                } else {
                    print json_encode($errorArray = array('error'=>$contact_data['error']));
                }                
            }
        } else {
            print $errors;
        }
    }

    private function RenderContactForm() {
        $contactObj = new ContactModel($this->db);
        $contactData = $contactObj -> GetContactInformation();
        include_once(ADMIN_VIEW_PATH . 'ContactFormView.php');
    }

    private function ValidateContactFormFull() {
        include_once(CORE_PATH . 'Validator.php');
        $validateInfo = array();
        $validateInfo[] = array('function'=>'validateText', 'data'=>$_POST['Name'], 'controllId'=>'Name');
        $validateInfo[] = array('function'=>'validateText', 'data'=>$_POST['Address'], 'controllId'=>'Address');
        $validateInfo[] = array('function'=>'validatePhone', 'data'=>$_POST['Phone'], 'controllId'=>'Phone');
        $validateInfo[] = array('function'=>'validatePhone', 'data'=>$_POST['Mobile'], 'controllId'=>'Mobile');
        $validateInfo[] = array('function'=>'validatePhone', 'data'=>$_POST['Fax'], 'controllId'=>'Fax');
        $validateInfo[] = array('function'=>'validateEmail', 'data'=>$_POST['TargetMail'], 'controllId'=>'TargetMail');
        $validateInfo[] = array('function'=>'validateText', 'data'=>$_POST['SmtpPassword'], 'controllId'=>'SmtpPassword');
        $validateInfo[] = array('function'=>'validateText', 'data'=>$_POST['SmtpServer'], 'controllId'=>'SmtpServer');
        $validateInfo[] = array('function'=>'validateInt', 'data'=>$_POST['Port'], 'controllId'=>'Port');
        $validateInfo[] = array('function'=>'validateText', 'data'=>$_POST['UserName'], 'controllId'=>'UserName');
        $validator = new mainValidator($validateInfo);
        $errorArray = $validator -> validateCore();
        if (empty($errorArray)) {
            return '';
        } else if (!empty($errorArray)) {
            return json_encode($errorArray);
        }
    }
}