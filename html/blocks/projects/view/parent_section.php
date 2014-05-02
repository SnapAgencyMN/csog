<?php
$action = getParameterString("action");
$childrenSections = $sectionsClass->listChlidrenSectionsForUser($sectionDetails['sectionID'], $_SESSION['USER']['ID']);

$children = $sectionsClass->listChildrenSections($sectionID);

$img = "<img src='".WS_URL."/media/hint.png' alt='Hint' title='Please select {$sectionDetails['title']} that you have'>";

echo <<< HTML_STRING

<h3> Please select options relevant to you: </h3>


    <div class='question_set_wrapper' style='display:block; float:left; width:100%;'>
        <form method='post' id='select_children_{$sectionDetails['sectionID']}'>
        <input type='hidden' name='action' value='save_parent_selection'/> 
        <input type='hidden' name='parentID' value='{$sectionDetails['sectionID']}'/> 
        <div class='question_set_row'>
            <div class='question_set_row_hint'>
                $img
            </div>
            <div class='question_set_row_title'>
                {$sectionDetails['title']}
            </div>
            <div class='question_set_row_field'>
HTML_STRING;

foreach ($children as $child)
{
    $checked = isSelected($child['sectionID'], $childrenSections) ? "checked='checked'" : "";
    
    echo <<< HTML_STRING
                <div class='question_answers'>
                    <input class='left' type='checkbox' $checked name='parentID_{$sectionDetails['sectionID']}[]' id='check_{$child['sectionID']}' class='form_question checkbox' value='{$child['sectionID']}' />
                    <label class='left' for='check_{$child['sectionID']}' class='form_question'>{$child['title']}</label>
                </div>
HTML_STRING;
    
}
echo "</div></div></form></div>"
. "<a href='#' onclick='submitForm(\"select_children_{$sectionDetails['sectionID']}\");return false;' >Save</a>";