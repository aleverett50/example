<?php 

include('includes/config.php');

$row = $productObj->getProductById($_GET['id'])[0];

if( isset($_POST['product_id']) ){

	$cartObj->add();

}

include('header.php');

?>

<style> .zoom { display:inline-block } </style>
<script src="js/jquery.zoom.js"></script>

<script>

$(function(){

	$('.change-thumb').click(function(){
	
	var Img = $(this).attr('rel');

		$('#main-image').attr('src', 'product-images/'+Img);
		
		$('#ex1').zoom();
	
	});	

	$('#ex1').zoom();

});

</script>


<div class="container">

	<?php include(dirname(__FILE__).'/includes/flash-messages.php'); ?>

  <div class="row">

    <div class="col-md-12 mt-20">
      <ol class="breadcrumb">
        <li><a href="index.php"><i class="fa fa-home"></i></a></li>
        <li><a href="product-list.php?subCatId=<?= $row->id; ?>&cat=****&subCat=<?= urlencode(strtolower($row->title)); ?>"><?= $row->title; ?></a></li>
        <li><?= $row->product_title; ?></li>
      </ol>
      <div class="col-md-12 column">
        <div class="row clearfix">
	
          <div class="col-md-8 column"> 

	  
	<?php
	
if(!$detect->isPc()){  ?>

	<div id="myCarousel" class="carousel slide">
	<div class="carousel-inner" role="listbox">
				  
<?php
	
	for($i = 1; $i < 3; $i++){
	
	if(file_exists('product-images/'.$_GET['id'].'-'.$i.'.png')){ $ext = 'png'; } else 
	if(file_exists('product-images/'.$_GET['id'].'-'.$i.'.jpg')){ $ext = 'jpg'; } else 
	if(file_exists('product-images/'.$_GET['id'].'-'.$i.'.gif')){ $ext = 'gif'; } else 
	{ continue;  }
	
?>
				  
	<div class="item <?php if($i == 1){ print "active"; } ?>">
	<img class="img-responsive" src="product-images/<?= $_GET['id'].'-'.$i; ?>.<?= $ext ?>" alt="<?= htmlspecialchars($row->title) ?>">
	</div>


	<?php if($i == 2){ ?> 

	<a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
	<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
	<span class="sr-only">Previous</span>
	</a>
	<a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
	<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
	<span class="sr-only">Next</span>
	</a>

	<?php } ?>

<?php

} 

print "</div></div><br />";

}
else {

	for($i = 1; $i < 3; $i++){
	
	if(file_exists('product-images/'.$_GET['id'].'-'.$i.'.png')){ $ext = 'png'; } else 
	if(file_exists('product-images/'.$_GET['id'].'-'.$i.'.jpg')){ $ext = 'jpg'; } else 
	if(file_exists('product-images/'.$_GET['id'].'-'.$i.'.gif')){ $ext = 'gif'; } else 
	{ continue;  }

 if($i == 1){ ?><span class='zoom' id='ex1' ><a title="<?= htmlspecialchars($row->title).' - Image '.$i; ?>" href="product-images/<?= $_GET['id'].'-'.$i; ?>.<?= $ext ?>" class="theater" rel="group"><img id="main-image" src="product-images/<?= $_GET['id'].'-'.$i; ?>.<?= $ext ?>" class="img-responsive" alt="<?= htmlspecialchars($row->title).' - Image '.$i; ?>"></a> </span> <?php } ?>
			
		<div class="col-md-2 column mt-10"> <a title="<?= htmlspecialchars($row->title).' - Image '.$i; ?>" class="change-thumb" rel="<?= $_GET['id'].'-'.$i.'.'.$ext; ?>"><img src="product-images/<?= $_GET['id'].'-'.$i; ?>.<?= $ext ?>" class="img-responsive" alt="<?= htmlspecialchars($row->title).' - Thumbnail Image '.$i; ?>"></a> </div> 
		
<?php } ?>


	<?php } ?>

	    
          </div>

          <div class="col-md-4 column">
		<h1 class="mt-10"><?= $row->product_title; ?></h1>


		<p>Size: ( <?= $row->size; ?> )</p>

		<p>Product Code: <?= $row->product_code; ?></p>
		
		<p>Price: <span class="price_show">
		
		<?php include('includes/format-price.php'); ?>
		
		</span></p>
	    
	<?php if($row->stock_amount < 1){ ?>
	
	<p class="out-of-stock"><i class="fa fa-exclamation-triangle"></i> THIS PRODUCT IS CURRENTLY OUT OF STOCK</p>
	
	<?php } else { ?>

            <form class="mb-20" action="" method="post">
	<input type="hidden" name="product_id" value="<?= $row->product_id ?>" />
	<input type="hidden" name="cart_price" value="<?= $row->price ?>" />
	<input type="hidden" name="redirect" value="<?= str_replace('&added=true', '', $_SERVER['REQUEST_URI']); ?>" />
              <div class="form-group">
                <label >Select Quantity</label>
                <select class="form-control" name="quantity">
		<?php for($i = 1; $i < 101; $i++){ print "<option value='$i'>$i</option>"; } ?>
                </select>
              </div>
              <button type="submit" class="btn btn-base width-160"><span class="fa fa-shopping-cart"></span> ADD TO BASKET</button>
            </form>
            <ul class="fa-ul">
              <li><i class="fa-li fa fa-truck"></i>Fast Delivery</li>
              <li><i class="fa-li fa fa-check-square"></i>Same day shipping if ordered before 2pm</li>
            </ul>
	    
	<?php if(isset($_GET['added'])){ ?><a href="basket.php"> <button type="submit" class="btn btn-base mt-20 width-160"> VIEW BASKET <span class="fa fa-arrow-right"></span></button>  </a>  <?php } ?>
	    
	    
	 <?php } ?>   
	    
	    
	    
          </div>
        </div>
      </div>
      <div class="col-md-12 column mt-50">
        <div class="row clearfix">
          <div class="col-md-12 column">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#description" data-toggle="tab">Description</a></li>
              <li><a href="#returns" data-toggle="tab">Returns Policy</a></li>
            </ul>
            
            <!-- Tab panes -->
            <div class="tab-content tabs-box mb-50">
              <div class="tab-pane active" id="description" >
	      
		<h2>Product Description</h2>

		<p><?= nl2br($row->description); ?></p>
		
              </div>
              <div class="tab-pane" id="returns">
	      
	      <h2>Returns Policy</h2>


	
              </div>

          </div>
        </div>
      </div>
    </div>
  </div>
</div>
			
			
			

	</div>


    

<?php include('footer.php'); ?>