<?php

/*
  $categoriesClass = new Categories($db);
  $userID = $_SESSION['USER']["ID"];
  $questionsClass = new Questions($db);
  $projectID = 1;
  $answersClass = new Answers($db);
  $sectionsClass = new Sections($db);
 */

define("CONFIGURATION_ABOVE_GRADE_ANSWER_ID", 1082);
define("CONFIGURATION_AT_GRADE_ANSWER_ID", 1084);


define("GRAVITY_ANSWER_ID", 1079);
define("PRESSURE_ANSWER_ID", 1080);
define("PRESSURE_DOSED_ANSWER_ID", 1081);

$questionID = 252;

$html .= "<h3>Final Treatment & Dispersal Systems operations and maintenance</h3>";
$html .= "<div class='content'>";
$html .= "The goal of a septic system is to protect human health and the environment by properly treating wastewater before returning it to the environment. Your final treatment and dispersal system is designed to be the final part of the treatment process before your wastewater is recycled back into our lakes, streams, and groundwater.";
$html .= "In most cases, system owners are the operators of Final Treatment & Dispersal units and the entire onsite wastewater treatment system. The units need periodic inspection, evaluation, and maintenance. The frequency of this depends on many factors: number of people using the system, the appliances that send waste to the tank (such as a garbage disposal), and the presence or absence of effluent screens in the pretreatment component(s).";
$html .= "</div>";
//Header
$html .= '<table style="border-collapse:collapse;">';
$html .= '<tr style="border:1px solid #000;">';
$html .= '<td style="font-weight:bold;text-align:center;width:175px;min-width:175px;border:1px solid #000;">' . "Component" . "</td>";
$html .= '<td style="font-weight:bold;text-align:center;width:175px;min-width:175px;border:1px solid #000;">' . "Activity" . "</td>";
$html .= '<td style="font-weight:bold;text-align:center;width:115px;min-width:115px;border:1px solid #000;">' . "Frequency" . "</td>";
$html .= '<td style="font-weight:bold;text-align:center;width:155px;min-width:155px;border:1px solid #000;">' . "Responsible Party" . "</td>";
$html .= '</tr>';
//$html .= '</table>';

//$html .= '<table style="border-collapse:collapse;">';
$html .= "<tr style='border:1px solid #000;$color'>";
$html .= '<td style="width:175px;min-width:175px;border:1px solid #333;">All</td>';
$html .= '<td style="width:175px;min-width:175px;border:1px solid #333;"><b><i>Odor as you approach soil treatment area.</i></b> Evaluate the presence of odor as you approach the soil treatment area. There should be no strong odors near the drainfield if the venting system is operating properly and there is no surfacing effluent.</td>';
$html .= '<td style="width:115px;min-width:115px;border:1px solid #333;">At the time of septic tank pumping or annually – whichever is the shorter time period.</td>';
$html .= '<td style="width:155px;min-width:155px;border:1px solid #333;">Service Provider</td>';
$html .= '</tr>';
//$html .= '</table>';

//$html .= '<table style="border-collapse:collapse;">';
$html .= "<tr style='border:1px solid #000;$color'>";
$html .= '<td style="width:175px;min-width:175px;border:1px solid #333;">All</td>';
$html .= '<td style="width:175px;min-width:175px;border:1px solid #333;"><b><i>Vegetation</i></b> Vegetation management on and around the soil treatment area is important for proper performance.</td>';
$html .= '<td style="width:115px;min-width:115px;border:1px solid #333;">At the time of septic tank pumping or annually – whichever is the shorter time period.</td>';
$html .= '<td style="width:155px;min-width:155px;border:1px solid #333;">Service Provider</td>';
$html .= '</tr>';
//$html .= '</table>';

$answers = $answersClass->getDetailsByLabel("Drip", $questionID);
$answer = $answers[0];
$values = $answersClass->getUserAnswers($userID, $projectID, $answer['id']);

