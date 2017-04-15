<?php
class FormsClass {
    public function optionTolto($db, $BeTabla, $BeValue, $BeText, $Sel1, $PlusszMezo1 = "", $PlusszMezo2 = "", $PlusszMezo3 = "") {
        if (strtoupper((substr($BeTabla, 0, 6))) == "SELECT") {
            $sql = $BeTabla;
        } else {
            if ($BeText != "") {
                $sql = 'SELECT * FROM ' . $BeTabla . ' ORDER BY ' . $BeText;
            } else {
                $sql = 'SELECT * FROM ' . $BeTabla;
            }
        }

        $result = $db->selectQuery($sql);
        $Vissza = "";

        if ($PlusszMezo1 == "") {
            $PlusszMezo1Text = '';
        }
        if ($PlusszMezo2 == "") {
            $PlusszMezo2Text = '';
        }
        if ($PlusszMezo3 == "") {
            $PlusszMezo3Text = '';
        }

        foreach ($result as $lines) {

            $Mezo1 = $lines["$BeValue"];

            if ($Mezo1 == null) {
                $Mezo1 = "";
            }
            if ($BeValue != $BeText) {
                $Mezo2 = $lines["$BeText"];
            } else {
                $Mezo2 = $Mezo1;
            }
            if ($PlusszMezo1 != "") {
                $PlusszMezo1Text = ' - ' . $lines["$PlusszMezo1"];
            }
            if ($PlusszMezo2 != "") {
                $PlusszMezo2Text = ' - ' . $lines["$PlusszMezo2"];
            }
            if ($PlusszMezo3 != "") {
                $PlusszMezo3Text = ' - ' . $lines["$PlusszMezo3"];
            }

            if ($Sel1 == $Mezo1) {
                $selected = 'selected="selected" ';
            } else {
                $selected = '';
            }
            $Vissza.= '<option ' . $selected . 'value="' . $Mezo1 . '">' . $Mezo2 . $PlusszMezo1Text . $PlusszMezo2Text . $PlusszMezo3Text . '</option>';
        }
        return($Vissza);
    }
}