<?php

if( isset($_POST['title']) ){
	
		$galleryObj->add();

}

?>

<h1>GALLERY IMAGE</h1>

<p>Default size for images: 800px X 800px - ( Square )</p>

	<form enctype="multipart/form-data" class="form-horizontal" method="post" action="">

						<div class="panel panel-default">
						<div class="panel-heading">ADD GALLERY IMAGE</div>
						<div class="panel-body">
						
								<div class="form-group">
									<label class="col-md-4 control-label">Title</label>
									<div class="col-md-6">
										<input type="text" class="form-control" name="title">
									</div>
								</div>
								
								<?php for($i = 1; $i < 2; $i++){ ?>
								
								<div class="form-group">
									<label class="col-md-4 control-label">(JPG, PNG or GIF)</label>
									<div class="col-md-6">
										<input required type="file" class="form-control" name="file-<?= $i; ?>">										
									</div>
								</div>
								
								<?php } ?>

								<div class="form-group">
									<div class="col-md-6 col-md-offset-4">
										<button type="submit" class="btn btn-primary"> UPLOAD </button>
									</div>
								</div>
							
						</div>
					</div>
		
		
	</form>		

