<?php
include_once(SITE_MODEL_PATH . '/SearchModel.php');

class SearchController {
    private $dataArray;
    private $db;

    public function __construct($db, $dataArray=null) {
        $this->dataArray = $dataArray;
        $this->db = $db;
        if (!isset($this->dataArray[0]['event'])) {
            $this->dataArray[0]['event'] = 'renderSearchForm';
        }
        call_user_func(array($this, $this->dataArray[0]['event']));
    }
    
    private function renderSearchForm() {
        $searchFormObject = json_decode(file_get_contents(SITE_RESOURCE_PATH . 'lang/' . $_SESSION['setupData']['languageSign'] . '/SearchForm.json'));
        include_once(SITE_VIEW_PATH . "SearchFormView.php");
    }
}