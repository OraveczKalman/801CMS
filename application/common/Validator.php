<?php
class mainValidator {
    const ALL = "/[\s\S]*/";
    const LEADING_WHITESPACE = "/^\s+/";
    const TRAILIING_WHITESPACE = "/\s+$/";
    const WHITESPACE = "/\s+/";
    const NONWHITESPACE = "/[^\s]+/";
    const FORWARD_SLASH = "/[\\\]/";
    const NONNEWLINE_CHARACTER = "/.+/";
    const NEWLINE_CHARACTER = "/[\r\n]+/";
    const ALPHABETH = "/[a-zA-Z]/";
    const ALPHABETHS = "/[a-zA-Z]+/";
    const UPPERCASE = "/[A-Z]+/";
    const LOWERCASE = "/[a-z]+/";
    const NUMBER = "/[0-9]/";
    const NUMBERS = "/[0-9]+/";
    const ALPHANUMERIC = "/[a-zA-Z0-9]+/";
    const HTML_HEXCODE = "/^#([a-fA-F0-9]){3}(([a-fA-F0-9]){3})?$/";
    const US_SOCIALSECURITY_NUMBER = "/^\d{3}-\d{2}-\d{4}$/";
    const US_ZIPCODE = "/^\d{5}(-\d{4})?$/";
    const US_STATE = "/^(?:A[KLRZ]|C[AOT]|D[CE]|FL|GA|HI|I[ADLN]|K[SY]|LA|M[ADEINOST]|N[CDEHJMVY]|O[HKR]|PA|RI|S[CD]|T[NX]|UT|V[AT]|W[AIVY])*$/";
    const USDPRICE = "/^\$\(d{1,3}(\,\d{3})*|\d+)(\.\d{2})?$/";
    const DATETIME = "/^\d{2}[-\/]\d{2}[-\/]\d{4}\s+\d{2}:\d{2}:\d{2}$/";
    const LINUXPATH = "/^.*\//";
    const IPADDRESS = "/^(\d|[01]?\d\d|2[0-4]\d|25[0-5])\.(\d|[01]?\d\d|2[0-4] \d|25[0-5])\. (\d|[01]?\d\d|2[0-4]\d|25[0-5])\.(\d|[01]?\d\d|2[0-4] \d|25[0-5])$/";
    const MACADDRESS = "/^([0-9a-fA-F]{2}:){5}[0-9a-fA-F]{2}$/";
    const CREDITCARD = "/^(?:4[0-9]{12}(?:[0-9]{3})?|5[1-5][0-9]{14}|6011[0-9]{12}|622((12[6-9]|1[3-9][0-9])|([2-8][0-9][0-9])|(9(([0-1][0-9])|(2[0-5]))))[0-9]{10}|64[4-9][0-9]{13}|65[0-9]{14}|3(?:0[0-5]|[68][0-9])[0-9]{11}|3[47][0-9]{13})*$/";
    const GUID = "/^[\{][A-Z0-9]{8}-[A-Z0-9]{4}-[A-Z0-9]{4}-[A-Z0-9]{4}-[A-Z0-9]{12}[\}]$/";
    const HOME_ADDRESS = "/([a-zA-Z.]*\s*\d+[a-zA-Z.]*)?([,.:;|\s]*[a-zA-Z0-9_\-]+[,.:;|\s]*[a-zA-Z0-9_\-,.]+\s*)*/";
    const EMAIL = "/[0-9a-zA-Z_+]+([-.]{0,1}[0-9a-zA-Z_+])*@([0-9a-zA-Z_]+[-.]+)+[0-9a-zA-Z_]{2,9}/";
    const URL = "/((https?|telnet|gopher|file|wais|ftp):(\/\/)+)?([a-zA-Z0-9_-]+[\/]*[a-zA-Z0-9_-]+\.)+([a-zA-Z0-9]{2,9})([\?#%\/][a-zA-Z0-9_=#@&%\-\w]*)*/";
    const SPECIAL_CHARACTERS = "/[,.<>;:\"'{}\[\]|?\/@!~`#$%\^&*()\-_+=\\\]/";
    const HTMLTAG = "/<([a-zA-Z\/][^<>]*)>/";
    const HTML_FULLTAG = "@<([a-zA-Z]+)[^>]*?>.*?</\\1>@si";
    const HTMLENTITY = "/&(([a-zA-Z]+)|(#[0-9]+));/";
    const CSSCLASS = "/[.][a-zA-Z0-9_-]+/";
    const CSSID = "/[#][a-zA-Z0-9_-]+/";
    const CSSSELECTOR = "/[#.\[][a-zA-Z0-9_-]+\s*([a-zA-Z0-9_\-#.=\[\]<>:\"']+)*\s*([a-zA-Z0-9_\-#.=\]<>:\"'()*]+)*/";
    const FULLNAME = "/[a-zA-Z]+[.\-]?(\s+[a-zA-Z]+[\-]?[a-zA-Z]*)+[.]?/";
    const SAFE_FILENAME = "/^[^,<>;\"'|?\/!`#$\^*\\\]+$/";
    const CLEAN_FILENAME = "/^([a-zA-Z0-9]+[.\-_][a-zA-Z0-9]*)+\.([a-zA-Z0-9]+)*$/";
    const MIMETYPE = "/^[a-zA-Z]+\/[a-zA-Z\-]+$/";
    const EMPTY_HTMLTAG = "/<([a-zA-Z][^<>]*)>(&nbsp;|\s)*<([a-zA-Z\/][^<>]*)>/";
    const CSTYLE_COMMENTS = "/(\/\*([^*]|[\r\n]|(\*+([^*\/]|[\r\n]+)))*\*+\/)|(\/\/[^\r\n]*)/";
    const WEAK_PASSWORD = "/^[a-zA-Z]+$/";
    const FAIR_PASSWORD = "/^(([a-zA-Z]+[0-9]+[a-zA-Z]*)|([0-9]+[a-zA-Z]+[0-9]*))$/";
    const STRONG_PASSWORD = "/^([,.<>;:\"'{}\[\]|?\/@!~`#$%\^&*()\-_+=\\\]*\w*[,.<>;:\"'{}\[\]|?\/@!~`#$%\^&*()\-_+=\\\]+\w*[,.<>;:\"'{}\[\]|?\/@!~`#$%\^&*()\-_+=\\\]*)+$/";
    const MOBILE_BROWSERS_USERAGENTS = "/android|avantgo|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone |od)|iris|kindle|lge |maemo|midp|mmp|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i";
    const MOBILE_BROWSERS_USERAGENTS_SB = "/1207|6310|6590|3gso|4thp|50[1- 6]i|770s|802s|a wa|abac|ac(er|oo|s\- )|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\- |cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\- d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\- 5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\- |\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|e\-|e\/|\-[a-w])|libw|lynx|m1\- w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\- cr|me(di|rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\- |on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1- 8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2- 7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\- )|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\- 0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\- mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0- 3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|xda(\-|2|g)|yas\-|your|zeto|zte\-/i";
    const MUSICAL_KEY = "/([ABCDEFG](?!\S))|([CDFGA]#)|([DEGAB]b)/";
    const PHPVAR = "/\\$[a-zA-Z0-9_]+/";
    const FREQUENCY = "/[0-9]+(\s*(,|\.)*\s*[0-9]*)*((?<![\s.])hz)/i";
    const FILESIZE = "/[0-9]+(\s*(,|\.)*\s*[0-9]*)*((?<!\.)(b|kb|mb|gb|tb|((mega|giga|tera)*byte)))/i";
    const TEMPERATURE = "/[0-9]+(\s*(,|\.)*\s*[0-9]*)*((?<!\.)(C|F|K|((deg|degree|\\\x176|°)*\s*[cf])))/i";
    const PHONE = "/^[+]?(([(]*\s*)(\d{1,3})(\s*[)]*))?((([\s\-]?\d){7,8})|(([\s\-]?\d){10}))$/";

