<?php

include('includes/config.php');

if(isset($_POST['cart'])){

	$cartObj->updateCart();

}

if(isset($_GET['delete'])){

	$cartObj->delete($_GET['delete']);

}

if(isset($_POST['shipping'])){

	$cartObj->setShipping();

}

include('header.php');

?>

            <div class="container">
	    
		<?php include(dirname(__FILE__).'/includes/flash-messages.php'); ?>

                   <div class="box">

			<form id="cart_form" action="" method="post" class="form-light">
			<input type="hidden" name="cart">
                          
			<h1>Basket</h1>
			  
			<?php if(count($cartObj->getAll())){
			
				include('includes/basket-include.php');
				
				/* THIS IS THE SESSION THAT HOLDS THE ORDER ITEMS FOR THE CONFIRMATION EMAIL */
				
				$cartObj->setOrderEmailHtml($html);
				
				if(isset($_GET['go']) && $_GET['go'] == 'to-checkout' ){ redirect('checkout.php'); }
				
			?>
			
			
                            <div class="box-footer">
                                <div class="pull-left hide-on-portrait-mobile">
                                    <a href="index.php" class="btn btn-default"><i class="fa fa-chevron-left"></i> Continue shopping</a>
                                </div>
                                <div class="pull-right">
                                     <button id="cart_form_button" type="button" class="btn btn-default"><i class="fa fa-refresh"></i> Update <span class="hide-on-portrait-mobile">basket</span></button> 
                                    <a class="btn btn-base" href="<?php if( $user->auth() ){ print "checkout.php"; } else { print "before-checkout.php"; } ?>"><?php if($detect->isMobile()){ print "Checkout"; } else { print "Proceed to checkout"; } ?> <i class="fa fa-chevron-right"></i> </a>
                                </div>
                            </div>
			    
			<?php } else { print "<p class='mb-200'>There are no items in your basket.</p> "; } ?>
		
                    </div>
                    <!-- /.box -->
	
            </div>
    

<?php include('footer.php'); ?>