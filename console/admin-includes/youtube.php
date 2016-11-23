<?php

if($action == 'edit'){

	$row = $youtubeObj->find($id);

}

if( isset($_POST['title']) ){

	if($action == 'add'){
	
		$youtubeObj->add();
	
	} else {
	
		$youtubeObj->update($id);
	
	}

}

?>

<h1>YOUTUBE VIDEOS</h1>

	<form class="form-horizontal" method="post" action="">

						<div class="panel panel-default">
						<div class="panel-heading"><?= strtoupper($action) ?> VIDEO</div>
						<div class="panel-body">
						
								<div class="form-group">
									<label class="col-md-4 control-label">Title</label>
									<div class="col-md-6">
										<input type="text" class="form-control" name="title" value="<?php if(isset($row)){ print $row->title; } ?>">
									</div>
								</div>

								<div class="form-group">
									<label class="col-md-4 control-label">Description</label>
									<div class="col-md-6">
										<textarea style="height:100px" class="form-control" name="description"><?php if(isset($row)){ print $row->description; } ?></textarea>
									</div>
								</div>
								
								<div class="form-group">
									<label class="col-md-4 control-label">Youtube Code</label>
									<div class="col-md-6">
										<textarea style="height:100px" class="form-control" name="code"><?php if(isset($row)){ print $row->code; } ?></textarea>
									</div>
								</div>

								<div class="form-group">
									<div class="col-md-6 col-md-offset-4">
										<button type="submit" class="btn btn-primary"> <?= strtoupper($action) ?> VIDEO </button>
									</div>
								</div>
							
						</div>
					</div>
		
		
	</form>		

