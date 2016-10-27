<?php

include('includes/config.php');
include('header.php'); ?>


<section>
	<div class="container-fluid banner-holder" style="padding:30px 0px 30px 0px;background:#F7F7F7">       
		<div class="slide container" data-ride="carousel">
			<div class="carousel-inner">
				<div class="item active">
				<img alt="Banner 1" src="images/Banner-1.jpg" />
				</div>
				<div class="item">
				<img alt="Banner 2" src="images/Banner-2.jpg" />
				</div>
				<div class="item">
				<img alt="Banner 3" src="images/Banner-3.jpg" />
				</div>
			</div>
		</div>
	</div>
</section>


 <div class="container <?php if(!$detect->isMobile()){ ?>border <?php } ?> p-20">
	<div class="row">
		<div class="col-md-12">
		
		<h1 class="mt-0 main-colour">Welcome</h1>

		
		</div>
	</div>
 </div>

            <div class="container">
                <div class="row mt-20">

			<div class="col-md-4">
			
				<a href=""><img class="home-page-image center-block" src=""></a>
			
			</div>
			
			<div class="col-md-4">
			
				<a href=""><img class="home-page-image center-block" src=""></a>
			
			</div>
			
			<div class="col-md-4">
			
				<a href=""><img class="home-page-image center-block" src=""></a>
			
			</div>
			


                </div>
		
                <div class="row">

			<div class="col-md-4">
			
				<a href=""><img class="home-page-image center-block" src=""></a>
			
			</div>
			
			<div class="col-md-4">
			
				<a href=""><img class="home-page-image center-block" src=""></a>
			
			</div>
			
			<div class="col-md-4">
			
				<a<a href=""><img class="home-page-image center-block" src=""></a>
			
			</div>

                </div>

        </div>    


<script>

$(document).ready(function() {
 
  $("#owl-demo").owlCarousel({
 
      autoPlay: 113000, //Set AutoPlay to 3 seconds
 
      items : 4,
      itemsDesktop : [1199,3],
      itemsDesktopSmall : [979,3]
 
  });
 
});

</script>

<style>

#owl-demo .item{
 margin: 3px;
}

#owl-demo .item img{
 display: block;
 width: 100%;
 height: auto;
}


</style>


<section class="slice relative bg-white bb animate-hover-slide">
	<div class="container">
	
	<h1>RECENT PRODUCTS</h1>
		

		<div id="owl-demo">
			
				<?php foreach($productObj->getAllForHomepage() as $row){
				
					if(file_exists('product-images/'.$row->id.'-1.png')){ $ext = 'png'; } else 
					if(file_exists('product-images/'.$row->id.'-1.jpg')){ $ext = 'jpg'; } else 
					{ $ext = 'gif'; }
				
				?>
			
                                    <div class="wp-block inverse item">
                                        <div class="figure">
                                            <img alt="" src="product-images/<?= $row->id ?>-1.<?= $ext ?>" class="img-responsive">
                                            <div class="figcaption bg-base"></div>
                                            <div class="figcaption-btn">
                                                <a href="product-images/<?= $row->id ?>-1.<?= $ext ?>" class="btn btn-xs btn-b-white theater"><i class="fa fa-plus-circle"></i> Zoom</a>
                                                <a href="product-details.php?id=<?= $row->id; ?>&p=<?= urlencode(strtolower($row->title)); ?>" class="btn btn-xs btn-b-white"><i class="fa fa-link"></i> View</a>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xs-12 text-center">
					<p class="home-page-para"><?= $row->title ?></p>
                                               
					<p class="main-colour">( <?= $row->size ?> )<br />
					
					<?php include('includes/format-price.php'); ?>
					
					</p>
                                                
                                            </div>
                                        </div>
                                    </div> 
				    
				<?php } ?>

		</div>
	</div>
</section>

    
        <section class="slice p-15 base">
        <div class="cta-wr">
            <div class="container">
                <div class="row">
		<form action="contact.php" method="post">
                    <div class="col-md-4 text-center">
                        <h1 class="text-normal"> SIGN UP TO OUR NEWSLETTER </h1>
                    </div>
                    <div class="col-md-4 text-center">
			
			<input placeholder="Email Address..." class="newletter_input" type="email" name="email_subscribe">
			
                    </div>
                    <div class="col-md-4 text-center">
			<input type="submit" class="btn btn-lg btn-b-white btn-icon btn-icon-right btn-check" value="SIGN UP">
                        
                    </div>
		</form>
                </div>
            </div>
        </div>
    </section>

<?php include('footer.php'); ?>
