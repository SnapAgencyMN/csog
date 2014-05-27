<?php
define("CATEGORY_ID", 63);

//Header
$html .= '<table style="border-collapse:collapse;">';
$html .= '<tr style="border:1px solid #000;">';
$html .= '<td style="font-weight:bold;text-align:center;width:175px;min-width:175px;border:1px solid #000;">' . "Problem" . "</td>";
$html .= '<td style="font-weight:bold;text-align:center;width:200px;min-width:200px;border:1px solid #000;">' . "Risk" . "</td>";
$html .= '<td style="font-weight:bold;text-align:center;width:200px;min-width:200px;border:1px solid #000;">' . "Potential Causes" . "</td>";
$html .= '<td style="font-weight:bold;text-align:center;width:200px;min-width:200px;border:1px solid #000;">' . "Potential Remedies" . "</td>";
$html .= '</tr>';
$html .= '</table>';

// 1st row
$html .= '<table style="border-collapse:collapse;">';
$html .= "<tr style='border:1px solid #000;$color'>";
$html .= '<td style="width:175px;min-width:175px;border:1px solid #333;">Sewage backs up into house and/or plumbing fixtures don’t drain or are sluggish</td>';
$html .= '<td style="width:200px;min-width:200px;border:1px solid #333;">Human contact with sewage is a serious public health risk. Many waterborne diseases exist in household sewage.<br /> 
<b>Avoid Contact</b><br /> 
Link to factsheet about cleaning up after spills</td>';
$html .= '<td style="width:200px;min-width:200px;border:1px solid #333;">
- Excess water entering system<br /> 
- Improper plumbing<br /> 
- Blockage in plumbing<br /> 
- Improper operation<br /> 
- Pump failure<br /> 
- Improper system design ­ Roots clogging pipes<br /> 
- Improper venting</td>';
$html .= '<td style="width:200px;min-width:200px;border:1px solid #333;">
• Fix leaks/vents<br /> 
• Install water­saving fixtures<br /> 
• Stop using garbage disposal<br /> 
• Clean septic tank and check pumps<br /> 
• Replace broken or cracked pipes and remove roots<br /> 
• Avoid water loving trees near system <br /> 
• Seal pipe connections   
</td>';
$html .= '</tr>';
$html .= '</table>';


//2nd row
$html .= '<table style="border-collapse:collapse;">';
$html .= "<tr style='border:1px solid #000;$color'>";
$html .= '<td style="width:175px;min-width:175px;border:1px solid #333;">Sewage surfacing in yard</td>';
$html .= '<td style="width:200px;min-width:200px;border:1px solid #333;">Human contact with sewage is a serious public health risk. Many water-borne diseases exist in household sewage.<br /> 
<b>Avoid Contact</b><br /></td>';
$html .= '<td style="width:200px;min-width:200px;border:1px solid #333;">
- Excess water use<br /> 
- System blockages<br /> 
- Improper system elevations<br /> 
- Undersized soil treatment system<br /> 
- Pump failure or improper operation<br /> 
- Improper separation from limiting condition
</td>';
$html .= '<td style="width:200px;min-width:200px;border:1px solid #333;">
• Fix leaks<br />
• Install water-saving fixtures<br />
• Clean septic tank and check pumps<br />
• Consult professionals<br />
• Fence off area until problem is fixed
</td>';
$html .= '</tr>';
$html .= '</table>';

//3rd row
$html .= '<table style="border-collapse:collapse;">';
$html .= "<tr style='border:1px solid #000;$color'>";
$html .= '<td style="width:175px;min-width:175px;border:1px solid #333;">Sewage odors — indoors</td>';
$html .= '<td style="width:200px;min-width:200px;border:1px solid #333;">Toxic gases can cause discomfort and illness.
<br/>Do not light matches/lighters or use appliances that may spark.</td>';
$html .= '<td style="width:200px;min-width:200px;border:1px solid #333;">
- Improper plumbing<br/>
- Sewage backup in house<br/>
- Unsealed basement sewage pump<br/>
- Roof vent pipe blocked
</td>';
$html .= '<td style="width:200px;min-width:200px;border:1px solid #333;">
• Repair plumbing by checking traps and vent penetrations<br/>
• Clean septic tank and check pumps<br/>
• Replace water in drain traps<br/>
• Check and tighten seals on pumps and cleanouts<br/>
• Clear roof vent
</td>';
$html .= '</tr>';
$html .= '</table>';

