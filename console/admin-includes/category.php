<?php

$categoryObj = new App\Category;

if($action == 'edit'){

	$row = $categoryObj->find($id);

}

if( isset($_POST['title']) ){

	if($action == 'add'){
	
		$categoryObj->add();
	
	} else {
	
		$categoryObj->update($id);
	
	}

}

?>

<h1>CATEGORY</h1>

	<form class="form-horizontal" method="post" action="">

						<div class="panel panel-default">
						<div class="panel-heading"><?= strtoupper($action) ?> CATEGORY</div>
						<div class="panel-body">
						
								<div class="form-group">
									<label class="col-md-4 control-label">Title</label>
									<div class="col-md-6">
										<input type="text" class="form-control" name="title" value="<?php if(isset($row)){ print $row->title; } ?>">
									</div>
								</div>								

								<div class="form-group">
									<div class="col-md-6 col-md-offset-4">
										<button type="submit" class="btn btn-primary"> <?= strtoupper($action) ?> CATEGORY </button>
									</div>
								</div>
							
						</div>
					</div>
		
		
	</form>		

