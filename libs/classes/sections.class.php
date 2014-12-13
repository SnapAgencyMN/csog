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
    
    //private $orderStr = "ORDER BY order";
    private $orderStr = "ORDER BY [order]";
    
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
        $sections = $this->sectionsTable->fetchAll("WHERE type != 'child' {$this->orderStr}");
        
        return $sections;
    }
    
    public function listAllSections()
    {
        $returnArr = array();
        
        $topLevelSections = $this->listTopSections();
        
        foreach ($topLevelSections as $section)
        {
            if ($section['type'] == 'standalone')
                $returnArr[] = $section;
            elseif ($section['type'] == "parent")
            {
                $returnArr[] = $section;
                $children = $this->listChildrenSections($section['sectionID']);
                
                foreach ($children as $child)
                {
                    $returnArr[] = $child;
                }
            }
        }
        
        ///$sections = $this->sectionsTable->fetchAll("WHERE type != 'parent' {$this->orderStr} ");
        
        return $returnArr;
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
        
        ///$sections = $this->sectionsTable->fetchAll("WHERE type != 'parent' {$this->orderStr} ");
        
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
        $parents = $this->sectionsTable->find_by_attribute("type", 'parent');
        
        return $parents;

    }
    
    public function listChlidrenSectionsForUser($parentID, $userID, $projectID = 0)
    {   
        if ($parentID > 0 && $userID > 0)
        {
            $suffix = "";
            if ($projectID > 0)
                $suffix = "AND projectID = $projectID";
            
            $sql = "SELECT sectionID FROM {$this->sections_mapping_table} WHERE parentID=$parentID AND userID=$userID $suffix";
            $sections = $this->sectionsMappingTable->find_by_sql($sql);

            return $sections;
        }
    }
    
    public function getDetails($sectionID)
    {
        $details = null;
        if ($sectionID > 0)
            $details = $this->sectionsTable->find_by_attribute("sectionID", $sectionID);
        
        return $details[0];
    }
    
    public function addUserSection ($userID, $sectionID, $parentID, $projectID)
    {
        $id = -1;
        if ($userID >0 && $sectionID >0 && $parentID >0)
        {           
            try
            {
                $selectSQL = "SELECT sectionID FROM {$this->sections_mapping_table} WHERE sectionID = $sectionID AND userID = $userID AND projectID = $projectID";
                $resource = $this->db->query($selectSQL);
                $result = sqlsrv_fetch_array($resource, SQLSRV_FETCH_ASSOC);
                $id = $result['sectionID'];
            }
            catch (Exception $e)
            {
                $id = 0;
            }
            
            if ($id > 0)
            {
                $sql = "UPDATE {$this->sections_mapping_table} SET parentID = '$parentID' WHERE id = $id";
            }
            else
            {
                $sql = "INSERT INTO {$this->sections_mapping_table} (userID, sectionID, parentID, projectID) VALUES ($userID, $sectionID, $parentID, $projectID) ";
            }
            $this->db->query($sql);
        }
    }
    
    public function deleteUserSection ($userID, $sectionID, $parentID, $projectID)
    {
        if ($userID >0 && $sectionID >0 && $parentID >0)
        {            
            $sql = "DELETE FROM {$this->sections_mapping_table} WHERE userID = $userID AND sectionID = $sectionID AND parentID = $parentID AND projectID = $projectID";
            
            $this->db->query($sql);
        }

    }
    
    public function clearUserSectionsForParent($userID, $parentID)
    {
        if ($userID > 0 && $parentID >0)
        {
            $sql = "DELETE FROM {$this->sections_mapping_table} WHERE parentID=$parentID AND userID=$userID";
            
            $this->db->query($sql);
        }
    }
    
    public function saveSection($title, $description, $order, $parentID=0, $type="", $sectionID =0)
    {
        $this->sectionsTable->data['title'] = str_replace("'", "''", $title);
        $this->sectionsTable->data['description'] = str_replace("'", "''", $description);
        $this->sectionsTable->data['parentID'] = $parentID;
        $this->sectionsTable->data['[order]'] = $order;
        //$this->sectionsTable->data['order'] = $order;

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
    
    public function getNextSectionID($currentSectionID, $userID)
    {
        $check = false;
        $sections = $this->listAllSections();
        
        foreach ($sections as $section)
        {
            if ($check)
            {
                $sectionDetails = $this->getDetails($section['sectionID']);
                if ($sectionDetails['parentID'] > 0)
                {
                    $userSections = $this->listChlidrenSectionsForUser($sectionDetails['parentID'], $userID);
                    
                    foreach ($userSections as $sec)
                    {
                        if ($sec['sectionID'] == $section['sectionID'])
                        {
                            return $section['sectionID'];
                        }
                    }
                }
                else                
                    return $section['sectionID'];
            }
            
            if ($section['sectionID'] == $currentSectionID)
                $check = true;
        }
    }
    
    public function isLastSection($sectionID)
    {
        //$lastSection = $this->sectionsTable->fetchAll("WHERE type = 'standalone' ORDER BY order DESC LIMIT 1");
        $this->sectionsTable->limit = 1;
        $lastSection = $this->sectionsTable->fetchAll("WHERE type = 'standalone' ORDER BY [order] DESC");
        $this->sectionsTable->limit = 0;
        //print_r($lastSection);
        if ($lastSection[0]['sectionID'] == $sectionID)
            return true;
        else 
            return false;
    }
    
    public function getPaginationData($sectionID, $userID)
    {
        $i = 0;
        $nextSectionID = 0;
        
        //$sql = "SELECT * FROM {$this->table_name} WHERE type != 'child' ORDER BY order";
        $sql = "SELECT * FROM {$this->table_name} WHERE type != 'child' ORDER BY [order]";
        $topLevelSections = $this->sectionsTable->find_by_sql($sql);
        
        foreach ($topLevelSections as $section)
        {
            $i++;
            
            if ($section['sectionID'] == $sectionID)
                $seqNum = $i;
            
            if ($section['type'] == "parent")
            {
                $children = $this->listChlidrenSectionsForUser($section['sectionID'], $userID);
                
                if (!empty($children))
                {
                    foreach ($children as $child)
                    {
                        $i++;

                        if ($child['sectionID'] == $sectionID)
                            $seqNum = $i;
                    }
                }
            }
        }
        $result['sequence'] = $seqNum;
        $result['nextSectionSeqNum'] = $seqNum+1;
        $result['total'] = $i;
        
        return $result;
    }
    
}
