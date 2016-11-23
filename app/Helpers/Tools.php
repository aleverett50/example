<?php

namespace App\Helpers;

class Tools
{

    public static function flashes()
    {

	$flashes = array();
	
	if(isset($_SESSION[SALT.'flash']) && !empty($_SESSION[SALT.'flash'])){
	
		foreach( $_SESSION[SALT.'flash'] as $flash ){ 

			$flashes[] = $flash;					
		
		}				
	
	}

	return $flashes;

    }


    public static function flash($message)
    {
	$_SESSION[SALT.'flash'][] = $message;
    }


    public static function error($message)
    {
	$_SESSION[SALT.'errors'][] = $message;
    }


    public static function passwordHash($password)
    {

	if( $password == null ){
	
		return null;
	
	}
	
	return hash("sha256", $password . SALT);

    }


    public static function createHash($length)
    {

	$bytes = openssl_random_pseudo_bytes($length * 2);

	return substr(str_replace(array('/', '+', '='), '', base64_encode($bytes)), 0, $length);

    }


    public static function boot()
    {

	if( isset($_POST) ){

		foreach( $_POST as $key => $value ){
		
			$_SESSION[SALT.$key] = $value;
		
		}	

	}

    }


    public static function deleteSessions()
    {

	foreach($_SESSION as $key => $session){
	
		if( $key != SALT.'session' && $key != SALT.'order-for-email' && $key != SALT.'shipping'  ){
	
			unset($_SESSION[$key]);
		
		}
	
	}

    }


    public static function formatPostcode($postcode)
    {

	/*  Remove any spaces from postcode  */

	$postcode = preg_replace("/[^A-Za-z0-9]/", '', $postcode);
	
	/*  Make it capitals  */
	
	$postcode = strtoupper($postcode);
	
	/*  See how many characters are in postcode  */
	
	$postcodelength = strlen($postcode);
	
	/*  Put a space before last 3 digits  */
	
	$postcode = substr_replace($postcode, " ", ($postcodelength - 3), 0);
	
	return $postcode; 

    }


    public static function formatDate($date)
    {

		if(!$date){ return ''; }

		/*  Format all dates from dd/mm/yyy to yyyy-mm-dd for mysql  */
	
		$day = substr($date, 0, 2);
		$month = substr($date, 3, 2);
		$year = substr($date, 6, 4);
		
		return $year."-".$month."-".$day;

    }


    public static function formatFields($values, $dates)
    {

	foreach($values as $key => $value){
		
		/*  Format all fields with postcode in the field name  */
		
		if( strstr($key, 'postcode') ){
		
			$values[$key] = self::formatPostcode($values[$key]);
		
		}
	
		
	}
	
	foreach($dates as $dateField){
	
		if(isset($values[$dateField]) && $values[$dateField] != null){
		
			$values[$dateField] = self::formatDate($values[$dateField]);
		
		}
		
	}
	
		/*  Hash the password  */

	if( isset($values['password']) ){
	
		$values['password'] = self::passwordHash($values['password']);
		
	}
	
	if( isset($values['email']) ){
	
		/*  strtolower the email to look neat in DB  */
	
		$values['email'] = strtolower($values['email']);
		
	}

	
	return $values;

    }


}
