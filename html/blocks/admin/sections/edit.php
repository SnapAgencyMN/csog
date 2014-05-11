<?php
    if (!isset($sectionsClass))
        $sectionsClass = new Sections($db);

    
    $action = getParameterString("action");
    $sectionID = getParameterNumber("sectionID");

    
    if (!empty($action))
    {
        if ($action == 'save')
        {
            $title = getParameterString("title");
            $description = getParameterString("description");
            $order = getParameterNumber("order");
            $type = getParameterString("type");
            $parentID = getParameterNumber("parentID");
            
            $sectionsClass->saveSection($title, $description, $order, $parentID, $type, $sectionID);
        }
        if ($action == "delete")
        {
            $sectionsClass->deleteSection($sectionID);
        }
        
        $action = "display-all";
    }
    else
    {        
        if ($sectionID > 0)
            $action = "display-one";
        else
            $action = "display-all";
    }
    
    if ($action == "display-all")
    {
        $sections  = $sectionsClass->listTopSections();

        echo "
            <div class='submenu'>
                <a href='/admin/sections/add'>Add new section</a>
            </div>
            <br />
        ";

        echo "
            <table>
                <thead>
                    <tr>
                        <th scope='col'>Name</th>
                        <th scope='col'>Description</th>
                        <th scope='col'>Type</th>
                        <th scope='col'>Order</th>
                        <th scope='col'>Actions</th>
                    </tr>
                </thead>
                <tbody>
        ";
        foreach ($sections as $section)
        {

            echo "
                <tr>
                    <td>{$section['title']}</td>
                    <td>{$section['description']}</td>
                    <td>{$section['type']}</td>
                    <td>{$section['order']}</td>
                    <td>
                        <a href='/admin/sections/edit?sectionID={$section['sectionID']}'>Edit</a>
                        <a href='/admin/questions/edit?sectionID={$section['sectionID']}'>Manage questions</a>
                        <a href='/admin/sections/edit?action=delete&amp;sectionID={$section['sectionID']}'>Delete</a>
                    </td>
                </tr>
            ";

            if ($section['type'] == 'parent')
                printChildren ($section['sectionID']);
        }

        echo "</tbody></table>";
        //pr_out($sections);
    }
    elseif ($action == "display-one")
    {
        require_once ("singleSection.php");
    }
    
    function printChildren($sectionID)
    {
        global $sectionsClass;
        
        $sections  = $sectionsClass->listChildrenSections($sectionID);

        foreach ($sections as $section)
        {
            echo "
                <tr>
                    <td><span style='padding-left:10px'>{$section['title']}</span></td>
                    <td>{$section['description']}</td>
                    <td>{$section['type']}</td>
                    <td>{$section['order']}</td>
                    <td>
                        <a href='/admin/sections/edit?sectionID={$section['sectionID']}'>Edit</a>
                        <a href='/admin/questions/edit?sectionID={$section['sectionID']}'>Manage questions</a>
                        <a href='/admin/sections/edit?action=delete&amp;sectionID={$section['sectionID']}'>Delete</a>
                    </td>
                </tr>
            ";
        }
    }
    
?>
