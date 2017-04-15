<?php
class CoreFunctions {
    function getValuta($BeValuta) {
        $postData = array('rateYearSelect' => '2014',
            'rateMonthSelect' => '7',
            'rateDaySelect' => '18');
        $context = stream_context_create(array(
            'http' => array(
                'method' => 'POST',
                'header' => "Content-type: text/html\r\n",
                'content' => http_build_query($postData)
            ),
        ));
        echo "postData:" . http_build_query($postData) . "\n";

        $return = file_get_contents('https://www.mkb.hu/friss_informaciok/arfolyamok/mkb_penztari/index.html', false, $context);
        echo $return;
    }

    function DateDiff($interval, $datefrom, $dateto, $using_timestamps = false) {
        /*
          $interval can be:
          yyyy - Number of full years
          q - Number of full quarters
          m - Number of full months
          y - Difference between day numbers
          (eg 1st Jan 2004 is "1", the first day. 2nd Feb 2003 is "33". The datediff is "-32".)
          d - Number of full days
          w - Number of full weekdays
          ww - Number of full weeks
          h - Number of full hours
          n - Number of full minutes
          s - Number of full seconds (default)
         */
        if (!$using_timestamps) {
            $datefrom = strtotime($datefrom, 0);
            $dateto = strtotime($dateto, 0);
        }
        $difference = $dateto - $datefrom; // Difference in seconds

        switch ($interval) {

            case 'yyyy': // Number of full years
                $years_difference = floor($difference / 31536000);
                if (mktime(date("H", $datefrom), date("i", $datefrom), date("s", $datefrom), date("n", $datefrom), date("j", $datefrom), date("Y", $datefrom) + $years_difference) > $dateto) {
                    $years_difference--;
                }
                if (mktime(date("H", $dateto), date("i", $dateto), date("s", $dateto), date("n", $dateto), date("j", $dateto), date("Y", $dateto) - ($years_difference + 1)) > $datefrom) {
                    $years_difference++;
                }
                $datediff = $years_difference;
                break;
            case "q": // Number of full quarters
                $quarters_difference = floor($difference / 8035200);
                while (mktime(date("H", $datefrom), date("i", $datefrom), date("s", $datefrom), date("n", $datefrom) + ($quarters_difference * 3), date("j", $dateto), date("Y", $datefrom)) < $dateto) {
                    $months_difference++;
                }
                $quarters_difference--;
                $datediff = $quarters_difference;
                break;
            case "m": // Number of full months
                $months_difference = floor($difference / 2678400);
                while (mktime(date("H", $datefrom), date("i", $datefrom), date("s", $datefrom), date("n", $datefrom) + ($months_difference), date("j", $dateto), date("Y", $datefrom)) < $dateto) {
                    $months_difference++;
                }
                $months_difference--;
                $datediff = $months_difference;
                break;
            case 'y': // Difference between day numbers
                $datediff = date("z", $dateto) - date("z", $datefrom);
                break;
            case "d": // Number of full days
                $datediff = floor($difference / 86400);
                break;
            case "w": // Number of full weekdays
                $days_difference = floor($difference / 86400);
                $weeks_difference = floor($days_difference / 7); // Complete weeks
                $first_day = date("w", $datefrom);
                $days_remainder = floor($days_difference % 7);
                $odd_days = $first_day + $days_remainder; // Do we have a Saturday or Sunday in the remainder?
                if ($odd_days > 7) { // Sunday
                    $days_remainder--;
                }
                if ($odd_days > 6) { // Saturday
                    $days_remainder--;
                }
                $datediff = ($weeks_difference * 5) + $days_remainder;
                break;
            case "ww": // Number of full weeks
                $datediff = floor($difference / 604800);
                break;
            case "h": // Number of full hours
                $datediff = floor($difference / 3600);
                break;
            case "n": // Number of full minutes
                $datediff = floor($difference / 60);
                break;
            default: // Number of full seconds (default)
                $datediff = $difference;
                break;
        }
        return $datediff;
    }

