<?php
class mainValidator {
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