if (!empty($values[0]['value'])) {
    //$html .= '<table style="border-collapse:collapse;">';
    $html .= "<tr style='border:1px solid #000;$color'>";
    $html .= '<td style="width:175px;min-width:175px;border:1px solid #333;">Drip</td>';
    $html .= '<td style="width:175px;min-width:175px;border:1px solid #333;"><b><i>Vegetation</i></b> Check the dripfield for the evenness of vegetation growth. Changes in the vegetation patterns can indicate problems within the dripfield.</td>';
    $html .= '<td style="width:115px;min-width:115px;border:1px solid #333;">At the time of septic tank pumping or annually – whichever is the shorter time period.</td>';
    $html .= '<td style="width:155px;min-width:155px;border:1px solid #333;">Service Provider</td>';
    $html .= '</tr>';
    //$html .= '</table>';
}

$answers = $answersClass->getDetailsByLabel("Spray", $questionID);
$answer = $answers[0];
$values = $answersClass->getUserAnswers($userID, $projectID, $answer['id']);

if (!empty($values[0]['value'])) {
    //$html .= '<table style="border-collapse:collapse;">';
    $html .= "<tr style='border:1px solid #000;$color'>";
    $html .= '<td style="width:175px;min-width:175px;border:1px solid #333;">Spray</td>';
    $html .= '<td style="width:175px;min-width:175px;border:1px solid #333;"><b><i>Vegetation</i></b> Tall plants near the distribution heads can obstruct the spray pattern and cause problems with effluent distribution. During the growing season, grasses help remove moisture from the spray field.</td>';
    $html .= '<td style="width:115px;min-width:115px;border:1px solid #333;">At the time of septic tank pumping or annually – whichever is the shorter time period.</td>';
    $html .= '<td style="width:155px;min-width:155px;border:1px solid #333;">Service Provider</td>';
    $html .= '</tr>';
    //$html .= '</table>';
}

$values = $answersClass->getUserAnswers($userID, $projectID, PRESSURE_ANSWER_ID);

if (!empty($values[0]['value'])) {
    $answers1 = $answersClass->getDetailsByLabel("Trenches", $questionID);
    $answer1 = $answers[0];
    $values1 = $answersClass->getUserAnswers($userID, $projectID, $answer['id']);

    $answers2 = $answersClass->getDetailsByLabel("Beds", $questionID);
    $answer2 = $answers[0];
    $values2 = $answersClass->getUserAnswers($userID, $projectID, $answer['id']);

    if (!empty($values1[0]['value']) || !empty($values2[0]['value'])) {
        //$html .= '<table style="border-collapse:collapse;">';
        $html .= "<tr style='border:1px solid #000;$color'>";
        $html .= '<td style="width:175px;min-width:175px;border:1px solid #333;"></td>';
        $html .= '<td style="width:175px;min-width:175px;border:1px solid #333;"><b><i>Root intrusion.</i></b> Check for root intrusion into orifices in the lateral line (while snaking and flushing laterals).</td>';
        $html .= '<td style="width:115px;min-width:115px;border:1px solid #333;">At the time of septic tank pumping or annually – whichever is the shorter time period.</td>';
        $html .= '<td style="width:155px;min-width:155px;border:1px solid #333;">Service Provider</td>';
        $html .= '</tr>';
        //$html .= '</table>';
    }
} else {
    $values1 = $answersClass->getUserAnswers($userID, $projectID, CONFIGURATION_ABOVE_GRADE_ANSWER_ID);

    $values2 = $answersClass->getUserAnswers($userID, $projectID, CONFIGURATION_AT_GRADE_ANSWER_ID);

    if (!empty($values1[0]['value']) || !empty($values2[0]['value'])) {
        //$html .= '<table style="border-collapse:collapse;">';
        $html .= "<tr style='border:1px solid #000;$color'>";
        $html .= '<td style="width:175px;min-width:175px;border:1px solid #333;"></td>';
        $html .= '<td style="width:175px;min-width:175px;border:1px solid #333;"><b><i>Root intrusion.</i></b> Check for root intrusion into orifices in the lateral line (while snaking and flushing laterals).</td>';
        $html .= '<td style="width:115px;min-width:115px;border:1px solid #333;">At the time of septic tank pumping or annually – whichever is the shorter time period.</td>';
        $html .= '<td style="width:155px;min-width:155px;border:1px solid #333;">Service Provider</td>';
        $html .= '</tr>';
        //$html .= '</table>';
    }
}

