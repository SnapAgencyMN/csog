<?php    
    if(!isset($answersClass)) 
        $answersClass = new Answers($db);
    
    $action = getParameterString("action");
    $questionID = getParameterNumber('questionID');
    $answerID = getParameterNumber("answerID");
    $sectionID = getParameterNumber('sectionID');

    if ($questionID <= 0 && $answerID <= 0)
    {
        out("Invalid parameters");
        die();
    }

    if (!empty($action))
    {
        if ($action == 'save-answer')
        {
            $label = getParameterString("label");
            $type = getParameterString("type");
            $pdf = getParameterString("pdfOutput");
            $order = getParameterNumber('order');
            $parentID = getParameterNumber('parentID');
            
            $answersClass->saveAnswer($label, $type, $pdf, $parentID, $questionID, $order, $answerID);
        }
        if ($action == "delete-answer")
        {
            $answersClass->deleteAnswer($answerID);
        }
        
        $action = "display-all";
    }
    else
    {        
        if ($answerID>0)
            $action = "display-one";
        else
            $action = "display-all";
    }
    
    if ($action == "display-all")
    {
        $answers  = $answersClass->listParentAnswers($questionID);

        if (!empty($answers))
        {
            echo "
                <br /><br /><br />
                <h3>Answers details:</h3>
                <a href='/admin/answers/add?questionID=$questionID&amp;sectionID=$sectionID'>Add new answer</a><br />
            ";

            echo "<br />
                <table>
                    <thead>
                        <tr>
                            <th scope='col'>ID</th>
                            <th scope='col'>Label</th>
                            <th scope='col'>Type</th>
                            <th scope='col'>PDF Output</th>
                            <th scope='col'>Order</th>
                            <th scope='col'>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
            ";
            
            foreach ($answers as $answer)
            {
                printAnswerRow($answer);
                $children = $answersClass->listChildren($answer['id']);
                
                if (!empty($children))
                {
                    foreach ($children as $child)
                    {
                        printAnswerRow($child, "15px");
                    }
                }

            }

            echo "</tbody></table>";
        }
        else
        {
            
            echo "<br /><br /><h3>No answers set for this questions</h3>";
            echo "<a href='/admin/answers/add?questionID=$questionID&amp;sectionID=$sectionID'>Add new answer</a><br />";

        }
    }
    elseif ($action == "display-one")
    {
        require_once ("singleAnswer.php");
    }
    
    function printAnswerRow($answer, $intent = "5px")
    {
        global $sectionID, $questionID;
        
        echo "
            <tr>
                <td style='padding-left:$intent'>{$answer['id']}</td>
                <td style='padding-left:$intent'>{$answer['label']}</td>
                <td style='padding-left:$intent'>{$answer['type']}</td>
                <td style='padding-left:$intent'>{$answer['pdfOutput']}</td>
                <td style='padding-left:$intent'>{$answer['order']}</td>
                <td style='padding-left:$intent'>
                    <a href='/admin/answers/edit?questionID={$questionID}&amp;answerID={$answer['id']}&amp;sectionID=$sectionID'>Edit</a>
                    <a href='/admin/questions/edit?action=delete-answer&amp;questionID={$questionID}&amp;answerID={$answer['id']}&amp;sectionID=$sectionID'>Delete</a>
                </td>
            </tr>
        ";
    }
?>
