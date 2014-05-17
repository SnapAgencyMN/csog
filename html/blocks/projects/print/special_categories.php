<?php

function printSpecialCategories($category)
{
    switch ($category['id'])
    {
        case 4: // Additional Assistance & Contacts [Operation & Maintainance]
            global $html, $questionsClass, $answersClass, $userID, $projectID;
            
            //Header
            $html .= '<table style="border-collapse:collapse;">';
            $html .= "<tr>";
            $html .= "<td  style='text-weight:bold;text-align:center;border:1px solid #000;' colspan='5'><h4>Website/Phone Numbers</h4></td>";
            $html .= "</tr>";
            $html .= '<tr style="border:1px solid #000;">';
            $html .= '<td style="font-weight:bold;text-align:center;width:175px;min-width:175px;border:1px solid #000;">'."Type"."</td>";
            $html .= '<td style="font-weight:bold;text-align:center;width:155px;min-width:155px;border:1px solid #000;">'."Name"."</td>";
            $html .= '<td style="font-weight:bold;text-align:center;width:215px;min-width:215px;border:1px solid #000;">'."Website"."</td>";
            $html .= '<td style="font-weight:bold;text-align:center;width:155px;min-width:155px;border:1px solid #000;">'."Phone Number"."</td>";
            $html .= '<td style="font-weight:bold;text-align:center;width:155px;min-width:155px;border:1px solid #000;">'."Email"."</td>";
            $html .= '</tr>';
            $html .= '</table>';
            
            //Content
            $questions = $questionsClass->listQuestions($category['id']);

            $i=0;
            foreach ($questions as $question)
            {
                $color = $i % 2 ? "background-color:#ddd" : "";
                switch ($question['type']){
                    case "question":                        
                        $name = $answersClass->getDetailsByLabel("Name", $question['id']);
                        $nameValue = $answersClass->getUserAnswers($userID, $projectID, $name[0]['id']);
                        
                        $website = $answersClass->getDetailsByLabel("Website", $question['id']);
                        $websiteValue = $answersClass->getUserAnswers($userID, $projectID, $website[0]['id']);
                        
                        $phone = $answersClass->getDetailsByLabel("Phone Number", $question['id']);
                        $phoneValue = $answersClass->getUserAnswers($userID, $projectID, $phone[0]['id']);
                        
                        $email = $answersClass->getDetailsByLabel("Email", $question['id']);
                        $emailValue = $answersClass->getUserAnswers($userID, $projectID, $email[0]['id']);
                        
                        $html .= '<table style="border-collapse:collapse;">';
                            $html .= "<tr style='border:1px solid #000;$color'>";
                                $html .= '<td style="width:175px;min-width:175px;border:1px solid #333;">'.$question['title']."</td>";
                                $html .= '<td style="width:155px;min-width:155px;border:1px solid #333;">'.$nameValue[0]['value']."</td>";
                                $html .= '<td style="width:215px;min-width:215px;border:1px solid #333;">'.$websiteValue[0]['value']."</td>";
                                $html .= '<td style="width:155px;min-width:155px;border:1px solid #333;">'.$phoneValue[0]['value']."</td>";
                                $html .= '<td style="width:155px;min-width:155px;border:1px solid #333;">'.$emailValue[0]['value']."</td>";
                            $html .= '</tr>';
                        $html .= '</table>';
                        break;
                    
                    case "other":
                        $checkBoxAnswer = $answersClass->listParentAnswers($question['id']);
                        $values = $answersClass->getUserAnswers($userID, $projectID, $checkBoxAnswer[0]['id']);
      
                        for ($i=1; $i<=count($values); $i++)
                        {                            
                            $children = $answersClass->listChildren($checkBoxAnswer[0]['id']);
                            
                            foreach ($children as $child)
                            {
                                switch ($child['label'])
                                {
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
                            
                            $html .= '<table style="border-collapse:collapse;">';
                                $html .= "<tr style='border:1px solid #000;$color'>";
                                    $html .= '<td style="width:175px;min-width:175px;border:1px solid #333;">'.$question['title']." #$i</td>";
                                    $html .= '<td style="width:155px;min-width:155px;border:1px solid #333;">'.$nameValue[0]['value']."</td>";
                                    $html .= '<td style="width:215px;min-width:215px;border:1px solid #333;">'.$websiteValue[0]['value']."</td>";
                                    $html .= '<td style="width:155px;min-width:155px;border:1px solid #333;">'.$phoneValue[0]['value']."</td>";
                                    $html .= '<td style="width:155px;min-width:155px;border:1px solid #333;">'.$emailValue[0]['value']."</td>";
                                $html .= '</tr>';
                            $html .= '</table>';
                        }
                        break;
                }
                
                $i++;
            }
            
            return true;
        default:
            return false;
    }
}