$values1 = $answersClass->getUserAnswers($userID, $projectID, GRAVITY_ANSWER_ID);

$values2 = $answersClass->getUserAnswers($userID, $projectID, PRESSURE_DOSED_ANSWER_ID);

if (!empty($values1[0]['value']) || !empty($values2[0]['value'])) {
    //$html .= '<table style="border-collapse:collapse;">';
    $html .= "<tr style='border:1px solid #000;$color'>";
    $html .= '<td style="width:175px;min-width:175px;border:1px solid #333;">Gravity or pressure-do sed to gravity</td>';
    $html .= '<td style="width:175px;min-width:175px;border:1px solid #333;"><b><i>Distribution devices.</i></b> Examine the distribution device to determine if there is 1) equal distribution in the soil, 2) there is presence of sludge, and 3) if there is root intrusion.</td>';
    $html .= '<td style="width:115px;min-width:115px;border:1px solid #333;">At the time of septic tank pumping or annually – whichever is the shorter time period.</td>';
    $html .= '<td style="width:155px;min-width:155px;border:1px solid #333;">Service Provider</td>';
    $html .= '</tr>';
    //$html .= '</table>';
}

$values = $answersClass->getUserAnswers($userID, $projectID, PRESSURE_ANSWER_ID);
if (!empty($values[0]['value'])) {
    //$html .= '<table style="border-collapse:collapse;">';
    $html .= "<tr style='border:1px solid #000;$color'>";
    $html .= '<td style="width:175px;min-width:175px;border:1px solid #333;">Pressure distribution</td>';
    $html .= '<td style="width:175px;min-width:175px;border:1px solid #333;"><b><i>Distribution devices.</i></b> If the system is using a pressure manifold, record the distal head.</td>';
    $html .= '<td style="width:115px;min-width:115px;border:1px solid #333;">At the time of septic tank pumping or annually – whichever is the shorter time period.</td>';
    $html .= '<td style="width:155px;min-width:155px;border:1px solid #333;">Service Provider</td>';
    $html .= '</tr>';
    //$html .= '</table>';
}

//$html .= '<table style="border-collapse:collapse;">';
$html .= "<tr style='border:1px solid #000;$color'>";
$html .= '<td style="width:175px;min-width:175px;border:1px solid #333;">All</td>';
$html .= '<td style="width:175px;min-width:175px;border:1px solid #333;"><b><i>Access.</i></b> A riser is recommended if the lid is not accessible from the ground surface. Check to make sure there is no infiltration in the risers. Insulate the riser cover for frost protection. Make sure that lids are securely fastened and in operable condition.</td>';
$html .= '<td style="width:115px;min-width:115px;border:1px solid #333;">At the time of septic tank pumping or annually – whichever is the shorter time period.</td>';
$html .= '<td style="width:155px;min-width:155px;border:1px solid #333;">Service Provider</td>';
$html .= '</tr>';
//$html .= '</table>';

//$html .= '<table style="border-collapse:collapse;">';
$html .= "<tr style='border:1px solid #000;$color'>";
$html .= '<td style="width:175px;min-width:175px;border:1px solid #333;">All</td>';
$html .= '<td style="width:175px;min-width:175px;border:1px solid #333;"><b><i>Switching valves (if present).</i></b> Record the type of switching valve and record if any actions were taken for maintenance. Switching valves are used to automatically or manually divert the flow of effluent to another field or a different part of the field.</td>';
$html .= '<td style="width:115px;min-width:115px;border:1px solid #333;">At the time of septic tank pumping or annually – whichever is the shorter time period.</td>';
$html .= '<td style="width:155px;min-width:155px;border:1px solid #333;">Service Provider</td>';
$html .= '</tr>';
//$html .= '</table>';

