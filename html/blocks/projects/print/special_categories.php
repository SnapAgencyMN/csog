<?php

function printSpecialCategories($category) {
    switch ($category['id']) {
        case 4: // Additional Assistance & Contacts [Operation & Maintainance]
            global $html, $questionsClass, $answersClass, $userID, $projectID;

            //Header
            $html .= '<table style="border-collapse:collapse;">';
            $html .= "<tr>";
            $html .= "<td  style='text-weight:bold;text-align:center;border:1px solid #000;' colspan='5'><h4>Website/Phone Numbers</h4></td>";
            $html .= "</tr>";
            $html .= '<tr style="border:1px solid #000;">';
            $html .= '<td style="font-weight:bold;text-align:center;width:175px;min-width:175px;border:1px solid #000;">' . "Type" . "</td>";
            $html .= '<td style="font-weight:bold;text-align:center;width:155px;min-width:155px;border:1px solid #000;">' . "Name" . "</td>";
            $html .= '<td style="font-weight:bold;text-align:center;width:215px;min-width:215px;border:1px solid #000;">' . "Website" . "</td>";
            $html .= '<td style="font-weight:bold;text-align:center;width:155px;min-width:155px;border:1px solid #000;">' . "Phone Number" . "</td>";
            $html .= '<td style="font-weight:bold;text-align:center;width:155px;min-width:155px;border:1px solid #000;">' . "Email" . "</td>";
            $html .= '</tr>';
            //$html .= '</table>';

            //Content
            $questions = $questionsClass->listQuestions($category['id']);

            $i = 0;
            foreach ($questions as $question) {
                $color = $i % 2 ? "background-color:#ddd" : "";
                switch ($question['type']) {
                    case "question":
                        $name = $answersClass->getDetailsByLabel("Name", $question['id']);
                        $nameValue = $answersClass->getUserAnswers($userID, $projectID, $name[0]['id']);

                        $website = $answersClass->getDetailsByLabel("Website", $question['id']);
                        $websiteValue = $answersClass->getUserAnswers($userID, $projectID, $website[0]['id']);

                        $phone = $answersClass->getDetailsByLabel("Phone Number", $question['id']);
                        $phoneValue = $answersClass->getUserAnswers($userID, $projectID, $phone[0]['id']);

                        $email = $answersClass->getDetailsByLabel("Email", $question['id']);
                        $emailValue = $answersClass->getUserAnswers($userID, $projectID, $email[0]['id']);

                        //$html .= '<table style="border-collapse:collapse;">';
                        $html .= "<tr style='border:1px solid #000;$color'>";
                        $html .= '<td style="width:175px;min-width:175px;border:1px solid #333;">' . $question['title'] . "</td>";
                        $html .= '<td style="width:155px;min-width:155px;border:1px solid #333;">' . $nameValue[0]['value'] . "</td>";
                        $html .= '<td style="width:215px;min-width:215px;border:1px solid #333;">' . $websiteValue[0]['value'] . "</td>";
                        $html .= '<td style="width:155px;min-width:155px;border:1px solid #333;">' . $phoneValue[0]['value'] . "</td>";
                        $html .= '<td style="width:155px;min-width:155px;border:1px solid #333;">' . $emailValue[0]['value'] . "</td>";
                        $html .= '</tr>';
                        //$html .= '</table>';
                        break;

                    case "other":
                        $checkBoxAnswer = $answersClass->listParentAnswers($question['id']);
                        $values = $answersClass->getUserAnswers($userID, $projectID, $checkBoxAnswer[0]['id']);

                        for ($i = 1; $i <= count($values); $i++) {
                            $children = $answersClass->listChildren($checkBoxAnswer[0]['id']);

                            foreach ($children as $child) {
                                switch ($child['label']) {
                                    case "Name":
                                        $nameValue = $answersClass->getUserAnswers($userID, $projectID, $child['id'], 0, $i);
                                        break;
                                    case "Website":
                                        $websiteValue = $answersClass->getUserAnswers($userID, $projectID, $child['id'], 0, $i);
                                        break;
                                    case "Phone Number":
                                        $phoneValue = $answersClass->getUserAnswers($userID, $projectID, $child['id'], 0, $i);
                                        break;
                                    case "Email":
                                        $emailValue = $answersClass->getUserAnswers($userID, $projectID, $child['id'], 0, $i);
                                        break;
                                }
                            }

                            //$html .= '<table style="border-collapse:collapse;">';
                            $html .= "<tr style='border:1px solid #000;$color'>";
                            $html .= '<td style="width:175px;min-width:175px;border:1px solid #333;">' . $question['title'] . " #$i</td>";
                            $html .= '<td style="width:155px;min-width:155px;border:1px solid #333;">' . $nameValue[0]['value'] . "</td>";
                            $html .= '<td style="width:215px;min-width:215px;border:1px solid #333;">' . $websiteValue[0]['value'] . "</td>";
                            $html .= '<td style="width:155px;min-width:155px;border:1px solid #333;">' . $phoneValue[0]['value'] . "</td>";
                            $html .= '<td style="width:155px;min-width:155px;border:1px solid #333;">' . $emailValue[0]['value'] . "</td>";
                            $html .= '</tr>';
                            //$html .= '</table>';
                        }
                        break;
                }

                $i++;
            }
            $html .= '</table>';
            return true;

        case 39: // Setbacks from System [Wastewater Streatment System]
            global $html, $questionsClass, $answersClass, $userID, $projectID;


            $html .= "<p>Your system has been located so that it does not adversely affect neighbouring property or the local environment. Such 'setbacks' are part of your local regulations. Here are the relevant setbacks and easements for your system:</p>";
            //Header
            $html .= '<table style="border-collapse:collapse; width:330px; min-width:330px">';
            $html .= '<tr style="border:1px solid #000;">';
            $html .= '<td style="font-weight:bold;text-align:center;width:175px;min-width:175px;border:1px solid #000;">' . "Component" . "</td>";
            $html .= '<td style="font-weight:bold;text-align:center;width:155px;min-width:155px;border:1px solid #000;">' . "Setback in feet" . "</td>";
            $html .= '</tr>';
            //$html .= '</table>';
            //Content
            $questions = $questionsClass->listQuestions($category['id']);

            $i = 0;
            foreach ($questions as $question) {
                $color = $i % 2 ? "background-color:#ddd" : "";
                switch ($question['type']) {
                    case "question":
                        $setback = $answersClass->getDetailsByLabel("Setback in feet", $question['id']);
                        $val = $answersClass->getUserAnswers($userID, $projectID, $setback[0]['id']);
                        $setbackValue = !empty($val[0]) ? $val[0]['value'] : 0;

                        //$html .= '<table style="border-collapse:collapse;">';
                        $html .= "<tr style='border:1px solid #000;$color'>";
                        $html .= '<td style="width:175px;min-width:175px;border:1px solid #333;">' . $question['title'] . "</td>";
                        $html .= '<td style="width:155px;min-width:155px;border:1px solid #333;">' . $setbackValue . " feet </td>";
                        $html .= '</tr>';
                        //$html .= '</table>';
                        break;
                    case "other":
                        $checkBoxAnswer = $answersClass->listParentAnswers($question['id']);
                        $values = $answersClass->getUserAnswers($userID, $projectID, $checkBoxAnswer[0]['id']);
                        
                        for ($i = 1; $i <= count($values); $i++) {
                            $children = $answersClass->listChildren($checkBoxAnswer[0]['id']);

                            foreach ($children as $child) {
                                switch ($child['label']) {
                                    case "Name":
                                        $nameValue = $answersClass->getUserAnswers($userID, $projectID, $child['id'], 0, $i);
                                        break;
                                    case "Setback in feet":
                                        $val = $answersClass->getUserAnswers($userID, $projectID, $child['id'], 0, $i);
                                        $setbackValue = !empty($val[0]) ? $val[0]['value'] : 0;
                                        break;
                                }
                            }
                            
                            //$html .= '<table style="border-collapse:collapse;">';
                            $html .= "<tr style='border:1px solid #000;$color'>";
                            $html .= '<td style="width:175px;min-width:175px;border:1px solid #333;">' . $nameValue[0]['value'] . "</td>";
                            $html .= '<td style="width:155px;min-width:155px;border:1px solid #333;">' . $setbackValue . " feet</td>";
                            $html .= '</tr>';
                            //$html .= '</table>';                        
                        }
                        break;
                }
            }
            $html .= '</table>';
            return true;
            break;

        case 62: // Maintenance [Maintenance]
            global $html, $questionsClass, $userID, $projectID, $categoriesClass, $answersClass, $sectionsClass;
            
            // Intro
            $html .= "<div class='content'>";
            $html .= '<p>Your onsite system is a vital part of your property’s infrastructure. Taking care of it, just as you would your roof or windows, will ensure longevity and save you money.</p>';
            $html .= '<p>Depending on your system type there may be specific guidance listed elsewhere in this Guide. For conventional systems, a schedule of suggested pumping and cleaning will depend on the size of your property, number of residents, size of tank and type of treatment field.</p>';
            $html .= '<p>Your current system requires regular service to prevent early failure or poor treatment performance. Below are the components of your system and the suggested maintenance activities, frequencies and responsible parties.</p>';
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
            
            // Wastewater Treatment Plumbing
            require_once("o&m/wastewater.php");
            
            // Collection Types
            require_once("o&m/collection.php");

            // Tanks 
            require_once("o&m/tanks.php");
            
            //ATT
            require_once("o&m/att.php");
            $html .= "</table>";
            
            //Final Treatment
            require_once("o&m/finalTreatment.php");
            
            
            return false;
            
        case 63:
            global $html, $questionsClass, $userID, $projectID, $answersClass;
            
            // Intro
            $html .= "<div class='content'>";
            $html .= '<p>If you have having a problem with your system your best plan of attack is to contact a septic professional to evaluate the problem and recommend a course of action. See the key contact list (4.4.1) to determine who can best assist you with your problem. Some of the most typical general and specific issues are identified below.</p>';
            $html .= '<h4>Common problems</h4>';
            $html .= '<p>The three most common causes of septic system failure are:</p>';
            $html .= '<ol>';
            $html .= '<li><p>Overuse of water. Abnormally high water use above or close to the amount your system was designed for, leaks, or short periods of very high water use can all cause failure. Even normal water volumes delivered to a partially damaged system may be too much.</p></li>';
            $html .= '<li><p>Improper maintenance. When too many solids are allowed to accumulate in the septic tank, they will be carried out into the soil treatment area and cause plugging. This usually happens because the owner did not have the septic tank pumped regularly.</p></li>';
            $html .= '<li><p>Improper design or installation. This could result from bad choices or mistakes made by designers, installers and inspectors, or homeowners who have remodeled their home increasing or changing the water use without making appropriate adjustments to their septic system.</p></li>';
            $html .= "</ol>";
            $html .= "<h4>Septic System Troubleshooting Guide for Homeowners</h4>";
            $html .= '<p>Diagnosing the specific causes of failure may be difficult for the owner and often requires the skills of a professional. The following chart shows common problems, possible causes and remedies.</p>';
            $html .= "</div>";
            //Table
            require_once("troubleshooting/table.php");
            
            return true;
        case 65:
            global $html, $questionsClass, $userID, $projectID, $answersClass;
            
            $question = $questionsClass->getQuestionsByTitle("Contact details", 65);
            $questionID = $question[0]['id'];

            $answers = $answersClass->getDetailsByLabel("Company name", $questionID);
            $companyID = $answers[0]['id'];
            $values = $answersClass->getUserAnswers($userID, $projectID, $companyID);
            $companyName = $values[0]['value'];

            
            $answers = $answersClass->getDetailsByLabel("Phone number", $questionID);
            $phoneID = $answers[0]['id'];
            $values = $answersClass->getUserAnswers($userID, $projectID, $phoneID);
            $phoneNumber = $values[0]['value'];
            
            $html .= "<p>Contact your septic professional – $companyName at $phoneNumber</p>";
            
            $html .= '<table style="border-collapse:collapse;">';
            $html .= '<tr style="border:1px solid #000;">';
            $html .= '<td style="font-weight:bold;text-align:center;width:175px;min-width:175px;border:1px solid #000;">' . "Problem" . "</td>";
            $html .= '<td style="font-weight:bold;text-align:center;width:200px;min-width:200px;border:1px solid #000;">' . "Risk" . "</td>";
            $html .= '<td style="font-weight:bold;text-align:center;width:200px;min-width:200px;border:1px solid #000;">' . "Potential Causes" . "</td>";
            $html .= '<td style="font-weight:bold;text-align:center;width:200px;min-width:200px;border:1px solid #000;">' . "Potential Remedies" . "</td>";
            $html .= '</tr>';
            //$html .= '</table>';
            
            //$html .= '<table style="border-collapse:collapse;">';
            $html .= "<tr style='border:1px solid #000;$color'>";
            $html .= '<td style="width:175px;min-width:175px;border:1px solid #333;">Alarm activated</td>';
            $html .= '<td style="width:200px;min-width:200px;border:1px solid #333;">Could result in improper sewage treatment, surfacing of effluent  or back-up of effluent into the home</td>';
            $html .= '<td style="width:200px;min-width:200px;border:1px solid #333;">
            - Pump failed<br /> 
            - Fuse breaker tripped<br /> 
            - Pump unplugged<br /> 
            - Controls malfunctioning<br /> 
            - Ground or rainwater infiltration<br /> 
            - High water use<br /> 
            - Effluent screen plugged<br />
            - Advanced treatment unit not working properly<br />
            - Frozen component</td>';
            $html .= '<td style="width:200px;min-width:200px;border:1px solid #333;">
            • Control water use<br /> 
            • Check breaker and plugs<br /> 
            • Check controls and pump<br /> 
            • Fix leaks in plumbing, tank and piping<br /> 
            • Hire a professional to evaluate the system<br /> 
            </td>';
            $html .= '</tr>';
            $html .= '</table>';

            return true;
        default:
            return false;
    }
}
