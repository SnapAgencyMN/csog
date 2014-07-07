<?php
$action = getParameterString("action");
$childrenSections = $sectionsClass->listChlidrenSectionsForUser($sectionDetails['sectionID'], $_SESSION['USER']['ID']);

$children = $sectionsClass->listChildrenSections($sectionID);

$img = "";
$subTitle = "";
if(!$_SESSION['USER']['Verbose'] )
    $img = "<img src='".WS_URL."/media/hint.png' alt='Hint' title='Please select {$sectionDetails['title']} that you have'>";
else
    $subTitle = "<p class='hintVerbose'>Please select {$sectionDetails['title']} that you have</p>";
    
    
echo <<< HTML_STRING

<h3> Please select options relevant to you: </h3>


    <div class='question_set_wrapper' style='display:block; float:left; width:100%;'>
        <div class='question_set_row'>
            <div class='question_set_row_hint'>
                $img
            </div>
            <div class='question_set_row_title'>
                {$sectionDetails['title']}
                $subTitle
            </div>
            <div class='question_set_row_field'>
HTML_STRING;

foreach ($children as $child)
{
    $checked = isSelected($child['sectionID'], $childrenSections) ? "checked='checked'" : "";
    
    echo <<< HTML_STRING
                <div class='question_answers'>
                    <input class='left' onchange='updateSectionsMenu({$child['sectionID']}, {$sectionDetails['sectionID']}, $projectID); return false;' type='checkbox' $checked name='parentID_{$sectionDetails['sectionID']}[]' id='check_{$child['sectionID']}' class='form_question checkbox' value='{$child['sectionID']}' />
                    <label class='left' for='check_{$child['sectionID']}' class='form_question'>{$child['title']}</label>
                </div>
HTML_STRING;
    
}
echo "</div></div></div>";