//$html .= '<table style="border-collapse:collapse;">';
$html .= "<tr style='border:1px solid #000;$color'>";
$html .= '<td style="width:175px;min-width:175px;border:1px solid #333;">All</td>';
$html .= '<td style="width:175px;min-width:175px;border:1px solid #333;"><b><i>Inspection pipes.</i></b> Check to make sure they are properly capped. Replace caps that are damaged.</td>';
$html .= '<td style="width:115px;min-width:115px;border:1px solid #333;">Annually.</td>';
$html .= '<td style="width:155px;min-width:155px;border:1px solid #333;">Service Provider</td>';
$html .= '</tr>';
//$html .= '</table>';

//$html .= '<table style="border-collapse:collapse;">';
$html .= "<tr style='border:1px solid #000;$color'>";
$html .= '<td style="width:175px;min-width:175px;border:1px solid #333;">All</td>';
$html .= '<td style="width:175px;min-width:175px;border:1px solid #333;"><b><i>Surfacing of effluent.</i></b> Check for surfaced effluent or other signs of problems.</td>';
$html .= '<td style="width:115px;min-width:115px;border:1px solid #333;">At the time of septic tank pumping or annually – whichever is the shorter time period.</td>';
$html .= '<td style="width:155px;min-width:155px;border:1px solid #333;">Service Provider</td>';
$html .= '</tr>';
//$html .= '</table>';

$values1 = $answersClass->getUserAnswers($userID, $projectID, GRAVITY_ANSWER_ID);

$answers2 = $answersClass->getDetailsByLabel("Trenches", $questionID);
$answer2 = $answers[0];
$values2 = $answersClass->getUserAnswers($userID, $projectID, $answer['id']);

$answers3 = $answersClass->getDetailsByLabel("Beds", $questionID);
$answer3 = $answers[0];
$values3 = $answersClass->getUserAnswers($userID, $projectID, $answer['id']);

if (!empty($values1[0]['value']) && (!empty($values2[0]['value']) || !empty($values3[0]['value']))) {
    //$html .= '<table style="border-collapse:collapse;">';
    $html .= "<tr style='border:1px solid #000;$color'>";
    $html .= '<td style="width:175px;min-width:175px;border:1px solid #333;">Gravity trenches & beds</td>';
    $html .= '<td style="width:175px;min-width:175px;border:1px solid #333;"><b><i>Ponding.</i></b> Check the number of gravity trenches with ponded effluent. Identify the percentage of the system in use. Determine if action is needed.</td>';
    $html .= '<td style="width:115px;min-width:115px;border:1px solid #333;">At the time of septic tank pumping or annually – whichever is the shorter time period.</td>';
    $html .= '<td style="width:155px;min-width:155px;border:1px solid #333;">Service Provider</td>';
    $html .= '</tr>';
    //$html .= '</table>';
}

$answers = $answersClass->getDetailsByLabel("ET Bed", $questionID);
$answer = $answers[0];
$values = $answersClass->getUserAnswers($userID, $projectID, $answer['id']);

if (!empty($values[0]['value'])) {
    //$html .= '<table style="border-collapse:collapse;">';
    $html .= "<tr style='border:1px solid #000;$color'>";
    $html .= '<td style="width:175px;min-width:175px;border:1px solid #333;">Gravity trenches & beds</td>';
    $html .= '<td style="width:175px;min-width:175px;border:1px solid #333;"><b><i>Ponding.</i></b> Evaluate the presence and depth of ponding in the ET bed.</td>';
    $html .= '<td style="width:115px;min-width:115px;border:1px solid #333;">At the time of septic tank pumping or annually – whichever is the shorter time period.</td>';
    $html .= '<td style="width:155px;min-width:155px;border:1px solid #333;">Service Provider</td>';
    $html .= '</tr>';
    //$html .= '</table>';
}

$values = $answersClass->getUserAnswers($userID, $projectID, PRESSURE_ANSWER_ID);

