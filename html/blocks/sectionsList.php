<h4>Sections</h4>
<ol id="category_list">
    
<?php
    $sectionsClass = new Sections($db);
    
    $sections = $sectionsClass->listTopSections();
    
    $selectedSection = -1;
    
    if (isset($path[4]) && $path[4] > 0)
        $selectedSection = $path[4];
    else
        $selectedSection = 1;
    
    if ($action == "save_parent_selection")
    {
        $parentID = getParameterNumber("parentID");
        
        if ($parentID > 0)
        {
            $sectionsClass->clearUserSectionsForParent($_SESSION['USER']['ID'], $parentID);

            $selectionArray = getParameterArray("parentID_$parentID");

            foreach ($selectionArray as $selectionID)
            {
                $sectionsClass->addUserSection($_SESSION['USER']['ID'], $selectionID, $parentID);
            }
        }
    }
    
    foreach ($sections as $section)
    {
        if ($section['type'] == "standalone")
        {
            printSectionLink($section);
        }
        elseif($section['type'] == "parent")
        {
            printParentSection ($section);
        }
    }
  
    function printParentSection($parent)
    {
        global $sectionsClass;
        
        $children = $sectionsClass->listChlidrenSectionsForUser($parent['sectionID'], $_SESSION['USER']['ID']);
        
        printSectionLink($parent);
        
        echo "</ol>";
       
        echo "<ol class='sublist'>";
        foreach ($children as $child)
        {
            $details = $sectionsClass->getDetails($child['sectionID']);
            printSectionLink($details);
        }
        echo "</ol>";
        echo "<ol>";
    }
    
    function printSectionLink($section)
    {
        global $projectID, $selectedSection;
        
        $selected = "";
        if ($selectedSection == $section['sectionID'])
            $selected = 'class="activePage"';
        
        echo "
            <li>
                <a $selected href='".WS_URL."projects/view/$projectID/{$section['sectionID']}'>{$section['title']}</a>
            </li>
        ";
    }
    
?>
</ol>
<script type="text/javascript">
    $(document).ready(function(){
        $("#selectedParent").click();
    });
</script>