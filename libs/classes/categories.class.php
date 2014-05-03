<?php
/**
 * Sections class is used to manipulate with category elements.
 *
 * @author mpak
 */
class Categories {
    
    private $orderStr = "ORDER BY `order`";
    
    /**
     * @param   DbObject   $db
     */
    public function __construct($db) {
        $this->db = $db;
        $this->table_name = "question_categories";
        $this->categories_mapping_table = "user_category_preferences";
        $this->categoriesTable = new DbObject($this->db, $this->table_name,false);
        $this->categoriesMappingTable = new DbObject($this->db, $this->categories_mapping_table, false);
    }
   
    public function getDetails($categoryID)
    {
        if ($categoryID > 0)
            $details = $this->categoriesTable->find_by_id($categoryID);
        
        return $details;
    }
    
    public function listCategories($sectionID)
    {
        if ($sectionID > 0)
        {
            $categories = $this->categoriesTable->fetchAll(" WHERE `sectionID` = $sectionID {$this->orderStr}");
            
            return $categories;
        }
    }
    
    public function getNumberOfSpawnBoxesForUser($categoryID, $userID)
    {
        if ($userID > 0 && $categoryID > 0)
        {
            $sql = "SELECT `number` FROM {$this->categories_mapping_table} WHERE `categoryID` = $categoryID AND `userID` = $userID";
            
            $result = $this->db->query($sql, true);
            
            if (!empty($result))
                return $result[0];
        }
    }
    
    public function saveSpawnNumber($categoryID, $userID, $value)
    {
        if ($categoryID >0 && $userID > 0)
        {
           $sql = "INSERT INTO `{$this->categories_mapping_table}` (`categoryID`, `userID`, `number`) VALUES ($categoryID, $userID, $value) ON DUPLICATE KEY UPDATE `number` = $value";
           
           $this->db->query($sql);
        }
    }
    
    public function saveCategory($title, $sectionID, $type, $spawn_label, $order, $categoryID = 0)
    {
        $this->categoriesTable->data['title'] = $title;
        $this->categoriesTable->data['sectionID'] = $sectionID;
        $this->categoriesTable->data['type'] = $type;
        $this->categoriesTable->data['spawn_box_label'] = $spawn_label;
        $this->categoriesTable->data['`order`'] = $order;

        if ($categoryID > 0)
        {
            $this->categoriesTable->data['id'] = $categoryID;
            $id = $this->categoriesTable->update();
        }
        else
            $id = $this->categoriesTable->create();
        
        return $id;
    }
    
    public function deleteCategory($categoryID)
    {
        if ($categoryID > 0)
        {
            $this->categoriesTable->data['id'] = $categoryID;
            $this->categoriesTable->delete();
        }
    }
}
