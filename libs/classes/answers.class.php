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

 * @author mpak
 */
class Answers {
    
    //private $orderStr = "ORDER BY `order`";
    private $orderStr = "ORDER BY [order]";
    
    /**
     * @param   DbObject   $db
     */
    public function __construct($db) {
        $this->db = $db;
        $this->table_name = "answers2";
        $this->answers_mapping_table_name = "user_answers";
        $this->answersTable = new DbObject($this->db, $this->table_name,false);
        $this->answersMappingTable = new DbObject($this->db, $this->answers_mapping_table_name, false);
    }
    
    public function getDetails($answerID)
    {
        if ($answerID > 0)
            $details = $this->answersTable->find_by_id($answerID);
        
        return $details;
    }
    
    public function getDetailsByLabel($label, $questionID)
    {
        $results = $this->answersTable->fetchAll(" WHERE `label` = \"$label\" AND `questionID` = $questionID");
        
        return $results;
    }
    
    public function listAnswers($questionID, $type="")
    {
        if ($questionID > 0)
        {
            $suffix = "";
            if (!empty($type))
                $suffix .= "AND `type` = '$type' ";
            
            $answers = $this->answersTable->fetchAll(" WHERE `questionID` = $questionID $suffix {$this->orderStr}");
            
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
    
    public function clearUserSelection($userID, $projectID, $questionID, $type="", $spawnID = 0)
    {
        $answers = $this->listAnswers($questionID, $type);
        foreach ($answers as $answer)
        {
            $this->deleteUserAnswer($userID, $projectID, $answer['id'], $spawnID);
        }
    }
    
    public function saveAnswer($label, $type,  $pdf, $parentID, $questionID, $order, $default, $answerID = 0)
    {
        $this->answersTable->clear_data();
        $this->answersTable->data['label'] = $label;
        $this->answersTable->data['type'] = $type;
        $this->answersTable->data['pdfOutput'] = $pdf;
        $this->answersTable->data['parentID'] = $parentID;
        $this->answersTable->data['questionID'] = $questionID;
        //$this->answersTable->data['`order`'] = $order;
        $this->answersTable->data['[order]'] = $order;
        $this->answersTable->data['`default`'] = $default;

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
            $this->answersMappingTable->clear_data();
            $this->answersTable->data['id'] = $answerID;
            $this->answersTable->delete();
        }
    }
    
    public function deleteUserAnswer($userID, $projectID, $answerID, $spawnID)
    {
        if ($userID > 0)
        {
            $userAnswers = $this->getUserAnswers($userID, $projectID, $answerID, $spawnID);
            
            foreach ($userAnswers as $userAnswer)
            {
                $this->answersMappingTable->clear_data();
                $this->answersMappingTable->data['id'] = $userAnswer['id'];
                $this->answersMappingTable->delete();
            }
        }
    }
    
    public function deleteAllAnswers($questionID)
    {
        $answers = $this->listAnswers($questionID);
        
        foreach ($answers as $answer)
        {
            $this->deleteAnswer($answer['id']);
        }
    }
    
    public function getUserAnswers($userID, $projectID, $answerID, $spawnID = 0, $otherID = 0)
    {
        if ($answerID > 0)
        {
            $otherSQL = "";
            if ($otherID > 0)
                $otherSQL = "AND `other_sequenceID` = $otherID";

            $values = $this->answersMappingTable->fetchAll(" WHERE `projectID` = $projectID AND `userID`=$userID AND `answerID` = $answerID AND `spawn_sequenceID` = $spawnID $otherSQL ORDER BY `other_sequenceID`");
            return $values;
        }
        else
            return null;
    }
    
    public function saveUserAnswer($userID, $projectID, $answerID, $value, $spawn_sequenceID = 0, $other_sequenceID = 0)
    {
        $id = -1;
        if (!empty($value))
        {
            $value = $this->db->escape($value);
            try
            {
                $selectSQL = "SELECT id FROM {$this->answers_mapping_table_name} WHERE userID = $userID AND projectID = $projectID AND answerID = $answerID AND spawn_sequenceID = $spawn_sequenceID "
                        . "AND other_sequenceID = $other_sequenceID;";
                $resource = $this->db->query($selectSQL);
                $result = sqlsrv_fetch_array($resource, SQLSRV_FETCH_ASSOC);
                $id = $result['id'];
            }
            catch (Exception $e)
            {
                $id = 0;
            }
            
            if ($id > 0)
            {
                $sql = "UPDATE {$this->answers_mapping_table_name} SET value = '$value' WHERE id = $id";
                $this->db->query($sql);
            }
            else
            {
                $sql = "INSERT INTO `{$this->answers_mapping_table_name}` (`userID`, `projectID`,  `answerID`, `spawn_sequenceID`, `other_sequenceID`, `value`) VALUES ($userID, $projectID, $answerID, $spawn_sequenceID, $other_sequenceID, \"$value\")";

                $id = $this->answersMappingTable->insert_by_sql($sql);
            }
            
            return $id;
        }
    }
    
    public function clearAll($userID, $projectID, $answerID)
    {
        $ids = $this->answersMappingTable->fetchAll(" WHERE `projectID` = $projectID AND `userID` = $userID AND `answerID` = $answerID ");
        
        foreach ($ids as $id)
        {
            $this->answersMappingTable->clear_data();
            $this->answersMappingTable->data['id'] = $id['id'];
            $this->answersMappingTable->delete();
        }
        
    }
}
