<?php
class ContactFormController {
    private $dataArray;
    private $db;
    
    public function __construct($db, $dataArray=null) {
        $this -> dataArray = $dataArray;
        if (!isset($this->dataArray[0]['event'])) {
            $this->dataArray[0]['event'] = 'Render';
        }
        $this -> db = $db;
        call_user_func(array($this, $this->dataArray[0]['event']));
    }
    
    private function Render() {
        $this->articleLabels = json_decode(file_get_contents(SITE_RESOURCE_PATH . 'lang/' . $_SESSION['setupData']['languageSign'] . '/ArticleViewLabels.json'));
        include_once(SITE_VIEW_PATH . 'ContactFormView.php');
    }
}