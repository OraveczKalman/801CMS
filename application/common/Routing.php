<?php
class Router {
    private $uri;
    private $script;
    private $db;

    public function __construct($uri, $script, $db) {
        $this->uri = $uri;
        $this->script = $script;
        $this->db = $db;
        $this->mainRouter();
    }

    private function mainRouter() {
        include_once(DATABASE_PATH . 'LinkModel.php');
        $requestURI = explode('/', $this->uri);
        $scriptName = explode('/', $this->script);

        for ($i = 0; $i < sizeof($scriptName); $i++) {
            if ($requestURI[$i] == $scriptName[$i]) {
                unset($requestURI[$i]);
            }
        }

        $command = array_values($requestURI);
        switch ($command[0]) {
            case 'admin' :
                $this->adminRouter($command);
                break;
            case 'setup' :
                $this->setupRouter();
                break;
            default :
                $this->siteRouter($command);
                break;
        }
    }

    private function setupRouter() {
        $setupDataArray = array();
        if (!empty($_POST)) {
            $setupDataArray[0] = $_POST;
        } else {
            $setupDataArray = null;
        }
        $menuPoint[0]['ControllerName'] = 'SetupForm';
        $controllerName = $menuPoint[0]['ControllerName'] . 'Controller';
        include_once(SITE_CONTROLLER_PATH . $controllerName . '.php');
        $setup = new $controllerName($this->db, $setupDataArray);
    }
    
    private function siteRouter($commandArray) {
        if (count($commandArray) > 1) {
            $cmd = implode('/', $commandArray);
        } else {
            $cmd = $commandArray[0];
        }
        if (!is_null($this->db)) {
            $menu = new LinkModel($this->db);
            if ($cmd == '') {
                $menuPointDataArray = array();
                $menuPointDataArray["mainPage"] = 1;
                $menuPointDataArray["active"] = 1;
                $menu->setDataArray($menuPointDataArray);
                $menuPoint = $menu->getRoleMain();
            } else {
                $menuPointDataArray = array();
                $menuPointDataArray["cmd"] = $cmd;
                $menuPointDataArray["active"] = 1;
                $menu->setDataArray($menuPointDataArray);
                $menuPoint = $menu->getRoleCommon();
            }
            if (!empty($menuPoint)) {
                $menuPoint[0] = array_merge($menuPoint[0], $_POST);
                $controllerName = $menuPoint[0]['ControllerName'] . 'Controller';
                if (isset($menuPoint[0]['event'])) {
                    include_once(SITE_CONTROLLER_PATH . $controllerName . '.php');
                    $controllerRout = new $controllerName($menuPoint, $this->db);
                } else {
                    if (isset($commandArray[1])) {
                        $menuPoint[0]['param'] = $commandArray[1];
                    }
                    if (intval($menuPoint[0]['Role']) != 7) {
                        include_once(SITE_MODEL_PATH . 'WidgetModel.php');
                        $widgetModel = new WidgetModel($this->db);
                        $menuPoint[0]['widgets'] = $widgetModel->getWidgets($menuPoint[0]['MainHeaderId']);
                        $address = $_SESSION['prefix'] .'://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
                        include_once(SITE_VIEW_PATH . 'MainLayout.php');
                    } else if (intval($menuPoint[0]['Role']) == 7) {
                        include_once(SITE_CONTROLLER_PATH . $controllerName . '.php');
                        $controllerRout = new $controllerName($menuPoint, $this->db);
                    }
                }
            } else {
                $address = $_SESSION['prefix'] .'://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
                include_once(SITE_VIEW_PATH . 'MainLayout404.php');
            }
        }
    }

    private function adminRouter($commandArray) {
        include_once(ADMIN_MODEL_PATH . "UserModel.php");
        $userDataArray = array();
        $userDataArray[0]["where"] = " RightId = 1";
        $userModel = new UserModel($this->db, $userDataArray);
        $userRightCount = $userModel->getUserCount();
        if ($userRightCount[0]["userIdCount"] > 0) {
            if (!isset($_SESSION['admin']['userData'])) {
                include_once(ADMIN_CONTROLLER_PATH . 'LoginController.php');           
                if (!isset($_POST['event'])) {
                    $_POST['event'] = 'LoginForm';
                }
                $dataArray[0] = $_POST;
                $login = new LoginController($dataArray, $this->db);
            } else if (isset($_SESSION['admin']['userData'])) {
                if (isset($commandArray[1]) && $commandArray[1] != '') {
                    $controllerName = ucfirst($commandArray[1]) . 'Controller';
                }
                if (!isset($controllerName)) {
                    $adminMainMenu = json_decode(file_get_contents(ADMIN_RESOURCE_PATH . 'lang/'. $_SESSION['setupData']['languageSign'] . '/NewAdminMainMenu.json'));
                    include_once(ADMIN_VIEW_PATH . 'MainLayout.php');
                } else if (isset($controllerName)) {
                    include_once(ADMIN_CONTROLLER_PATH . $controllerName . '.php');
                    $menuPoint[0] = $_POST;
                    $controllerRout = new $controllerName($menuPoint, $this->db);
                }
            }
        } else {
            include_once(ADMIN_CONTROLLER_PATH . "UserController.php");
            if (empty($_POST)) {
                $userControllerDataArray[0] = array("event" => "firstUserForm");
                $userController = new UserController($userControllerDataArray, $this->db);
            } else {
                $userControllerDataArray[0] = $_POST;
                $userController = new UserController($userControllerDataArray, $this->db);
            }
        }
    }
}
