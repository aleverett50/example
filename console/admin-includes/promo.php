<?php

if($action == 'edit'){

	$row = $promoObj->find($id);

}

if( isset($_POST['code']) ){

	if($action == 'add'){
	
		$promoObj->add();
	
	} else {
	
		$promoObj->update($id);
	
	}

}

?>

<h1>PROMO CODE</h1>

	<form class="form-horizontal" method="post" action="">

						<div class="panel panel-default">
						<div class="panel-heading"><?= strtoupper($action) ?> PROMO CODE</div>
						<div class="panel-body">
						
								<div class="form-group">
									<label class="col-md-4 control-label">Title</label>
									<div class="col-md-6">
										<input type="text" class="form-control" name="code" value="<?php if(isset($row)){ print $row->code; } ?>">
									</div>
								</div>

								<div class="form-group">
									<label class="col-md-4 control-label">Percentage</label>
									<div class="col-md-6">
										<input type="text" class="form-control" name="percentage" value="<?php if(isset($row)){ print $row->percentage; } ?>">
									</div>
								</div>


								<div class="form-group">
									<div class="col-md-6 col-md-offset-4">
										<button type="submit" class="btn btn-primary"> <?= strtoupper($action) ?> PROMO CODE </button>
									</div>
								</div>
							
						</div>
					</div>
		
		
	</form>		

