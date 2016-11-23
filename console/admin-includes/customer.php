<?php

if($action == 'edit'){

	$row = $user->find($id);

}

if( isset($_POST['first_name']) ){
	
	$user->updateCustomer($id);
		
}

?>

<h1>CUSTOMER</h1>

	<form id="form" class="form-horizontal" method="post" action="">

						<div class="panel panel-default">
						<div class="panel-heading"><?= strtoupper($action) ?> CUSTOMER</div>
						<div class="panel-body">
						
								<div class="form-group">
									<label class="col-md-4 control-label">First Name</label>
									<div class="col-md-6">
										<input type="text" class="form-control" id="first_name" name="first_name" value="<?= $row->first_name; ?>">
									</div>
								</div>
								
								<div class="form-group">
									<label class="col-md-4 control-label">Last Name</label>
									<div class="col-md-6">
										<input type="text" class="form-control" id="last_name" name="last_name" value="<?= $row->last_name; ?>">
									</div>
								</div>
								
								<div class="form-group">
									<label class="col-md-4 control-label">Email Address</label>
									<div class="col-md-6">
										<input type="email" class="form-control" id="email" name="email" value="<?= $row->email; ?>">
									</div>
								</div>
								
								<div class="form-group">
									<label class="col-md-4 control-label">Phone</label>
									<div class="col-md-6">
										<input type="text" class="form-control" id="phone" name="phone" value="<?= $row->phone; ?>">
									</div>
								</div>
								
								<div class="form-group">
									<label class="col-md-4 control-label">Address 1</label>
									<div class="col-md-6">
										<input type="text" class="form-control" id="address_1" name="address_1" value="<?= $row->address_1; ?>">
									</div>
								</div>
								
								<div class="form-group">
									<label class="col-md-4 control-label">Address 2</label>
									<div class="col-md-6">
										<input type="text" class="form-control" id="address_2" name="address_2" value="<?= $row->address_2; ?>">
									</div>
								</div>
								
								<div class="form-group">
									<label class="col-md-4 control-label">Town</label>
									<div class="col-md-6">
										<input type="text" class="form-control" id="town" name="town" value="<?= $row->town; ?>">
									</div>
								</div>
								
								<div class="form-group">
									<label class="col-md-4 control-label">Country</label>
									<div class="col-md-6">
										<input type="text" class="form-control" id="country" name="country" value="<?= $row->country; ?>">
									</div>
								</div>
								
								<div class="form-group">
									<label class="col-md-4 control-label">Postcode</label>
									<div class="col-md-6">
										<input type="text" class="form-control" id="postcode" name="postcode" value="<?= $row->postcode; ?>">
									</div>
								</div>
								
<?php if($row->member_type == 1){

$what_you_ride = array();

if( $row->what_you_ride ){

$what_you_ride = json_decode($row->what_you_ride);

}

?>

								<div class="form-group">
									<label class="col-md-4 control-label">Are you part of a club/team?</label>
									<div class="col-md-6">
										<select class="form-control" id="team" name="team">
										<option value='Yes' <?php if($row->team == 'Yes'){ print 'selected'; } ?>>Yes</option>
										<option value='No' <?php if($row->team == 'No'){ print 'selected'; } ?>>No</option>
										</select>
									</div>
								</div>
								
								<div class="form-group">
									<label class="col-md-4 control-label">What do you ride</label>
									<div class="col-md-6">
	<input type="checkbox" name="what_you_ride[]" id="BMX" value="BMX" <?php if(in_array('BMX', $what_you_ride)){ print 'checked'; } ?>> <label for="BMX">BMX </label> <br />
	<input type="checkbox" name="what_you_ride[]" id="Road" value="Road" <?php if(in_array('Road', $what_you_ride)){ print 'checked'; } ?>> <label for="Road"> Road </label> <br />
	<input type="checkbox" name="what_you_ride[]" id="MTB" value="MTB" <?php if(in_array('MTB', $what_you_ride)){ print 'checked'; } ?>> <label for="MTB"> MTB </label> <br />
	<input type="checkbox" name="what_you_ride[]" id="Cyclocross" value="Cyclocross" <?php if(in_array('Cyclocross', $what_you_ride)){ print 'checked'; } ?>> <label for="Cyclocross"> Cyclocross </label>
									</div>
								</div>
								

<?php } else { ?>

								<div class="form-group">
									<label class="col-md-4 control-label">Company Name</label>
									<div class="col-md-6">
										<input type="text" class="form-control" id="company_name" name="company_name" value="<?= $row->company_name; ?>">
									</div>
								</div>
								
								<div class="form-group">
									<label class="col-md-4 control-label">VAT Number</label>
									<div class="col-md-6">
										<input type="text" class="form-control" id="vat_number" name="vat_number" value="<?= $row->vat_number; ?>">
									</div>
								</div>
								
								<div class="form-group">
									<label class="col-md-4 control-label">Company Registration Number</label>
									<div class="col-md-6">
										<input type="text" class="form-control" id="company_reg_number" name="company_reg_number" value="<?= $row->company_reg_number; ?>">
									</div>
								</div>
								
								<div class="form-group">
									<label class="col-md-4 control-label">Do you have a team?</label>
									<div class="col-md-6">
										<select class="form-control" id="team" name="team">
										<option value='Yes' <?php if($row->team == 'Yes'){ print 'selected'; } ?>>Yes</option>
										<option value='No' <?php if($row->team == 'No'){ print 'selected'; } ?>>No</option>
										</select>
									</div>
								</div>
								
								<div class="form-group">
									<label class="col-md-4 control-label">Do you have shop riders?</label>
									<div class="col-md-6">
										<select class="form-control" id="shop_riders" name="shop_riders">
										<option value='Yes' <?php if($row->shop_riders == 'Yes'){ print 'selected'; } ?>>Yes</option>
										<option value='No' <?php if($row->shop_riders == 'No'){ print 'selected'; } ?>>No</option>
										</select>
									</div>
								</div>
								
<?php } ?>

								<div class="form-group">
									<div class="col-md-6 col-md-offset-4">
										<button type="submit" class="btn btn-primary"> <?= strtoupper($action) ?> CUSTOMER </button>
									</div>
								</div>
							
						</div>
					</div>
		
		
	</form>		

