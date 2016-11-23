<?php

if($action == 'edit'){

	$row = $newsObj->find($id);

}

if( isset($_POST['title']) ){

	if($action == 'add'){
	
		$newsObj->add();
	
	} else {
	
		$newsObj->update($id);
	
	}

}

?>

<h1>NEWS</h1>

	<form enctype="multipart/form-data" class="form-horizontal" method="post" action="">

						<div class="panel panel-default">
						<div class="panel-heading"><?= strtoupper($action) ?> NEWS</div>
						<div class="panel-body">
						
								<div class="form-group">
									<label class="col-md-4 control-label">Title</label>
									<div class="col-md-6">
										<input type="text" class="form-control" name="title" value="<?php if(isset($row)){ print $row->title; } ?>">
									</div>
								</div>

								<div class="form-group">
									<label class="col-md-4 control-label">Link</label>
									<div class="col-md-6">
										<input type="text" class="form-control" name="link" value="<?php if(isset($row)){ print $row->link; } ?>"> <br />
										eg. http://www.cyclingweekly.co.uk/news/racing/peter-sagan-wins-tour-of-flanders-219413?trend=Tour-of-flanders%22
									</div>
								</div>
								
								<div class="form-group">
									<label class="col-md-4 control-label">Description</label>
									<div class="col-md-6">
										<textarea class="form-control" name="description"><?php if(isset($row)){ print $row->description; } ?></textarea>
									</div>
								</div>
								
								<?php for($i = 1; $i < 2; $i++){ ?>
								
								<div class="form-group">
									<label class="col-md-4 control-label">Image (JPG, PNG or GIF)</label>
									<div class="col-md-6">
										<input type="file" class="form-control" name="file-<?= $i; ?>">
										
										<?php
										
										if(isset($id) && file_exists('../news-images/'.$id.'-'.$i.'.png')){
										
											print "<br /><img class='img-responsive-admin' src='../news-images/".$id."-".$i.".png'>"; 
										
										} else 
										
										if(isset($id) && file_exists('../news-images/'.$id.'-'.$i.'.jpg')){
																																																								print "<br /><img class='img-responsive-admin' src='../news-images/".$id."-".$i.".jpg'>"; 
										
										} else 
										
										if(isset($id) && file_exists('../news-images/'.$id.'-'.$i.'.gif')){
										
											print "<br /><img class='img-responsive-admin' src='../news-images/".$id."-".$i.".gif'>"; 
										
										}
										
										?>
										
									</div>
								</div>
								
								<?php } ?>

								<div class="form-group">
									<div class="col-md-6 col-md-offset-4">
										<button type="submit" class="btn btn-primary"> <?= strtoupper($action) ?> NEWS ITEM </button>
									</div>
								</div>
							
						</div>
					</div>
		
		
	</form>		