//4th row
$html .= '<table style="border-collapse:collapse;">';
$html .= "<tr style='border:1px solid #000;$color'>";
$html .= '<td style="width:175px;min-width:175px;border:1px solid #333;">Sewage odors — outdoors</td>';
$html .= '<td style="width:200px;min-width:200px;border:1px solid #333;">Major nuisance, but no serious health risk</td>';
$html .= '<td style="width:200px;min-width:200px;border:1px solid #333;">
- Source other than owner’s system<br/>
- Sewage surfacing in yard<br/>
- Inspection pipe caps  damaged or removed<br/>
- Unsealed manhole cover<br/>
- Short roof vent pipe(yours/neighbors)
</td>';
$html .= '<td style="width:200px;min-width:200px;border:1px solid #333;">
• Clean tank and check pumps<br/>
• Check and replace damaged caps<br/>
• Repair or replace system<br/>
• Seal manhole cover<br/>
• Extend roof plumbing vent pipe<br/>
• Add carbon filter to plumbing roof vent
</td>';
$html .= '</tr>';
$html .= '</table>';

//4th row
$html .= '<table style="border-collapse:collapse;">';
$html .= "<tr style='border:1px solid #000;$color'>";
$html .= '<td style="width:175px;min-width:175px;border:1px solid #333;">Contaminated surface waters</td>';
$html .= '<td style="width:200px;min-width:200px;border:1px solid #333;">
Swimming in contaminated water can cause health problems such as dysentery, hepatitis, etc.<br />
Lowered water quality can negatively impact aquatic life and promote the growth of algae and other weeds.
</td>';
$html .= '<td style="width:200px;min-width:200px;border:1px solid #333;">
- System too close to water table, or fractured bedrock<br />
- Cesspool or seepage pit in use<br />
- Sewage discharges to surface or groundwater<br />
- High levels from other sources<br />
- Broken sewage lines
</td>';
$html .= '<td style="width:200px;min-width:200px;border:1px solid #333;">
• Contact your local government to investigate other potential sources<br/>
• Work with community to upgrade septic systems that are not providing proper wastewater treatment.
</td>';
$html .= '</tr>';
$html .= '</table>';

//Flooding
$value = getValue("Flooding");
if (!empty($value))
{
    $html .= '<table style="border-collapse:collapse;">';
    $html .= "<tr style='border:1px solid #000;$color'>";
    $html .= '<td style="width:175px;min-width:175px;border:1px solid #333;">System was covered with floodwater</td>';
    $html .= '<td style="width:200px;min-width:200px;border:1px solid #333;">
    Your septic system is not working if it is flooded.  
    If wastewater is discharged to the system pathogens, solids and other contaminants will be entering the floodwater.
    </td>';
    $html .= '<td style="width:200px;min-width:200px;border:1px solid #333;">
    - The system is located in an area prone to flooding<br/>
    - The system is located in a position where a lot of surface water drains to the system<br/>
    - A natural disaster occurred
    </td>';
    $html .= '<td style="width:200px;min-width:200px;border:1px solid #333;">
    • Pump all the  tanks as soon as possible after the flood recedes and prior to resuming use of the system<br/>
    • Protect the soil treatment system from compaction by keeping all traffic off the area<br/>
    • Check electrical connections for damage or wear before turning electricity back on<br/>
    • Check that the septic tank manhole cover is secure and that inspection ports have not been blocked or damaged<br/>
    • Check the vegetation over the system and repair as needed.<br/> 
    • If the system will still not accept effluent the pipes or soil might be “plugged”. At this time the homeowner should consult a septic system professional
    </td>';
    $html .= '</tr>';
    $html .= '</table>';
}

