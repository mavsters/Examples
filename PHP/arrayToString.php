<?php

echo array2string(array("test","hello","world"));

function array2string($data)
{
    $log_a = "";
    foreach ($data as $key => $value) {
        if (is_array($value)) {
            $log_a .= "[" . $key . "] => (" . array2string($value) . ") \n";
        } else {
            $log_a .= "[" . $key . "] => " . $value . "\n";
        }
    }
    return $log_a;
}