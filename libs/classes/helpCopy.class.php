<?php
/**
 * 
 * @author mpak
 */
class HelpCopy {
    
    private $orderStr = "ORDER BY [order]";
    //private $orderStr = "ORDER BY `order`";
    
    /**
     * @param   DbObject   $db
     */
    public function __construct($db) {
        $this->db = $db;
        $this->table_name = "help_copy_text";
        $this->copyTextTable = new DbObject($this->db, $this->table_name,false);
    }
    
   
    public function listAll()
    {
        //$entries = $this->copyTextTable->fetchAll("ORDER BY `order`");
        $entries = $this->copyTextTable->fetchAll("ORDER BY [order]");
        
        return $entries;
    }
    
    
    public function getDetails($copyID)
    {
        if ($copyID > 0)
            $details = $this->copyTextTable->find_by_id($copyID);
        
        return $details;
    }
    
    public function saveCopy($title, $body, $order, $copyID = 0)
    {
        $this->copyTextTable->clear_data();
        $this->copyTextTable->data['title'] = str_replace("'", "''", $title);
        $this->copyTextTable->data['body'] = $body;
        //$this->copyTextTable->data['`order`'] = $order;
        $this->copyTextTable->data['[order]'] = $order;

        if ($copyID > 0)
        {
            $this->copyTextTable->data['id'] = $copyID;
            $id = $this->copyTextTable->update();
        }
        else
            $id = $this->copyTextTable->create();
        
        return $id;
    }
    
    public function deleteCopy($copyID)
    {
        if ($copyID > 0)
        {
            $this->copyTextTable->clear_data();
            $this->copyTextTable->data['id'] = $copyID;
            $this->copyTextTable->delete();
        }
    }
}
