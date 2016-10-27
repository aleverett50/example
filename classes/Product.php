<?php

class Product extends ObjectModel{

		protected $table = 'products';
		protected $fillable = ['title', 'product_code', 'size', 'category_id', 'sub_category_id', 'price', 'description', 'inner_diameter', 'outer_diameter', 'thickness', 'stock_amount'];
		protected $rules = ['title' => 'required', 'product_code' => 'required', 'size' => 'required', 'stock_amount' => 'required', 'category_id' => 'required', 'sub_category_id' => 'required', 'price' => 'required', 'description' => 'required'];

	
		public function getAll(){
		
	return $this->execute('SELECT *, products.title AS product_title, categories.title AS category_title, products.id AS product_id FROM products LEFT JOIN categories ON categories.id = products.category_id LEFT JOIN sub_categories ON sub_categories.id = products.sub_category_id WHERE products.deleted_at IS NULL ORDER BY sub_categories.title ASC, products.product_code ASC ', [] );
		
		
		}
		
		public function getAllForHomepage(){
		
			return $this->execute('SELECT * FROM products WHERE deleted_at IS NULL ORDER BY id DESC LIMIT 16  ', [] );
		
		
		}
		
		public function getAllBySubCategory($subCategoryId){
		
			return $this->execute("SELECT * FROM products WHERE sub_category_id = ? AND products.deleted_at IS NULL ORDER BY products.product_code ASC ", [$subCategoryId] );		
		
		}
		
		
		public function search($search){
		
			return $this->execute("SELECT * FROM products WHERE ( title LIKE ? OR product_code LIKE ? ) AND products.deleted_at IS NULL ORDER BY products.product_code ASC ", ["%".$search."%", "%".$search."%"] );		
		
		}
		
	
		public function measurementSearch($inner_diameter, $outer_diameter, $thickness){
		
		$inner_diameter = str_replace("'", "", $inner_diameter);
		$outer_diameter = str_replace("'", "", $outer_diameter);
		$thickness = str_replace("'", "", $thickness);
		
		$and = '';
		
		if(!empty($inner_diameter)){
		
			$inner_diameter_less = $inner_diameter - 0.5;
			$inner_diameter_plus = $inner_diameter + 0.5;
			$and .= "AND inner_diameter IS NOT NULL AND inner_diameter >= '".$inner_diameter_less."' AND inner_diameter <= '".$inner_diameter_plus."'";
		
		}
		
		if(!empty($outer_diameter)){
		
			$outer_diameter_less = $outer_diameter - 0.5;
			$outer_diameter_plus = $outer_diameter + 0.5;
			$and .= " AND outer_diameter IS NOT NULL AND outer_diameter >= '".$outer_diameter_less."' AND outer_diameter <= '".$outer_diameter_plus."'";
		
		}
		
		if(!empty($thickness)){
		
			if(is_numeric($thickness)){
		
			$thickness_less = $thickness - 0.5;
			$thickness_plus = $thickness + 0.5;
			$and .= " AND thickness IS NOT NULL AND thickness >= '".$thickness_less."' AND thickness <= '".$thickness_plus."'";
			
			} else {
			
			$and .= " AND thickness IS NOT NULL AND thickness = '".$thickness."'";
			
			}
		
		}
		
		if(!$and){ return null; }
		
			return $this->execute("SELECT * FROM products WHERE products.deleted_at IS NULL $and ORDER BY products.product_code ASC ", [] );		
		
		}
		
		
		public function getProductById($id){
		
			return $this->execute("SELECT *, products.id AS product_id, products.title AS product_title FROM products LEFT JOIN sub_categories ON sub_categories.id = products.sub_category_id WHERE products.id = ?  ", [$id] );		
		
		}
		
		public function add(){
		
			if( !$this->validate() ){
			
				return redirect('account.php?page=product&action=add');
			
			}
			
			$id = parent::add();
			
			$this->uploadImages($id);
		
			return redirect('account.php?page=products', 'The product has been added');
		
		}
		
		
		public function update($id, $whereValues = null){
		
			if( !parent::update('id = :id', ['id' => $id]) ){
			
				return redirect('account.php?page=product&action=edit&id='.$id);
			
			}
			
			$this->uploadImages($id);

			return redirect('account.php?page=products', 'The product has been updated');

		}
		
		
		public function delete($id){
		
			$this->updateRow($this->table, ['deleted_at' => DT], 'id = :id  ', [ 'id' => $id ] );
			
			return redirect('account.php?page=products', 'The product has been deleted');
		
		
		}
		
		public function deleteImage($image){
		
			copy('../product-images/'.$image, '../deleted-product-images/'.$image);
			unlink('../product-images/'.$image);
		
			return redirect( 'account.php?page=product&action=edit&id='.$_GET['id'], 'The image has been deleted' );
		
		}
		
		
		public function uploadImages($id){
		
				foreach($_FILES as $key => $file){
				
					$fileNum = str_replace('file-', '', $key);

					if($_FILES[$key]['size'] > 0){

						$explodedot = explode('.', $_FILES[$key]['name']);
						$ext = $explodedot[sizeof($explodedot)-1];
						$ext = strtolower($ext);

						$size = getimagesize($_FILES[$key]['tmp_name']);

						if(empty($size)){ return redirect( 'account.php?page=product&action=edit&id='.$id, 'You must upload a valid image', 'e' ); }

						if ( $ext != "jpg" && $ext != "png" && $ext != "gif" ){ return redirect( 'account.php?page=product&action=edit&id='.$id, 'JPG, PNG or GIF extensions only', 'e' );  }
						
							if(file_exists('../product-images/'.$id.'-'.$fileNum.'.jpg')){ unlink( '../product-images/'.$id.'-'.$fileNum.'.jpg' ); }
							if(file_exists('../product-images/'.$id.'-'.$fileNum.'.png')){ unlink( '../product-images/'.$id.'-'.$fileNum.'.png' ); }
							if(file_exists('../product-images/'.$id.'-'.$fileNum.'.gif')){ unlink( '../product-images/'.$id.'-'.$fileNum.'.gif' ); }
							if(file_exists('../product-images/'.$id.'-'.$fileNum.'.jpeg')){ unlink( '../product-images/'.$id.'-'.$fileNum.'.jpeg' ); }
						
							move_uploaded_file($_FILES[$key]['tmp_name'], '../product-images/'.$id.'-'.$fileNum.'.'.$ext);

					}

				}		
		
		}
		
		
		public function updateTable(){
		
			$query = $this->execute('SELECT * FROM products WHERE products.deleted_at IS NULL ', [] );
			
			foreach($query as $row){
			
				$count = substr_count($row->size, 'X');
				
				if($count == 2){
				
					$explode = explode('X', $row->size);
					
					$this->updateRow($this->table, ['inner_diameter' => trim($explode[0]), 'outer_diameter' => trim($explode[1]), 'thickness' => trim($explode[2])], 'id = :id LIMIT 1 ', [ 'id' => $row->id ] );
				
				}
			
				
			
			}
		
		}



}









