<?php
require_once("../config.php");
require_once("../libs/utils.php");
require_once("../libs/classes/db.php");
require_once("../libs/classes/dbObj.php");
require_once("../libs/classes/sections.class.php");
require_once("../libs/classes/categories.class.php");
require_once("../libs/classes/questions.class.php");
require_once("../libs/classes/answers.class.php");

define("CATEGORY_ID", 4);
define("TYPE", "question");
define("START_ORDER", 9);

$dbInfo = array(
        "user" => DB_USER,
        "pass" => DB_PASS,
        "host" => DB_HOST,
        "name" => DB_BASE,
        "site" => "localhost"
    );
 
$questionTitles = array(
    "Local", "Rules & Definitions", "Key Contacts", "Regulatory", "O&M", "Pumper", "Installer", "Designer", "Community contact", "Other"
);


$answers = array(
    "Name" => "text",
    "Website" => "text",
    "Phone Number" => "text",
    "Email" => "text",
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
        $answersClass->saveAnswer($label, $type, "", 0, $questionID, $z);
        $z++;
    }
    
    $i++;
}