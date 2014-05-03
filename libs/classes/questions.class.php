<?php
/**
 * Sections class is used to manipulate with question elements.
 *
 * @author mpak
 */
class Questions {
    
    private $orderStr = "ORDER BY `order`";
    
    /**
     * @param   DbObject   $db
     */
    public function __construct($db) {
        $this->db = $db;
        $this->table_name = "questions2";
        $this->questionsTable = new DbObject($this->db, $this->table_name,false);
    }
   
    public function getDetails($questionID)
    {
        if ($questionID > 0)
        {
            $details = $this->questionsTable->find_by_id($questionID);
        
            return $details;
        }
    }
    
    public function listQuestions($categoryID)
    {
        if ($categoryID > 0)
        {
            $questions = $this->questionsTable->fetchAll(" WHERE `categoryID` = $categoryID {$this->orderStr}");
            
            return $questions;
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
    
    public function saveQuestion($title, $hint, $categoryID, $type, $order, $questionID=0)
    {
        $this->questionsTable->data['title'] = $title;
        $this->questionsTable->data['hint'] = $hint;
        $this->questionsTable->data['categoryID'] = $categoryID;
        $this->questionsTable->data['type'] = $type;
        $this->questionsTable->data['`order`'] = $order;

        if ($questionID > 0)
        {
            $this->questionsTable->data['id'] = $questionID;
            $id = $this->questionsTable->update();
        }
        else
            $id = $this->questionsTable->create();    
    }
    
    public function deleteQuestion($questionID)
    {
        if ($questionID > 0)
        {
            $this->questionsTable->data['id'] = $questionID;
            
            $result = $this->questionsTable->delete();
        }
    }
}
