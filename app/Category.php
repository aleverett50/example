<?php

namespace App;

class Category extends ObjectModel
{

    protected $table = 'categories';
    protected $fillable = ['title'];
    protected $rules = ['title' => 'required'];

	
    public function getAll()
    {
	return $this->execute('SELECT * FROM categories WHERE deleted_at IS NULL ORDER BY title ASC ', [] );
    }


    public function add()
    {
		
	if( !$this->validate() ){
	
		return redirect('account.php?page=category&action=add');
	
	}
	
	parent::add();

	return redirect('account.php?page=categories', 'The category has been added');
		
    }
		
		
    public function delete($id)
    {
		
	$this->updateRow($this->table, ['deleted_at' => DT], 'id = :id  ', [ 'id' => $id ] );
	
	return redirect('account.php?page=categories', 'The category has been deleted');
		
    }
		
    
    public function update($id, $whereValues = null)
    {
		
	if( !parent::update('id = :id', ['id' => $id]) ){
	
		return redirect('account.php?page=category&action=edit&id='.$id);
	
	}

	return redirect('account.php?page=categories', 'The category has been updated');

    }



}
