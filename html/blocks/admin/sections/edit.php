<?php
    $sectionsTable = new DbObject($db, 'sections', false);
   
    @$action = !empty($_GET['action'])? $_GET['action'] : $_POST['action'];
    @$sectionID = (int)$_GET['sectionID'] > 0 ? (int)$_GET['sectionID'] : (int)$_POST['sectionID'];

    
    if (!empty($action))
    {
        if ($action == 'save')
        {
            $sectionsTable->data['title'] = $_POST['title'];
            $sectionsTable->data['description'] = $_POST['description'];
            $sectionsTable->data['parentID'] = ((int)$_POST['parentID'] > 0) ? (int)$_POST['parentID'] : null;
            $sectionsTable->data['`order`'] = (int)$_POST['order'];

            $sectionsTable->data['type'] = $sectionsTable->data['parentID'] > 0 ? "child" : $_POST['type'];
            
            if ($sectionID > 0)
            {
                $sectionsTable->data['sectionID'] = $sectionID;
                $id = $sectionsTable->updateSection();
            }
            else
                $id = $sectionsTable->create();    
            
        }
        if ($action == "delete")
        {
            if ($sectionID > 0)
            {
                // TODO: if parent, make all children standalone
                $sectionsTable->data['sectionID'] = $sectionID;
            }
            
            $result = $sectionsTable->deleteSection();
        }
        
        $action = "display-all";
    }
    else
    {        
        if (!empty($sectionID))
            $action = "display-one";
        else
            $action = "display-all";
    }
    
    if ($action == "display-all")
    {
        $sections  = $sectionsTable->fetchAll(" WHERE `parentID` IS NULL OR `parentID` = 0 ORDER BY `order`");

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
                        <a href='/admin/sections/edit?action=delete&apm;sectionID={$section['sectionID']}'>Delete</a>
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
        global $sectionsTable;
        
        $sections  = $sectionsTable->fetchAll(" WHERE `parentID` = $sectionID ORDER BY `order`");
/*
        $result = $sectionsTable->find_by_attribute ("sectionID", $sectionID);
        $parentInfo = $result[0];
  */      
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
