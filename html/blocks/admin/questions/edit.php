<?php
    $questionsTable = new DbObject($db, 'questions2', false);
    $sectionsTable = new DbObject($db, "sections", false);
    $categoriesTable = new DbObject($db, "question_categories", false);
    
    @$action = !empty($_GET['action'])? $_GET['action'] : $_POST['action'];
    @$sectionID = (int)$_GET['sectionID'] > 0 ? (int)$_GET['sectionID'] : (int)$_POST['sectionID'];
    @$questionID = (int)$_GET['questionID'] > 0 ? (int)$_GET['questionID'] : (int)$_POST['questionID'];
    @$categoryID = (int)$_GET['categoryID'] > 0 ? (int)$_GET['categoryID'] : (int)$_POST['categoryID'];

    
    if ($sectionID <= 0 && $questionID <= 0)
    {
        out("Invalid parameters");
        die();
    }
    
    if (!empty($action))
    {
        if ($action == "save-category")
        {
            $categoriesTable->data['title'] = $_POST['title'];
            $categoriesTable->data['sectionID'] = (int)$_POST['sectionID'];
            $categoriesTable->data['type'] = $_POST['type'];
            $categoriesTable->data['spawn_box_label'] = $_POST['spawn_box_label'];
            $categoriesTable->data['`order`'] = (int)$_POST['order'];
            
            if ($categoryID > 0)
            {
                $categoriesTable->data['id'] = $categoryID;
                $id = $categoriesTable->update();
            }
            else
                $id = $categoriesTable->create();
        }
        
        if ($action == "delete-category")
        {
            if ($categoryID > 0)
            {
                $categoriesTable->data['id'] = $categoryID;
                $categoriesTable->delete();
            }
        }
        
        if ($action == 'save')
        {
            $questionsTable->data['title'] = $_POST['title'];
            $questionsTable->data['hint'] = $_POST['hint'];
            $questionsTable->data['categoryID'] = (int)$_POST['categoryID'];
            $questionsTable->data['sectionID'] = (int)$_POST['sectionID'];
            $questionsTable->data['`order`'] = (int)$_POST['order'];
            
            if ($questionID > 0)
            {
                $questionsTable->data['id'] = $questionID;
                $id = $questionsTable->update();
            }
            else
                $id = $questionsTable->create();    
            
        }
        if ($action == "delete")
        {
            if ($questionID > 0)
            {
                // TODO: if parent, make all children standalone
                $questionsTable->data['id'] = $questionID;
            }
            
            $result = $questionsTable->delete();
        }
        
        $action = "display-all";
    }
    
    if (!empty($questionID))
        $action = "display-one";
    else
        $action = "display-all";
    
    
    if ($action == "display-all")
    {
        $questions  = $questionsTable->fetchAll(" WHERE `sectionID` = $sectionID ORDER BY `order`");
        $categories = $categoriesTable->fetchAll(" WHERE `sectionID` = $sectionID ORDER BY `order`");
        
        echo "
            <div class='submenu'>
                <a href='/admin/sections/edit'>Back to sections</a>
                <a style='margin-left:20px;' href='/admin/questions/add?sectionID=$sectionID'>Add new question</a>
                <a style='margin-left:20px;' href='/admin/categories/add?sectionID=$sectionID'>Add new category</a>
            </div>
            <br />
        ";

        echo "
            <table>
                <thead>
                    <tr>
                        <th scope='col'>Title</th>
                        <th scope='col'>Order</th>
                        <th scope='col'>Actions</th>
                    </tr>
                </thead>
                <tbody>
        ";
        
        foreach ($categories as $category)
        {
            echo "
                <tr>
                    <td><span style='font-weight:800;'>{$category['title']}</span> (type: {$category['type']})</td>
                    <td>{$category['order']}</td>
                    <td>
                        <a href='/admin/categories/edit?sectionID={$sectionID}&amp;categoryID={$category['id']}'>Edit</a>
                        <a href='/admin/questions/edit?action=delete-category&amp;sectionID={$sectionID}&amp;categoryID={$category['id']}'>Delete</a>
                    </td>
                </tr>
            ";
                        
            printQuestions($category['id']);
        }
        
        

        echo "</tbody></table>";
    }
    elseif ($action == "display-one")
    {
        require_once ("singleQuestion.php");
    }
    
    
    function printQuestions($categoryID)
    {
        global $questionsTable, $sectionID;
        
        $questions = $questionsTable->fetchAll(" WHERE `categoryID`=$categoryID AND `sectionID` = $sectionID");
        
        foreach ($questions as $question)
        {

            echo "
                <tr>
                    <td style='padding-left:10px'>{$question['title']}</td>
                    <td style='padding-left:10px'>{$question['order']}</td>
                    <td>
                        <a href='/admin/questions/edit?sectionID={$sectionID}&amp;questionID={$question['id']}'>Edit</a>
                        <a href='/admin/questions/edit?action=delete&amp;sectionID={$sectionID}&amp;questionID={$question['id']}'>Delete</a>
                    </td>
                </tr>
            ";
        }
    }
?>