//Forest fire
$value = getValue("Forest fire");
if (!empty($value))
{
    $html .= '<table style="border-collapse:collapse;">';
    $html .= "<tr style='border:1px solid #000;$color'>";
    $html .= '<td style="width:175px;min-width:175px;border:1px solid #333;">System was burned by a forest fire</td>';
    $html .= '<td style="width:200px;min-width:200px;border:1px solid #333;">
    The system may be inoperable.<br/>
    High temperatures damaged plastic components.<br/>
    Water or chemical used to extinguish fire damaged system.<br/>
    Vegetation over system was damaged.
    </td>';
    $html .= '<td style="width:200px;min-width:200px;border:1px solid #333;">
    - The system is located in an area prone to forest fires
    </td>';
    $html .= '<td style="width:200px;min-width:200px;border:1px solid #333;">
    • Have system evaluated to determine the extent of damage to piping and access<br/>
    • Re-vegetate over the system
    </td>';
    $html .= '</tr>';
    $html .= '</table>';
}

//Freezing
$value = getValue("Freezing");
if (!empty($value))
{
    $html .= '<table style="border-collapse:collapse;">';
    $html .= "<tr style='border:1px solid #000;$color'>";
    $html .= '<td style="width:175px;min-width:175px;border:1px solid #333;">Distribution pipes and/or soil treatment system freezes in winter</td>';
    $html .= '<td style="width:200px;min-width:200px;border:1px solid #333;">    
The system may be inoperable.
    </td>';
    $html .= '<td style="width:200px;min-width:200px;border:1px solid #333;">
    - Cold temperature with lack of snow cover<br/>
    - Water standing in pipes, sags, lack of draining back, undersized pump<br/>
    - Foot or vehicle traffic over pipes, trenches, mound or bed<br/>
    - Low flow rates or lack of use<br/>
    - Lack of vegetative cover<br/>
    - Leaking plumbing fixture(s)<br/>
    - Low flow [drip] from high efficiency furnace<br/>
    - Open or cracked manhole or inspection pipes<br/>
    - Saturated system
    </td>';
    $html .= '<td style="width:200px;min-width:200px;border:1px solid #333;">
    • Check piping and pumps<br/>
    • Consult a professional<br/>
    • Keep people and vehicles off area<br/>
    • Increase water use and temperature<br/>
    • Have someone use water in house if you are away<br/>
    • Don’t use automobile antifreeze, salt, or other additives<br/>
    • Fix leaking fixtures<br/>
    • Add insulation over tanks, pipes and soil treatment area<br/>
    • Do NOT run water continuously <br/>
    • Operate septic tank as a holding tank<br/>
    • Do NOT build a fire over system 
    </td>';
    $html .= '</tr>';
    $html .= '</table>';
}

//Pests/rodents
$value = getValue("Pests/rodents");
if (!empty($value))
{
    $html .= '<table style="border-collapse:collapse;">';
    $html .= "<tr style='border:1px solid #000;$color'>";
    $html .= '<td style="width:175px;min-width:175px;border:1px solid #333;">Pest or rodents are living or borrowing into system</td>';
    $html .= '<td style="width:200px;min-width:200px;border:1px solid #333;">    
Pests can be dangerous such as bees, spiders, snakes.<br/>
Rodents can burrow into system and damage components & cause surfacing of sewage<br/>
Vegetation over system can be damaged
    </td>';
    $html .= '<td style="width:200px;min-width:200px;border:1px solid #333;">
    - The system is located in an area prone to pest or rodents
    </td>';
    $html .= '<td style="width:200px;min-width:200px;border:1px solid #333;">
    • Make sure all components are tightly sealed to limit intrusion<br/>
    • Eliminate pests and rodents<br/>
    • Have a septic professional fix any areas where the soil and vegetation have been impacted
    </td>';
    $html .= '</tr>';
    $html .= '</table>';
}

