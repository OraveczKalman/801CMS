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
                $menuPoint = $menu->getRole(array('table' => 'main_header',
                    'fields' => 'main_header.*, lang_header.*, role.ControllerName, cimlap_kep.ProfilePicture',
                    'joins' => 'INNER JOIN role ON main_header.Role = role.RoleId ' .
                        'LEFT JOIN lang_header ON lang_header.MainHeaderId = main_header.MainHeaderId ' .
                        'LEFT JOIN (SELECT picture.ThumbName AS ProfilePicture, gallery_picture.MainHeaderId FROM picture LEFT JOIN gallery_picture ' .
                        'ON gallery_picture.PictureId = picture.PictureId WHERE gallery_picture.Cover=1) AS cimlap_kep ' .
                        'ON cimlap_kep.MainHeaderId = main_header.MainHeaderId ',
                    'where' => 'main_header.MainPage = 1 AND main_header.Active = 1'));
            } else {
                $menuPoint = $menu->getRole(array('table' => 'main_header',
                    'fields' => 'main_header.*, lang_header.*, role.ControllerName, cimlap_kep.ProfilePicture',
                    'joins' => 'INNER JOIN role ON main_header.Role = role.RoleId ' .
                        'LEFT JOIN lang_header ON lang_header.MainHeaderId = main_header.MainHeaderId ' .
                        'LEFT JOIN (SELECT picture.ThumbName AS ProfilePicture, gallery_picture.MainHeaderId FROM picture LEFT JOIN gallery_picture ' .
                        'ON gallery_picture.PictureId = picture.PictureId WHERE gallery_picture.Cover=1) AS cimlap_kep ' .
                        'ON cimlap_kep.MainHeaderId = main_header.MainHeaderId ',
                    'where' => 'lang_header.Link LIKE "' . $cmd . '" AND main_header.Active = 1'));
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
                    $adminMainMenu = json_decode(file_get_contents(ADMIN_RESOURCE_PATH . 'lang/NewAdminMainMenuHu.json'));
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