    private $accented_chars = 'ÁÉÍÓÖŐÚÜŰáéíóöőúüű';
    private $dataArray;
    
    public function __construct($dataArray) {
        $this->dataArray = $dataArray;
    }

    public function validateCore() {
        $errorArray = array();
        foreach ($this->dataArray as $dataArray2) {
            $error = null;
            if (!isset($dataArray2['min'])) {
                $dataArray2['min'] = '';
            }
            if (!isset($dataArray2['max'])) {
                $dataArray2['max'] = '';
            }
            if (!isset($dataArray2['required']) || $dataArray2['required'] == '') {
                $dataArray2['required'] = null;
            }
            if (!is_null($dataArray2['required']) && $dataArray2['data'] == '') {
                $error['controllId'] = $dataArray2['controllId'];
                $error['message'] = 'Ez a mező nem lehet üres!';             
            }
            if ($dataArray2['data'] != '' && is_null($error)) {
                $error = call_user_func(array($this, $dataArray2['function']), $dataArray2);
            }
            if (!is_null($error)) {
                array_push($errorArray, $error);
            }
        }
        return $errorArray;
    }

    private function validateUrl($dataArray) {
        $errorArray = array();
        if (filter_var($dataArray['data'], FILTER_VALIDATE_URL) === false) {
            $errorArray = array();
            $errorArray['controllId'] = $dataArray['controllId'];
            $errorArray['message'] = 'Nem megfelelő url!';
            return $errorArray;
        }
    }

