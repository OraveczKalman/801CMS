<?php
/**
 * Created by PhpStorm.
 * User: Oravecz Kálmán
 * Date: 2015.03.07.
 * Time: 15:55
 */

class TimelineModel {
    private $docData;
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

    public function renderTimeline() {
        switch ($this->docData[0]['Link']) {
            case 'GetByYear' :
                $this->docData[0]['headerWhere'] = ' main_header.Year = "' . $this->docData[0]['param'] . '"';
                $timelineArray['headerData'] = $this->getGenresByYear();
                foreach ($timelineArray['headerData'] as $headerData2)
                {
                    $timelineArray['columnData'][$headerData2['GenreName']] = $this->getTimelineData(array('where' => ' genre.GenreId = ' . $headerData2['GenreId'] . ' AND main_header.Year = "' . $this->docData[0]['param']. '"'));
                }
                include_once(SITE_VIEW_PATH . '/YearTimelineView.php');
                break;
            case 'GetByGenre' :
                break;
            case 'GetByArtist' :
                break;
        }

    }

    public function getTimelineData($timelineInfo) {
        $getTimelineDataQueryString = 'SELECT main_header.*, cimlap_kep.Profile_Picture, artist.ArtistName, genre.GenreName, genre.GenreId FROM main_header ' .
            'INNER JOIN szerep ON main_header.Szerep = szerep.Szerep_Id ' .
            'INNER JOIN header_artist ON header_artist.MainHeaderId = main_header.MainHeaderId ' .
            'INNER JOIN header_genre ON header_genre.MainHeaderId = main_header.MainHeaderId ' .
            'INNER JOIN artist ON header_artist.Artist_Id = artist.ArtistId ' .
            'INNER JOIN genre ON header_genre.Genre_Id = genre.GenreId ' .
            'LEFT JOIN (SELECT kep.ThumbKepnev AS Profile_Picture, galeria_kep.MainHeaderId FROM kep ' .
            'LEFT JOIN galeria_kep ON galeria_kep.KepId = kep.KepId WHERE galeria_kep.Cimlap=1) AS cimlap_kep ON cimlap_kep.MainHeaderId = main_header.MainHeaderId ';
        if (isset($timelineInfo['where'])) {
            $getTimelineDataQueryString .= 'WHERE ' . $timelineInfo['where'];
        }
        $getTimelineDataQuery = $this->db->SelectQuery($getTimelineDataQueryString, $error);
        return $getTimelineDataQuery;
    }

    private function getGenresByYear() {
        $getGenresByYearQueryString = 'SELECT genre.* FROM genre ' .
            'INNER JOIN header_genre ON header_genre.Genre_Id = genre.GenreId ' .
            'INNER JOIN main_header ON main_header.MainHeaderId = header_genre.MainHeaderId ';
        if (isset($this->docData[0]['headerWhere'])) {
            $getGenresByYearQueryString .= 'WHERE ' . $this->docData[0]['headerWhere'];
        }
        $getGenresByYearQuery = $this->db->SelectQuery($getGenresByYearQueryString, $error);
        return $getGenresByYearQuery;
    }

    private function getArtistsByYear() {
        $getArtistsByYearQueryString = 'SELECT artists.* FROM artists ' .
            'INNER JOIN header_artist ON header_artist.Artist_Id = artists.ArtistId ' .
            'INNER JOIN main_header ON main_header.MainHeaderId = header_artist.MainHeaderId ';
        if (isset($this->docData['headerWhere'])) {
            $getArtistsByYearQueryString .= 'WHERE ' . $this->docData['headerWhere'];
        }
        $getArtistsByYearQuery = $this->db->SelectQuery($getArtistsByYearQueryString, $error);
        return $getArtistsByYearQuery;
    }

    private function getGenresByArtists() {

    }

    private function getArtistsByGenres() {

    }
}