    function CurrencyFormat($number) {
        if (strlen($number) >= 12) {
            $szamol = strlen($number) - 12;
            $formatedNumber = substr($number, 0, $szamol) . " " . substr($number, $szamol, 3) . " " . substr($number, $szamol + 3, 3) . " " . substr($number, $szamol + 6, 3) . " " . substr($number, $szamol + 9, 3);
        } else if (strlen($number) >= 9) {
            $szamol = strlen($number) - 9;
            $formatedNumber = substr($number, 0, $szamol) . " " . substr($number, $szamol, 3) . " " . substr($number, $szamol + 3, 3) . " " . substr($number, $szamol + 6, 3);
        } else if (strlen($number) >= 6) {
            $szamol = strlen($number) - 6;
            $formatedNumber = substr($number, 0, $szamol) . " " . substr($number, $szamol, 3) . " " . substr($number, $szamol + 3, 3);
        } else if (strlen($number) >= 3) {
            $szamol = strlen($number) - 3;
            $formatedNumber = substr($number, 0, $szamol) . " " . substr($number, $szamol, 3);
        }

        return $formatedNumber;
    }
    
    function splitByWords($text, $splitLength = 200) {
        // explode the text into an array of words
        $wordArray = explode(' ', $text);

        // Too many words
        if (sizeof($wordArray) > $splitLength) {
            // Split words into two arrays
            $firstWordArray = array_slice($wordArray, 0, $splitLength);
            $lastWordArray = array_slice($wordArray, $splitLength + 1, sizeof($wordArray));

            // Turn array back into two split strings 
            $firstString = implode(' ', $firstWordArray);
            $lastString = implode(' ', $lastWordArray);
            return array($firstString, $lastString);
        }
        // if our array is under the limit, just send it straight back
        return array($text);
    }

    function round_up1($value) {
        if ($value - intval($value) >= 0.5) {
            return(ceil($value));
        } else {
            return(floor($value));
        }
    }

    function round_5ft($value) {

        $maradek = fmod(round_up1($value), 5);
        if ($maradek == 0) {
            return($value);
        }
        $stringe = (string) round_up1($value);
        $last = intval(substr($stringe, -1, 1));
        switch ($last) {
            case 1:
            case 2:
                if (intval($value / 10) < 0.3) {
                    return(0);
                }
                return(intval($value / 10) * 10);
                break;
            case 3:
            case 4:
            case 6:
            case 7:
                if (intval($value / 10) < 0.8) {
                    return(5);
                }
                return(intval($value / 10) * 10) + 5;
                break;

            case 8:
            case 9:
                return($value + (5 - fmod($value, 5)));
                break;

            default:
                return(0);
                break;
        }
    }

    function vesszocsere($BeString) {
        $Vanaposztrof = 0;
        for ($i = 0; $i < strlen($BeString); $i++) {
            if ($BeString[$i] == "'") {
                if ($Vanaposztrof == 0) {
                    $Vanaposztrof = 1;
                } else {
                    $Vanaposztrof = 0;
                }
            }
            if ($BeString[$i] == ",") {
                if ($Vanaposztrof == 1) {
                    $BeString[$i] = "�";
                }
            }
        }
        return($BeString);
    }
    
    function getvaluta($BeBank, $BeValuta, $BeDatum) {
        $erep = error_reporting(0);
        $url = "http://napiarfolyam.hu/$BeDatum/$BeBank/";
        $head = get_headers($url);
        $homepage = str_replace("> ", ">", file_get_contents($url));

        $findValuta = strpos(strtoupper($homepage), ">$BeValuta</A>");
        $td = explode("<td>", substr($homepage, $findValuta));

        $findtd = strpos($td[1], ">");
        $findpertd = strpos($td[1], "</td>");
        $vetel = substr($td[1], $findtd + 1, $findpertd - $findtd - 1);
        if ($BeBank != "MNB") {
            $findtd = strpos($td[2], ">");
            $findpertd = strpos($td[2], "</td>");
            $eladas = substr($td[2], $findtd + 1, $findpertd - $findtd - 1);

            $findtd = strpos($td[3], ">");
            $findpertd = strpos($td[3], "</td>");
            $datum = substr($td[3], $findtd + 1, $findpertd - $findtd - 1);
            $datumT = explode(" ", $datum);
            $datum = $datumT[0];
        } else {
            $eladas = $vetel;
            $findpertd = strpos($td[2], "</td>");
            $datum = substr($td[2], 0, $findpertd);
            $datumT = explode(" ", $datum);
            $datum = $datumT[0];
        }
        error_reporting($erep);
        return($vetel . "�" . $eladas . "�" . $datum);
    }

