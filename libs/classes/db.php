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
		//mysqli_query("SET NAMES 'utf8'");
                ini_set('mssql.charset', 'UTF-8');
	}
	
	public function open_connection($dbInfo){
            /*
		self::$connection = mysqli_connect($dbInfo['host'],$dbInfo['user'],$dbInfo['pass']);
		if (!self::$connection) {
			die("Database connection failed: " . sqlsrv_errors());
		}else{
			$db_select = mysqli_select_db(self::$connection, $dbInfo['name']);
			if (!$db_select) {
				die("Database selection failed: " . sqlsrv_errors());
			}
		}
             */
            $connectionInfo = array( "Database"=>$dbInfo['name'], "UID"=>$dbInfo['user'], "PWD"=>$dbInfo['pass']);
            self::$connection = sqlsrv_connect( $dbInfo['host'], $connectionInfo);
            if (!self::$connection) {
                die("Database connection failed: " . sqlsrv_errors());
            }
	}
	
	public function close_connection(){
		if(isset(self::$conneciton)){
			sqlsrv_close(self::$conneciton);
			unset(self::$conneciton);
		}	
	}

	public static function query($sql,$returnObject=false){
		//MSSQL specific hacks
                //$sql = str_replace("`", "", $sql);
                //$sql = str_replace("label", "[label]", $sql);
                //$sql = str_replace('"',"'", $sql);

		self::$last_query=$lastQuery=$sql;
		$results= sqlsrv_query(self::$connection, $sql);
		self::confirm_query($results);
                
		if($returnObject==true){			
			$resultArray=array();			
			while ($result=sqlsrv_fetch_array($results, SQLSRV_FETCH_ASSOC)) {
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
			$output= "Database query failed: <pre>".print_r(sqlsrv_errors()) . "</pre><br/><br/>";
			$output.= "Last SQL query: ". self::$last_query;
                        print_r($output);
			Session::message($output,'error');
		}
	}

        public function escape($value){		
		if(self::$real_escape_string_exists){ 
			return mysqli_real_escape_string(self::$connection, $value); 
		}	
                //return addslashes($value);	
		return str_replace("'", "''", $value);	
	}
        
	public static function escape_value($value){		
		if(self::$real_escape_string_exists){ 
			return mysqli_real_escape_string(self::$connection, $value); 
		}	    
		//return addslashes($value);	
		return str_replace("'", "''", $value);	
	}
	
	public static function fetch_array($result_set){
		if($result_set){
			return sqlsrv_fetch_array($result_set, SQLSRV_FETCH_ASSOC);
		}	
	}
	
	public function fetchAll($result_set){
		$results=array();
		while ($row = sqlsrv_fetch($result_set)) {
		    $results[]=current($row);
		}		
		return $results;
	}
	
	public static function fetch($result_set){
		return sqlsrv_fetch_array($result_set);
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
		return sqlsrv_num_rows($result_set);
	}
	
	public static function insert_id(){
            $sql = "SELECT SCOPE_IDENTITY() as id;";
            $result = self::query($sql);
            $resultArr = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC);
            return $resultArr['id'];
	}
	
	public static function affected_rows($statement){
		return sqlsrv_rows_affected($statement);
	}
	
	public function mysql_current_db() {
	    $r = mysqli_query("SELECT DATABASE()") or die(sqlsrv_errors());
	    return mysqli_result($r,0);
	}

}
