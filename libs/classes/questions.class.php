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
    
    public function listQuestionsOfType($categoryID, $type='question')
    {
        if ($categoryID > 0)
        {
            $questions = $this->questionsTable->fetchAll(" WHERE `categoryID` = $categoryID AND `type`='$type' {$this->orderStr}");
            
            return $questions;
        }
    }
    
    public function getQuestionByTitle($title, $categoryID)
    {
        if (!empty($title) && $categoryID > 0)
        {
            $questions = $this->questionsTable->fetchAll(" WHERE `categoryID` = $categoryID AND `title` = '$title' {$this->orderStr} LIMIT 1");
            
            return $questions[0];
        }
    }
    
    public function getQuestionsByTitle($title, $categoryID)
    {
        if (!empty($title) && $categoryID > 0)
        {
            $questions = $this->questionsTable->fetchAll(" WHERE `categoryID` = $categoryID AND `title` = '$title' {$this->orderStr}");
            
            return $questions;
        }
    }
    
    public function saveQuestion($title, $hint, $categoryID, $type, $order, $questionID=0)
    {
        include_once(__DIR__."/answers.class.php");
        $answersClass = new Answers($this->db);

        $this->questionsTable->clear_data();
        $this->questionsTable->data['title'] = $title;
        $this->questionsTable->data['hint'] = $hint;
        $this->questionsTable->data['categoryID'] = $categoryID;
        $this->questionsTable->data['type'] = $type;
        $this->questionsTable->data['`order`'] = $order;
        $otherAnswersExist = false;
        if ($questionID > 0)
        {
            $data = $this->getDetails($questionID);
            
            if ($data['type'] == "other")
            {
                if ($type != "other")
                    $answersClass->deleteAllAnswers($questionID);
                else
                    $otherAnswersExist = true;
            }
            
            $this->questionsTable->data['id'] = $questionID;
            $id = $this->questionsTable->update();
        }
        else
            $questionID = $this->questionsTable->create();  
        
        if ($type == "other" && !$otherAnswersExist)
        {
            $answersClass->saveAnswer("", "checkbox", "", 0, $questionID, 0);
            $answersClass->saveAnswer("", "text", "", 0, $questionID, 1);
        }
        
        unset($answersClass);
        return $questionID;
    }
    
    public function deleteQuestion($questionID)
    {
        include_once(__DIR__."/answers.class.php");
        $answersClass = new Answers($this->db);
        
        if ($questionID > 0)
        {
            $answersClass->deleteAllAnswers($questionID);
            
            $this->questionsTable->data['id'] = $questionID;
            
            $result = $this->questionsTable->delete();
        }
        unset($answersClass);
    }
}
