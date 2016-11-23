<?php

$orderObj = new App\Order;

if($user->isAdmin()){

	if(isset($_GET['order-number']) && isset($_GET['status']) && $_GET['status'] == 'Completed'  ){

		$orderObj->emailStatus($_GET['order-number']);

	}

?>

<form id="status_form" action="" method="get"> <input type="hidden" name="page" value="orders"> <select class="form-control" id="status" name="status"> <option value="New" <?php if($_GET['status'] == 'New'){ print 'selected'; } ?>>New Orders</option> <option value="Completed" <?php if($_GET['status'] == 'Completed'){ print 'selected'; } ?>>Completed Orders</option> </select> </form>

<br />

<?php } ?>


<h1><?php if($user->isAdmin()){ print strtoupper($_GET['status']); } ?> ORDERS</h1>

<?php

if( count($orderObj->getAll($status = $_GET['status'])) ){

?>

<div class="table-responsive">

	<table class="table table-striped table-hover">

	<tr><td><strong>Date</strong></td><?php if($user->isAdmin()){ ?><td><strong>Customer</strong></td><?php } ?><?php if(!$user->isAdmin()){ ?><td><strong>Status</strong></td><?php } ?><td><strong>Order Number</strong></td><td><strong>Total</strong></td><td width="250"><strong>Action</strong></td></tr>
	
	<?php
	
	foreach( $orderObj->getAll( $status = $_GET['status'] ) as $row ){
	
	$status = $row->is_dispatched ? 'Dispatched' : $row->status;
	
		if( $user->isAdmin() ){
		
			print '<tr><td>'.date('d/m/Y H:i', strtotime($row->order_date)).'</td><td>'.ucwords($row->first_name).' '.ucwords($row->last_name).'</td><td>'.$row->order_number.'</td><td>£'.$row->cost.'</td><td><a class="btn btn-primary" href="account.php?page=order&id='.$row->order_id.'">View <i class="fa fa-arrow-right"></i></a>';

			if($_GET['status'] == 'Completed'){ print ' <a onclick=\'return confirm("Are you sure you want to email this order as dispatched?")\' class="btn btn-primary" href="account.php?page=orders&status=Completed&order-number='.$row->order_number.'">Dispatched <i class="fa fa-envelope"></i></a>';  }
			
			print '</td></tr>';
		
		} else {
		
			print '<tr><td>'.date('d/m/Y H:i', strtotime($row->order_date)).'</td><td>'.$status.'</td><td>'.$row->order_number.'</td><td>£'.$row->cost.'</td><td><a class="btn btn-base" href="account.php?page=order&id='.$row->order_id.'">View <i class="fa fa-arrow-right"></i></a></td></tr>';
		
		}
	
	}
	
	?>

	</table>

</div>		

<?php

} else {

print $user->isAdmin() ? "<p>There are currently no ".strtolower($_GET['status'])." ".$page.". <br /><br /><br /><br /><br /><br /><br /><br /></p>" : "<p>There are currently no orders.<br /><br /><br /><br /><br /><br /><br /><br /></p>";

}

?>

















