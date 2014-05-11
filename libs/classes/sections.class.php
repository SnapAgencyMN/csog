<?php
/**
 * Sections class is used to manipulate with sections elements.
  Sections are the main element of the tree. Every section can have infinite number of question categories. Sections can be of the three types: standalone, child and parent. 
     - If it is a standalone/child section, display its’ content. 
     - If it is a parent section, prompt user to select for children sections that are relevant to his property
          - Once selected, display child sections

User story:
User selects a dynamic section from the left hand-side menu. The page does not have any children underneath yet. 
 * @author mpak
 */
class Sections {
    
    private $orderStr = "ORDER BY `order`";
    
    /**
     * @param   DbObject   $db
     */
    public function __construct($db) {
        $this->db = $db;
        $this->table_name = "sections";
        $this->sections_mapping_table = "sections_mapping";
        $this->sectionsTable = new DbObject($this->db, $this->table_name,false);
        $this->sectionsMappingTable = new DbObject($this->db, $this->sections_mapping_table, false);
    }
    
    public function listTopSections()
    {
        $sections = $this->sectionsTable->fetchAll("WHERE `type` != 'child' {$this->orderStr}");
        
        return $sections;
    }
    
    public function listNonParentSections()
    {
        $returnArr = array();
        
        $topLevelSections = $this->listTopSections();
        
        foreach ($topLevelSections as $section)
        {
            if ($section['type'] == 'standalone')
                $returnArr[] = $section;
            elseif ($section['type'] == "parent")
            {
                $children = $this->listChildrenSections($section['sectionID']);
                
                foreach ($children as $child)
                {
                    $returnArr[] = $child;
                }
            }
        }
        
        ///$sections = $this->sectionsTable->fetchAll("WHERE `type` != 'parent' {$this->orderStr} ");
        
        return $returnArr;
    }
    
    public function listChildrenSections($parentID)
    {
        if ($parentID > 0)
            $children = $this->sectionsTable->find_by_attribute("parentID", $parentID);
        
        return $children;

    }
    
    public function listParentSections()
    {
        $parents = $this->sectionsTable->find_by_attribute("`type`", 'parent');
        
        return $parents;

    }
    
    public function listChlidrenSectionsForUser($parentID, $userID)
    {   
        if ($parentID > 0 && $userID > 0)
        {
            $sql = "SELECT sectionID FROM `{$this->sections_mapping_table}` WHERE `parentID`=$parentID AND `userID`=$userID";
            $sections = $this->sectionsMappingTable->find_by_sql($sql);
            
            return $sections;
        }
    }
    
    public function getDetails($sectionID)
    {
        if ($sectionID > 0)
            $details = $this->sectionsTable->find_by_attribute("sectionID", $sectionID);
        
        return $details[0];
    }
    
    public function addUserSection ($userID, $sectionID, $parentID)
    {
        
        if ($userID >0 && $sectionID >0 && $parentID >0)
        {            
            $sql = "INSERT INTO `{$this->sections_mapping_table}` (`userID`, `sectionID`, `parentID`) VALUES ($userID, $sectionID, $parentID) ON DUPLICATE KEY UPDATE `sectionID`=$sectionID, `parentID`=$parentID ";
            
            $this->db->query($sql);
        }
    }
    
    public function clearUserSectionsForParent($userID, $parentID)
    {
        if ($userID > 0 && $parentID >0)
        {
            $sql = "DELETE FROM `{$this->sections_mapping_table}` WHERE `parentID`=$parentID AND `userID`=$userID";
            
            $this->db->query($sql);
        }
    }
    
    public function saveSection($title, $description, $order, $parentID=0, $type="", $sectionID =0)
    {
        $this->sectionsTable->data['title'] = $title;
        $this->sectionsTable->data['description'] = $description;
        $this->sectionsTable->data['parentID'] = $parentID;
        $this->sectionsTable->data['`order`'] = $order;

        $this->sectionsTable->data['type'] = $parentID > 0 ? "child" : $type;

        if ($sectionID > 0)
        {
            $this->sectionsTable->data['sectionID'] = $sectionID;
            $id = $this->sectionsTable->updateSection();
        }
        else
            $id = $this->sectionsTable->create();    
    }
    
    public function deleteSection($sectionID)
    {
        if ($sectionID > 0)
        {
            //TODO: Delete all categories for this section
            
            $details = $this->getDetails($sectionID);
            
            // Making all children standalone if deleting parent category
            if ($details['type'] == "parent")
            {
                $children = $this->listChildrenSections($parentID);
                
                foreach ($children as $child)
                {
                    $this->saveSection($child['title'], $child['description'], $child['order'], 0, 'standalone', $child['section']);
                }
            }

            $this->sectionsTable->data['sectionID'] = $sectionID;
            
            $result = $this->sectionsTable->deleteSection();
        }
    }
    
    public function getNextSectionID($currentSectionID)
    {
        $return = false;
        $sections = $this->listNonParentSections();
        
        foreach ($sections as $section)
        {
            if ($return)
                return $section['sectionID'];
            
            if ($section['sectionID'] == $currentSectionID)
                $return = true;
        }
    }
    
}
