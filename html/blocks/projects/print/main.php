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
    $html = "";
    switch ($section['type'])
    {
        case "standalone":
            printSection($section);
            break;
        case "parent":
            $children = $sectionsClass->listChlidrenSectionsForUser($parentID, $userID);
            foreach ($children as $child)
            {
                printSection($child);
            }
            break;
    }
    $romeNumber = rome($i);
    
    $mpdf->Bookmark("$romeNumber. {$section['title']}", 0);
    $mpdf->WriteHTML($html,2);
    $mpdf->AddPage();
    $i++;
}