//Power failure
$value = getValue("Power failure");
if (!empty($value))
{
    $html .= '<table style="border-collapse:collapse;">';
    $html .= "<tr style='border:1px solid #000;$color'>";
    $html .= '<td style="width:175px;min-width:175px;border:1px solid #333;">Power failure</td>';
    $html .= '<td style="width:200px;min-width:200px;border:1px solid #333;">    
If electricity is needed to power pumps or treatment components they will not operate during the outage.<br/>
Could result in improper sewage treatment, surfacing of effluent  or back-up of effluent into the home<br/>
    </td>';
    $html .= '<td style="width:200px;min-width:200px;border:1px solid #333;">
    - Nature disaster<br/>
    - Electrical line being cut<br/>
    - Fuse breaker being tripped
    </td>';
    $html .= '<td style="width:200px;min-width:200px;border:1px solid #333;">
    • Verify fuse breaker has not been tripped <br/>
    • Report power outage to electrical company <br/>
    • After power is restored if issues persists, have a septic professional evaluate panels, pumps or other components to determine if damaged
    </td>';
    $html .= '</tr>';
    $html .= '</table>';
}

//Roots
$value = getValue("Roots");
if (!empty($value))
{
    $html .= '<table style="border-collapse:collapse;">';
    $html .= "<tr style='border:1px solid #000;$color'>";
    $html .= '<td style="width:175px;min-width:175px;border:1px solid #333;">Roots plugging pipes or components</td>';
    $html .= '<td style="width:200px;min-width:200px;border:1px solid #333;">    
If roots are excessive in pipes or components they can cause blockages resulting in improper sewage treatment, surfacing of effluent  or back-up of effluent into the home
    </td>';
    $html .= '<td style="width:200px;min-width:200px;border:1px solid #333;">
    - Components not sealed properly<br/>
    - Old piping or components are in need of replacement<br/>
    - Components located near water loving trees
    </td>';
    $html .= '<td style="width:200px;min-width:200px;border:1px solid #333;">
    • Confirm where roots are growing into system <br/>
    • Seal up or replace areas where roots are getting into the system <br/>
    • Copper sulfate is a short term Band-Aid  but not the solution and should only be a temporary solution
    </td>';
    $html .= '</tr>';
    $html .= '</table>';
}

//Trees Uprooting
$value = getValue("Tree uprooting");
if (!empty($value))
{
    $html .= '<table style="border-collapse:collapse;">';
    $html .= "<tr style='border:1px solid #000;$color'>";
    $html .= '<td style="width:175px;min-width:175px;border:1px solid #333;">Trees uprooting near or on septic system</td>';
    $html .= '<td style="width:200px;min-width:200px;border:1px solid #333;">    
Damage to system components<br/>
Compaction due to trees or equipment used to remove trees<br/>
Loss of vegetation<br/>
    </td>';
    $html .= '<td style="width:200px;min-width:200px;border:1px solid #333;">
    - Natural disaster<br/>
    - Water logged soils<br/>
    - High winds
    </td>';
    $html .= '<td style="width:200px;min-width:200px;border:1px solid #333;">
    • Keep heavy equipment off of septic system components <br/>
    • Re-establish vegetationHave a septic professional evaluate system to determine if damaged
    </td>';
    $html .= '</tr>';
    $html .= '</table>';
}

