<?php
/**
 * 
Answers are the last element in the tree. They are used to prompt user for an input. Can be of the following types:
     - Checkbox (If checked, provides pdfOutput)
     - Radio (depending on which options is selected, may or may not display output)
     - Image upload (Image should be referenced in pdfOutput)
     - Text field (A simple text field input, can be referenced in pdfOutput)
     - Other-textfield (if used, additional text input of the same type is provided, label can be set to whatever)
     - Unknown (if checked, remove all other answers for this question) 

In addition, every answer can be of a following sub-type
     - Trigger (If trigger is selected, children questions are revealed)
     - Basic
 *
 * @author mpak
 */
class Answers {
    
    private $orderStr = "ORDER BY `order`";
    
    /**
     * @param   DbObject   $db
     */
    public function __construct($db) {
        $this->db = $db;
        $this->table_name = "answers2";
        $this->answers_mapping_table = "user_answers";
        $this->answersTable = new DbObject($this->db, $this->table_name,false);
        $this->answersMappingTable = new DbObject($this->db, $this->answers_mapping_table, false);
    }
   
    public function getDetails($answerID)
    {
        if ($answerID > 0)
            $details = $this->answersTable->find_by_id($answerID);
        
        return $details;
    }
    
    public function listAnswers($questionID)
    {
        if ($questionID > 0)
        {
            $answers = $this->answersTable->fetchAll(" WHERE `questionID` = $questionID {$this->orderStr}");
            
            return $answers;
        }
    }
    
    public function listParentAnswers($questionID)
    {
        if ($questionID > 0)
        {
            $answers = $this->answersTable->fetchAll(" WHERE `questionID` = $questionID AND `parentID` = 0 {$this->orderStr}");
            
            return $answers;
        }
    }
    
    public function listChildren($answerID)
    {
        if ($answerID > 0)
        {
            $answers = $this->answersTable->fetchAll(" WHERE `parentID` = $answerID {$this->orderStr}");
            
            return $answers;
        }
    }
    
    public function saveAnswer($label, $type,  $pdf, $parentID, $questionID, $order, $answerID = 0)
    {
        $this->answersTable->data['label'] = $label;
        $this->answersTable->data['type'] = $type;
        $this->answersTable->data['`sub-type`'] = $subtype;
        $this->answersTable->data['pdfOutput'] = $pdf;
        $this->answersTable->data['parentID'] = $parentID;
        $this->answersTable->data['questionID'] = $questionID;
        $this->answersTable->data['`order`'] = $order;

        if ($answerID > 0)
        {
            $this->answersTable->data['id'] = $answerID;
            $id = $this->answersTable->update();
        }
        else
            $id = $this->answersTable->create();
        
        return $id;
    }
    
    public function deleteAnswer($answerID)
    {
        if ($answerID > 0)
        {
            $this->answersTable->data['id'] = $answerID;
            $this->answersTable->delete();
        }
    }
}
