<?php
/**
 * 
 * This class allows for manipulation with system projects 
 * @author mpak
 */
class Projects {
    
    /**
     * @param   DbObject   $db
     */
    public function __construct($db) {
        $this->db = $db;
        $this->table_name = "projects";
        $this->projectsTable = new DbObject($this->db, $this->table_name,false);
    }
    
    public function search($zip, $name, $parcelID)
    {
        $name = str_replace("'", "''", $name);
        
        $condition = "";
        if (!empty($zip))
        {
            $condition .= "zip = '$zip' ";
        }
        
        if (!empty($name))
        {
            $condition .= "AND name = '$name' ";
        }
        
        if (!empty($parcelID))
        {
            $condition .= "AND parcelIDNumber = '$parcelID' ";
        }
        
        $condition = ltrim($condition, "AND");
        $condition = "WHERE $condition";
        
        $results = $this->projectsTable->fetchAll($condition);
        
        //print_r($results);
        return $results;
    }
}
