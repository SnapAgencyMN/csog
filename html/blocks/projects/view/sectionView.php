<?php
require_once("helper_functions.php");

if (!isset($questionsTable))
    $questionsTable = new DbObject($db, 'questions2', false);

if (!isset($sectionsClass))
    $sectionsClass = new Sections($db);

if (!isset($categoriesTable))
    $categoriesTable = new DbObject($db, "question_categories", false);

if (!isset($answersTable))
    $answersTable = new DbObject($db, 'answers2', false);

$sectionDetails = $sectionsClass->getDetails($sectionID);
$categories = $categoriesTable->fetchAll(" WHERE `sectionID` = $sectionID ORDER BY `order`");

// Print out section title
echo "<h2>{$sectionDetails['title']}</h2>";

if ($sectionDetails['type'] == "parent")
    require_once("parent_section.php");

// Printing categories
foreach ($categories as $category)
{
    echo "<h3 class='question_header'>{$category['title']}</h3>";
    
    $questions = $questionsTable->fetchAll(" WHERE `categoryID` = {$category['id']} ORDER BY `order`");
    
    echo "<div class='question_set_wrapper hidden'>";
    
    foreach ($questions as $question)
    {
        echo "
            <div class='question_set_row'>
                <div class='question_set_row_hint'>
                    <img src='".WS_URL."/media/hint.png' alt='Hint' title='Current number of homes or businesses connected to system.'>
                </div>
                <div class='question_set_row_title'>
                    {$question['title']}
                </div>
        ";
                    
        $answers = $answersTable->fetchAll(" WHERE `questionID` = {$question['id']} ORDER BY `order`");
        echo "<div class='question_set_row_field'>";
        foreach ($answers as $answer)
        {
            echo "<br />";
            printAnswer($answer);
            echo "<br />";
        }
        echo "</div>
            </div>
            <div class='clear'></div>
        ";
    }
    echo "</div>";
}

