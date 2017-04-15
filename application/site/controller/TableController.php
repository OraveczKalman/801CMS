<?php
class TableController {
    private $dataArray;
    private $db;
    
    public function __construct($dataArray, $db) {
        $this->SetData($dataArray, $db);
        if (!isset($this->dataArray[0]['event'])) {
            $this->dataArray[0]['event'] = 'Init';
        }
        call_user_func(array($this, $this->dataArray[0]['event']));
    }
    
    public function SetData($data, $db) {
        $this->dataArray = $data;
        $this->db = $db;
    }
    
    private function Init() {
        $tableData = json_decode($this->dataArray[0]['AdditionalField']);
        include_once(SITE_VIEW_PATH . 'TableView.php');
    }
    
    private function RenderTable() {
        if (!isset($this->dataArray[0]['Fordulo'])) {
            $this->dataArray[0]['Fordulo'] = 1;
        }
        $tableData = json_decode($this->dataArray[0]['AdditionalField']);
        $ch = curl_init('http://www.mlsz.info/pr_public/tabella/egy_verseny_fordulo_tabella_700.asp?p_verseny_kod=' . $tableData->Tabellakod . 
            '&p_fordulo=' . $this->dataArray[0]['Fordulo']);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $pageContents = curl_exec($ch);
        $pageContents = iconv('windows-1250', 'utf-8', $pageContents);
        $pEncoding = mb_http_input();
     
        $table = strip_tags($pageContents, '<table><tr><td>');
        $table = preg_replace( "/(?:(?)|(?))(\s+)(?=\<\/?)/", "", $table );
        $table = str_replace('www.mlsz.info<table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse"><tr><td width="5"></td><td><table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse"><tr><td class="RED_2" width="700" height="1"></td></tr><tr><td height="4"></td></tr></table></td><td width="5"></td></tr></table><table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse"><tr><td class="RED_2" width="1"></td><td width="4"></td><td class="WHITE"><table class="public_fej" border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse"><tr><td class="WHITE_CR18" width="335" height="30" valign="top">mlsz</td><td width="30" align="center" align="center"></td><td class="WHITE_CL18" width="335" valign="bottom">info</td></tr></table><table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse"><tr><td valign="top"><table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse"><tr><td class="BLACK_CL11" width="300" height="20">Pest</td><tr><tr><td class="BLACK_CL11" width="300" height="20">' . $tableData->Fejszoveg . '</td><tr></table></td><td class="RED_2_CC12" width="100" height="40">TABELLA</td><td valign="top"><table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse"><tr><td class="BLACK_CR11" width="300" height="20">' . $tableData->Ideny . '</td></tr><tr><td class="BLACK_CR11" width="300" height="20">' . $this->dataArray[0]['Fordulo'] . '. forduló</td></tr></table></td></tr></table><table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse"><tr><td class="RED_2" width="700" height="1"></td></tr></table>', '', $table);
        $table = str_replace('<table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse"><tr><td class="GRAY_3" width="700" height="1"></td></tr></table><table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse"><tr><td width="700" height="30" valign="top"></td></tr></table></td><td width="4"></td><td class="RED_2" width="1"></td></tr></table><table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse"><tr><td width="5"></td><td><table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse"><tr><td height="4"></td></tr><tr><td class="RED_2" width="700" height="1"></td></tr></table></td><td width="5"></td></tr></table>' ,'', $table);
        $table = str_replace('<td width="4"></td>', '', $table);
        $table = str_replace('<td width="5"></td>', '', $table);
        $table = str_replace('<td class="BLACK_CL10" width="70">megjegyzés</td><td width="110"></td>', '', $table);
        $table = str_replace('<td class="BLACK_CL09" width="70"></td>', '', $table);
        $table = str_replace('<td class="GRAY_3" width="1"></td>', '', $table);
        $table = str_replace(' class="BLACK_CR10" width="25" height="15"', ' class="fejcella"', $table);
        $table = str_replace(' class="BLACK_CL10" width="240"', ' class="fejcella"', $table);
        $table = str_replace(' class="BLACK_CR10" width="25"', ' class="fejcella"', $table);
        $table = str_replace(' class="BLACK_CR11" width="25"', '', $table);
        $table = str_replace(' class="BLACK_CL13" width="240"', '', $table);
        $table = str_replace('<tr><td class="GRAY_3" width="700" height="1"></td></tr>', '', $table);
        $table = str_replace('<tr><td class="RED_2" width="700" height="1"></td></tr>', '', $table);
        $table = str_replace('<td>P</td>', '<td>P</td>', $table);
        $table = str_replace('<td width="110"></td>', '', $table);
        $table = strip_tags($table, '<tr><td>');
        $table = preg_replace("/(?:(?)|(?))(\s+)(?=\<\/?)/", "", $table);
        $table = '<table class="table table-striped" id="tabella_table">' . $table . '</table>';
        print $table;
    }
}