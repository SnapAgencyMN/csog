<?php
/**
 * Questions class is used to manipulate with question elements.
 
Questions are the third element in the tree. A question stores an infinite number of answers. Questions can be of the two types:
     - Title ( A title is just a header text, that can have a number of children questions)
     - Question (A question with a set of answers)

In addition, every question can be a parent and store a number of children questions.
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
