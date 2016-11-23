<?php

	$priceWithVat = $row->price * 1.2;
	$priceWithoutVat = $row->price;
	
	$html .= "<td>";
					    
		if(!$user->auth()){ print "&pound;".number_format($priceWithVat, 2) ." (inc vat)"; $html .= "&pound;".number_format($priceWithVat, 2) ." (inc vat)";  }

		if($user->auth() && $user->auth()->member_type == 2){ print "<strike>&pound;".number_format($row->price, 2)."</strike> &pound;".number_format($priceWithoutVat * $cartObj->discount(), 2)." (exc vat)";  $html .= "<strike>&pound;".$row->price."</strike> &pound;".number_format($priceWithoutVat * $cartObj->discount(), 2)." (exc vat)"; }

		if($user->auth() && $user->auth()->member_type == 1){ 

			if( $cartObj->getTotalSpend() < 50 ){
			
				print "&pound;".number_format($priceWithVat, 2) ." (inc vat)";	$html .= "&pound;".number_format($priceWithVat, 2) ." (inc vat)"; 
			
			} else if( $cartObj->getTotalSpend() >= 50 && $cartObj->getTotalSpend() < 100 ){
			
				print "<strike>&pound;".number_format($priceWithVat, 2) ."</strike> &pound;".number_format($priceWithVat * $cartObj->discount(), 2) ."  (inc vat)";  $html .=  "<strike>&pound;".number_format($priceWithVat, 2) ."</strike> &pound;".number_format($priceWithVat * $cartObj->discount(), 2) ."  (inc vat)";
			
			} else if( $cartObj->getTotalSpend() >= 100 ){
			
				print "<strike>&pound;".number_format($priceWithVat, 2) ."</strike> &pound;".number_format($priceWithVat * $cartObj->discount(), 2) ."  (inc vat)";  $html .= "<strike>&pound;".number_format($priceWithVat, 2) ."</strike> &pound;".number_format($priceWithVat * $cartObj->discount(), 2) ."  (inc vat)";
			
			}

		}
		
	$html .= "</td>";