if (!empty($values[0]['value'])) {
    $answers1 = $answersClass->getDetailsByLabel("Trenches", $questionID);
    $answer1 = $answers[0];
    $values1 = $answersClass->getUserAnswers($userID, $projectID, $answer['id']);

    $answers2 = $answersClass->getDetailsByLabel("Beds", $questionID);
    $answer2 = $answers[0];
    $values2 = $answersClass->getUserAnswers($userID, $projectID, $answer['id']);

    if (!empty($values1[0]['value']) || !empty($values2[0]['value'])) {
        //$html .= '<table style="border-collapse:collapse;">';
        $html .= "<tr style='border:1px solid #000;$color'>";
        $html .= '<td style="width:175px;min-width:175px;border:1px solid #333;">Pressure trenches & beds</td>';
        $html .= '<td style="width:175px;min-width:175px;border:1px solid #333;"><b><i>Lateral flushing.</i></b> Check lateral distribution; if cleanouts exist, flush and clean as needed.</td>';
        $html .= '<td style="width:115px;min-width:115px;border:1px solid #333;">At the time of septic tank pumping or annually – whichever is the shorter time period.</td>';
        $html .= '<td style="width:155px;min-width:155px;border:1px solid #333;">Service Provider</td>';
        $html .= '</tr>';
        //$html .= '</table>';
    }
}

$values1 = $answersClass->getUserAnswers($userID, $projectID, CONFIGURATION_ABOVE_GRADE_ANSWER_ID);

$values2 = $answersClass->getUserAnswers($userID, $projectID, CONFIGURATION_AT_GRADE_ANSWER_ID);

if (!empty($values1[0]['value']) || !empty($values2[0]['value'])) {
    //$html .= '<table style="border-collapse:collapse;">';
    $html .= "<tr style='border:1px solid #000;$color'>";
    $html .= '<td style="width:175px;min-width:175px;border:1px solid #333;">Above-grade or at-grade</td>';
    $html .= '<td style="width:175px;min-width:175px;border:1px solid #333;"><b><i>Lateral flushing.</i></b> Check lateral distribution; if cleanouts exist, flush and clean as needed. Distal head should be measured before and after lateral cleaning.</td>';
    $html .= '<td style="width:115px;min-width:115px;border:1px solid #333;">At the time of septic tank pumping or annually – whichever is the shorter time period.</td>';
    $html .= '<td style="width:155px;min-width:155px;border:1px solid #333;">Service Provider</td>';
    $html .= '</tr>';
    //$html .= '</table>';
}

$values = $answersClass->getUserAnswers($userID, $projectID, CONFIGURATION_AT_GRADE_ANSWER_ID);
if (!empty($values[0]['value'])) {
    //$html .= '<table style="border-collapse:collapse;">';
    $html .= "<tr style='border:1px solid #000;$color'>";
    $html .= '<td style="width:175px;min-width:175px;border:1px solid #333;">Above-grade or at-grade</td>';
    $html .= '<td style="width:175px;min-width:175px;border:1px solid #333;"><b><i>Ponding</i></b> Check for ponding. Excessive ponding in at-grade systems indicates problems.</td>';
    $html .= '<td style="width:115px;min-width:115px;border:1px solid #333;">At the time of septic tank pumping or annually – whichever is the shorter time period.</td>';
    $html .= '<td style="width:155px;min-width:155px;border:1px solid #333;">Service Provider</td>';
    $html .= '</tr>';
    //$html .= '</table>';
}

$answers = $answersClass->getDetailsByLabel("Mound", $questionID);
$answer = $answers[0];
$values = $answersClass->getUserAnswers($userID, $projectID, $answer['id']);

