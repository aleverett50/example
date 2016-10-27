<?php 

include('includes/config.php');

if( isset($_POST['email']) ){

	$user->login($user_role_id = 1);

}

if( isset($_GET['log']) ){

	User::logout();

}

if($user->auth()){

	redirect( 'account.php?page=home');

}

include('header.php'); ?>

<div class="container">

<?php include(dirname(__FILE__).'/includes/flash-messages.php'); ?>

  
                            <h1>Login</h1>


<p>Please login to your account here. <br /><br /></p>
		
		<form class="form-horizontal form-light" id="form" method="post" action="">
			
					<div class="panel panel-default">
						<div class="panel-heading">LOGIN</div>
						<div class="panel-body">
								
								<div class="form-group">
									<label class="col-md-4 control-label">Email Address</label>
									<div class="col-md-6">
										<input type="text" class="form-control" id="email" name="email">
									</div>
								</div>
								
								<div class="form-group">
									<label class="col-md-4 control-label">Password</label>
									<div class="col-md-6">
										<input type="password" class="form-control" name="password">
									</div>
								</div>
								

								<div class="form-group">
									<div class="col-md-6 col-md-offset-4">
										<button type="submit" class="btn btn-base"> LOGIN </button>
										<a class="btn btn-link" href="forgot-password.php">Forgotten Your Password?</a>
									</div>
								</div>
							
						</div>
					</div>
			
		
		</form>
		

</div>

    

<?php include('footer.php'); ?>