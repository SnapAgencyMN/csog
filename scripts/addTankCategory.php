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

define("SECTION_ID", 20);
define("ORDER", 0);
define("LABEL", "Other Tank");

define ("LOCATION_HINT", "Where is the " .  strtolower(LABEL). " located? You may upload an image for visual clarification.");
define ("MATERIAL_HINT", "What is the " .  strtolower(LABEL). " made of?");
define ("CAPACITY_HINT", "Enter the volume in gallons.");
define ("LOCAL_CODES_HINT", "Only answer if you know the local regulations/code.");
define ("EFFLUENT_SCREEN_HINT", "Check the box if the " .  strtolower(LABEL). " has an effluent screen.");
define ("SCREEN_ALARM_HINT", "Check if there is a high-water alarm. Where is the alarm located? You may upload an image of the location.");
define ("PUMP_HINT", "Check if the " .  strtolower(LABEL). " has a pump. Otherwise, skip to the Access questions.");
define ("PUMP_ACCESS_HINT", "Check if there is a high-water alarm for the " .  strtolower(LABEL). " pump. Where is the alarm located for the " .  strtolower(LABEL). " pump? You may upload an image of the location.");
define ("ACCESS_HINT", "Likely access `Type` would be like a manhole, inspection pipe, stub-out, clean-outs.

Where is the access located? You may upload an image of the location.");

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

// Location
$locationID = $questionsClass->saveQuestion("Location", LOCATION_HINT, $categoryID, "question", 0);

    //On property
    $onID = $answersClass->saveAnswer("On property", "radio", "", 0, $locationID, 0);
    $on_locID = $answersClass->saveAnswer("Location", "text", "", $onID, $locationID, 1);
    $on_imgID = $answersClass->saveAnswer("", "image", "", $onID, $locationID, 2);
    $onPDF = "%ID=$on_imgID%
    <p>Your " .  strtolower(LABEL). " is located on your property at %ID=$on_locID%.</p>
    ";
    $answersClass->saveAnswer("On property", "radio", $onPDF, 0, $locationID, 0, $onID);

    // Off property
    $offID = $answersClass->saveAnswer("Off property", "radio", "", 0, $locationID, 3);
    $off_locID = $answersClass->saveAnswer("Location", "text", "", $offID, $locationID, 4);
    $off_imgID = $answersClass->saveAnswer("", "image", "", $offID, $locationID, 5);
    $offPDF = "%ID=$off_imgID%
    <p>Your " .  strtolower(LABEL). " is located off your property at %ID=$off_locID%.";
    $answersClass->saveAnswer("Off property", "radio", $offPDF, 0, $locationID, 3, $offID);

    // Off property
    $combID = $answersClass->saveAnswer("Combination", "radio", "", 0, $locationID, 6);
    $comb_locID = $answersClass->saveAnswer("Location", "text", "", $combID, $locationID, 7);
    $comb_imgID = $answersClass->saveAnswer("", "image", "", $combID, $locationID, 8);
    $combPDF = "%ID=$comb_imgID%
    <p>The location of your " .  strtolower(LABEL). " is a combination of on and off your property and is located at %$comb_locID%.";
    $answersClass->saveAnswer("Combination", "radio", $combPDF, 0, $locationID, 6, $combID);

// Material
$materialID = $questionsClass->saveQuestion("Material", MATERIAL_HINT, $categoryID, "question", 1);
    $matPDF = "" .  ucfirst(LABEL). "s should be constructed of the same materials and by the same procedures as septic tanks. Lighter weight materials are more prone to flotation, so tanks made of plastic or fiberglass need to be protected against flotation. Your " .  strtolower(LABEL). " is made of %SELF%.";
    $answersClass->saveAnswer("", "text", $matPDF, 0, $materialID, 0);

// Material
$capacityID = $questionsClass->saveQuestion("Capacity", CAPACITY_HINT, $categoryID, "question", 2);
    $capPDF = "Your " .  strtolower(LABEL). " holds %SELF% gallons.";
    $answersClass->saveAnswer("", "text", $capPDF, 0, $capacityID, 0);

// Does this capacity meet local codes
$localCodesID = $questionsClass->saveQuestion("Does this capacity meet local codes?", LOCAL_CODES_HINT, $categoryID, "question", 3);
    $answersClass->saveAnswer("Yes", "radio", "Your " .  strtolower(LABEL). " meets local codes.", 0, $localCodesID, 0);
    $answersClass->saveAnswer("No", "radio", "Your " .  strtolower(LABEL). " does not meet local codes (i.e., you do not have an adequately sized " .  strtolower(LABEL). " for your facility). It is recommended that you increase the number of tanks, pump more frequently, or severely reduce your water use at this facility.", 0, $localCodesID, 1);
    $unknownPDF = "<p>It is not known whether your " .  strtolower(LABEL). " meets local codes. For a single family dwelling not located in a floodplain, it is recommended that " .  strtolower(LABEL). " capacity should be 1000 gallons or 400 times the number of bedrooms (whichever is greatest). In floodplain areas, the capacity is 100 times the number of bedrooms, times the number of days the site is flooded during a 10-year flood or 1000 gallons (whichever is greatest).</p>

    <p>For other than single-family dwellings, the capacity of the " .  strtolower(LABEL). " should be based on measured or estimated flow rates. The tank capacity should be at least five – ten times the average design flow rate.</p>";
    $answersClass->saveAnswer("Unknown", "radio", $unknownPDF, 0, $localCodesID, 2);

// Effluent screen
$effluentID = $questionsClass->saveQuestion("Effluent screen", EFFLUENT_SCREEN_HINT, $categoryID, "question", 4);
    $answersClass->saveAnswer("Yes", "radio", "Your " .  strtolower(LABEL). " has an effluent screen. An effluent screen is a device typically installed in the outlet piping of a tank to keep suspended solids in the tank, thereby protecting your downstream components (typically your soil treatment area). This effluent screen may have additional maintenance requirements. Check the O&M section for more information.", 0, $effluentID, 0);
    $answersClass->saveAnswer("No", "radio", "Your " .  strtolower(LABEL). " does not have an effluent screen. Consider adding an effluent screen to the " .  strtolower(LABEL). " because large chunks of material may escape the " .  strtolower(LABEL). " and cause future harm further in downstream components. The effluent screen needs to be one designed to handle the waste in the " .  strtolower(LABEL). ".", 0, $effluentID, 1);
    
    
// Screen alarm
$screenAlarmID = $questionsClass->saveQuestion("Screen alarm", SCREEN_ALARM_HINT, $categoryID, "question", 5);
    $yesID = $answersClass->saveAnswer("Yes", "radio", "", 0, $screenAlarmID, 0);
    $yesImgID = $answersClass->saveAnswer("", "image", "%SELF%", $yesID, $screenAlarmID, 1);
    $yesTxtID = $answersClass->saveAnswer("Location", "text", "", $yesID, $screenAlarmID, 2);
    $answersClass->saveAnswer("Visual", "checkbox", "Your " .  strtolower(LABEL). " has a visual high-water alarm. It is located at %ID=$yesTxtID%. Alarms are important because they notify you BEFORE costly back-ups occur and let you know when pumping is required.", $yesID, $screenAlarmID, 3);
    $answersClass->saveAnswer("Audible", "checkbox", "Your " .  strtolower(LABEL). " has a audible high-water alarm. It is located at %ID=$yesTxtID%. Alarms are important because they notify you BEFORE costly back-ups occur and let you know when pumping is required.", $yesID, $screenAlarmID, 4);
    $answersClass->saveAnswer("Remote", "checkbox", "Your " .  strtolower(LABEL). " has a remote high-water alarm. It is located at %ID=$yesTxtID%. Alarms are important because they notify you BEFORE costly back-ups occur and let you know when pumping is required.", $yesID, $screenAlarmID, 5);
    $answersClass->saveAnswer("No", "radio", "<p>Your " .  strtolower(LABEL). " has no high-water alarm. Consider adding a mechanical or electrical alarm to your " .  strtolower(LABEL). " as it can notify you BEFORE costly back-ups occur.</p>", 0, $screenAlarmID, 6);

// PUMP
$pumpID = $questionsClass->saveQuestion("Pump", PUMP_HINT, $categoryID, "question", 6);
    $answersClass->saveAnswer("Yes", "radio", "Your " .  strtolower(LABEL). " has a pump. Your pump may have additional maintenance requirements. Check the O&M section for more information.", 0, $pumpID, 0);
    $answersClass->saveAnswer("No", "radio", "", 0, $pumpID, 1);

// Pump alarm
$pumpAlarmID = $questionsClass->saveQuestion("Pump alarm", SCREEN_ALARM_HINT, $categoryID, "question", 7);
    $pumpyesID = $answersClass->saveAnswer("Yes", "radio", "", 0, $pumpAlarmID, 0);
    $pumpyesImgID = $answersClass->saveAnswer("", "image", "%SELF%", $pumpyesID, $pumpAlarmID, 1);
    $pumpyesTxtID = $answersClass->saveAnswer("Location", "text", "", $pumpyesID, $pumpAlarmID, 2);
    $answersClass->saveAnswer("Visual", "checkbox", "<p>%ID=$pumpyesImgID%</p><p>The pump for your " .  strtolower(LABEL). " has a visual high-water alarm. It is located at %ID=$pumpyesTxtID%. Alarms are important because they notify you BEFORE costly back-ups occur and let you know when servicing is required.</p>", $pumpyesID, $pumpAlarmID, 3);
    $answersClass->saveAnswer("Audible", "checkbox", "<p>%ID=$pumpyesImgID%</p><p>The pump for your " .  strtolower(LABEL). " has an audible high-water alarm. It is located at %ID=$pumpyesTxtID%. Alarms are important because they notify you BEFORE costly back-ups occur and let you know when servicing is required.</p>", $pumpyesID, $pumpAlarmID, 4);
    $answersClass->saveAnswer("Remote", "checkbox", "<p>%ID=$pumpyesImgID%</p><p>The pump for your " .  strtolower(LABEL). " has a remote high-water alarm. It is located at %ID=$pumpyesTxtID%. Alarms are important because they notify you BEFORE costly back-ups occur and let you know when servicing is required.</p>", $pumpyesID, $pumpAlarmID, 5);
    $answersClass->saveAnswer("No", "radio", "<p>The pump for your " .  strtolower(LABEL). " has no high-water alarm. Consider adding a mechanical or electrical alarm to your " .  strtolower(LABEL). " as it can notify you BEFORE costly back-ups occur and let you know when servicing is required.", 0, $pumpAlarmID, 6);

    
$accessID = $questionsClass->saveQuestion("Access", ACCESS_HINT, $categoryID, "question", 8);
    $aboveID = $answersClass->saveAnswer("Above grade", "radio", "", 0, $accessID, 0);
    $accessImgID = $answersClass->saveAnswer("", "image", "", $aboveID, $accessID, 1);
    $accessLocationID = $answersClass->saveAnswer("Location", "text", "", $aboveID, $accessID, 2);
    $accessTypeID = $answersClass->saveAnswer("Type", "text", "", $aboveID, $accessID, 3);
    $abovePDF = "%ID=$accessImgID%
    <p>%ID=$accessLocationID%</p>
    <p>The type of access to your " .  strtolower(LABEL). " is a/an %ID=$accessTypeID% and is above grade which makes maintenance easier to perform.</p>
    ";
    $answersClass->saveAnswer("Above grade", "radio", $abovePDF, 0, $accessID, 0, $aboveID);
    
    $belowID = $answersClass->saveAnswer("Below grade", "radio", "", 0, $accessID, 4);
    $belowImgID = $answersClass->saveAnswer("", "image", "", $belowID, $accessID, 5);
    $belowLocationID = $answersClass->saveAnswer("Location", "text", "", $belowID, $accessID, 6);
    $belowTypeID = $answersClass->saveAnswer("Type", "text", "", $belowID, $accessID, 7);
    $belowPDF = "%ID=$belowImgID%
    <p>%ID=$belowLocationID%</p>
    <p>The type of access to your " .  strtolower(LABEL). " is a/an %ID=$belowTypeID% and is below grade which can make maintenance difficult to perform. Consider raising the access to the " .  strtolower(LABEL). " to grade or above grade.</p>
    ";
    $answersClass->saveAnswer("Below grade", "radio", $belowPDF, 0, $accessID, 4, $belowID);

    
echo "done";