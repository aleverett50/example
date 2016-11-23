<?php

if($action == 'edit'){

	$row = $productObj->find($id);

}

if($action == 'delete-image'){

	$row = $productObj->deleteImage($_GET['img']);

}

if( isset($_POST['title']) ){

	if($action == 'add'){
	
		$productObj->add();
	
	} else {
	
		$productObj->update($id);
	
	}

}

?>

<script>

$(function(){

	$.get('account.php?page=product&action=add&get=sessions', function(data){
		
		var data = jQuery.parseJSON(data);
		
		$('#form input[type=text], #form input[type=email], #form textarea').each(function(){
			
			if (typeof data[this.id] !== 'undefined') {
			
				$('#' + this.id).val(data[this.id]);
				
			}
		
		});
		
		$('#form select').each(function(){
		
			$('#' + this.id + ' option[value='+data[this.id]+']').prop('selected', true);
		
		});

	});

});

</script>

<h1>PRODUCT</h1>

<p>Default size for images: 1200px X 771px - or a ratio of 1.56 (Width by Height)</p>
<p>Once uploaded, to delete an image, just click it.</p>

	<form enctype="multipart/form-data" <?php if($action == 'add'){ print 'id="form"'; } ?> class="form-horizontal" method="post" action="">

						<div class="panel panel-default">
						<div class="panel-heading"><?= strtoupper($action) ?> PRODUCT</div>
						<div class="panel-body">
						
								<div class="form-group">
									<label class="col-md-4 control-label">Title</label>
									<div class="col-md-6">
										<input type="text" class="form-control" name="title" id="title" value="<?php if(isset($row)){ print $row->title; } ?>">
									</div>
								</div>
								
								<div class="form-group">
									<label class="col-md-4 control-label">Product Code</label>
									<div class="col-md-6">
										<input type="text" class="form-control" name="product_code" id="product_code" value="<?php if(isset($row)){ print $row->product_code; } ?>">
									</div>
								</div>
								
								<div class="form-group">
									<label class="col-md-4 control-label">Size</label>
									<div class="col-md-6">
										<input type="text" class="form-control" name="size" id="size" value="<?php if(isset($row)){ print $row->size; } ?>">
									</div>
								</div>
								
								<div class="form-group">
									<label class="col-md-4 control-label">ID</label>
									<div class="col-md-6">
										<input type="text" class="form-control" name="inner_diameter" id="inner_diameter" value="<?php if(isset($row)){ print $row->inner_diameter; } ?>">
									</div>
								</div>
								
								<div class="form-group">
									<label class="col-md-4 control-label">OD</label>
									<div class="col-md-6">
										<input type="text" class="form-control" name="outer_diameter" id="outer_diameter" value="<?php if(isset($row)){ print $row->outer_diameter; } ?>">
									</div>
								</div>
								
								<div class="form-group">
									<label class="col-md-4 control-label">Thickness</label>
									<div class="col-md-6">
										<input type="text" class="form-control" name="thickness" id="thickness" value="<?php if(isset($row)){ print $row->thickness; } ?>">
									</div>
								</div>
								
								<div class="form-group">
									<label class="col-md-4 control-label">Stock Amount</label>
									<div class="col-md-6">
										<input type="text" class="form-control" name="stock_amount" id="stock_amount" value="<?php if(isset($row)){ print $row->stock_amount; } ?>">
									</div>
								</div>

								<div class="form-group">
									<label class="col-md-4 control-label">Category</label>
									<div class="col-md-6">
										
										<select class="form-control" name="category_id" id="category_id">
										
										<?php
										
										foreach($categoryObj->getAll() as $category){
										
										$selected = '';
										
											if( isset($row) ){
										
												$selected = $category->id == $row->category_id ? 'selected' : '';
											
											}
										
										print "<option value='".$category->id."' $selected>".$category->title."</option>\n";
										
										}
										
										?>
										
										</select>
										
									</div>
								</div>
								
								<div class="form-group">
									<label class="col-md-4 control-label">Sub Category</label>
									<div class="col-md-6">
										
										<select class="form-control" name="sub_category_id" id="sub_category_id">
										<option value="">Select</option>
										<?php
										
										foreach($subCategoryObj->getAll() as $subCategory){
										
										$selected = '';
										
											if( isset($row) ){
										
												$selected = $subCategory->sub_category_id == $row->sub_category_id ? 'selected' : '';
											
											}
										
										print "<option value='".$subCategory->sub_category_id."' $selected>".$subCategory->sub_category_title."</option>\n";
										
										}
										
										?>
										
										</select>
										
									</div>
								</div>
								
								<div class="form-group">
									<label class="col-md-4 control-label">Price</label>
									<div class="col-md-6">
										<input type="text" class="form-control" name="price" id="price" value="<?php if(isset($row)){ print $row->price; } ?>">
									</div>
								</div>
								
								<div class="form-group">
									<label class="col-md-4 control-label">Description</label>
									<div class="col-md-6">
										
										<textarea class="form-control" rows="3" name="description" id="description"><?php if(isset($row)){ print $row->description; } ?></textarea>
										
									</div>
								</div>
								
								<?php for($i = 1; $i < 3; $i++){ ?>
								
								<div class="form-group">
									<label class="col-md-4 control-label">Image <?= $i; ?> (JPG, PNG or GIF)</label>
									<div class="col-md-6">
										<input type="file" class="form-control" name="file-<?= $i; ?>">
										
										<?php
										
										if(isset($id) && file_exists('../product-images/'.$id.'-'.$i.'.png')){
										
	print "<br /><a onclick=\"return confirm('Are you sure you want to delete this image?')\" href='account.php?page=product&action=delete-image&id=".$id."&img=".$id."-".$i.".png'><img class='img-responsive-admin' src='../product-images/".$id."-".$i.".png'></a>"; 
										
										} else 
										
										if(isset($id) && file_exists('../product-images/'.$id.'-'.$i.'.jpg')){
																																														print "<br /><a onclick=\"return confirm('Are you sure you want to delete this image?')\" href='account.php?page=product&action=delete-image&id=".$id."&id=".$id."&img=".$id."-".$i.".jpg'><img class='img-responsive-admin' src='../product-images/".$id."-".$i.".jpg'></a>"; 
										
										} else 
										
										if(isset($id) && file_exists('../product-images/'.$id.'-'.$i.'.gif')){
										
	print "<br /><a onclick=\"return confirm('Are you sure you want to delete this image?')\" href='account.php?page=product&action=delete-image&id=".$id."&id=".$id."&img=".$id."-".$i.".gif'><img class='img-responsive-admin' src='../product-images/".$id."-".$i.".gif'></a>"; 
										
										}
										
										?>
										
									</div>
								</div>
								
								<?php } ?>

								<div class="form-group">
									<div class="col-md-6 col-md-offset-4">
										<button type="submit" class="btn btn-primary"> <?= strtoupper($action) ?> PRODUCT </button>
									</div>
								</div>
							
						</div>
					</div>
		
		
	</form>		