if (!empty($values[0]['value'])) {
    //$html .= '<table style="border-collapse:collapse;">';
    $html .= "<tr style='border:1px solid #000;$color'>";
    $html .= '<td style="width:175px;min-width:175px;border:1px solid #333;">Mounds</td>';
    $html .= '<td style="width:175px;min-width:175px;border:1px solid #333;"><b><i>Ponding.</i></b> Check for ponding in the mound and at the toe of the mound. Excessive ponding in the mound indicates problems. There should be no pounding at the toe of the mound.</td>';
    $html .= '<td style="width:115px;min-width:115px;border:1px solid #333;">At the time of septic tank pumping or annually – whichever is the shorter time period.</td>';
    $html .= '<td style="width:155px;min-width:155px;border:1px solid #333;">Service Provider</td>';
    $html .= '</tr>';
    //$html .= '</table>';

    //$html .= '<table style="border-collapse:collapse;">';
    $html .= "<tr style='border:1px solid #000;$color'>";
    $html .= '<td style="width:175px;min-width:175px;border:1px solid #333;">Mounds</td>';
    $html .= '<td style="width:175px;min-width:175px;border:1px solid #333;"><b><i>Leaks around or on the mound.</i></b> Leaks around or on the system are not acceptable and are signs that the dispersal area is not operating properly.</td>';
    $html .= '<td style="width:115px;min-width:115px;border:1px solid #333;">At the time of septic tank pumping or annually – whichever is the shorter time period.</td>';
    $html .= '<td style="width:155px;min-width:155px;border:1px solid #333;">Service Provider</td>';
    $html .= '</tr>';
    //$html .= '</table>';
}

$answers = $answersClass->getDetailsByLabel("Drip", $questionID);
$answer = $answers[0];
$values = $answersClass->getUserAnswers($userID, $projectID, $answer['id']);

if (!empty($values[0]['value'])) {
    //$html .= '<table style="border-collapse:collapse;">';
    $html .= "<tr style='border:1px solid #000;$color'>";
    $html .= '<td style="width:175px;min-width:175px;border:1px solid #333;">Drip</td>';
    $html .= '<td style="width:175px;min-width:175px;border:1px solid #333;"><b><i>Filters</i></b> Note which type of filter is being used. Check the operating pressure before and after the filter to determine the level of plugging on the filter. Check the valve after the filter is cleaned to make sure it is adjusted correctly.</td>';
    $html .= '<td style="width:115px;min-width:115px;border:1px solid #333;">Each maintenance visit or as indicated by manufacturer’s specifications.</td>';
    $html .= '<td style="width:155px;min-width:155px;border:1px solid #333;">Service Provider</td>';
    $html .= '</tr>';
    //$html .= '</table>';

    //$html .= '<table style="border-collapse:collapse;">';
    $html .= "<tr style='border:1px solid #000;$color'>";
    $html .= '<td style="width:175px;min-width:175px;border:1px solid #333;">Drip</td>';
    $html .= '<td style="width:175px;min-width:175px;border:1px solid #333;"><b><i>Flow meters and flow rates.</i></b> Flow metering can assist in evaluating the dripfields. A flow meter recording the total volume of flow entering the dripfields allows estimation of loading which is compared to design loading rates. Evaluation the flow rate going to each drip zone can assist in determining the potential of emitter plugging. Elapsed time meter and cycle/event counter readings at the time of the visit can be compared with previous readings to determine number of doses and total pump run time.</td>';
    $html .= '<td style="width:115px;min-width:115px;border:1px solid #333;">Each maintenance visit or as indicated by manufacturer’s specifications.</td>';
    $html .= '<td style="width:155px;min-width:155px;border:1px solid #333;">Service Provider</td>';
    $html .= '</tr>';
    //$html .= '</table>';

    //$html .= '<table style="border-collapse:collapse;">';
    $html .= "<tr style='border:1px solid #000;$color'>";
    $html .= '<td style="width:175px;min-width:175px;border:1px solid #333;">Drip</td>';
    $html .= '<td style="width:175px;min-width:175px;border:1px solid #333;"><b><i>Flushing system.</i></b> Evaluate the operation of the flushing system by checking the operating pressure in the drip fields. Record the present and last flushing time reading OR the present and last flushing cycle reading. Conduct a field flushing event.</td>';
    $html .= '<td style="width:115px;min-width:115px;border:1px solid #333;">Each maintenance visit or as indicated by manufacturer’s specifications.</td>';
    $html .= '<td style="width:155px;min-width:155px;border:1px solid #333;">Service Provider</td>';
    $html .= '</tr>';
    //$html .= '</table>';

    //$html .= '<table style="border-collapse:collapse;">';
    $html .= "<tr style='border:1px solid #000;$color'>";
    $html .= '<td style="width:175px;min-width:175px;border:1px solid #333;">Drip</td>';
    $html .= '<td style="width:175px;min-width:175px;border:1px solid #333;"><b><i>Dripfield zones.</i></b> Evaluate the dripfield zones for proper operaton by 1) measuring total flow and flow rate entering the dripfield, 2) checking to ensure air/vacuum relief valves do not leak effluent once the system pressurizes, and 3) checking for excess water or we areas in the field.</td>';
    $html .= '<td style="width:115px;min-width:115px;border:1px solid #333;">Each maintenance visit or as indicated by manufacturer’s specifications.</td>';
    $html .= '<td style="width:155px;min-width:155px;border:1px solid #333;">Service Provider</td>';
    $html .= '</tr>';
    //$html .= '</table>';
}
$html .= "</table>";

