<?php
class LogoutController {
    public function __construct() {
        session_destroy();
        include_once(ADMIN_VIEW_PATH . 'LogoutView.php');
    }
}