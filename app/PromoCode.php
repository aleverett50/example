<?php

namespace App;

class PromoCode extends ObjectModel
{

    protected $table = 'promo_codes';
    protected $fillable = ['code', 'percentage'];
    protected $uniqueID;
    protected $user;


    public function __construct()
    {

	$this->user = new User;

	if($this->user->uniqueId()){
	
		$this->uniqueID = $this->user->uniqueId();
	
	}

    }


    public function getAll()
    {
	return $this->execute("SELECT * FROM promo_codes WHERE promo_codes.deleted_at IS NULL ", [] );		
    }


    public function add()
    {
	
	parent::add();

	return redirect('account.php?page=promos', 'The promo code has been added');

    }
		
		
    public function delete($id)
    {

	$this->updateRow($this->table, ['deleted_at' => DT], 'id = :id  ', [ 'id' => $id ] );
	
	return redirect('account.php?page=promos', 'The promo code has been deleted');

    }


    public function update($id, $whereValues = null)
    {

	parent::update('id = :id', ['id' => $id]);

	return redirect('account.php?page=promos', 'The promo code has been updated');

    }
		
		
    public function checkPromoCode()
    {

	$row = $this->getRowByFieldNotDeleted('code', $_POST['code']);
	
	if( isset($row->id) ){
		
		setcookie(SALT.'promo_code', $row->id, time()+604800);
		$_SESSION[SALT.'promo_code'] = $row->id;
		
		return redirect( 'basket.php', 'The promotional code has been accepted' );
	
	}
	
	else {
	
		setcookie(SALT.'promo_code', '', time()-3600);
		unset($_SESSION[SALT.'promo_code']);
		
		return redirect( 'basket.php', 'The promotional code was incorrect', 'e' );
	
	}


    }


}
