<?php

    $title = "";
    $order = "";
    
    if (@$categoryID > 0)
    {
        $info = $categoriesTable->find_by_id($categoryID);
        
        $title = $info['title'];
        $order = $info['order']; 
    }
    
    echo "
            <div class='submenu'>
                <a href='/admin/questions/edit?sectionID=$sectionID'>Back to list of questions</a>
            </div>
            <br />
        ";


    echo "
        <h3> Category details: </h3>
        <form action = '/admin/questions/edit' method='POST'>
            <table id='questionTable'>
                <thead>
                    <tr>
                        <th scope='col'>Title</th>
                        <th scope='col'>Section</th>
                        <th scope='col'>Order</th>
                    </tr>
                </thead>
        ";

        $sections = $sectionsTable->fetchAll("WHERE `type` != 'parent' ORDER BY `order` ");
        $sectionsDropdown = "<select name='sectionID'>";
        
        foreach ($sections as $section)
        {
            $selected = "";
            if ($section['sectionID'] == $sectionID)
                $selected = 'selected="selected"';
            
            $sectionsDropdown .= "
                <option $selected value='{$section['sectionID']}'>{$section['title']}</option>
            ";
        }
        $sectionsDropdown .= "</select>";
        
        echo "
            <tbody>
                <tr>
                    <td><input type='text' id='title' name='title' value='$title' /></td>
                    <td>$sectionsDropdown</td>
                    <td><input class='order' type='text' name='order' onclick='this.select();' value='$order' /></td>
                </tr>
            </tbody>
        ";

        echo "
                </table>
                <input style = 'margin-top: 10px;' type='submit' value='Submit' />
                <input type='hidden' name='action' value='save-category' />
                <input type='hidden' name='sectionID' value='$sectionID' />
        ";
        
        if ($categoryID > 0)
            echo "<input type='hidden' name='categoryID' value='$categoryID' />";
        
?>