//Vegetation
$value = getValue("Vegetation");
if (!empty($value))
{
    $html .= '<table style="border-collapse:collapse;">';
    $html .= "<tr style='border:1px solid #000;$color'>";
    $html .= '<td style="width:175px;min-width:175px;border:1px solid #333;">Lack of vegetation over system</td>';
    $html .= '<td style="width:200px;min-width:200px;border:1px solid #333;">    
System may look unappealing<br/>
Erosion of soil cover which may result in damage to system components<br/>
Freezing more likely in cold climates<br/>
    </td>';
    $html .= '<td style="width:200px;min-width:200px;border:1px solid #333;">
    - Vegetation was not properly established<br/>
    - Cover material may not be suitable to support vegetation<br/>
    - The vegetation planted may not be appropriate 
    </td>';
    $html .= '<td style="width:200px;min-width:200px;border:1px solid #333;">
    • Consult local septic professional or landscaping expert about proper establishment of vegetation over septic system<br/>
    • Plant and maintain vegetation appropriate for climate,  location and soil conditions
    </td>';
    $html .= '</tr>';
    $html .= '</table>';
}

//Well related issues
$value = getValue("Well related issues");
if (!empty($value))
{
    $html .= '<table style="border-collapse:collapse;">';
    $html .= "<tr style='border:1px solid #000;$color'>";
    $html .= '<td style="width:175px;min-width:175px;border:1px solid #333;">Contaminated well</td>';
    $html .= '<td style="width:200px;min-width:200px;border:1px solid #333;">    
Health risks are magnified by possible ingestion of contaminated water.<br/>
Drinking contaminated water can cause health problems such as dysentery, hepatitis, and, for infants, methemo-globinemia. <br/>
    </td>';
    $html .= '<td style="width:200px;min-width:200px;border:1px solid #333;">
    - System too close to well, water table, or fractured bedrock<br/>
    - Cesspool or drywell in use <br/>
    - Sewage discharges to surface or groundwater<br/>
    - Improper well construction<br/>
    - Broken water supply pipe<br/>
    - High levels from other sources<br/>
    - Broken sewage lines
    </td>';
    $html .= '<td style="width:200px;min-width:200px;border:1px solid #333;">
    • Replace your well and/or septic system<br/>
    • Contact your local government to investigate other potential sources 
    </td>';
    $html .= '</tr>';
    $html .= '</table>';
}

$question = $questionsClass->getQuestionsByTitle("Other", CATEGORY_ID);
$questionID = $question[0]['id'];

$answers = $answersClass->getDetailsByLabel("Problem", $questionID);
$problemID = $answers[0]['id'];

$answers = $answersClass->getDetailsByLabel("Risk", $questionID);
$riskID = $answers[0]['id'];

$answers = $answersClass->getDetailsByLabel("Potential Causes", $questionID);
$causesID = $answers[0]['id'];

$answers = $answersClass->getDetailsByLabel("Potential Remedies", $questionID);
$remediesID = $answers[0]['id'];

$problems = $answersClass->getUserAnswers($userID, $projectID, $problemID);
$risks = $answersClass->getUserAnswers($userID, $projectID, $riskID);
$causes = $answersClass->getUserAnswers($userID, $projectID, $causesID);
$remedies = $answersClass->getUserAnswers($userID, $projectID, $remediesID);

for ($i=0; $i<count($problems); $i++)
{
    $html .= '<table style="border-collapse:collapse;">';
    $html .= "<tr style='border:1px solid #000;$color'>";
    $html .= "<td style='width:175px;min-width:175px;border:1px solid #333;'>{$problems[$i]['value']}</td>";
    $html .= '<td style="width:200px;min-width:200px;border:1px solid #333;">' .$risks[$i]['value']. '</td>';
    $html .= '<td style="width:200px;min-width:200px;border:1px solid #333;">' .$causes[$i]['value']. '</td>';
    $html .= '<td style="width:200px;min-width:200px;border:1px solid #333;">' .$remedies[$i]['value']. '</td>';
    $html .= '</tr>';
    $html .= '</table>';
}

function getValue($title)
{
    global $questionsClass, $answersClass, $projectID, $userID;
    
    $question = $questionsClass->getQuestionByTitle($title, CATEGORY_ID);
    $questionID = $question['id'];
    $answers = $answersClass->getDetailsByLabel("Yes", $questionID);
    $answer = $answers[0];
    $values = $answersClass->getUserAnswers($userID, $projectID, $answer['id']);
    
    return ($values[0]['value']);
}