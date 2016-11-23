<?php

namespace App;

use App\Helpers\Tools;

class User extends ObjectModel
{

    protected $userID = false;
    protected $table = 'users';
    protected $rules = [
					'email' => 'required',
					'first_name' => 'required',
					'last_name' => 'required',
					'address_1' => 'required',
					'town' => 'required',
					'postcode' => 'required'
				];
	
    protected $fillable = ['email', 'password', 'first_name', 'last_name', 'address_1', 'address_2', 'phone', 'town', 'postcode', 'country' ];
    protected $what_you_ride;
    protected $member_type;
		
			
    public function __construct()
    {

	if( !empty($_SESSION[SALT.'session']) && $_SESSION[SALT.'session'] > 0 ){
	
		$this->userID = $_SESSION[SALT.'session'];

	
	} elseif( !empty($_COOKIE[SALT.'session']) && $_COOKIE[SALT.'session'] > 0 ) {
	
		$this->userID = $_COOKIE[SALT.'session'];
	
	}

    }


    public function setUniqueId()
    {

		setcookie(SALT.'unique', $_SERVER['REMOTE_ADDR'].'-'.time(), time()+604800);
		$_SESSION[SALT.'unique'] = $_SERVER['REMOTE_ADDR'].'-'.time();

    }


    public function uniqueId()
    {

	if( isset($_COOKIE[SALT.'unique']) && !empty($_COOKIE[SALT.'unique']) && $_COOKIE[SALT.'unique'] != '' ){
	
		return $_COOKIE[SALT.'unique'];
	
	} elseif( isset($_SESSION[SALT.'unique']) && !empty($_SESSION[SALT.'unique']) && $_SESSION[SALT.'unique'] != '' ){
	
		return $_SESSION[SALT.'unique'];
	
	} else {
	
		return false;						
	
	}

    }


    public function destroyUniqueId()
    {

	if( isset($_COOKIE[SALT.'unique']) ){
	
		setcookie(SALT.'unique', '', time()-3600); 
	
	} 
	
	if( isset($_SESSION[SALT.'unique']) ){
	
		unset($_SESSION[SALT.'unique']);
	
	}

    }


    public function auth()
    {

	if( !$this->userID ){
	
		return false;
	
	} else {
	
		return $this->find($this->userID);				
	
	}

    }