$answers = $answersClass->getDetailsByLabel("Spray", $questionID);
$answer = $answers[0];
$values = $answersClass->getUserAnswers($userID, $projectID, $answer['id']);

if (!empty($values[0]['value'])) {
    $title = "Spray";
    $activity = "<b><i>Conditions at the spray distribution site. </i></b> Ensure that purple components are noted on the distribution heads, valve boxes, and piping. If the jurisdiction requires signage or fencing to raise awareness regarding reclaimed water distribution or limiting access, verify their presence.";
    $frequency = "At the time of septic tank pumping or annually – whichever is the shorter time period.";
    $responsible = "Service Provider";
    drawRow($title, $activity, $frequency, $reponsible);

    $activity = "<b><i>Operating pressure.</i></b> Measure at the discharge assembly to minimize risk of contact with the effluent. Note location of operating pressure reading.";
    drawRow($title, $activity, $frequency, $reponsible);

    $activity = "<b><i>Control panel.</i></b> If the system uses a control panel, make sure all components are operating properly by determining if present and then manually testing the timer, photocell, and/or rainfall shutoff.";
    drawRow($title, $activity, $frequency, $reponsible);

    $activity = "<b><i>Operational conditions in each zone of spray field.</i></b> Check for erosion or ponding on the spray field. Vegetation must be present, but not excessively around spray heads. Presence of trees or shrubs within 10 ft of spray heads can cause uneven distribution.";
    drawRow($title, $activity, $frequency, $reponsible);

    $activity = "<b><i>Distribution head.</i></b> Distribution heads have operational components that need to be evaluated: in-line filters need to be cleaned; distribution heads need to be adjusted to have proper distribution pattern; pop-up heads need to have clear area; low-pressure shutoff valves need to be looked at.";
    drawRow($title, $activity, $frequency, $reponsible);

    $activity = "<b><i>Operating pressure.</i></b> Measure at the discharge assembly to minimize risk of contact with the effluent. Note location of operating pressure reading.";
    drawRow($title, $activity, $frequency, $reponsible);
}

$answers = $answersClass->getDetailsByLabel("Lagoon", $questionID);
$answer = $answers[0];
$values = $answersClass->getUserAnswers($userID, $projectID, $answer['id']);

if (!empty($values[0]['value'])) {
    $title = "Lagoon";
    $activity = "<b><i>Conditions at the lagoon.</i></b> Check the following conditions: 1) Is there an odor within 10 ft of the perimeter of the system? 2) What is the color of the lagoon water? 3) Is pumping necessary? 4) Is there animal activity at the surface?";
    $frequency = "At the time of septic tank pumping or annually – whichever is the shorter time period.";
    $responsible = "Service Provider";
    drawRow($title, $activity, $frequency, $reponsible);

    $activity = "<b><i>Border around lagoon.</i></b> Verify that the border effective and in good repair; berm is free of burrowing animals and protected from erosion; fencing is present and operable; no water or soil is entering the lagoon.";
    drawRow($title, $activity, $frequency, $reponsible);

    $activity = "<b><i>Vegetation in lagoon.</i></b>Verify that there is no floating vegetation present & if there is, remove it.";
    drawRow($title, $activity, $frequency, $reponsible);

    $activity = "<b><i>Water level management.</i></b>Determine the water level below freeboard (indicate if the water level is relative to the outlet or the berm). Determine if there is water level control available.";
    drawRow($title, $activity, $frequency, $reponsible);

    $activity = "<b><i>Effluent quality.</i></b>The following items should be measured: turbidity, DO at outlet or across from inlet, pH at outlet or across from inlet, and temperature at outlet.";
    drawRow($title, $activity, $frequency, $reponsible);

    $activity = "<b><i>Effluent quality.</i></b>The following should be determined: is there an oily film on the surface of the effluent; is there bypass or overflow noticed; acceptable effluent odor after passing through the lagoon (if discharging), and color of effluent after passing through the lagoon (if discharging).";
    drawRow($title, $activity, $frequency, $reponsible);
}

