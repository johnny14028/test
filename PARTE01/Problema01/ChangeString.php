<?php

class ChangeString {

    private $firstLetterUpp;
    private $lastLetterUpp;

    public function __construct() {
        $this->firstLetterLow = ord('a');
        $this->lastLetterLow = ord('z');
        $this->firstLetterUpp = ord('A');
        $this->lastLetterUpp = ord('Z');
    }

    public function build($string) {
        $returnValue = '';
        if (strlen(trim($string)) > 0) {
            $string_array = $this->str_split_unicode($string);
            //recorremos el array para verificar cada caracter
            foreach ($string_array as $index => $item) {
                if (ctype_alpha($item)) {//verificamos si es alphabetico
                    $code = ord($item);
                    if (ctype_upper($item)) {//verficamos si es mayuscula
                        if ($code == $this->lastLetterUpp) {
                            $code = $this->firstLetterUpp;
                        } else {
                            $code = $code + 1;
                        }
                    } else {//es minuscula
                        if ($code == $this->lastLetterLow) {
                            $code = $this->firstLetterLow;
                        } else {
                            $code = $code + 1;
                        }
                    }
                    $item = chr($code);
                } else {
                    //validamos si es un caracter especial ñ, Ñ
                    if ($item == 'ñ') {
                        $item = 'o';
                    } elseif ($item == 'Ñ') {
                        $item = 'O';
                    }
                }
                $string_array[$index] = $item;
            }
            $returnValue = $string_array;
        }
        return $returnValue;
    }

    private function str_split_unicode($str, $length = 1) {
        $tmp = preg_split('~~u', $str, -1, PREG_SPLIT_NO_EMPTY);
        if ($length > 1) {
            $chunks = array_chunk($tmp, $length);
            foreach ($chunks as $i => $chunk) {
                $chunks[$i] = join('', (array) $chunk);
            }
            $tmp = $chunks;
        }
        return $tmp;
    }

}
//no soporta caracteres con tílde por no estar en el requerimiento inicial
$objChangeString = new ChangeString();
$string = '123 abcd*3';
$result = $objChangeString->build($string);
echo $string.' => '.implode('',$result);
