<?php 


class Session {

	public static function init(){
		session_start();
	}

	public static function set($variable,$val){
		// Set session variables
		$_SESSION[$variable] = $val;
	}


	public static function get($key){
		// Get session variables
		if (isset($_SESSION[$key])) {
			return $_SESSION[$key];
		}else{
			return false;
		}
	}

// Check session data 
	public static function CheckSession(){
		
		self::init();
		if(self::get('login') == false){
			self::destroy();
			header('Location:login.php');
		}

	}

	// Check Login data 
	public static function CheckLogin(){
		
		self::init();
		if(self::get('login') == true){
			header('Location:index.php');
		}

	}

	// Check session data 
	public static function destroy(){
		self::init();
		session_destroy();
		header('Location:login.php');

	}


}


 ?>