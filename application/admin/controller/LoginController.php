<?php
class LoginController {
    private $dataArray;
    private $db;

    public function __construct($dataArray, $db) {
        $this->dataArray = $dataArray;
        $this->db = $db;
        call_user_func(array($this, $this->dataArray[0]['event']));
    }

    private function LoginForm() {
        include_once(ADMIN_VIEW_PATH . 'LoginView.php');
    }
    
    private function Login() {
        include_once(ADMIN_MODEL_PATH . 'UserModel.php');
        $errorArray = array();

        if ($_POST['UserName'] == '') {
            array_push($errorArray, 'UserName');
        }
        if ($_POST['Password'] == '') {
            array_push($errorArray, 'Password');
        }

        if (empty($errorArray)) {
            $userData = array();
            $userData[] = array('where' => 'UserName = "' . $_POST['UserName'] . '" AND Password = "' . $_POST['Password'] . '"');
            $user = new UserModel($this->db, $userData);
            $enteredUserData = $user->getUser();
            if (empty($enteredUserData)) {
                array_push($errorArray, 'UserName', 'Password');
                print json_encode($errorArray);
            } else {
                $_SESSION['admin']['userData'] = $enteredUserData[0];
            }
        } else if (!empty($errorArray)) {
            print json_encode($errorArray);
        }
    }
}