    private function validateEmail($dataArray) {
        $errorArray = array();
        if (filter_var($dataArray['data'], FILTER_VALIDATE_EMAIL) === false) {
            $errorArray = array();
            $errorArray['controllId'] = $dataArray['controllId'];
            $errorArray['message'] = 'Nem megfelelő e-mail cím!';
            return $errorArray;
        }
    }

    private function validateMd5Pass($dataArray) {
        $errorArray = array();
        if (!preg_match('/[a-z0-9]+/i', $dataArray['data'])) {
            $errorArray = array();
            $errorArray['controllId'] = $dataArray['controllId'];
            $errorArray['message'] = 'Nem megfelelő jelszó!';
            return $errorArray;
        }
    }

    /*private function validateCreditCard($str, $controllId, $required) {
        if ((!is_null($required)) && ($str=='')) {
            return $controllId;
        } else {
            if (!preg_match('/^[0-9]{4}-[0-9]{4}-[0-9]{4}-[0-9]([0-9]{1,3}|[\ ]{1,3})$/i', $str) && !preg_match('/^[0-9]{4}-[0-9X]{6}-[0-9X]{5}$/i', $str)) {
                return $controllId;
            }
            $ccn = str_replace('-', '', $str);
            $sum = 0;
            for ($i = strlen($ccn) - 2; $i >= 0; $i -= 2) {
                $j = $ccn[$i] * 2;
                if ($j > 9) {
                    $j -= 9;
                }
                $sum += $j + $ccn[$i + 1];
            }
            if ($i == -1) {
                $sum += $ccn[0];
            }
            return (!($sum % 10));
        }
    }

    private function validateCreditExp($str, $controllId, $required) {
        if ((!is_null($required)) && ($str=='')) {
            return $controllId;
        } else {
            if (!preg_match('/^[0-9]{2}\/[0-9]{4}$/i', $str)) {
                return $controllId;
            }
        }
    }*/

    private function validate_edate($dataArray) {
        return (preg_match('/^[0-9]{2}\/[0-9]{2}\/[0-9]{4}$/i', $dataArray['data']));
    }

    private function validate_time() {

    }

    private function validate_datetime() {

    }

    private function validateInt($dataArray) {
        $errorArray = array();
        if (!is_numeric($dataArray['data'])) {
            $errorArray['controllId'] = $dataArray['controllId'];
            $errorArray['message'] = 'Ez az érték nem szám!';
            return $errorArray;
        }
        if (($dataArray['min']!='') && ($dataArray['max']!='')) {
            if ($dataArray['data'] < $dataArray['min']) {
                $errorArray['controllId'] = $dataArray['controllId'];
                $errorArray['message'] = 'Az érték kisebb mint a minimum érték!';
                return $errorArray;
            }

            if ($dataArray['data'] > $dataArray['max']) {
                $errorArray['controllId'] = $dataArray['controllId'];
                $errorArray['message'] = 'Az érték nagyobb mint a maximum érték!';
                return $errorArray;
            }
        }
    }

    private function validatePhone($dataArray) {
        $errorArray = array();
        if (!preg_match('/^[0-9]{8,}$/i', $dataArray['data'])) {
            $errorArray['controllId'] = $dataArray['controllId'];
            $errorArray['message'] = 'Nem megfelelő telefonszám!';
            return $errorArray;
        }
    }

    private function validateAlpha($dataArray) {
        $errorArray = array();
        if (!preg_match('/^[a-z' . $this->accented_chars . ']+$/i', $dataArray['data'])) {
            $errorArray['controllId'] = $dataArray['controllId'];
            $errorArray['message'] = 'Csak betűk írhatók!';
            return $errorArray;
        }
    }

    private function validateAlphaWs($dataArray) {
        $errorArray = array();
        if (!preg_match('/^[a-z' . $this->accented_chars . '\(\)\&\ \+\-\,\.\'\"\/\\\\]+$/i', $dataArray['data'])) {
            $errorArray['controllId'] = $dataArray['controllId'];
            $errorArray['message'] = 'Csak betűk írhatók!';
            return $errorArray;
        }
    }

