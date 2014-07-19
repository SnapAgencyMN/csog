<?php
$parentSectionID = 21;

// List all sections
$children = $sectionsClass->listChlidrenSectionsForUser($parentSectionID, $userID);
//pr_out($children);
foreach ($children as $child) {
    $sectionDetails = $sectionsClass->getDetails($child['sectionID']);
    
    // Find OM category in this section and use it as ID
    $category = $categoriesClass->getDetailsByTitle($child['sectionID'], "Operation & Maintenance");
    $categoryID = $category['id'];
    $spawnBoxes = $categoriesClass->getNumberOfSpawnBoxesForUser($categoryID, $userID);
    $questions = $questionsClass->listQuestions($categoryID);

    for ($spawnID = 0; $spawnID < $spawnBoxes; $spawnID++) {
        foreach ($questions as $question) {
            $answers = $answersClass->listParentAnswers($question['id']);

            foreach ($answers as $answer) {
                $values = $answersClass->getUserAnswers($userID, $projectID, $answer['id'], $spawnID);
                switch ($answer['label']) {
                    case "Details":
                        $activityTitle = $values[0]['value'];
                        break;
                    case "Frequency":
                        $activityFrequency = $values[0]['value'];
                }
            }

            switch ($question['title']) {
                case "Activity":
                    $responsibleParty = "";
                    break;
                case "Professional activities":
                    $responsibleParty = "Professional";
                    break;
                case "Homeowner activities":
                    $responsibleParty = "Homeowner";
                    break;
            }

            if (!empty($activityTitle)) {
                //$html .= '<table style="border-collapse:collapse;">';
                $html .= "<tr style='border:1px solid #000;$color'>";
                $html .= '<td style="width:175px;min-width:175px;border:1px solid #333;">' . $sectionDetails['title'] . '</td>';
                $html .= '<td style="width:175px;min-width:175px;border:1px solid #333;">' . $activityTitle . "</td>";
                $html .= '<td style="width:115px;min-width:115px;border:1px solid #333;">' . $activityFrequency . "</td>";
                $html .= '<td style="width:155px;min-width:155px;border:1px solid #333;">' . $responsibleParty . "</td>";
                $html .= '</tr>';
                //$html .= '</table>';
            }
        }
    }
}
                