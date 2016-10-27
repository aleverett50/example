<?php 

include('includes/config.php');
include('includes/page-titles.php');
include('header.php'); ?>

<style>.panel-default{ border:1px solid #808080 }</style>

            <div class="container">

                            <h1>News</h1>
			    
			<?php foreach($newsObj->getAll() as $row){ ?>
			
					<div class="panel panel-default">
						<div class="panel-body">						
							
							<div class="row">
							
								<div class="col-md-8">
								
									<h2 class="no-margin"><?= $row->title ?></h2>
									
									<br />
									<p><?= nl2br($row->description) ?></p>
									
									<?php if($row->link){ print '<a target="_blank" href="'.$row->link.'">'.$row->link.'</a><br /><br />'; } ?>
									
								</div>
								
								<div class="col-md-4">
								
								<img alt="<?= htmlspecialchars($row->title) ?>" class="img-responsive" src="news-images/<?= $row->id ?>-1.<?= $row->image_ext ?>">
								
								</div>
							
							</div>

						</div>
					</div>
					
			<?php } ?>


            </div>

<?php include('footer.php'); ?>