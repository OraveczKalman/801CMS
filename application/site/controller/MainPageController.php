<?php
include_once(MODEL_PATH . '/MainCoverModel.php');

class MainPageController {
    private $dataArray;
    private $mediaData;
    private $db;
    private $articleLabels;

    public function __construct($db, $docData=null) {
        $this->dataArray = $docData;
        $this->db = $db;
        $this->Render();
    }
    
    public function Render() {
        $this->articleLabels = json_decode(file_get_contents(SITE_RESOURCE_PATH . 'lang/' . $_SESSION['setupData']['languageSign'] . '/ArticleViewLabels.json'));
        $mainCoverModel = new MainCoverModel($this->db);
        $mainCovers = $mainCoverModel->getMainCoverList();
        $indicators = "";
        $carousel = "";
        $iPod    = stripos($_SERVER['HTTP_USER_AGENT'],"iPod");
        $iPhone  = stripos($_SERVER['HTTP_USER_AGENT'],"iPhone");
        $iPad    = stripos($_SERVER['HTTP_USER_AGENT'],"iPad");
        $Android = stripos($_SERVER['HTTP_USER_AGENT'],"Android");
        $webOS   = stripos($_SERVER['HTTP_USER_AGENT'],"webOS");
        for ($i=0; $i<=count($mainCovers)-1; $i++) {
            if ($i==0) {
                $active = 'class="active"';
                $cActive = " active";
            } else {
                $active = 'class=""';
                $cActive = "";
            }
            
            if ($iPod || $iPhone || $iPad) {
                $ext = $mainCovers[$i]["OriginalExtension"];
            } else {
                $ext = "webp";
            }            
            
            $indicators .= '<li data-target="#carouselIndicators" data-slide-to="' . $i . '" ' . $active . '></li>';
            $carousel .= '<div class="carousel-item ' . $cActive . '" style="background-image: url(\'' . UPLOADED_MEDIA_PATH . $mainCovers[$i]['Name'] . "." . $ext . '\')">
                <a href="'. $mainCovers[$i]["Link"] . '">
                <div class="carousel-caption d-none d-md-block">
                    <h3>' . $mainCovers[$i]["Title"] . '</h3>
                    <p>' . $mainCovers[$i]["Heading"] . '</p>
                </div>
                </a>
            </div>';
        }
        include_once(SITE_VIEW_PATH . "MainPageView.php");
    }  
}
