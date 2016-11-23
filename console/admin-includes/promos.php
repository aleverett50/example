<?php

if(isset($action)){

	$promoObj->delete($id);

}

?>

<h1>PROMO CODES</h1>

<a class="btn btn-primary" href="account.php?page=promo&action=add">Add <i class="fa fa-plus"></i></a> <br /> <br />

<?php

if( count($promoObj->getAll()) ){

?>

<div class="table-responsive">

	<table class="table table-striped table-hover">

	<tr><td><strong>Code</strong></td><td><strong>Percentage</strong></td><td><strong>Action</strong></td></tr>
	
	<?php
	
	foreach( $promoObj->getAll() as $row ){
	
	print '<tr><td>'.$row->code.'</td><td>'.$row->percentage.'</td><td><a class="btn btn-primary" href="account.php?page=promo&action=edit&id='.$row->id.'">Edit <i class="fa fa-edit"></i></a> <a class="btn btn-primary" href="account.php?page=promos&action=delete&id='.$row->id.'">Delete <i class="fa fa-remove"></i></a></td></tr>';
	
	}
	
	?>

	</table>

</div>		

<?php

} else { print "<p>There are currently no promo codes. <br /><br /><br /><br /><br /><br /><br /><br /></p>"; }