<?php

if(isset($_GET['action']) && $_GET['action'] == 'delete'){

	$user->delete($id);

}

?>

<h1>CUSTOMERS</h1>

<div class="table-responsive">

	<table class="table table-striped table-hover">
	
	<?php
	
	$i = 0;
	
	$memberArray = [];
	
	foreach( $user->getAll() as $row ){
	
	if($row->member_type == 0){ $memberType = 'Guest'; } else 
	if($row->member_type == 1){ $memberType = 'Member'; } else 
	if($row->member_type == 2){ $memberType = 'Business Member'; }
	
	if(!in_array($memberType, $memberArray)){

	$memberArray[] = $memberType;
	
	print '<tr style="background:#D6D6D6"><td><strong>'.$memberType.'</strong></td><td></td><td></td><td></td></tr>';
	
	}
	
	print '<tr><td>'.date('d/m/Y H:i:s', strtotime($row->created_at)).'</td><td>'.$memberType.'</td><td>'.$row->first_name.' '.$row->last_name.'</td><td><a class="btn btn-primary" href="account.php?page=customer&action=edit&id='.$row->id.'">View <i class="fa fa-arrow-circle-right"></i></a> <a onclick="return confirm(\'Are you sure you want to delete this customer?\')" class="btn btn-danger" href="account.php?page=customers&action=delete&id='.$row->id.'">Delete <i class="fa fa-remove"></i></a></td></tr>';
	
	
	$i++;
	
	}

	
	?>

	</table>

</div>