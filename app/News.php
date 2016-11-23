<?php

namespace App;

class News extends ObjectModel
{

    protected $table = 'news';
    protected $fillable = ['title', 'description', 'link'];
    protected $rules = ['title' => 'required'];

	
    public function getAll()
    {
	return $this->execute("SELECT * FROM news WHERE deleted_at IS NULL ORDER BY id DESC ", []);
    }
		
		
    public function add()
    {

	if( !$this->validate() ){
	
		return redirect('account.php?page=news-item&action=add');
	
	}
	
	$id = parent::add();
	
	$this->uploadImages($id);

	return redirect('account.php?page=news', 'The news item has been added');

    }
		
		
    public function delete($id)
    {

	$this->updateRow($this->table, ['deleted_at' => DT], 'id = :id  ', [ 'id' => $id ] );
	
	return redirect('account.php?page=news', 'The news item has been deleted');


    }


    public function update($id, $whereValues = null)
    {

	if( !parent::update('id = :id', ['id' => $id]) ){
	
		return redirect('account.php?page=news-item&action=edit&id='.$id);
	
	}
	
	$this->uploadImages($id);

	return redirect('account.php?page=news', 'The news item has been updated');

    }
		
		
    public function uploadImages($id)
    {

	foreach($_FILES as $key => $file){

		$fileNum = str_replace('file-', '', $key);

		if($_FILES[$key]['size'] > 0){

			$explodedot = explode('.', $_FILES[$key]['name']);
			$ext = $explodedot[sizeof($explodedot)-1];
			$ext = strtolower($ext);

			$size = getimagesize($_FILES[$key]['tmp_name']);

			if(empty($size)){
			
				return redirect( 'account.php?page=news-item&action=edit&id='.$id, 'You must upload a valid image', 'e' );
			
			}

			if ( $ext != "jpg" && $ext != "png" && $ext != "gif" && $ext != "jpeg" ){ 
			
				return redirect( 'account.php?page=news-item&action=edit&id='.$id, 'JPG, PNG or GIF extensions only', 'e' );
			
			}
				
				$this->updateRow($this->table, ['image_ext' => $ext], 'id = :id  ', [ 'id' => $id ] );
				
				move_uploaded_file($_FILES[$key]['tmp_name'], '../news-images/'.$id.'-'.$fileNum.'.'.$ext);

		}

	}		

    }


}
