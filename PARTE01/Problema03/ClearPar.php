<?php

class ClearPar {

    public function build($string) {
        $returnValue = '';
        if(strlen(trim($string))>0){
            preg_match_all("/[(][)]/", $string, $output_array);
            if(is_array($output_array) && count($output_array)>0){
                $returnValue = implode('',array_shift($output_array));
            }
        }
        return $returnValue;
    }
}

$objClearPar = new ClearPar();
$string='((()';
$result = $objClearPar->build($string);
echo $string.' => '.$result;
