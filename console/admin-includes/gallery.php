<?php

if(isset($action)){

	$galleryObj->delete($id);

}

?>

<h1>GALLERY</h1>

<a class="btn btn-primary" href="account.php?page=add-gallery">Add <i class="fa fa-plus"></i></a> <br /> <br />

<?php

if( count($galleryObj->getAll()) ){

?>

<div class="table-responsive">

	<table class="table table-striped table-hover">

	<tr><td><strong>Title</strong></td><td><strong>Image</strong></td><td><strong>Action</strong></td></tr>
	
	<?php
	
	foreach( $galleryObj->getAll() as $row ){
	
		print '<tr><td>'.$row->title.'</td><td><img style="width:100px" src="../gallery/'.$row->id.'.'.$row->extension.'"></td><td> <a class="btn btn-primary" href="account.php?page=gallery&action=delete&id='.$row->id.'">Delete <i class="fa fa-remove"></i></a></td></tr>';
	
	}
	
	?>

	</table>

</div>		

<?php

} else { print "<p>There are currently no ".$page." images. <br /><br /><br /><br /><br /><br /><br /><br /></p>"; }

?>