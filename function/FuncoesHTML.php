<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of FuncoesHTML
 *
 * @author Alisson
 */
class FuncoesHTML {

    public function validateSelect($option, $value) {
        if ($option == $value) {
            return 'selected="selected"';
        }
    }

    public function validateChecked($option, $value) {
        if ($option == $value) {
            return 'checked="checked"';
        }
    }

    public function createOptions($array) {
        if (count($array) > 0) {
            foreach ($array as $value) {
                echo '<option value="' . $value['value'] . '">' . $value['nome'] . '</option>';
            }
        }
    }

    public function createCheckBox($array, $name) {
        echo "<div>";
        if (count($array) > 0) {
            foreach ($array as $value) {
                echo '<div style="float: left; margin: 10px 0 10px 20px"><input style="float: left" type="checkbox" name="' . $name . '[]" value="' . $value['value'] . '" /><span style="float: left; margin-left: 5px; font-weight: bold">' . $value['nome'] . '</span></div>';
            }
        }
        echo "</div>";
    }

    public function createOptionsValidate($value, $array) {
        if (count($array) > 0) {
            foreach ($array as $line) {
                if ($line['value'] == $value) {
                    echo '<option selected="selected" value="' . $line['value'] . '">' . $line['nome'] . '</option>';
                } else {
                    echo '<option value="' . $line['value'] . '">' . $line['nome'] . '</option>';
                }
            }
        }
    }

    public function createAlertas($type, $array) {
        if (count($array) > 0) {
            foreach ($array as $line) {
                if ($type == "P") {
                    echo '<p class="pendencia">
                            <img src="' . image . 'icons/error.png" />
                            <span>' . $line['origem'] . '</span>
                            <span>&nbsp;-&nbsp;</span>
                            <span>' . $line['descricao'] . '</span>
                        </p>';
                } else {
                    echo '<p class="observacao">
                            <img src="' . image . 'icons/warn.png" />
                            <span>' . $line['origem'] . '</span>
                            <span>&nbsp;-&nbsp;</span>
                            <span>' . $line['descricao'] . '</span>
                        </p>';
                }
            }
        }
    }

    public function completaStringLeft($string, $char, $length) {
        return str_pad($string, $length, $char, STR_PAD_LEFT);
    }

    public function completaStringRight($string, $char, $length) {
        return str_pad($string, $length, $char, STR_PAD_RIGHT);
    }

    function limpaNumero($value) {
        return preg_replace("/\D+/", "", trim($value));
    }

    function limpaString($string) {
        $string = str_replace("Á", "A", $string);
        $string = str_replace("À", "A", $string);
        $string = str_replace("Ã", "A", $string);
        $string = str_replace("Â", "A", $string);
        $string = str_replace("á", "a", $string);
        $string = str_replace("à", "a", $string);
        $string = str_replace("â", "a", $string);
        $string = str_replace("É", "E", $string);
        $string = str_replace("Ê", "E", $string);
        $string = str_replace("é", "e", $string);
        $string = str_replace("ê", "e", $string);
        $string = str_replace("í", "i", $string);
        $string = str_replace("Í", "I", $string);
        $string = str_replace("ó", "o", $string);
        $string = str_replace("õ", "o", $string);
        $string = str_replace("ô", "o", $string);
        $string = str_replace("Ó", "O", $string);
        $string = str_replace("Õ", "O", $string);
        $string = str_replace("Ô", "O", $string);
        $string = str_replace("ú", "u", $string);
        $string = str_replace("Ú", "U", $string);
        $string = str_replace("ç", "c", $string);
        $string = str_replace("Ç", "C", $string);
        $string = str_replace("º", " ", $string);
        $string = str_replace("ª", " ", $string);
        $string = str_replace("'", " ", $string);
        return $string;
    }

    function removeAcentoU($string) {
        $string = str_replace("Ç", "&Ccedil;", $string);
        $string = str_replace("ç", "&ccedil;", $string);
        $string = str_replace("Ã", "&Atilde;", $string);
        $string = str_replace("ã", "&atilde;", $string);
        $string = str_replace("Á", "&Aacute;", $string);
        $string = str_replace("á", "&aacute;", $string);
        $string = str_replace("À", "&Agrave;", $string);
        $string = str_replace("à", "&agrave;", $string);
        $string = str_replace("É", "&Eacute;", $string);
        $string = str_replace("é", "&eacute;", $string);
        $string = str_replace("Í", "&Iacute;", $string);
        $string = str_replace("í", "&iacute;", $string);
        $string = str_replace("Õ", "&otilde;", $string);
        $string = str_replace("õ", "&otilde;", $string);
        $string = str_replace("Ó", "&Oacute;", $string);
        $string = str_replace("ó", "&oacute;", $string);
        $string = str_replace("Ú", "&Uacute;", $string);
        $string = str_replace("ú", "&uacute;", $string);
        return $string;
    }
    
    public function getHTML($url) {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		if(!empty($post)) {
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
		} 
		$result = curl_exec($ch);
		curl_close($ch);
		return $result;
    }

}

?>
