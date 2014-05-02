<?php
/**
 * Sections class is used to manipulate with sections elements.
 *
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
    
    public function listChildrenSections($parentID)
    {
        if ($parentID > 0)
            $children = $this->sectionsTable->find_by_attribute("parentID", $parentID);
        
        return $children;

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
    
    
}
