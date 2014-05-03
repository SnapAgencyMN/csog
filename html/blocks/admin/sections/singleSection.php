<?php
    $title = "";
    $description = "";
    $type = "";
    $parentID = "";
    $order = "";
    $standaloneSelected = '';
    $parentSelected = '';
    
    if (@$sectionID > 0)
    {
        $info = $sectionsClass->getDetails($sectionID);
        
        $title = $info['title'];
        $description = $info['description'];
        $type = $info['type'];
        $parentID = $info['parentID'];
        $order = $info['order'];  
        
        if ($type == "standalone")
            $standaloneSelected = 'selected="selected"';
        else
            $parentSelected = 'selected="selected"';
        
    }
    
    echo "
            <div class='submenu'>
                <a href='/admin/sections/edit'>Back to list of section</a>
            </div>
            <br />
        ";


    echo "
        <form action = '/admin/sections/edit' method='POST'>
            <table id='contentTable'>
                <thead>
                    <tr>
                        <th scope='col'>Name</th>
                        <th scope='col'>Description</th>
                        <th scope='col' id='typeHeader'>Type</th>
                        <th scope='col' id='parentHeader'>Parent</th>
                        <th scope='col'>Order</th>
                    </tr>
                </thead>
        ";

        $parentsDropdown = "<select name='parentID' id='parentID' onchange='javascript:updateTableView(); return false;'>";

        $parentSections = $sectionsClass->listParentSections();

        if (!empty($parentSections))
        {
            $parentsDropdown .= "<option value='-1'>No parents</option>";
            foreach ($parentSections as $section)
            {
                $selected = "";
                if ($parentID > 0 )
                {
                    if ($parentID = $section['sectionID'])
                    {
                        $selected = "selected='selected'";
                    }
                }
                $parentsDropdown .= "<option $selected value='{$section['sectionID']}'>{$section['title']}</option>";
            }
        }
        else
            $parentsDropdown .= "<option value='-1'>No parent sections found</option>";

        echo "
            <tbody>
                <tr>
                    <td><input type='text' id='title' name='title' value='$title' /></td>
                    <td><input type='text' id='description' name='description' value='$description' /></td>
                    <td id='typeCell'>
                        <select name='type'>
                            <option value='standalone' $standaloneSelected>Standalone</option>
                            <option value='parent' $parentSelected>Parent</option>
                        </select>
                    </td>
                    <td id='parentCell'>$parentsDropdown</td>
                    <td><input class='order' type='text' name='order' onclick='this.select();' value='$order' /></td>
                </tr>
            </tbody>
        ";

        echo "
                </table>
                <input style = 'margin-top: 10px;' type='submit' value='Submit' />
                <input type='hidden' name='action' value='save' />
        ";
        
        if (@$sectionID > 0)
            echo "<input type='hidden' name='sectionID' value='$sectionID' />";
        
        echo "</form>";
?>
<script type="text/javascript">
    $(document).ready(function(){
        updateTableView();
    });
    
    function updateTableView()
    {
        var parentID = $("#parentID").val();
        
        if (parentID == -1)
        {
            $("#typeHeader").css('display', '');
            $("#typeCell").css('display', '');
            $("#parentHeader").css('display', '');
            $("#parentCell").css('display', '');
        }
        else
        {
            $("#typeHeader").css('display', 'none');
            $("#typeCell").css('display', 'none');
        }
    }
</script>
