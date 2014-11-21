<?php
    $fieldName = "";
    $label = "";
    $pdfOutput = "";
    $order = "";
    $default = "";
    $imageDefault = "";

    $textBoxSelected = "";
    $radioSelected = "";
    $checkboxSelected = "";
    $imageSelected = "";
    $unknownSelected = "";
    $staticSelected = "";
    $phoneSelected = "";

    $idHTMLHeader = "";
    $idHTMLValue = "";
    
    if (@$answerID > 0)
    {
        $info = $answersClass->getDetails($answerID);
        
        $label = $info['label'];
        $pdfOutput = $info['pdfOutput'];
        $order = $info['order'];
        
        if ($info['default'] == 1)
            $default = "checked='checked'";
        
        if ($info['type'] == "image")
        {
            $imageDefault = "<label for='default'>Has default image</label><input $default style = 'margin-top: 10px;' type='checkbox' name='default' id='default' value='1' />
                <br />";
        }
        
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
            case "unknown":
                $unknownSelected = "selected='selected'";
                break;
            case "static":
                $staticSelected = "selected='selected'";
                break;
            case "phone":
                $phoneSelected = "selected='selected'";
        }
        
        $idHTMLHeader = "<th scope='col'>ID</th>";
        $idHTMLValue = "<td><h3>$answerID</h3></td>";
    }
    
    echo "
            <div class='submenu'>
                <a href='/admin/questions/edit?sectionID=$sectionID&amp;questionID=$questionID'>Back to question details</a>
            </div>
            <br />
        ";
    
    $typeSelect = "
        <select name='type' onchange='checkImageDefault(this)'>
            <option $textBoxSelected value='text'>Textbox</option>
            <option $radioSelected value='radio'>Radio button</option>
            <option $checkboxSelected value='checkbox'>Checkbox</option>
            <option $imageSelected value='image'>Image</option>
            <option $unknownSelected value='unknown'>Unknown</option>
            <option $staticSelected value='static'>Static PDF</option>
            <option $phoneSelected value='phone'>Phone number</option>
        </select>
    ";
    
    
    $answersAvailable = $answersClass->listParentAnswers($questionID);
    $parentSelect = "
        <select name='parentID'>
            <option value='0'>No parent</option>
    ";
    
    foreach ($answersAvailable as $answ)
    {
        $selected = "";
        if (@$info['parentID'] > 0)
        {
            if ($answ['id'] == $info['parentID'])
                $selected = 'selected="selected"';
        }
        $optionTitle = "(".$answ['id'].") ".$answ['type'];
        if (!empty($answ['label']))
            $optionTitle .= " - {$answ['label']}";
        
        $parentSelect .= "<option $selected value='{$answ['id']}'>$optionTitle</option>";
    }
    $parentSelect .= "</select>";        
        
    echo "
        <h3> Answer details: </h3>
        <form action = '/admin/questions/edit' method='POST'>
            <table id='answersTable'>
                <thead>
                    <tr>                    
                        $idHTMLHeader
                        <th scope='col'>Label</th>
                        <th scope='col'>Type</th>
                        <th scope='col'>Parent</th>
                        <th scope='col'>PDF Output</th>
                        <th scope='col'>Order</th>
                    </tr>
                </thead>
        ";

        echo "
            <tbody>
                <tr>
                    $idHTMLValue
                    <td><input type='text' style='min-width:200px; width:200px;' name='label' value='$label' /></td>
                    <td>$typeSelect</td>
                    <td>$parentSelect</td>
                    <td><textarea rows='5' cols='50' name='pdfOutput'>$pdfOutput</textarea></td>
                    <td><input class='order' type='text' name='order' onclick='this.select();' value='$order' /></td>
                </tr>
            </tbody>
        ";
        
        echo "
                </table>
                <div id='defaultImageInput'>
                    $imageDefault
                </div>
                <input style = 'margin-top: 10px;' type='submit' value='Submit' />
                <input type='hidden' name='action' value='save-answer' />
                <input type='hidden' name='sectionID' value='$sectionID' />
                <input type='hidden' name='questionID' value='$questionID' />
        ";
        
        if (@$answerID > 0)
            echo "<input type='hidden' name='answerID' value='$answerID' />";
        
        echo "</form>";
        
        echo "
            <script>
                function checkImageDefault(selectBox)
                {
                    if (selectBox.value == 'image')
                    {
                        $('#defaultImageInput').html(\"<label for='default'>Has default image</label><input style = 'margin-top: 10px;' type='checkbox' name='default' id='default' value='1' /><br />\");
                    }
                    else
                    {
                        $('#defaultImageInput').html('');

                    }
                }      
            </script>
            ";
?>
