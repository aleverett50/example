<!DOCTYPE html>
<html>  
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="index, follow">
    <title><?= $title ?></title>
    <?php if (isset($page_metadata['description'])): ?>
    <meta name="description" content="<?= $page_metadata['description']; ?>" />
	<?php endif; ?>
	<?php if (isset($page_metadata['keywords'])): ?>
    <meta name="keywords" content="<?= $page_metadata['keywords']; ?>" />
	<?php endif; ?>
	<link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css" type="text/css">
	<link rel="stylesheet" href="font-awesome/css/font-awesome.min.css" type="text/css"> 
	<link rel="stylesheet" href="assets/fancybox/jquery.fancybox.css?v=2.1.5" media="screen"> 
	<link type="text/css" href="css/global-style.css" rel="stylesheet" media="screen">
	<link type="text/css" href="css/styles.css" rel="stylesheet" media="screen">
	<link href="images/favicon.ico" rel="icon">
	<link rel="stylesheet" href="assets/owl-carousel/owl.carousel.css">
	<link rel="stylesheet" href="assets/owl-carousel/owl.theme.css">
	<link rel="stylesheet" href="assets/sky-forms/css/sky-forms.css">    
	<script src="js/jquery-ui.min.js"></script>
	<script src="js/jquery.js"></script>
	<link rel="stylesheet" href="assets/layerslider/css/layerslider.css" type="text/css">

<script>

$(function(){

	$('.fa-search').click(function(){

		$('#search_form').submit();
	
	});
	
	$('#cart_form_button').click(function(){

		$('#cart_form').submit();
	
	});

	$('#shipping').change(function(){

		$('#shipping_form').submit();
	
	});

});

</script>
</head>
<body>
<?php include('includes/cookies.php'); ?>
<!-- MAIN WRAPPER -->
<div class="body-wrap">

	<div class="container-fluid bg-top-grey">
	
		<div class="container padding-5">
		
			<?php if($detect->isMobile()){  ?>
		
			<div class="row text-center">
		
			<i class="fa fa-phone"></i>  <br />
			<i class="fa fa-envelope"></i> <br />
			<i class="fa fa-user"></i> <?php if($user->auth()){ print "<a id='show-account-links' href='#'>My Account</a>"; } else { print "<a href='login.php'>Login</a>"; } ?>
			<i style="margin-left:50px" class="fa fa-shopping-basket"></i> <a href="basket.php">Basket</a>
			
			<ul id="account-links">
			<li><a href="account.php?page=details">My Details</a></li>
			<li><a href="account.php?page=orders">My Orders</a></li>
			<li><a href="account.php?page=change-password">Change Password</a></li>
			<li><a href="login.php?log=out">Logout</a></li>
			</ul>
			
 			</div>
			
			
			
			<?php } else { ?>
			
			<div class="row">
		

			<div class="green-circle"><i class="fa fa-phone fatop"></i></div> 
			<div class="float-left">  </div>  
			<div class="green-circle"><i style="font-size:0.8em;position:absolute;top:4px;left:5px" class="fa fa-envelope fatop"></i> </div> 
			<div class="float-left">  </div>
			
			<?php if( $detect->isTablet() ){ ?>
			
			<div class="show-on-portrait-tablet"><div class="green-circle"><i style="font-size:0.8em;position:absolute;top:5px;left:4px" class="fa fa-shopping-basket fatop"></i></div> 
			<div class="float-left"> <a href="basket.php">View Basket >></a></div> </div>
			
			<?php } ?>
			
					<?php if( $user->auth() ){ ?>
					
							<div class="dropdown pull-right">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-user"></i> Welcome <?php print ucwords($user->auth()->first_name); ?> <span class="caret"></span></a>
								<ul class="dropdown-menu" style="z-index:999999">
									<li><a href="account.php?page=home">My Account</a></li>
									<li><a href="account.php?page=details">My Details</a></li>
									<li><a href="account.php?page=orders">My Orders</a></li>
									<li><a href="account.php?page=change-password">Change Password</a></li>
									<li><a href="login.php?log=out">Logout</a></li>
								</ul>
							</div>
							
					<?php } else { ?>
			
						<div class="pull-right"><i class="fa fa-user"></i> <a href="login.php">Login</a> </div>
			 
						<?php } ?>
			
			</div>
			
			<?php }  ?>
		
		</div>
	
	</div>

            <!-- HEADER -->
        <div id="divHeaderWrapper">
	
            <header class="header-standard-2">     
    <!-- MAIN NAV -->
<div class="navbar navbar-wp navbar-arrow mega-nav" role="navigation">
	<div class="container">
	
		<div class="navbar-header">
		
		<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
		<i class="fa fa-bars icon-custom"></i>
		</button>
		<a class="navbar-brand" href="index.php"> <img src="images/logo.jpg"> </a>
		
		</div>
		
			<div class="contact-header">
			
			<a href="basket.php"><i class="fa fa-shopping-basket colour-green"></i> 
			
			<?php if(basename($_SERVER['SCRIPT_NAME']) == 'complete.php' && !isset($_GET['status'])){
			
			$user->destroyUniqueId();
			
			?>
			
			£0.00 (0) </a> <br />
			
			<?php } else {  ?>
			
			£<?php if(isset($user->auth()->member_type) && $user->auth()->member_type == 2){ print number_format( ( $cartObj->subTotal() * $cartObj->discount() ), 2); } else { print number_format( ( $cartObj->subTotal() * $cartObj->discount() * 1.2 ), 2); }  ?> (<?= $cartObj->countItems() ?>) </a> <br />
			
			<?php } ?>
			
				<div class="search-bar-holder">
				
					<div style="width:150px;float:left"><form id="search_form" action="product-list.php" method="get"><input name="search" placeholder="Search..." type="text"></div>
					<div style="width:50px;float:left;text-align:center;margin-top:3px"><i class="fa fa-search"></i></form></div>
				
				</div>
			
			</div>
		
	</div>
	
	
	
</div>
    
    <div class="container-fluid bg-grey"  style='border-bottom:1px solid #E0EDED'>
    
    <div class="container">
    
            <div class="navbar-collapse collapse">
	    
                <ul class="nav navbar-nav main-colour">
 	 
		<li class="dropdown">
		<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"></a>
		<ul class="dropdown-menu">
		<?php
		
		foreach($subCategoryObj->getAll() as $subCategory){
		
			print "<li><a href='product-list.php?subCatId=".$subCategory->sub_category_id."&cat=".strtolower($subCategory->title)."&subCat=".urlencode(strtolower($subCategory->sub_category_title))."'>".$subCategory->sub_category_title."</a></li>\n";
		
		}
		
		?>
		</ul>
		</li>
		<li><a href="search.php">SEARCH</a></li>
		<li><a href="explanations.php">EXPLANATIONS</a></li>
		<li><a href="news.php">NEWS</a></li>
		<li><a href="how-to-videos.php">HOW TO VIDEOS</a></li>
		<?php if( !$user->auth() ){ ?>
		<li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">MEMBERS SIGN UP</a>
		
		<ul class="dropdown-menu">
			<li><a href="sign-up.php?memberType=1">Individual</a></li>
			<li><a href="sign-up.php?memberType=2">Shop - Business Member</a></li>
		</ul>
		
		</li>
		<?php } ?>
		<li><a href="contact.php">CONTACT US</a></li>

                </ul>
               
            </div>
    
    </div>
    
    </div>
    
</header>        </div>