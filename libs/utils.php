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