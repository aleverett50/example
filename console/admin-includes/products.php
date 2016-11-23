<?php

if(isset($action)){

	$productObj->delete($id);

}

?>

<h1>PRODUCTS</h1>

<a class="btn btn-primary" href="account.php?page=product&action=add">Add <i class="fa fa-plus"></i></a> <br /> <br />

<?php

if( count($productObj->getAll()) ){

?>

<div class="table-responsive">

	<table class="table table-striped table-hover">

	<tr><td><strong>Title</strong></td><td><strong>Category</strong></td><td><strong>Sub Category</strong></td><td><strong>Stock Amount</strong></td><td><strong>ID</strong></td><td><strong>OD</strong></td><td><strong>Thickness</strong></td><td width="190px"><strong>Action</strong></td></tr>
	
	<?php
	
	foreach( $productObj->getAll() as $row ){
	
	$stock = $row->stock_amount < 1 ? '<span class="red-background">'.$row->stock_amount.'</span>' : $row->stock_amount;
	
	print '<tr><td>'.$row->product_title.'</td><td>'.$row->category_title.'</td><td>'.$row->title.'</td><td>'.$stock.'</td><td>'.$row->inner_diameter.'</td><td>'.$row->outer_diameter.'</td><td>'.$row->thickness.'</td><td><a class="btn btn-primary" href="account.php?page=product&action=edit&id='.$row->product_id.'">Edit <i class="fa fa-edit"></i></a> <a class="btn btn-primary" href="account.php?page=products&action=delete&id='.$row->product_id.'">Delete <i class="fa fa-remove"></i></a></td></tr>';
	
	}
	
	?>

	</table>

</div>		

<?php

} else { print "<p>There are currently no ".$page.". <br /><br /><br /><br /><br /><br /><br /><br /></p>"; }

?>