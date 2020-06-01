<?php
/**
 * Created by PhpStorm.
 * User: Oravecz Kálmán
 * Date: 2015.02.21.
 * Time: 19:56
 */

include_once(SITE_MODEL_PATH . '/NewsCoverModel.php');

class NewsCoverController {
    private $docData;
    private $db;

    public function __construct($db, $docData=null) {
        var_dump('xxx');
        $this -> docData = $docData;
        $this -> db = $db;
        $this -> renderNewsCover();
    }

    private function renderNewsCover() {
        print "<pre>";
        print_r($_SESSION);
        print "</pre>";
        include_once(SITE_CONTROLLER_PATH . '/NewsController.php');
        //include_once(SITE_RESOURCE_PATH . 'lang/' . )
        $newsCovers = new NewsCoverModel($this->db, $this->docData);
        $newsCoverData = $newsCovers -> getNewsStreams();
        $newsStreams = array();
        foreach ($newsCoverData as $newsCoverData2) {
            array_push($newsStreams, $newsCoverData2);
        }
        include_once(SITE_VIEW_PATH . '/NewsCoverView.php');
    }
}