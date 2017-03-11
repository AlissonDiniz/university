<?php

function digitoVerificador_nossonumero($numero) {
    $resto2 = modulo_11($numero, 9, 1);
    $digito = 11 - $resto2;
    if ($digito == 10 || $digito == 11) {
        $dv = 0;
    } else {
        $dv = $digito;
    }
    return $dv;
}

function digitoVerificador_barra($numero) {
    $resto2 = modulo_11($numero, 9, 1);
    if ($resto2 == 0 || $resto2 == 1 || $resto2 == 10) {
        $dv = 1;
    } else {
        $dv = 11 - $resto2;
    }
    return $dv;
}

function formata_numero($numero, $loop, $insert, $tipo = "geral") {
    if ($tipo == "geral") {
        $numero = str_replace(",", "", $numero);
        while (strlen($numero) < $loop) {
            $numero = $insert . $numero;
        }
    }
    if ($tipo == "valor") {
        $numero = str_replace(",", "", $numero);
        while (strlen($numero) < $loop) {
            $numero = $insert . $numero;
        }
    }
    if ($tipo == "convenio") {
        while (strlen($numero) < $loop) {
            $numero = $numero . $insert;
        }
    }
    return $numero;
}

function esquerda($entra, $comp) {
    return substr($entra, 0, $comp);
}

function direita($entra, $comp) {
    return substr($entra, strlen($entra) - $comp, $comp);
}

function fator_vencimento($data) {
    $data = explode("/", $data);
    $ano = $data[2];
    $mes = $data[1];
    $dia = $data[0];
    return(abs((_dateToDays("1997", "10", "07")) - (_dateToDays($ano, $mes, $dia))));
}

function _dateToDays($year, $month, $day) {
    $century = substr($year, 0, 2);
    $year = substr($year, 2, 2);
    if ($month > 2) {
        $month -= 3;
    } else {
        $month += 9;
        if ($year) {
            $year--;
        } else {
            $year = 99;
            $century--;
        }
    }
    return ( floor(( 146097 * $century) / 4) +
            floor(( 1461 * $year) / 4) +
            floor(( 153 * $month + 2) / 5) +
            $day + 1721119);
}

function modulo_10($num) {
    $numtotal10 = 0;
    $fator = 2;

    for ($i = strlen($num); $i > 0; $i--) {
        $numeros[$i] = substr($num, $i - 1, 1);
        $temp = $numeros[$i] * $fator;
        $temp0 = 0;
        foreach (preg_split('//', $temp, -1, PREG_SPLIT_NO_EMPTY) as $k => $v) {
            $temp0+=$v;
        }
        $parcial10[$i] = $temp0;
        $numtotal10 += $parcial10[$i];
        if ($fator == 2) {
            $fator = 1;
        } else {
            $fator = 2;
        }
    }

    $resto = $numtotal10 % 10;
    $digito = 10 - $resto;
    if ($resto == 0) {
        $digito = 0;
    }

    return $digito;
}

function modulo_11($num, $base = 9, $r = 0) {
    $soma = 0;
    $fator = 2;
    for ($i = strlen($num); $i > 0; $i--) {
        $numeros[$i] = substr($num, $i - 1, 1);
        $parcial[$i] = $numeros[$i] * $fator;
        $soma += $parcial[$i];
        if ($fator == $base) {
            $fator = 1;
        }
        $fator++;
    }

    if ($r == 0) {
        $soma *= 10;
        $digito = $soma % 11;
        if ($digito == 10) {
            $digito = 0;
        }
        return $digito;
    } elseif ($r == 1) {
        $resto = $soma % 11;
        return $resto;
    }
}

function modulo_11_invertido($num) {
    $ftini = 2;
    $fator = $ftfim = 9;
    $soma = 0;

    for ($i = strlen($num); $i > 0; $i--) {
        $soma += substr($num, $i - 1, 1) * $fator;
        if (--$fator < $ftini) {
            $fator = $ftfim;
        }
    }

    $digito = $soma % 11;
    if ($digito > 9) {
        $digito = 0;
    }
    return $digito;
}

function monta_linha_digitavel($codigo) {
    $campo1 = substr($codigo, 0, 3) . substr($codigo, 3, 1) . substr($codigo, 19, 1) . substr($codigo, 20, 4);
    $campo1 = $campo1 . modulo_10($campo1);
    $campo1 = substr($campo1, 0, 5) . '.' . substr($campo1, 5);
    $campo2 = substr($codigo, 24, 10);
    $campo2 = $campo2 . modulo_10($campo2);
    $campo2 = substr($campo2, 0, 5) . '.' . substr($campo2, 5);
    $campo3 = substr($codigo, 34, 10);
    $campo3 = $campo3 . modulo_10($campo3);
    $campo3 = substr($campo3, 0, 5) . '.' . substr($campo3, 5);
    $campo4 = substr($codigo, 4, 1);
    $campo5 = substr($codigo, 5, 4) . substr($codigo, 9, 10);
    return "$campo1 $campo2 $campo3 $campo4 $campo5";
}

function geraCodigoBanco($numero) {
    $parte1 = substr($numero, 0, 3);
    $parte2 = modulo_11($parte1);
    return $parte1 . "-" . $parte2;
}
?>
