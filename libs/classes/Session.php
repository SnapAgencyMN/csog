<?php

class Session{
	
	public $logged_in=false;
	public $user_id;
	public $messages=array();
	public $devnotes;
	
	function __construct(){
		session_start();
		session_regenerate_id(true); 
		if(!strstr($_SERVER['REQUEST_URI'],'.jpg')){
			$_SESSION['history'][]=$_SERVER['REQUEST_URI'];
		}
		$this->check_messages();
		$this->check_devNotes();
		$this->check_login();
		if(strstr($_SERVER['REQUEST_URI'], 'admin/logout')){		
			$this->logout();
		  redirect_to("/");
		}
	}
	
	public function is_logged_in(){
		return $this->logged_in;
	}
	
	public function login(&$user){
		if($user){		
			$this->user_id=$_SESSION['user_id']= $user['uid'];
			$this->logged_in=true;		
		}
	}
	
	public function logout(){
		unset($_SESSION['user_id']);
		unset($this->user_id);
		$this->logged_in=false;
	}
	
	private function check_login(){
		global $www;
		if(isset($_SESSION['user_id'])){
			$this->user_id=$_SESSION['user_id'];
			$this->logged_in=$www->logged_in=true;
		}else{
			unset($this->user_id);
			$this->logged_in=$www->logged_in=false;			
		}
		return $this->logged_in;
	}
	
	public static function message($msg="",$type='success'){
		if(!empty($msg)){
			$_SESSION['messages'][]=array('text'=>$msg,'status'=>$type);
		}else{
			return $this->message;
		}	
	}
	
	private function check_messages(){
		if(isset($_SESSION['messages'])){
			$this->messages=$_SESSION['messages'];
			unset($_SESSION['messages']);
		}else{
			$this->messages=array();
		}
	}
	
	public function devnotes($note=""){
		if(!empty($note)){
			$_SESSION['devnotes']=$note;
		}else{
			return $this->devnotes;
		}		
	}
	
	private function check_devNotes(){
		if(isset($_SESSION['devnotes'])){
			$this->devnotes=$_SESSION['devnotes'];
			unset($_SESSION['devnotes']);
		}else{
			$this->devnotes="";
		}
	}
}
