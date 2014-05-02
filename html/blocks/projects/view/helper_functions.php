<?php

function printAnswer($answer)
{
    switch ($answer['type'])
    {
        case "text":
            echo "
                <input type='text' name='{$answer['fieldName']}' id='answer_{$answer['id']}' class='textbox form_question' />
            ";
            break;
        case "radio":
            echo "
                <label class='form_question'>{$answer['label']}</label>
                <input type='radio' name='{$answer['fieldName']}' id='answer_{$answer['id']}' class='form_question' />
            ";
            break;
        case "checkbox":
            echo "
                <input type='checkbox' name='{$answer['fieldName']}' id='answer_{$answer['id']}' class='form_question checkbox' />
                <label class='form_question'>{$answer['label']}</label>
            ";
            break;
        case "image":
            echo "
                <a href='".WS_URL."media/uploads/139628533653399f98999a2.jpeg' data-lightbox='image-116'><img src='".WS_URL."media/uploads/139628533653399f98999a2.jpeg' class='imageLightboxLink'>
                    <img src='".WS_URL."media/uploads/139628533653399f98999a2.jpeg' class='imageLightboxLink'>
                </a>
                <iframe src='".WS_URL."html/blocks/fileupload.php?qID={$answer['answerID']}' class='upload_frame'></iframe>
            ";
            break;
    }
}

function isSelected($sectionID, $sectionsArray)
{
    foreach ($sectionsArray as $section)
    {
        if ($section['sectionID'] == $sectionID)
            return true;
    }
    return false;
}