    public function updateCustomerFromCheckout( $rules )
    {

	/* UNSET PASSWORD FROM RULES ARRAY */

	foreach($rules as $rule){
	
		unset($this->rules[$rule]);
	
	}
	
	if( !$this->validate() ){
	
		return redirect('checkout.php');
	
	}
	
	$result = $this->execute(' SELECT * FROM users 
					WHERE email = ? AND id != ? AND password IS NOT NULL 
					AND deleted_at IS NULL ', [ $_POST['email'], $this->userID ] );

	if( count($result) ){
	
		return redirect( 'checkout.php', 'That email address already exists.', 'e' );
	
	}
	
		
		$this->update( 'id = :id LIMIT 1 ' , [ 'id' => $this->userID ] );

    }


    public function addMember($memberType)
    {

	if($memberType == 1){
	
		$this->rules = [
					'first_name' => 'required', 
					'last_name' => 'required', 
					'team' => 'required', 
					'email' => 'required|unique:users', 
					'password' => 'required'
				];

		$this->fillable = ['email', 'password', 'first_name', 'last_name', 'team', 'what_you_ride', 'member_type'];

		$this->what_you_ride = isset($_POST['what_you_ride']) ? json_encode($_POST['what_you_ride']) : '';
	
	} else {
	
		$this->rules = [
					'first_name' => 'required', 
					'last_name' => 'required', 
					'company_name' => 'required', 
					'vat_number' => 'required',
					'company_reg_number' => 'required', 
					'team' => 'required', 
					'shop_riders' => 'required', 
					'email' => 'required|unique:users', 
					'password' => 'required'
				];

		$this->fillable = ['email', 'password', 'first_name', 'last_name', 'team', 'company_name', 'vat_number', 'company_reg_number', 'shop_riders', 'member_type'];
	
	}
	
	if( !$this->validate() ){
	
		return redirect('sign-up.php?memberType='.$memberType);
	
	}
	
	$this->member_type = $memberType;
	
	$id = parent::add();
	
	$_SESSION[SALT.'session'] = $id;
	setcookie(SALT.'session', $id, time()+604800);
	
	redirect('account.php?page=home', 'Your registration was successful');

    }


    public function add()
    {

	if(isset($_POST['password']) && $_POST['password'] != null){
	
		$this->rules['password'] = 'min:4';
		$this->rules['email'] = 'required|unique:users';
	
	}


	if( !$this->validate() ){
	
		return redirect('checkout.php');
	
	}
	
	$id = parent::add();
	
	if(isset($_POST['password']) && $_POST['password'] != null){
	
		$_SESSION[SALT.'session'] = $id;
		setcookie(SALT.'session', $id, time()+604800);
	
	}
	
	return $id;

    }


    public function requestPasswordReset($email)
    {

	$this->rules = ['email' => 'required|exists:users'];

	if( !$this->validate() ){
	
		return redirect('forgot-password.php');
	
	}
	
	$row = $this->getRowByField('email', $email);
	
	$remember_token = Tools::createHash(100);
	
	$this->updateRow($this->table, ['remember_token' => $remember_token], 'email = :email ' , [ 'email' => $email ] );
	
	$message = 'Hello '.$row->first_name.',<br /><br />Please click the link below where you can reset your password.<br /><br /><a href="'.DOMAIN.'/change-password.php?remember_token='.$remember_token.'">'.DOMAIN.'/change-password.php?remember_token='.$remember_token.'</a>';

	
	Mail::send( $email, $message, 'Password Reset', $row->first_name.' '.$row->last_name );
	
	return redirect( 'forgot-password.php', 'You have been sent an email with a link to change your password' );

    }


    public function resetPassword($remember_token)
    {

	$this->rules = ['password' => 'required|isSame:repeat_password', 'repeat_password' => 'required'];
	
	if( !$this->validate() ){
	
		return redirect('change-password.php?remember_token='.$remember_token);
	
	}
	
	if( !$this->getRowByField('remember_token', $remember_token) ){
		
		return redirect('change-password.php?remember_token='.$remember_token, 'The token did not match the token stored in the database. Please click your email link again.', 'e');
	
	};
	
	$this->updateRow($this->table, ['password' => $_POST['password'], 'remember_token' => NULL], 'remember_token = :remember_token AND remember_token IS NOT NULL ', [ 'remember_token' => $remember_token ] );
	
	return redirect( 'login.php', 'Your password has been changed. Please login with your new details' );
		
    }


    public function changePassword()
    {

	$this->rules = ['old_password' => 'required', 'password' => 'required|isSame:repeat_password', 'repeat_password' => 'required'];
	
	if( !$this->validate() ){
	
		return redirect('account.php?page=change-password');
	
	}
	
	$result = $this->execute(' SELECT * FROM users WHERE id = ? AND password = ? ', [ $this->userID, Tools::passwordHash($_POST['old_password']) ]);
	
	if( count($result) ){
	
		$this->updateRow($this->table, [ 'password' => $_POST['password'] ], 'id = :id LIMIT 1 ', [ 'id' => $this->userID ]);
		
		return redirect( 'account.php?page=change-password', 'Your password has been changed' );
	
	} else {
	
		return redirect('account.php?page=change-password', 'Your old password was incorrect', 'e');
	
	}


    }


    public function login($role, $basketItemCount = false)
    {

	$this->rules = ['email' => 'required', 'password' => 'required'];

	if( !$this->validate() ){
	
		return isset($_POST['redirect']) ? redirect( $_POST['redirect'] ) : redirect( 'login.php' );
	
	}
	
	$result = $this->execute(' SELECT * FROM users WHERE email = ? AND password = ? AND user_role_id = ? AND deleted_at IS NULL ', [ $_POST['email'], Tools::passwordHash($_POST['password']), $role ]);
	
	if( !count($result) ){
	
return isset($_POST['redirect']) ? redirect( $_POST['redirect'], 'Your login credentials were incorrect.', 'e' ) : redirect( 'login.php', 'Your login credentials were incorrect.', 'e' );
	
	} else {
	
		$_SESSION[SALT.'session'] = $result[0]->id;
		setcookie(SALT.'session', $result[0]->id, time()+604800);
		Tools::deleteSessions();
		
		return $basketItemCount ? redirect( 'basket.php?go=to-checkout' ) : redirect( 'account.php?page=home' );
	
	}


    }


    public static function logout()
    {

	unset($_SESSION[SALT.'session']);
	setcookie(SALT.'session', '', time()-3600);
	Tools::deleteSessions();
	return redirect('login.php', 'You have logged out');
	
    }


    public function checkAuth()
    {

	if(!$this->auth()){

	return redirect('login.php', 'You must be logged in to view that page.', 'e'); exit;

	}

    }


    public function updateCustomer($user_id = null)
    {

	/* IF CUSTOMER IS UPDATING OR ADMIN IS UPDATING THE CUSTOMER */
	
	$id = $user_id == null ? $this->userID : $user_id;

	$this->rules['email'] = 'required';
	unset($this->rules['password']);
	array_push($this->fillable,'team');
	
	/*  REMOVE PASSWORD FILLABLE FIELD  */
	
	unset($this->fillable[1]);
	
	$result = $this->execute(' SELECT * FROM users WHERE email = ? AND id != ? AND password IS NOT NULL AND deleted_at IS NULL ', [ $_POST['email'], $id ] );


	if( count($result) ){
	
		return $user_id == null ? redirect( 'account.php?page=details', 'That email address already exists.', 'e' ) : redirect( 'account.php?page=customer&action=edit&id='.$user_id, 'That email address already exists.', 'e' );
	
	}
	
	if( $this->find($id)->member_type == 2 ){
	
		$this->rules['company_name'] = 'required';
		$this->rules['vat_number'] = 'required';
		$this->rules['company_reg_number'] = 'required';
		array_push($this->fillable,'company_name','vat_number', 'company_reg_number', 'shop_riders');
	
	} else {
	
		array_push($this->fillable, 'what_you_ride');
		$this->what_you_ride = isset($_POST['what_you_ride']) ? json_encode($_POST['what_you_ride']) : '';

	}
	
	
	if( !$this->update( 'id = :id LIMIT 1 ' , [ 'id' => $id ] ) ){
					
		return $user_id == null ? redirect( 'account.php?page=details' ) : redirect( 'account.php?page=customer&action=edit&id='.$id );
	
	} else {
	
		return $user_id == null ? redirect( 'account.php?page=home', 'Your details have been updated' ) : redirect( 'account.php?page=customers', 'The details have been updated' );
	
	}
	
	
    }


    public function isAdmin()
    {

	if( $this->auth() && $this->auth()->user_role_id > 1 ){
		
		return true;
	
	} 
	
	return false;

    }


    public function getAll()
    {
	return $this->execute('SELECT * FROM users WHERE user_role_id = ? AND deleted_at IS NULL ORDER BY member_type ASC ', [1] );
    }


    public function isMember()
    {

	if( $this->auth() && $this->auth()->member_type == 1 ){
		
		return true;
	
	}
	
	return false;

    }


   public function isBusinessMember()
   {

	if( $this->auth() && $this->auth()->member_type == 2 ){
		
		return true;
	
	}
	
	return false;

    }


    public function delete($id){

	if($this->isAdmin()){

		$this->updateRow($this->table, ['deleted_at' => DT], 'id = :id ' , [ 'id' => $id ] );
	
	}

	return redirect( 'account.php?page=customers' );					

    }


}
