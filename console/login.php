<?php

require __DIR__.'/../includes/config.php';

if( $user->auth() && $user->auth()->user_role_id == 1 ){

	redirect('../login.php?log=out'); exit;

}

if( isset($_POST['email']) ){

	$user->login($user_role_id = 2);

}

if( isset($_GET['log']) ){

	App\User::logout();

}

if( $user->auth() && $user->auth()->user_role_id == 2 ){

	redirect('account.php?page=home');

}

?>

<?php require __DIR__.'/header.php'; ?>

<div class="container">

<h1>ADMIN LOGIN</h1>

<p>Please login to your admin panel here. <br /><br /></p>

<?php require __DIR__.'/../includes/flash-messages.php'; ?>
		
		
		<form class="form-horizontal" method="post" action="">
			
					<div class="panel panel-default">
						<div class="panel-heading">ADMIN LOGIN</div>
						<div class="panel-body">
								
								<div class="form-group">
									<label class="col-md-4 control-label">Username</label>
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
										<button type="submit" class="btn btn-primary"> LOGIN </button>
										
									</div>
								</div>
							
						</div>
					</div>
			
	
			
			

		
		</form>

	
		

</div>


<?php require __DIR__.'/footer.php'; ?>