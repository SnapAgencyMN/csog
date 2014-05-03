<?php
    $title = "";
    $order = "";
    $hint = "";
    $categoryID = "";
    $titleSelected = "";
    $questionSelected = "";
    
    if (@$questionID > 0)
    {
        $info = $questionsClass->getDetails($questionID);
        
        $title = $info['title'];
        $order = $info['order']; 
        $hint = $info['hint'];
        $categoryID = $info['categoryID'];
        
        if ($info['type'] == "question")
            $questionSelected = 'selected="selected"';
        
        if ($info['type'] == "title")
            $titleSelected = 'selected="selected"';
    }
    
    echo "
            <div class='submenu'>
                <a href='/admin/questions/edit?sectionID=$sectionID'>Back to list of questions</a>
            </div>
            <br />
        ";


    echo "
        <h3> Question details: </h3>
        <form action = '/admin/questions/edit' method='POST'>
            <table id='questionTable'>
                <thead>
                    <tr>
                        <th scope='col'>Title</th>
                        <th scope='col'>Hint</th>
                        <th scope='col'>Type</th>
                        <th scope='col'>Category</th>
                        <th scope='col'>Order</th>
                    </tr>
                </thead>
        ";

        $typeDropdown = "
            <select name='type'>
                <option $questionSelected value='question'>Question</option>
                <option $titleSelected value='title'>Title</option>
            </select>
        ";
    
        $categories = $categoriesTable->fetchAll("WHERE `sectionID`='$sectionID' ORDER BY `order` ");
        $categoriesDropdown = "<select name='categoryID'>";
        
        foreach ($categories as $category)
        {
            $selected = "";
            if ($category['id'] == $categoryID)
                $selected = 'selected="selected"';
            
            $categoriesDropdown .= "
                <option $selected value='{$category['id']}'>{$category['title']}</option>
            ";
        }
        $categoriesDropdown .= "</select>";
        
        echo "
            <tbody>
                <tr>
                    <td><input type='text' id='title' name='title' value='$title' /></td>
                    <td><textarea rows='4' cols='50' name='hint'>$hint</textarea></td>
                    <td>$typeDropdown</td>
                    <td>$categoriesDropdown</td>
                    <td><input class='order' type='text' name='order' onclick='this.select();' value='$order' /></td>
                </tr>
            </tbody>
        ";

        echo "
                </table>
                <input style = 'margin-top: 10px;' type='submit' value='Submit' />
                <input type='hidden' name='action' value='save' />
                <input type='hidden' name='sectionID' value='$sectionID' />
        ";
        
        if (@$questionID > 0)
            echo "<input type='hidden' name='questionID' value='$questionID' />";
        
        echo "</form>";

    if (@$questionID > 0)
        require_once (FS_PATH."html/blocks/admin/answers/edit.php");
?>