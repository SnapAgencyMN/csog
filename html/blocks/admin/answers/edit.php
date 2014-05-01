<?php
    if (!isset($questionsTable))
        $questionsTable = new DbObject($db, 'questions2', false);
    
    if(!isset($answersTable)) 
        $answersTable = new DbObject($db, 'answers2', false);
    

    @$action = !empty($_GET['action'])? $_GET['action'] : $_POST['action'];
    @$questionID = (int)$_GET['questionID'] > 0 ? (int)$_GET['questionID'] : (int)$_POST['questionID'];
    @$answerID = (int)$_GET['answerID'] > 0 ? (int)$_GET['answerID'] : (int)$_POST['answerID'];
    @$sectionID = (int)$_GET['sectionID'] > 0 ? (int)$_GET['sectionID'] : (int)$_POST['sectionID'];

    
    if ($questionID <= 0 && $answerID <= 0)
    {
        out("Invalid parameters");
        die();
    }
    
    if (!empty($action))
    {
        if ($action == 'save-answer')
        {
            $answersTable->data['fieldName'] = $_POST['fieldName'];
            $answersTable->data['label'] = $_POST['label'];
            $answersTable->data['type'] = $_POST['type'];
            $answersTable->data['pdfOutput'] = $_POST['pdfOutput'];
            $answersTable->data['questionID'] = $questionID;
            $answersTable->data['`order`'] = (int)$_POST['order'];
            
            if ($answerID > 0)
            {
                $answersTable->data['id'] = $answerID;
                $id = $answersTable->update();
            }
            else
                $id = $answersTable->create();
        }
        if ($action == "delete-answer")
        {
            if ($questionID > 0)
            {
                // TODO: if parent, make all children standalone
                $answersTable->data['id'] = $answerID;
                $result = $answersTable->delete();
            }
        }
        
        $action = "display-all";
    }
    else
    {        
        if (!empty($answerID))
            $action = "display-one";
        else
            $action = "display-all";
    }
    
    if ($action == "display-all")
    {
        $answers  = $answersTable->fetchAll(" WHERE `questionID` = $questionID ORDER BY `order`");


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
                            <th scope='col'>Field name</th>
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
                echo "
                    <tr>
                        <td>{$answer['fieldName']}</td>
                        <td>{$answer['label']}</td>
                        <td>{$answer['type']}</td>
                        <td>{$answer['pdfOutput']}</td>
                        <td>{$answer['order']}</td>
                        <td>
                            <a href='/admin/answers/edit?questionID={$questionID}&amp;answerID={$answer['id']}&amp;sectionID=$sectionID'>Edit</a>
                            <a href='/admin/questions/edit?action=delete-answer&amp;questionID={$questionID}&amp;answerID={$answer['id']}&amp;sectionID=$sectionID'>Delete</a>
                        </td>
                    </tr>
                ";


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
?>
