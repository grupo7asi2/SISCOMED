<?php

function encode_this($string) {
    $string = utf8_encode($string);
    $control = "qwerty"; //defino la llave para encriptar la cadena, cambiarla por la que deseamos usar
    $string = $control . $string . $control; //concateno la llave para encriptar la cadena
    $string = base64_encode($string); //codifico la cadena
    return($string);
}

function decode_get2($string) {
    $cad = explode("?", $string); //separo la url desde el ?
    $string = $cad[1]; //capturo la url desde el separador ? en adelante
    $string = base64_decode($string); //decodifico la cadena
    $control = "qwerty"; //defino la llave con la que fue encriptada la cadena,, cambiarla por la que deseamos usar
    $string = str_replace($control, "", "$string"); //quito la llave de la cadena
//procedo a dejar cada variable en el $_GET
    $cad_get = explode("&", $string); //separo la url por &
    foreach ($cad_get as $value) {
        $val_get = explode("=", $value); //asigno los valores al GET
        $SA[$val_get[0]] = utf8_decode($val_get[1]);
    }
    return $SA;
}
?>