<?php

class Gallery extends ObjectModel{

		protected $table = 'gallery';
		protected $fillable = ['title', 'extension'];

		public $extension;
	
		public function getAll(){
		
			return $this->execute('SELECT * FROM gallery WHERE deleted_at IS NULL  ', [] );
		
		
		}
		
		public function add(){

				foreach($_FILES as $key => $file){
				
					$fileNum = str_replace('file-', '', $key);

					if($_FILES[$key]['size'] > 0){

						$explodedot = explode('.', $_FILES[$key]['name']);
						$ext = $explodedot[sizeof($explodedot)-1];
						$ext = strtolower($ext);

						$size = getimagesize($_FILES[$key]['tmp_name']);

						if(empty($size)){ return redirect( 'account.php?page=add-gallery', 'You must upload a valid image', 'e' ); }

						if ( $ext != "jpg" && $ext != "png" && $ext != "gif" ){ return redirect( 'account.php?page=add-gallery', 'JPG, PNG or GIF extensions only', 'e' );  }
						
						$this->extension = $ext;

						$id = parent::add();
						
						move_uploaded_file($_FILES[$key]['tmp_name'], '../gallery/'.$id.'.'.$ext);

					}

				}
			
		
		
			return redirect('account.php?page=gallery', 'The gallery image has been added');
		
		}
		
		
		public function delete($id){
		
			$this->updateRow($this->table, ['deleted_at' => DT], 'id = :id  ', [ 'id' => $id ] );
			
			return redirect('account.php?page=gallery', 'The gallery image has been deleted');
		
		
		}



}