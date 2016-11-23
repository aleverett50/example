<?php

session_start();

require __DIR__. '/../vendor/autoload.php';

define('HOST', '**********');
define('USERNAME', '**********');
define('PASSWORD', '**********');
define('DATABASE', '**********');
define('DOMAIN', '**********');
define('SMTP_HOST', '**********');
define('COMPANY_NAME', '**********');
define('SMTP_USERNAME', '**********');
define('SMTP_EMAIL', '**********');
define('SMTP_PASSWORD', '**********');
define('SALT', '**********');
date_default_timezone_set('Europe/London');
define('DT', date('Y-m-d H:i:s'));


$user = new App\User;
$cartObj = new App\Cart;
$subCategoryObj = new App\SubCategory;


if( !$user->uniqueId() ){

	$user->setUniqueId();

}


function redirect($url, $message = null, $type = null){

	if($message){

		$message = $type == 'e' ? App\Helpers\Tools::error($message) : App\Helpers\Tools::flash($message);

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

