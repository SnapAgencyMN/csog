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

$sectionDetails = $sectionsClass->getDetails($sectionID);
$categories = $categoriesClass->listCategories($sectionID); 

$nextSectionID = $sectionsClass->getNextSectionID($sectionID);

require_once("actions.php");

// Print out section title
echo "
    <h2>{$sectionDetails['title']}</h2>
    <form action='".WS_URL."projects/view/$projectID/$nextSectionID' id='mainPage' method='POST'>
        <input type='hidden' name='save_sectionID' value='$sectionID' />
";

if ($sectionDetails['type'] == "parent")
    require_once("parent_section.php");
else
{
    // Printing categories
    foreach ($categories as $category)
    {
        switch ($category['type'])
        {
            case "normal":
                echoCategory($category, 'normal');
                break;
            case "spawn":
                echoSpawnCategory($category);
                break;
            
        }
    }
}
echo "</form>";
echo "<a href='#' onclick=\"submitForm('mainPage'); return false;\" class='nextSectionLink'>Next Section</a>";
