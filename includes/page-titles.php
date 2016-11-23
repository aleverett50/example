<?php

$currentPage = basename($_SERVER['SCRIPT_NAME']);

switch($currentPage){

	case 'basket.php';
	$title = COMPANY_NAME.' - Shopping Basket';
	break;
	
	case 'sign-up.php';
	$title = COMPANY_NAME.' - Sign Up';
	break;
	
	case 'change-password.php';
	$title = COMPANY_NAME.' - Change Your Password';
	break;
	
	case 'forgot-password.php';
	$title = COMPANY_NAME.' - Forgotten Your Password';
	break;
	
	case 'terms.php';
	$title = COMPANY_NAME.' - Terms and Conditions';
	break;
	
	case 'privacy.php';
	$title = COMPANY_NAME.' - Privacy Policy';
	break;
	
	case 'checkout.php';
	$title = COMPANY_NAME.' - Checkout';
	break;
	
	case 'login.php';
	$title = COMPANY_NAME.' - Login';
	break;
	
	case 'contact.php';
	$title = COMPANY_NAME.' - Contact Us';
	break;
	
	case 'product-details.php';
	$title = COMPANY_NAME.' - '.ucwords($_GET['p']);
	break;

	case 'news.php';
	$title = 'Full Ceramic Bearings Bicycle, Bottom Bracket & Bike Bearing News';
	$page_metadata = array();
	$page_metadata['description'] = 'We provide news and details about bicycles and bike bearing including details on our full ceramic and bottom bracket bearings. Visit our website today!';
	$page_metadata['keywords'] = 'Full Ceramic Bearings Bicycle, Bike Bearings, Headset Bike Bearings, Headset Bearings, Mountain Bike Bearings';
	break;
	
	default:
	$title = 'Ball Bearings, Bottom Bracket & Bike Bearing Supplier UK';

}
