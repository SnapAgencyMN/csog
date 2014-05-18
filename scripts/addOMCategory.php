<?php

ini_set('display_errors', 1);
require_once("../config.php");
require_once("../libs/utils.php");
require_once("../libs/classes/db.php");
require_once("../libs/classes/dbObj.php");
require_once("../libs/classes/sections.class.php");
require_once("../libs/classes/categories.class.php");
require_once("../libs/classes/questions.class.php");
require_once("../libs/classes/answers.class.php");

define("SECTION_ID", 8);
define("ORDER", 2);
define("LABEL", "Enter number of activities necessary for maintaining this system");

define ("ACTIVITY_HINT", "Enter text in sentence form of the kinds of required or suggested operation and maintenance necessary for this system.");
define ("PROF_HINT", "Enter text in sentence form of the kinds of required or suggested operation and maintenance necessary for this system that should only be carried out by a professional.");
define ("HOME_HINT", "Enter text in sentence form of the kinds of required or suggested operation and maintenance necessary for this system that are safe for a homeowner to perform.");

$dbInfo = array(
        "user" => DB_USER,
        "pass" => DB_PASS,
        "host" => DB_HOST,
        "name" => DB_BASE,
        "site" => "localhost"
    );
 
$db = new Db($dbInfo);

$categoriesClass = new Categories($db);
$questionsClass = new Questions($db);
$answersClass = new Answers($db);

// Adding new category
$categoryID = $categoriesClass->saveCategory("Operation & Maintenance", SECTION_ID, "spawn", LABEL, ORDER);

//Add title
//$titleID = $questionsClass->saveQuestion("O&M", "", $categoryID, "title", 0);

$activityID = $questionsClass->saveQuestion("Activity", ACTIVITY_HINT, $categoryID, "question", 0);
$answersClass->saveAnswer("Details", "text", "", 0, $activityID, 0);
$answersClass->saveAnswer("Frequency", "text", "", 0, $activityID, 1);

$profID = $questionsClass->saveQuestion("Professional activities", PROF_HINT, $categoryID, "question", 1);
$answersClass->saveAnswer("Details", "text", "", 0, $profID, 0);
$answersClass->saveAnswer("Frequency", "text", "", 0, $profID, 1);

$homeID = $questionsClass->saveQuestion("Homeowner activities", HOME_HINT, $categoryID, "question", 0);
$answersClass->saveAnswer("Details", "text", "", 0, $homeID, 0);
$answersClass->saveAnswer("Frequency", "text", "", 0, $homeID, 1);

echo "done";