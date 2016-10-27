<?php

session_start();
ob_start();

spl_autoload_register(function ($class) { require (dirname(__FILE__)."../../classes/".$class.".php"); });
function dd($array){ $dd = ''; if($array == ''){ print ''; exit; } foreach($array as $key => $value){ $dd .= $key.' => '.$value.'<br />'; } print $dd; exit;  }

if($_SERVER['HTTP_HOST'] == "localhost"){

	define('HOST', '**********');
	define('USERNAME', '**********');
	define('PASSWORD', '**********');
	define('DATABASE', '**********');
	define('DOMAIN', '**********');

} else{

	define('HOST', '**********');
	define('USERNAME', '**********');
	define('PASSWORD', '**********');
	define('DATABASE', '**********');
	define('DOMAIN', '**********');

}

define('SMTP_HOST', '**********');
define('COMPANY_NAME', '**********');
define('SMTP_USERNAME', '**********');
define('SMTP_EMAIL', '**********');
define('SMTP_PASSWORD', '**********');
define('COMPANY_EMAIL', '**********');
define('MAIN_COLOUR', '**********');
define('PHONE', '**********');


define('SALT', '**********');
date_default_timezone_set('Europe/London');
define('DT', date('Y-m-d H:i:s'));
Tools::boot();
$detect = new MobileDetect();
$user = new User();
$dice = new Dice();

$categoryObj = $dice->create('Category');	/*  $categoryObj is the object  */
$subCategoryObj = $dice->create('SubCategory');
$productObj = $dice->create('Product');
$cartObj = $dice->create('Cart');
$orderObj = $dice->create('Order');
$newsObj = $dice->create('News');
$galleryObj = $dice->create('Gallery');
$productsFromOrderObj = $dice->create('ProductsFromOrder');
$youtubeObj = $dice->create('Youtube');

$html = '';	//  DON'T DELETE - FOR SHOPPING CART EMAIL

if( !$user->uniqueId() ){

	setcookie(SALT.'unique', $_SERVER['REMOTE_ADDR'].'-'.time(), time()+604800);
	$_SESSION[SALT.'unique'] = $_SERVER['REMOTE_ADDR'].'-'.time();

}


if($user->auth() && $user->uniqueId()){

	$cartObj->updateCartWithMemberType($user->auth()->member_type);

}

if(!$user->auth() && $user->uniqueId()){

	$cartObj->updateCartWithNoMemberType();

}

function redirect($url, $message = null, $type = null){

	if($message){

		$message = $type == 'e' ? Tools::error($message) : Tools::flash($message);

	}

header('Location: '.$url); exit;

}

function addOrdinalNumberSuffix($num) {
  if (!in_array(($num % 100),array(11,12,13))){
    switch ($num % 10) {
      case 1:  return $num.'st';
      case 2:  return $num.'nd';
      case 3:  return $num.'rd';
    }
  }
  return $num.'th';
}





