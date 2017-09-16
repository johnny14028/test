<?php

class CompleteRange {

    public function build($range) {
        $returnValue = $range;
        //obtenemos el primer y último item
        $firstItem = array_shift($range);
        $lastItem = array_pop($returnValue);
        $new_range = range($firstItem, $lastItem);
        return $new_range;
    }
    
    public function vd($var){
        echo "<pre>";
        print_r($var);
        echo "</pre>";
    }

}

$objCompleteRange = new CompleteRange();
$range =  [55, 58, 60];
$new_range = $objCompleteRange->build($range);
$objCompleteRange->vd($range);
$objCompleteRange->vd($new_range);
