<?php
require_once("../config.php");
require_once("../libs/utils.php");
require_once("../libs/classes/db.php");
require_once("../libs/classes/dbObj.php");
require_once("../libs/classes/sections.class.php");
require_once("../libs/classes/categories.class.php");
require_once("../libs/classes/questions.class.php");
require_once("../libs/classes/answers.class.php");

define("CATEGORY_ID", 63);
define("TYPE", "question");
define("START_ORDER", 2);

$dbInfo = array(
        "user" => DB_USER,
        "pass" => DB_PASS,
        "host" => DB_HOST,
        "name" => DB_BASE,
        "site" => "localhost"
    );
 
$questionTitles = array(
    "Forest fire", 
    "Freezing", 
    "Pests/rodents", 
    "Power failure", 
    "Roots",
    "Tree uprooting",
    "Vegetation",
    "Well related issues",
);


$answers = array(
    "Yes" => "checkbox",
);

$db = new Db($dbInfo);
$questionsClass = new Questions($db);
$answersClass = new Answers($db);

$i = START_ORDER;
foreach ($questionTitles as $title)
{
    
    $questionID = $questionsClass->saveQuestion($title, "", CATEGORY_ID, TYPE, $i);
    
    $z=0;
    foreach ($answers as  $label => $type)
    {
        $parentID = $answersClass->saveAnswer($label, $type, "", 0, $questionID, $z);
        // Saving children answers !HARDCODED!
        //$answersClass->saveAnswer("Setback in feet", "text", "", $parentID, $questionID, $z+1);
        $z++;
    }
    
    $i++;
}