<?php
ini_set("error_reporting", "(E_ALL ^ E_DEPRECATED)");
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past

require_once(FS_PATH . "php/mpdf/mpdf.php");

/* Page settings */
$margin_left = '10';
$margin_right = '10';
$margin_top = '5';
$margin_bottom = '28';
$margin_header = '10';
$margin_footer = '5';

$mpdf=new mPDF('', 'A4', '', '', $margin_left, $margin_right, $margin_top, $margin_bottom, $margin_header, $margin_footer);
$mpdf->setAutoTopMargin = "stretch";

$css = "";
$css .= "body { font-family:sans-serif;}\n";
$css .= ".right-image {float:right; width:300px;margin-left:20px;}\n";
$css .= "h4 {color:#5e3229; margin-bottom:10px;margin-top:0px;}\n";
$css .= "h3 {color:#5e3229; margin-bottom:10px;margin-top:0px;}\n";
$css .= "h2 {color:#5e3229; margin-bottom:10px;margin-top:0px;}\n";
$css .= "h1 {color:#5e3229; margin-bottom:10px;margin-top:0px;}\n";
$css .= "img {max-width: 800px; max-height:600px; width:80%;margin-left:10%;}\n";
$css .= "div {page-break-inside: avoid;}\n";
$css .= ".content { margin-left:30px; margin-top:0px; margin-bottom:10px;}\n";
$css .= ".pdfImg { width:500px;}\n";
$css .= "p {margin-top:0px; margin-bottom:10px;}\n";
$css .= "table {margin-left:30px; margin-bottom:10px;}\n";
$css .= ".maint {border-collapse:collapse;}\n";
$css .= ".mainttd {border:1px solid #000;}\n";

$mpdf->WriteHTML($css,1); // Parses HTML as CSS only

$times["Header"] = microtime(true); 

require_once ("header.php");
require_once ("main.php");

$times["Finish"] = microtime(true); 

/*
pr_out($times);
echo "Time differences: <br />";

$first = true;
$last = null;
foreach ($times as $time)
{
    if ($first)
    {
        $last = $time;
        $first = false;
        continue;
    }
    
    $difference = round($time-$last);
    echo "difference: $difference seconds<br />";
    
    $last = $time;
    
}
 * 
 */
$mpdf->Output();