    private function validateAlphaNum($dataArray) {
        $errorArray = array();
        if (!preg_match('/^[0-9a-z' . $this->accented_chars . ']+$/i', $dataArray['data'])) {
            $errorArray['controllId'] = $dataArray['controllId'];
            $errorArray['message'] = 'Csak betűk és számok írthatók!';
            return $errorArray;
        }
    }

    private function validateAlphaNumWs($dataArray) {
        $errorArray = array();
        if (!preg_match('/^[0-9a-z' . $this->accented_chars . '\(\)\&\ \+\-\,\.\'\"\/\\\\]+$/i', $dataArray['data'])) {
            $errorArray['controllId'] = $dataArray['controllId'];
            $errorArray['message'] = 'Csak betűk és számok írthatók!';
            return $errorArray;
        }
    }

    private function validateText($dataArray) {
        $errorArray = array();
        if (!preg_match('/^[0-9a-zA-Z' . $this->accented_chars . '\*\!\#%_,;:@<>\(\)\&\ \+\-\,\.\'\"\/\\\\]+$/mi', $dataArray['data'])) {
            $errorArray['controllId'] = $dataArray['controllId'];
            $errorArray['message'] = 'Nem megfelelő érték!';
            return $errorArray;
        }
    }

    private function validateLink($dataArray) {
        $errorArray = array();
        if (!preg_match('/^[0-9a-z\-\_]+$/i', $dataArray['data'])) {
            $errorArray['controllId'] = $dataArray['controllId'];
            $errorArray['message'] = 'Nem megfelelő érték!';
            return $errorArray;
        }
    }

    private function validateDateDiff($dataArray) {

    }
    
    private function validateDate($dataArray) {
        $errorArray = array();
        if (!isset($dataArray['separator'])) {
            $dataArray['separator'] = '-';
        }
        $dateExploded = explode($dataArray['separator'], $dataArray['data']);
        /*if (intval($dateExploded[0], 10) < date('Y')) {
            $errorArray['controllId'] = $dataArray['controllId'];
            $errorArray['message'] = 'Az év nem lehet kisebb a mostani évnél!';
            return $errorArray;
        }*/

        /*if (intval($dateExploded[0], 10) > date('Y')) {
            $errorArray['controllId'] = $dataArray['controllId'];
            $errorArray['message'] = 'Az év nem lehet 115 évnél régebbi!';
            return $errorArray;
        }*/

        if (intval($dateExploded[1], 10) < 1 || intval($dateExploded[1], 10) > 12) {
            $errorArray['controllId'] = $dataArray['controllId'];
            $errorArray['message'] = 'A hónap értéke maximum 12!';
            return $errorArray;
        }

        if (intval($dateExploded[2], 10) < 1) {
            $errorArray['controllId'] = $dataArray['controllId'];
            $errorArray['message'] = 'A nap értéke nem lehet kisebb 1-nél!';
            return $errorArray;
        } else {
            switch (intval($dateExploded[1], 10)) {
                case 1:
                case 3:
                case 5:
                case 7:
                case 8:
                case 10:
                case 12:
                    if (intval($dateExploded[2], 10) > 31) {
                        $errorArray['controllId'] = $dataArray['controllId'];
                        $errorArray['message'] = 'Ebben a hónapban maximum 31 nap van!';
                        return $errorArray;
                    }
                    break;
                case 4 :
                case 6 :
                case 9 :
                case 11 :
                    if (intval($dateExploded[2]) > 30) {
                        $errorArray['controllId'] = $dataArray['controllId'];
                        $errorArray['message'] = 'Ebben a hónapban maximum 30 nap van!';
                        return $errorArray;
                    }
                    break;
                case 2 :
                    if (intval($dateExploded[0], 10) % 4 == 0) {
                        if (intval($dateExploded[2]) > 29) {
                            $errorArray['controllId'] = $dataArray['controllId'];
                            $errorArray['message'] = 'Ebben a hónapban maximum 29 nap van!';
                            return $errorArray;
                        }
                    } else {
                        if (intval($dateExploded[2], 10) > 28) {
                            $errorArray['controllId'] = $dataArray['controllId'];
                            $errorArray['message'] = 'Ebben a hónapban maximum 28 nap van!';
                            return $errorArray;
                        }
                    }
                    break;
            }
        }
    }
}