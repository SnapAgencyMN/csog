<?php

function pr_out($arr)
{
    echo "<pre style='background-color:white;'>";
    print_r($arr);
    echo "</pre>";
}

function out($m)
{
    echo "$m\n";
}

function l_out($m, $logFile=NULL)
{
    $date = date("Y-m-d H:i:s");
    
    if ($logFile)
        error_log("[$date] ".$m."\n", 3, $logFile);
    else
        error_log("[$date] ".$m."\n");
}

function getParameterString($param, $default = "") 
{
    if (isset($_REQUEST[$param]))
        return $_REQUEST[$param];
    else
        return $default;
}

function getParameterNumber($param, $default = 0) 
{
    if (isset($_REQUEST[$param])) 
    {
        $tmp = trim($_REQUEST[$param]);
        if (is_numeric($tmp))
            return $tmp;
    }

    return $default;
}

function getParameterArray($param) 
{
    $result = Array();

    if (isset($_REQUEST[$param]) && is_array($_REQUEST[$param])) {
        foreach ($_REQUEST[$param] as $item) {
            array_push($result, convertSpecialQuotes($item));
        }
    }
    return $result;
}

function convertSpecialQuotes($str) {
    // Trying a different approach, as byte conversion falls over when dealing with double byte characters.
    // this is a bit slower, but more reliable.
    $_encStr = urlencode($str);
    $_encStr = str_replace("%E2%80%98", "%27", $_encStr);
    $_encStr = str_replace("%E2%80%99", "%27", $_encStr);

    $_encStr = str_replace("%E2%80%9C", "%22", $_encStr);
    $_encStr = str_replace("%E2%80%9D", "%22", $_encStr);

    return urldecode($_encStr);
}