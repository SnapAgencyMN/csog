<?php
/**
 * Categories class is used to manipulate with category elements.

Categories are the second element in the tree. They used to store question sets. Categories can be of the three types:
     - Spawned based on user input (The number of these sections are specified by a user)
     - Operation & Maintenance ( Are referenced further. Can be spawned. Need clarification around user story)
     - Normal category, which is a simple set of questions 

User story:
If a user hits a spawned category, he is presented with a select drop down/input to enter the number of equipment that he posses. 
 * Once filled in, the user clicks “Update” button underneath the input box which reloads the page and provides user with a number of sub-categories 
 * that is equal to the number he has filled in.
 

 * * The page reloads and the selected sections appear with an intend below the parent section. 
 * @author mpak
 */
class Categories {
    
    //private $orderStr = "ORDER BY order";
    private $orderStr = "ORDER BY [order]";
    
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
            $categories = $this->categoriesTable->fetchAll(" WHERE sectionID = $sectionID {$this->orderStr}");
            
            return $categories;
        }
    }
    
    public function getNumberOfSpawnBoxesForUser($categoryID, $userID, $projectID=0)
    {
        if ($userID > 0 && $categoryID > 0)
        {
            $suffix = "";
            if ($projectID > 0)
                $suffix = "AND projectID = $projectID";
            
            $sql = "SELECT number FROM {$this->categories_mapping_table} WHERE categoryID = $categoryID AND userID = $userID $suffix";
            
            $result = $this->db->query($sql, true);

            if (!empty($result))
                return $result[0]['number'];
        }
    }
    
    public function getDetailsByTitle($sectionID, $title)
    {
        $title = str_replace("'", "''", $title);
        //$result = $this->categoriesTable->fetchAll(" WHERE sectionID = $sectionID AND title = '$title' {$this->orderStr} LIMIT 1");
        $this->categoriesTable->limit = 1;
        $result = $this->categoriesTable->fetchAll(" WHERE sectionID = $sectionID AND title = '$title' {$this->orderStr} ");
        $this->categoriesTable->limit = 0;
        
        return $result[0];
    }
    
    public function saveSpawnNumber($categoryID, $userID, $value, $projectID)
    {
        if ($categoryID >0 && $userID > 0)
        {
            try
            {
                $selectSQL = "SELECT * FROM {$this->categories_mapping_table} WHERE categoryID = $categoryID AND userID = $userID AND projectID=$projectID";
                $resource = $this->db->query($selectSQL);
                $result = sqlsrv_fetch_array($resource, SQLSRV_FETCH_ASSOC);
            }
            catch (Exception $e)
            {
                $result = "";
            }
            
            if (!empty($result))
            {
                $sql = "UPDATE {$this->categories_mapping_table} SET number = '$value' WHERE categoryID = $categoryID AND userID = $userID AND projectID=$projectID";
            }
            else
            {
                $sql = "INSERT INTO {$this->categories_mapping_table} (categoryID, userID, number, projectID) VALUES ($categoryID, $userID, $value, $projectID)";           
            }
            $this->db->query($sql);

        }
    }
    
    public function saveCategory($title, $sectionID, $type, $spawn_label, $order, $categoryID = 0)
    {
        $this->categoriesTable->data['title'] = str_replace("'", "''", $title);
        $this->categoriesTable->data['sectionID'] = $sectionID;
        $this->categoriesTable->data['type'] = $type;
        $this->categoriesTable->data['spawn_box_label'] = str_replace("'", "''", $spawn_label);
        //$this->categoriesTable->data['order'] = $order;
        $this->categoriesTable->data['[order]'] = $order;

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
            //TODO: Delete all questions for this category
            
            $this->categoriesTable->data['id'] = $categoryID;
            $this->categoriesTable->delete();
        }
    }
}