    function get_EUR($BeValuta) { // 
        $erep = error_reporting(0);
        $mnburl = "http://www.mnb.hu//AllandoTartalmak//ExchangeRateRss//" . $BeDatum . "_$BeValuta_ExchangeRate//";
        $head = get_headers($mnburl);
        $homepage = file_get_contents($mnburl);
        error_reporting($erep);
        if ($head != null) {
            if (strstr($head[0], "404 Not Found")) {
                return("404Error");
            }
            $Vag = explode("1 $BeValuta = ", $homepage);
            $Ft = explode(" Ft", $Vag[1]);
            $valuta = $Ft[0];
            return($valuta);
        } else {
            return(NULL);
        }
    }

    function Osszefuz($BeString, $BeSep, $BeMit) {
        if (strlen($BeString) > 0) {
            return($BeString . $BeSep . $BeMit);
        } else {
            return($BeString . $BeMit);
        }
    }

    function num2text($nsz) {
        $hatv = array('', 'ezer', 'millió', 'milliárd', 'billió', 'billiárd', 'trillió', 'trilliárd', 'kvadrillió', 'kvadrilliárd', 'kvintillió', 'kvintilliárd', 'szextilliárd',
            'szextilliárd', 'szeptillió', 'szeptilliárd', 'oktillió', 'oktilliárd',
            'nonillió', 'nonilliárd', 'decillió', 'decilliárd', 'centillió');
        $tizesek = array('', '', 'harminc', 'negyven', 'ötven', 'hatvan', 'hetven', 'nyolcvan', 'kilencven');
        $szamok = array('egy', 'kettő', 'három', 'négy', 'öt', 'hat', 'hét', 'nyolc', 'kilenc');
        $tsz = '';
        $ej = ($nsz < 0 ? '- ' : '');
        $sz = trim('' . floor($nsz));
        $hj = 0;

        if ($sz == '0') {
            $tsz = 'nulla';
        } else {
            $nullak = substr("0000", 0, 3 - strlen($sz));
            while ($sz > '') {
                $hj++;
                $t = '';

                $wsz = substr('00' . substr($nullak . $sz, -3), -3);
                $tizesek[0] = ($wsz[2] == '0' ? 'tíz' : 'tizen');
                $tizesek[1] = ($wsz[2] == '0' ? 'húsz' : 'huszon');
                if ($c = $wsz[0]) {
                    if ($c>0) {
                        $t = $szamok[$c - 1] . 'száz';
                    }        
                }
                if ($c = $wsz[1]) {
                    if ($c>0) {
                        $t.=$tizesek[$c - 1];     
                    }
                }
                if ($c = $wsz[2]) {
                    if ($c>0) {
                        $t.=$szamok[$c - 1];
                    }
                }

                $tsz = ($t ? $t . $hatv[$hj - 1] : '') . ($tsz == '' ? '' : ($nsz > 2000 ? '-' : '')) . $tsz;
                $sz = substr($sz, 0, -3);
            }
        }
        return $ej . $tsz;
    }

    function Cimletezo($BeSzam, $Cimletek) {
        $cimletdarab = count($Cimletek);
        $Maradek = $BeSzam;
        for ($i = 0; $i < $cimletdarab; $i++) {
            $Darab[] = floor($Maradek / $Cimletek[$i]);
            $szorzat = number_format($Darab[$i] * $Cimletek[$i], 2, ".", "");
            $Maradek = number_format($Maradek - $szorzat, 2, ".", "");
        }
        return($Darab);
    }
}

