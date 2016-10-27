<?php

class Youtube extends ObjectModel{

		protected $table = 'youtube';
		protected $fillable = ['title', 'description', 'code'];
		protected $rules = ['title' => 'required', 'code' => 'required'];

	
		public function getAll(){
		
			return $this->execute('SELECT * FROM youtube WHERE deleted_at IS NULL ORDER BY title ASC ', [] );
		
		
		}
		
		public function add(){
		
			if( !$this->validate() ){
			
				return redirect('account.php?page=youtube&action=add');
			
			}
			
			parent::add();
		
			return redirect('account.php?page=youtubes', 'The youtube video has been added');
		
		}
		
		
		public function delete($id){
		
			$this->updateRow($this->table, ['deleted_at' => DT], 'id = :id  ', [ 'id' => $id ] );
			
			return redirect('account.php?page=youtubes', 'The youtube video has been deleted');
		
		
		}
		
		public function update($id, $whereValues = null){
		
			if( !parent::update('id = :id', ['id' => $id]) ){
			
				return redirect('account.php?page=youtube&action=edit&id='.$id);
			
			}
		
			return redirect('account.php?page=youtubes', 'The youtube video has been updated');

		}



}