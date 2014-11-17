<?php
require_once("helper_functions.php");

if (!isset($questionsClass))
    $questionsClass = new Questions($db);

if (!isset($sectionsClass))
    $sectionsClass = new Sections($db);

if (!isset($categoriesClass))
    $categoriesClass = new Categories($db);

if (!isset($answersClass))
    $answersClass = new Answers($db);

$userID = $_SESSION['USER']['ID'];

$sections = $sectionsClass->listTopSections();

$i=2;
foreach ($sections as $section)
{
    $secN = $i-1;
    $times["Section $secN start"] = microtime(true); 
    $html = "";
    switch ($section['type'])
    {
        case "standalone":
            printSection($section);
            break;
        case "parent":
            $html .= "<h2>{$section['title']}</h2>";
            $children = $sectionsClass->listChlidrenSectionsForUser($section['sectionID'], $userID);
            foreach ($children as $child)
            {
                $sect = $sectionsClass->getDetails($child['sectionID']);
                printSection($sect);
            }
            break;
    }
    $romeNumber = rome($i);
    
    $mpdf->Bookmark("$romeNumber. {$section['title']}", 0);
    $mpdf->WriteHTML($html,2);
    $mpdf->AddPage();
    $times["Section $secN finish"] = microtime(true); 
    $i++;
    
    }
