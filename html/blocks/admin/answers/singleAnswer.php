<?php
    $fieldName = "";
    $label = "";
    $pdfOutput = "";
    $order = "";
    
    $textBoxSelected = "";
    $radioSelected = "";
    $checkboxSelected = "";
    $imageSelected = "";
    $otherSelected = "";
    $unknownSelected = "";
    
    $basicSelected = "";
    $triggerSelected = "";

    if (@$answerID > 0)
    {
        $info = $answersClass->getDetails($answerID);
        
        $label = $info['label'];
        $pdfOutput = $info['pdfOutput'];
        $order = $info['order'];
        
        switch ($info['type'])
        {
            case "text":
                $textBoxSelected = "selected='selected'";
                break;
            case "radio":
                $radioSelected = "selected='selected'";
                break;
            case "checkbox":
                $checkboxSelected = "selected='selected'";
                break;
            case "image":
                $imageSelected = "selected='selected'";
                break;
            case "other":
                $otherSelected = "selected='selected'";
                break;
            case "unknown":
                $unknownSelected = "selected='selected'";
                break;
        }
        
        switch ($info['sub-type'])
        {
            case "basic":
                $basicSelected = "selected='selected'";
                break;
            case "trigger":
                $triggerSelected = "selected='selected'";
                break;
        }
    }
    
    echo "
            <div class='submenu'>
                <a href='/admin/questions/edit?sectionID=$sectionID&amp;questionID=$questionID'>Back to question details</a>
            </div>
            <br />
        ";
    
    $typeSelect = "
        <select name='type'>
            <option $textBoxSelected value='text'>Textbox</option>
            <option $radioSelected value='radio'>Radio button</option>
            <option $checkboxSelected value='checkbox'>Checkbox</option>
            <option $imageSelected value='image'>Image</option>
        </select>
    ";
    
    echo "
        <h3> Answer details: </h3>
        <form action = '/admin/questions/edit' method='POST'>
            <table id='answersTable'>
                <thead>
                    <tr>                        
                        <th scope='col'>Field Name</th>
                        <th scope='col'>Label</th>
                        <th scope='col'>Type</th>
                        <th scope='col'>PDF Output</th>
                        <th scope='col'>Order</th>
                    </tr>
                </thead>
        ";

        echo "
            <tbody>
                <tr>
                    <td><input type='text' style='min-width:100px; width:100px;' name='fieldName' value='$fieldName' /></td>
                    <td><input type='text' style='min-width:100px; width:100px;' name='label' value='$label' /></td>
                    <td>$typeSelect</td>
                    <td><textarea rows='5' cols='100' name='pdfOutput'>$pdfOutput</textarea></td>
                    <td><input class='order' type='text' name='order' onclick='this.select();' value='$order' /></td>
                </tr>
            </tbody>
        ";

        echo "
                </table>
                <input style = 'margin-top: 10px;' type='submit' value='Submit' />
                <input type='hidden' name='action' value='save-answer' />
                <input type='hidden' name='sectionID' value='$sectionID' />
                <input type='hidden' name='questionID' value='$questionID' />
        ";
        
        if (@$answerID > 0)
            echo "<input type='hidden' name='answerID' value='$answerID' />";
        
        echo "</form>";
?>
