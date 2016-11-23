<?php

if(isset($action)){

	$newsObj->delete($id);

}

?>

<h1>NEWS</h1>

<a class="btn btn-primary" href="account.php?page=news-item&action=add">Add <i class="fa fa-plus"></i></a> <br /> <br />

<?php

if( count($newsObj->getAll()) ){

?>

<div class="table-responsive">

	<table class="table table-striped table-hover">

	<tr><td><strong>Title</strong></td><td><strong>Action</strong></td></tr>
	
	<?php
	
	foreach( $newsObj->getAll() as $row ){
	
	print '<tr><td>'.$row->title.'</td><td><a class="btn btn-primary" href="account.php?page=news-item&action=edit&id='.$row->id.'">Edit <i class="fa fa-edit"></i></a> <a class="btn btn-primary" href="account.php?page=news&action=delete&id='.$row->id.'">Delete <i class="fa fa-remove"></i></a></td></tr>';
	
	}
	
	?>

	</table>

</div>		

<?php

} else { print "<p>There are currently no ".$page." items. <br /><br /><br /><br /><br /><br /><br /><br /></p>"; }

?>