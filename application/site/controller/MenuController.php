<?php
include_once(SITE_MODEL_PATH . 'MenuModel.php');
class Menu_Controller {
    private $side; 
    private $menu_parent;

    function __construct($parent, $side) {
        $this -> menu_parent = $parent;
        $this -> side = $side;
    }

    private function get_menu_data($parentId) {
        $menu = new MenuModel(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);
        $menuData = $menu -> getMenu($parentId, $this -> side);
        return $menuData;
    }

    public function render_side_menu() {
        include_once('templates/vert_menu.php');
        $menu = $this -> get_menu_data($this -> menu_parent);
        //var_dump($menu);
        for ($i=0; $i<=count($menu)-1; $i++) {
            if ($menu[$i]['Szerep'] != 2) {
                vert_menu_main($menu[$i]['Link'], $menu[$i]['Felirat'], '');
                if ($menu[$i]['Szerep'] == 1) {
                    $sub_menu_data = $this -> get_menu_data($menu[$i]['Menu_Id']);
                    vert_menu_sub($sub_menu_data);
                }
            }
        }
    }

    public function render_child_menu() {
        $menu = $this -> get_menu_data($this -> menu_parent);
        include_once('templates/child_menu.php');	
    }
    
    public function render_top_menu() {
        include_once('templates/horz_menu.php');
        $menu = $this -> get_menu_data($this -> menu_parent);
        for ($i=0; $i<=count($menu)-1; $i++) {
            if ($menu[$i]['Szerep'] != 2) {
                if ($menu[$i]['Szerep'] == 19) {
                    $menu[$i]['Link'] = HOME_PAGE;
                }
                if ($menu[$i]['Szerep'] == 20) {
                    $menu[$i]['Link'] = "javascript: void(0);";
                }
                $last = 0;
                if ($i==count($menu)-1) {
                    $last = 1;
                }
                horz_menu_main($menu[$i]['Link'], $menu[$i]['Felirat'], $last, $i);
                /*if ($menu[$i]['Szerep'] == 1) {
                    $sub_menu_data = $this -> get_menu_data($menu[$i]['Menu_Id']);
                    horz_menu_sub($sub_menu_data);
                }*/
            }
        }
    }
    
    public function write_menu_form() {
        include_once('templates/menu_form.php');
        $menu = $this -> get_menu_data($this -> menu_parent);	
        for ($i=0; $i<=count($menu)-1; $i++) {
            menu_form($menu[$i]);
        }
    }
}