<h4>Sections</h4>
<ol id="category_list">
    
<?php
    $sectionsTable = new DbObject($db, 'sections', false);

    $sections = $sectionsTable->fetchAll("WHERE `type` != 'child' ORDER BY `order`");
    
    $selectedSection = -1;
    if (isset($path[4]) && $path[4] > 0)
        $selectedSection = $path[4];
    else
        $selectedSection = 1;
    
    foreach ($sections as $section)
    {
        if ($section['type'] == "standalone")
        {
            printSectionLink($section);
        }
        elseif($section['type'] == "parent")
        {
            printParentSection ($section['sectionID']);
        }
    }
    
    function printParentSection($sectionID)
    {
        global $sectionsTable, $selectedSection;
        
        $result = $sectionsTable->find_by_attribute("sectionID", $sectionID);
        $parentInfo = $result[0];
        $children = $sectionsTable->find_by_attribute("parentID", $sectionID);
        
        $result = $sectionsTable->find_by_attribute("sectionID", $selectedSection);
        $currentSection = $result[0];
        
        $selected = "";
        if ($currentSection['parentID'] == $parentInfo['sectionID'])
            $selected = 'id="selectedParent"';
        
        echo "</ol>";
        echo "
            <h5 $selected style='margin-bottom:5px' class='question_header'><a class='slidedown' href='#'>{$parentInfo['title']}</a></h5>
        ";
            
        echo "<ol class='question_set_wrapper hidden'>";
        foreach ($children as $child)
        {
            printSectionLink($child);
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