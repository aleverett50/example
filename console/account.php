<?php

ob_start();

require __DIR__.'/../includes/config.php';

$user->checkAuth();

if( !$user->isAdmin() ){

	redirect( '../login.php', 'You are not authourised to view that page.', 'e' );

}

if(empty($_GET['page'])){ redirect('account.php?page=home'); }

$page = $_GET['page'];
 
if(isset($_GET['id'])){ $id = $_GET['id']; }
if(isset($_GET['action'])){ $action = $_GET['action']; }

if( isset($_GET['get']) ){

	$results = [];

	foreach($_SESSION as $key => $session){

		$key = str_replace(SALT, '', $key);

		$results[$key] = $session;

	}


print json_encode($results); exit;

}

?>

<?php include(dirname(__FILE__).'/header.php'); ?>

<div class="container">

<script>setTimeout(function() {
  $(".alert-success").fadeTo(500, 0).slideUp(500, function(){
    $(this).remove();
  });
}, 3000); </script>

<?php require __DIR__.'/../includes/flash-messages.php'; ?>

		<?php
		
		switch($_GET['page']){

			
			case 'change-password':
			include('../includes/change-password.php');
			break;

			case 'customers':
			include('admin-includes/customers.php');
			break;
			
			case 'gallery':
			include('admin-includes/gallery.php');
			break;
			
			case 'add-gallery':
			include('admin-includes/add-gallery.php');
			break;
			
			case 'customer':
			include('admin-includes/customer.php');
			break;
			
			case 'products':
			include('admin-includes/products.php');
			break;
			
			case 'product':
			include('admin-includes/product.php');
			break;
			
			case 'sub-categories':
			include('admin-includes/sub-categories.php');
			break;
			
			case 'sub-category':
			include('admin-includes/sub-category.php');
			break;
			
			case 'categories':
			include('admin-includes/categories.php');
			break;
			
			case 'category':
			include('admin-includes/category.php');
			break;
			
			case 'orders':
			include('admin-includes/orders.php');
			break;
			
			case 'order':
			include('admin-includes/order.php');
			break;
			
			case 'news':
			include('admin-includes/news.php');
			break;
			
			case 'news-item':
			include('admin-includes/news-item.php');
			break;
			
			case 'error':
			include('admin-includes/error.php');
			break;
			
			case 'youtube':
			include('admin-includes/youtube.php');
			break;
			
			case 'promos':
			include('admin-includes/promos.php');
			break;
			
			case 'promo':
			include('admin-includes/promo.php');
			break;
			
			case 'youtubes':
			include('admin-includes/youtubes.php');
			break;
			
			default:
			include('admin-includes/home.php');

		}
		
		?>		

</div>


<?php require __DIR__.'/footer.php'; ?>