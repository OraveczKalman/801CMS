<?php
include_once(MODEL_PATH . 'ContactModel.php');

class ContactFormController /*extends FormController*/ {
    private $dataArray;
    private $db;

    public function __construct($dataArray, $db) {
        $this->dataArray = $dataArray;
        $this->db = $db;
        if (!isset($this->dataArray[0]['event'])) {
            $this->dataArray[0]['event'] = 'RenderContactForm';
        }
        call_user_func(array($this, $this->dataArray[0]['event']));
    }

    private function ContactUpdate() {
        $errors = $this->ValidateContactFormFull();
        if ($errors == '') {
            $contactObj = new ContactModel($this->db, $this->dataArray[0]);
            if ($this->dataArray[0]['cidHidden'] > 0) {
                $contactData = $contactObj->updateContactInformation();
                if (!isset($contactData['error'])) {
                    print json_encode($goodArray = array('good'=>1));
                } else {
                    print json_encode($errorArray = array('error'=>$contactData['error']));
                }
            } else if ($this->dataArray[0]['cidHidden'] == 0) {
                $contactData = $contactObj->insertContactInformation($this->dataArray[0]);
                if (!isset($contactData['error'])) {
                    print json_encode($goodArray = array('good'=>1));
                } else {
                    print json_encode($errorArray = array('error'=>$contactData['error']));
                }                
            }
        } else {
            print $errors;
        }
    }

    private function RenderContactForm() {
        $contactLabels = json_decode(file_get_contents(ADMIN_RESOURCE_PATH . 'lang/' . $_SESSION['setupData']['languageSign'] . '/ContactForm.json'));
        $contactObj = new ContactModel($this->db);
        $contactData = $contactObj->GetContactInformation();
        include_once(ADMIN_VIEW_PATH . 'ContactFormView.php');
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

    
    private function ValidateContactFormFull() {
        include_once(CORE_PATH . 'Validator.php');
        $validateInfo = array();
        $validateInfo[] = array('function'=>'validateText', 'data'=>$this->dataArray[0]['Name'], 'controllId'=>'Name');
        $validateInfo[] = array('function'=>'validateText', 'data'=>$this->dataArray[0]['Address'], 'controllId'=>'Address');
        $validateInfo[] = array('function'=>'validatePhone', 'data'=>$this->dataArray[0]['Phone'], 'controllId'=>'Phone');
        $validateInfo[] = array('function'=>'validatePhone', 'data'=>$this->dataArray[0]['Mobile'], 'controllId'=>'Mobile');
        $validateInfo[] = array('function'=>'validatePhone', 'data'=>$this->dataArray[0]['Fax'], 'controllId'=>'Fax');
        $validateInfo[] = array('function'=>'validateEmail', 'data'=>$this->dataArray[0]['TargetMail'], 'controllId'=>'TargetMail');
        $validateInfo[] = array('function'=>'validateText', 'data'=>$this->dataArray[0]['SmtpPassword'], 'controllId'=>'SmtpPassword');
        $validateInfo[] = array('function'=>'validateText', 'data'=>$this->dataArray[0]['SmtpServer'], 'controllId'=>'SmtpServer');
        $validateInfo[] = array('function'=>'validateInt', 'data'=>$this->dataArray[0]['Port'], 'controllId'=>'Port');
        $validateInfo[] = array('function'=>'validateText', 'data'=>$this->dataArray[0]['UserName'], 'controllId'=>'UserName');
        $validator = new mainValidator($validateInfo);
        $errorArray = $validator->validateCore();
        if (empty($errorArray)) {
            return '';
        } else if (!empty($errorArray)) {
            return json_encode($errorArray);
        }
    }
    
    public function getFooter() {
        $contactLabels = json_decode(file_get_contents(ADMIN_RESOURCE_PATH . 'lang/' . $_SESSION['setupData']['languageSign'] . '/ContactForm.json'));
        include_once(ADMIN_VIEW_PATH . "footers/ContactFormFooter.php");
    }
}