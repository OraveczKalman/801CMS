<?php
include_once(MODEL_PATH . 'UserModel.php');

class UserController {
    private $dataArray;
    private $db;

    public function __construct($dataArray, $db) {
        $this -> dataArray = $dataArray;
        $this -> db = $db;
        if (!isset($this->dataArray[0]['event'])) {
            $this->dataArray[0]['event'] = "UserList";
        }
        call_user_func(array($this, $this->dataArray[0]['event']));
    }

    private function NewUserForm() {
        $userDataArray = array();
        $userDataArray['where'] = " WHERE userRightId > 1";
        $user = new UserModel($this->db, $userDataArray);
        $rightList = $user->getUserRights();
        $labelObject = json_decode(file_get_contents(ADMIN_RESOURCE_PATH . 'lang/' . $_SESSION['setupData']['languageSign'] . '/NewUserForm.json'));
        include_once(ADMIN_VIEW_PATH . 'UserFormView.php');
    }
    
    private function firstUserForm() {
        $userDataArray = array();
        $userDataArray['where'] = " WHERE userRightId = 1";
        $user = new UserModel($this->db, $userDataArray);
        $rightList = $user->getUserRights();
        $labelObject = json_decode(file_get_contents(ADMIN_RESOURCE_PATH . 'lang/' . $_SESSION['setupData']['languageSign'] . '/NewUserForm.json'));
        include_once(ADMIN_VIEW_PATH . 'FirstUserFormView.php');    
    }

    private function EditUserForm() {
        $labelObject = json_decode(file_get_contents(ADMIN_RESOURCE_PATH . 'lang/' . $_SESSION['setupData']['languageSign'] . '/NewUserForm.json'));
        $this->dataArray[0]['where'] = 'UserId = ' . $_POST['userId'];
        $user = new UserModel($this->db, $this->dataArray);
        $userData = $user->getUser();
        include_once(ADMIN_VIEW_PATH . 'UserFormView.php');
    }

    private function newUser() {
        $errors = $this->ValidateUserFormFull();
        if ($errors == '') {
            $_POST['News'] = 1;
            $user = new UserModel($this->db, $_POST);
            $userData = $user->newUser();
            if (!isset($userData['error'])) {
                print json_encode($goodArray = array('good'=>1));
            } else {
                print json_encode($errorArray = array('error'=>$userData['error']));
            }
        } else {
            print $errors;
        }
    }

    private function editUser() {
        $errors = $this->ValidateUserFormFull();
        if ($errors == '') {
            $_POST['News'] = 1;
            $user = new UserModel($this->db, $_POST);
            $userData = $user->updateUser();
            if (!isset($userData['error'])) {
                print json_encode($goodArray = array('good'=>1));
            } else {
                print json_encode($errorArray = array('error'=>$userData['error']));
            }
        } else {
            print $errors;
        }
    }

    /**
     * @author Oravecz Kálmán
     * UserList function
     */
    private function UserList() {
        $user = new UserModel($this->db, $this->dataArray);
        $users = $user -> getAllUser();
        include_once(ADMIN_VIEW_PATH . 'UserListView.php');
    }

    /**
     * 
     * @author Oravecz Kálmán
     * Delete user controller function
     */
    private function deleteUser() {
        $user = new UserModel($this->dataArray, $this->db);
        $users = $user -> deleteUser();
    }
    
    /**
     * 
     * @return string
     * @author Oravecz Kálmán
     * Validates all fields on UserForm it's used before submit the form
     */
    private function ValidateUserFormFull() {
        include_once(CORE_PATH . 'Validator.php');
        $validateInfo = array();
        $validateInfo[] = array('function'=>'validateText', 'data'=>$_POST['Name'], 'controllId'=>'Name');
        $validateInfo[] = array('function'=>'validateText', 'data'=>$_POST['UserName'], 'controllId'=>'UserName');
        $validateInfo[] = array('function'=>'validateText', 'data'=>$_POST['Password'], 'controllId'=>'Password');
        $validateInfo[] = array('function'=>'validateText', 'data'=>$_POST['Pwdr'], 'controllId'=>'Pwdr');
        $validateInfo[] = array('function'=>'validateInt', 'data'=>$_POST['RightId'], 'controllId'=>'RightId');
        $validateInfo[] = array('function'=>'validateEmail', 'data'=>$_POST['Email'], 'controllId'=>'Email');
        $validator = new mainValidator($validateInfo);
        $errorArray = $validator -> validateCore();
        if (empty($errorArray)) {
            return '';
        } else if (!empty($errorArray)) {
            return json_encode($errorArray);
        }
    }
    
    /**
     * @author Oravecz Kálmán
     * Validates one field form userform 
     */
    private function ValidateField() {
        include_once(CORE_PATH . 'Validator.php');
        $validateInfo = array();
        $validateInfo[] = array('function'=>$_POST['function'], 'data'=>$_POST['data'], 'controllId'=>$_POST['controllId']);
        $validator = new mainValidator($validateInfo);
        $errorArray = $validator -> validateCore();
        print json_encode($errorArray);
    }
    
    public function GetFooter() {
        $labelObject = json_decode(file_get_contents(ADMIN_RESOURCE_PATH . 'lang/' . $_SESSION['setupData']['languageSign'] . '/NewUserForm.json'));
        include_once(ADMIN_VIEW_PATH . "footers/UserFooter.php");
    }
}
