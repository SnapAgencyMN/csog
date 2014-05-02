<?php

class Db{
	
	private static $connection;
	public static $last_query;
	private $magic_quotes_active;
	private static $real_escape_string_exists;
	private $dbInfo;
	
	function __construct($dbInfo){
		$this->dbInfo=$dbInfo;
		$this->open_connection($dbInfo);
		$this->magic_quotes_active = get_magic_quotes_gpc();
		self::$real_escape_string_exists = function_exists("mysqli_real_escape_string");
		@mysqli_query("SET NAMES 'utf8'");
	}
	
	public function open_connection($dbInfo){
		self::$connection = mysqli_connect($dbInfo['host'],$dbInfo['user'],$dbInfo['pass']);
		if (!self::$connection) {
			die("Database connection failed: " . mysqli_error());
		}else{
			$db_select = mysqli_select_db(self::$connection, $dbInfo['name']);
			if (!$db_select) {
				die("Database selection failed: " . mysqli_error());
			}
		}
	}
	
	public function close_connection(){
		if(isset(self::$conneciton)){
			mysqli_close(self::$conneciton);
			unset(self::$conneciton);
		}	
	}

	public static function query($sql,$returnObject=false){
		
		self::$last_query=$lastQuery=$sql;
		$results= mysqli_query(self::$connection, $sql);
		self::confirm_query($results);
				
		if($returnObject==true){			
			$resultArray=array();			
			while ($result=mysqli_fetch_array($results)) {
				$resultArray[]=$result;	
			}				
			if(count($resultArray)==1){
				if(isset($resultArray[0][0])){
					return $resultArray[0][0];
				} 
			}else{
				foreach ($resultArray as $key => $result) {
					foreach($result as $valueKey => $value){
						if(is_numeric($valueKey)){
							unset($resultArray[$key][$valueKey]);
						}
					}
				}
			}			
			return $resultArray;			
		}				
		return $results;			
	}
	
	private static function confirm_query($result){
		if(!$result){			
			$output= "WOOOHOO, we don't know where did you get this address from but it certainly does not exist in this website.";
			$output= "Database query failed:".mysqli_error(self::$connection) . "<br/><br/>";
			$output.= "Last SQL query: ". self::$last_query;
                        print_r($output);
			Session::message($output,'error');
		}
	}

	public static function escape_value($value){		
		if(self::$real_escape_string_exists){ 
			return mysqli_real_escape_string(self::$connection, $value); 
		}	    
		return addslashes($value);	
	}
	
	public static function fetch_array($result_set){
		if($result_set){
			return mysqli_fetch_array($result_set);
		}	
	}
	
	public function fetchAll($result_set){
		$results=array();
		while ($row = mysqli_fetch_row($result_set)) {
		    $results[]=current($row);
		}		
		return $results;
	}
	
	public static function fetch($result_set){
		return mysqli_fetch_array($result_set);
	}
	
	public function get_all_tables(){	
		$tables=self::query('SHOW TABLES FROM '.$this->dbInfo['name']);
		$tables=$this->fetchAll($tables);
		return $tables;
	}
	
	public static function table_exists($table_name){
		$result=self::query("SHOW TABLES LIKE '$table_name'");
		return self::fetch($result);
	}
	
	public function num_rows($result_set){
		return mysqli_num_rows($result_set);
	}
	
	public static function insert_id(){
		return mysqli_insert_id(self::$connection);
	}
	
	public static function affected_rows(){
		return mysqli_affected_rows(self::$connection);
	}
	
	public function mysql_current_db() {
	    $r = mysqli_query("SELECT DATABASE()") or die(mysqli_error());
	    return mysqli_result($r,0);
	}

}
