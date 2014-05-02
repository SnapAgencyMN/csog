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
        $this->categories_mapping_table = "categories_mapping";
        $this->categoriesTable = new DbObject($this->db, $this->table_name,false);
        $this->categoriesMappingTable = new DbObject($this->db, $this->categories_mapping_table, false);
    }
   
    public function getDetails($categoryID)
    {
        if ($categoryID > 0)
            $details = $this->categoriesTable->find_by_id($categoryID);
        
        return $details;
    }
    
}
