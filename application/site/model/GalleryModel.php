<?php
class GalleryModel {
    private $dataArray;
    private $db;

    public function __construct($db, $dataArray=null) {
        if (!is_null($dataArray)) {
            $this->setDataArray($dataArray);
        }
        $this->setDb($db);
    }
    
    public function setDb($db) {
        $this->db = $db;
    }

    public function setDataArray($dataArray) {
        $this->dataArray = $dataArray;
    }
    
    public function getPicture() {
        $getMenuQuery = $this->db->selectBuilder($this->dataArray);
        return $getMenuQuery;
    }
    
    public function getPicture2() {
        $getPictureQueryString = "SELECT t2.Name, t2.ThumbName
            FROM gallery_picture t1
            LEFT JOIN picture t2 ON t1.PictureId = t2.PictureId
            WHERE t1.MainHeaderId = " . $this->dataArray['MainHeaderId'];
        $getPictureQuery = $this->db->selectQuery($getPictureQueryString);
        return $getPictureQuery;
    }
    
    public function getGalleryObjects() {
        $getGalleryObjectQueryString = 'SELECT picture.PictureId, picture.Name AS kep_nev_big,
            picture.ThumbName AS kep_nev, picture.MediaType,
            (SELECT main_header.Role FROM main_header WHERE gallery_picture.MainHeaderId = main_header.MainHeaderId) AS Szerep,
            gallery_picture.MainHeaderId, gallery_picture.Rank
            FROM gallery_picture
            INNER JOIN picture ON gallery_picture.PictureId = picture.PictureId
            INNER JOIN main_header ON main_header.MainHeaderId = gallery_picture.MainHeaderId ';
        if (intval($this->dataArray['AdditionalField']) == 1) {
            $getGalleryObjectQueryString .= 'WHERE main_header.AdditionalField = ' . $this->dataArray['AdditionalField'] . ' AND gallery_picture.Active = 1 ';
        } else {
            $getGalleryObjectQueryString .= 'WHERE gallery_picture.MainHeaderId = ' . $this->dataArray['MainHeaderId'] . ' AND gallery_picture.Active = 1 ';
        }
        $getGalleryObjectQueryString .=  'ORDER BY gallery_picture.Rank ASC';
        $getGalleryObjectsQuery = $this->db->selectQuery($getGalleryObjectQueryString);
        return $getGalleryObjectsQuery;
    }
    
    public function getGalleryObjectText() {
        $getGalleryObjectTextQueryString = 'SELECT text.Text, text.TextId FROM text ' . 
            'WHERE SuperiorId = ' . $this->dataArray['galleryObjectId'] . ' ' .
            'AND Type = 3';
        $getGalleryObjectText = $this->db->selectQuery($getGalleryObjectTextQueryString);
        return $getGalleryObjectText;
    }

    public function getGalleryCovers($parent) {
        $get_gallery_covers_query_string = "SELECT menu.Link, menu.Felirat, menu.Profile_Picture, menu.Menu_Id " .
            "FROM menu LEFT JOIN rank ON menu.Menu_Id = rank.Point_id " .
            "WHERE rank.ParentId = " . $parent . " AND menu.Szerep = 3 AND menu.Active = 1";
        $get_gallery_covers_query = $this -> select_query($get_gallery_covers_query_string);
        return $get_gallery_covers_query;
    }
}