$answers = $answersClass->getDetailsByLabel("ET bed", $questionID);
$answer = $answers[0];
$values = $answersClass->getUserAnswers($userID, $projectID, $answer['id']);

if (!empty($values[0]['value'])) {
    $title = "Outfall";
    $activity = "<b><i>Outfall structure.</i></b> Should be free of obstructions and erosion. Determine if the pipe is crushed or broken.";
    $frequency = "At the time of septic tank pumping or annually – whichever is the shorter time period.";
    $responsible = "Service Provider";
    drawRow($title, $activity, $frequency, $reponsible);

    $activity = "<b><i>Discharging effluent.</i></b>Indicate rate of discharge (dripping, trickling, flowing). Determine if there are any residual solids or vectors living and growing in the discharged effluent.";
    drawRow($title, $activity, $frequency, $reponsible);
}

$answers = $answersClass->getDetailsByLabel("Outfall/Surface discharge", $questionID);
$answer = $answers[0];
$values = $answersClass->getUserAnswers($userID, $projectID, $answer['id']);

if (!empty($values[0]['value'])) {
    $title = "ET bed";
    $activity = "<b><i>Diverting rainfall and runoff.</i></b> Check to make sure rainfall and runoff are diverted around the ET bed. Maintain the sloped cover on the system to help keep rain and runoff out of the ET bed.";
    $frequency = "At the time of septic tank pumping or annually – whichever is the shorter time period.";
    $responsible = "Service Provider";
    drawRow($title, $activity, $frequency, $reponsible);
}


drawRow("", "<b>Other.</b>", "", "");

$title = "All";
$activity = "<b><i>Surfacing effluent.</i></b> Regularly check for wet or spongy soil around your soil treatment area. If surfaced sewage or strong odors are not corrected by pumping the tank or fixing broken caps, call your Service Provider.";
$frequency = "Seasonally or several times per year";
$responsible = "Owner";
drawRow($title, $activity, $frequency, $reponsible);

$activity = "<b><i>Caps.</i></b> Make sure all caps and lids are intact and in place. Inspect for damaged caps at least every fall. Fix or replace damaged caps before winter to help prevent freezing issues.";
$frequency = "Annually every fall";
drawRow($title, $activity, $frequency, $reponsible);

$activity = "Make sure that your Service provider has clear access to all of the components for the final treatment and dispersal system.";
$frequency = "Each visit";
drawRow($title, $activity, $frequency, $reponsible);

function drawRow($title, $activity, $frequency, $reponsible, $color = "") {
    global $html;

    //$html .= '<table style="border-collapse:collapse;">';
    $html .= "<tr style='border:1px solid #000;$color'>";
    $html .= '<td style="width:175px;min-width:175px;border:1px solid #333;">' . $title . '</td>';
    $html .= '<td style="width:175px;min-width:175px;border:1px solid #333;">' . $activity . '</td>';
    $html .= '<td style="width:115px;min-width:115px;border:1px solid #333;">' . $frequency . '</td>';
    $html .= '<td style="width:155px;min-width:155px;border:1px solid #333;">' . $reponsible . '</td>';
    $html .= '</tr>';
    //$html .= '</table>';
}
