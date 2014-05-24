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

define("SECTION_ID", 28);
define("ORDER", 1);
define("LABEL", "Other ATT");

define ("BRAND_HINT", "Provide the manufacturer for a packaged system or the type of system for a generic technology.");
define ("LOCATION_HINT", "Where is your " .  strtolower(LABEL). " located?  You may upload an image of the location. ");
define ("ACCESS_HINT", "Likely access “Type” would be like a lid covering the media or distribution system, valve boxes over pressure distribution pipe cleanouts, or other access to the distribution system. For some systems the media and distribution system may be buried. Where is the access located? You may upload an image of the location.");
define ("ALARM_HINT", "Check if there is an alarm for the " .  strtolower(LABEL). ". Where is the alarm for the media filter located? You may upload an image of the location.");

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
$categoryID = $categoriesClass->saveCategory(LABEL, SECTION_ID, "spawn", "Enter the Number of ".LABEL, ORDER);

//Brand
$brandlID = $questionsClass->saveQuestion("Specific information for the brand/generic technology your system uses.", BRAND_HINT, $categoryID, "question", 1);
    $brandPDF = "You have a/an %SELF% " .  strtolower(LABEL). " system. Most sand filters are constructed from local materials and may not have a specific manufacturer (generic technology). However the distribution system or other parts may come as a package. Peat filters are sold as units from manufacturers.";
    $answersClass->saveAnswer("", "text", $brandPDF, 0, $brandlID, 0);


// Location
$locationID = $questionsClass->saveQuestion("Location", LOCATION_HINT, $categoryID, "question", 2);
    $locTxtID = $answersClass->saveAnswer("Location", "text", "", 0, $locationID, 0);
    $locImgID = $answersClass->saveAnswer("", "image", "%SELF%", 0, $locationID, 1);

    //On property
    $onPDF = "Your ATU is located on your property at %ID=$locTxtID%. Be sure the " .  strtolower(LABEL). " is protected from vehicle or equipment traffic and is accessible for maintenance.";
    $onID = $answersClass->saveAnswer("On the property", "radio", $onPDF, 0, $locationID, 2);

    // Off property
    $offPDF = "Your ATU is located off your property at %ID=$locTxtID%. Be sure the " .  strtolower(LABEL). " is protected from vehicle or equipment traffic and is accessible for maintenance.";
    $offID = $answersClass->saveAnswer("Off the property", "radio", $offPDF, 0, $locationID, 3);
    
    // Combination property
    $combPDF = "The location of your " .  strtolower(LABEL). " is a combination of on and off your property. Be sure that the " .  strtolower(LABEL). " is protected from vehicle or equipment traffic and is accessible for maintenance.";
    $combID = $answersClass->saveAnswer("Combination", "radio", $combPDF, 0, $locationID, 4);

// Access
$accessID = $questionsClass->saveQuestion("Access", ACCESS_HINT, $categoryID, "question", 3);
    $accTxtID = $answersClass->saveAnswer("Type", "text", "", 0, $accessID, 0);
    
    // Above grade
    $abovePDF = "The type of access to your " .  strtolower(LABEL). " is a/an %ID=$accTxtID% and is above grade. Easy access is important for maintenance and the proper functioning of the " .  strtolower(LABEL). ".";
    $aboveID = $answersClass->saveAnswer("Above grade", "radio", $abovePDF, 0, $accessID, 1);

    // Below grade
    $belowPDF = "The type of access to your " .  strtolower(LABEL). " is a/an %ID=$accTxtID% and is below grade. It is important to be able to access the aerobic treatment units for ongoing maintenance. Consider adding an above grade access.";
    $belowID = $answersClass->saveAnswer("Below grade", "radio", $belowPDF, 0, $accessID, 2);
    
    //Image
    $accImgID = $answersClass->saveAnswer("", "image", "", 0, $accessID, 3);
    
    // Location
    $accLocPDF = "<p>Locating and accessing the " .  strtolower(LABEL). " is essential for maintenance and the
continued proper functioning of the unit. The access to your " .  strtolower(LABEL). " is at %SELF% </p>

<p>%ID=$accImgID%</p>";
    $accLocTxtID = $answersClass->saveAnswer("Location", "text", $accLocPDF, 0, $accessID, 4);

// Alarm
$alarmID = $questionsClass->saveQuestion("Alarm", ALARM_HINT, $categoryID, "question", 4);
    $yesID = $answersClass->saveAnswer("Yes", "radio", "", 0, $alarmID, 0);
    $yesImgID = $answersClass->saveAnswer("", "image", "", $yesID, $alarmID, 1);
    $yesTxtID = $answersClass->saveAnswer("Location", "text", "", $yesID, $alarmID, 2);
    $visPDF = "<p>Your " .  strtolower(LABEL). " has a visual alarm located at %ID=$yesTxtID%. Alarms are important because they notify you when your " .  strtolower(LABEL). " has a problem. This may allow you to find a problem before it becomes worse and more costly to repair.</p>
<p>%ID=$yesImgID%</p>";
    $answersClass->saveAnswer("Visual", "checkbox", $visPDF, $yesID, $alarmID, 3);
    
    $audPDF = "<p>Your " .  strtolower(LABEL). " has an audible alarm located at %ID=$yesTxtID%. Alarms are important because they notify you when your " .  strtolower(LABEL). " has a problem. This may allow you to find a problem before it becomes worse and more costly to repair. </p>
<p>%ID=$yesImgID%</p>";
    $answersClass->saveAnswer("Audible", "checkbox", $audPDF, $yesID, $alarmID, 4);
    
    $remotePDF = "<p>Your " .  strtolower(LABEL). " has a remote alarm located at %ID=$yesTxtID% Alarms are important because they notify you when your " .  strtolower(LABEL). " has a problem. This may allow you to find a problem before it becomes worse and more costly to repair. </p>
<p>%ID=$yesImgID%</p>";
    $answersClass->saveAnswer("Remote", "checkbox", $remotePDF, $yesID, $alarmID, 5);
    
    $answersClass->saveAnswer("No", "radio", "<p>Your " .  strtolower(LABEL). " has no alarm. Alarms are important because they notify you when your " .  strtolower(LABEL). " has a problem. This may allow you to find a problem before it becomes worse and more costly to repair. Consider adding an alarm.</p>", 0, $alarmID, 6);

    
echo "done";