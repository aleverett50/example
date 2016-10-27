<div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th colspan="2">Product</th>
                                            <th>Quantity</th>
                                            <th>Unit price</th>
                                            <th colspan="2">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
				
				<?php
				
				$html .= "<table style='width:100%' cellpadding='5'><tr><td><strong>Product Description</strong></td><td><strong>Quantity</strong></td><td><strong>Unit Price</strong></td><td style='text-align:right'><strong>Total</strong></td></tr>";
				
				foreach($cartObj->getAll() as $row){
				
				?>

				<tr>
                                            <td>
                                            
				<?php

					if(file_exists('product-images/'.$row->id.'-1.png')){ $ext = 'png'; } else 
					if(file_exists('product-images/'.$row->id.'-1.jpg')){ $ext = 'jpg'; } else 
					{ $ext = 'gif'; }
				?>
			
				<img style="width:80px" src="<?= DOMAIN ?>/product-images/<?= $row->id ?>-1.<?= $ext ?>" alt="<?= $row->title ?>">


                                            </td>
                                            <td>
					    
					<?php $html .= "<tr><td>".$row->title."</td>"; ?>
					    
					    <?php if(basename($_SERVER['SCRIPT_NAME']) == 'basket.php'){ ?>
					    
					<a href="product-details.php?id=<?= $row->id ?>&p=<?= urlencode(strtolower($row->title)) ?>&added=true"><?= $row->title ?></a>
					    
					    <?php } else { print $row->title; } ?>
					    
                                            </td>
                                            <td>
					    
					<?php $html .= "<td>".$row->quantity."</td>"; ?>
					    
					<?php if(basename($_SERVER['SCRIPT_NAME']) == 'basket.php'){ ?>
					    
                                                <input name="quantity-<?= $row->cart_id ?>" type="number" value="<?= $row->quantity ?>" class="form-control">
						
					<?php } else { print $row->quantity; } ?>
						
                                            </td>
                                            <td><?php include('includes/format-price.php'); ?></td>

                                        <td>
					
					<?php if($row->cart_member_type == 2){
					
						print "£".number_format(($row->cart_price * $row->discount * $row->quantity), 2);  $html .= "<td style='text-align:right'>£".number_format(($row->cart_price * $row->discount * $row->quantity), 2)."</td></tr>";
					
					} else { print "£".number_format(($row->cart_price * $row->discount * $row->quantity * 1.2), 2);  $html .=  "<td style='text-align:right'>£".number_format(($row->cart_price * $row->discount * $row->quantity * 1.2), 2)."</td></tr>"; }
					
					?>
					

					
					
				</td>
					    
					    
				
                                            <td><?php if(basename($_SERVER['SCRIPT_NAME']) == 'basket.php'){ ?> <a href="basket.php?delete=<?= $row->cart_id ?>"><i class="fa fa-trash-o"></i></a> <?php } ?>
                                            </td>
                                        </tr>
					
				</form>
					
				<?php } ?>

                                    </tbody>
                                    <tfoot>
				
				<?php if(basename($_SERVER['SCRIPT_NAME']) == 'basket.php'){ ?>
				    
                                        <tr>
                                            <th colspan="1"><strong>Shipping</strong></th>
                                            <th colspan="5">
				<form id="shipping_form" action="" method="post">
				<select id="shipping" name="shipping" class="form-control">
				
					<optgroup label="UK">
				
						<option value="0" <?php if($cartObj->shipping() == '0'){ print 'selected'; } ?>>Royal mail 1st class post - £0.00</option>
						<option value="3" <?php if($cartObj->shipping() == '3'){ print 'selected'; } ?>>Royal mail 1st class signed for post - £3.00</option>
						<option value="8.50" <?php if($cartObj->shipping() == '8.50'){ print 'selected'; } ?>>DHL UK Tracked &amp; Signed (next day) - £8.50</option>
					
					</optgroup>
					
					<optgroup label="Europe">
				
						<option value="12" <?php if($cartObj->shipping() == '12'){ print 'selected'; } ?>>Royal Mail International Tracked &amp; Signed (2-5 days) - £12.00</option>
						<option value="18" <?php if($cartObj->shipping() == '18'){ print 'selected'; } ?>>DHL Europe Tracked &amp; Signed (1-3 days) - £18.00</option>
					
					</optgroup>
					
					<optgroup label="Rest of World">
				
						<option value="35" <?php if($cartObj->shipping() == '35'){ print 'selected'; } ?>>DHL Rest of World Tracked &amp; Signed (3-5 days) - £35.00</option>
					
					</optgroup>
				
				</select>
				</form>
				
				</th>
                                        </tr>
				
				<?php } ?>
					
				<?php $html .= "<tr><td colspan='4'>&nbsp;</td></tr>"; ?>
				
				<?php $html .= "<tr><td colspan='3'><strong>Sub Total</strong></td><td style='text-align:right'>"; ?>	
					
                                        <tr>
                                            <th colspan="4"><strong>Sub Total</strong></th>
                                            <th colspan="2">£<?php if(isset($user->auth()->member_type) && $user->auth()->member_type == 2){ print number_format( ( $cartObj->subTotal() * $cartObj->discount() ), 2); $html .= "£".number_format( ( $cartObj->subTotal() * $cartObj->discount() ), 2); } else { print number_format( ( $cartObj->subTotal() * $cartObj->discount() * 1.2 ), 2);  $html .= "<strong>£".number_format( ( $cartObj->subTotal() * $cartObj->discount() * 1.2 ), 2)."</strong>"; } ?></th>
                                        </tr>
					
				<?php $html .= "<td></tr>"; ?>
					
				<?php if( $user->auth() && $user->auth()->member_type == 2 ){ ?>
				
				<?php $html .= "<tr><td colspan='3'><strong>VAT</strong></td><td style='text-align:right'>"; ?>
				
				<tr>
                                            <th colspan="4"><strong>VAT</strong></th>
                                            <th colspan="2">£<?= number_format($cartObj->subTotal() * $cartObj->discount() * 0.2, 2); $html .= "<strong>£".number_format($cartObj->subTotal() * $cartObj->discount() * 0.2, 2)."</strong>"; ?></th>
                                        </tr>
					
				<?php $html .= "<td></tr>"; ?>
					
				<?php } ?>
					
				<?php $html .= "<tr><td colspan='3'><strong>Shipping</strong></td><td style='text-align:right'>"; ?>
					
				<tr>
                                            <th colspan="4"><strong>Shipping</strong></th>
                                            <th colspan="2">£<?= number_format($cartObj->shipping(), 2); $html .= "<strong>£".number_format($cartObj->shipping(), 2)."</strong>"; ?></th>
                                        </tr>
					
				<?php $html .= "<td></tr>"; ?>
				
				<?php $html .= "<tr><td colspan='3'><strong>Total</strong></td><td style='text-align:right'>"; ?>
					
				<tr>
                                            <th colspan="4"><strong>Total</strong></th>
                                            <th colspan="2">£<?= number_format($cartObj->total(), 2); $html .= "<strong>£".number_format($cartObj->total(), 2)."</strong>"; ?></th>
                                        </tr>
					
				<?php if($orderObj->isHundred()){ ?>
				
				<?php $html .= "<tr><td colspan='3'><strong>CONGRATULATIONS, YOU ARE THE ".addOrdinalNumberSuffix($orderObj->countOrders()+1)." ORDER !! </strong></td><td style='text-align:right'>"; ?>
				
				<tr>
                                            <th colspan="4"><strong style="color:#ff0000"><?php print  basename($_SERVER['SCRIPT_NAME']) == "basket.php" ? "CONGRATULATIONS, YOU'LL BE THE ".addOrdinalNumberSuffix($orderObj->countOrders()+1)." ORDER !!" : "CONGRATULATIONS, YOU ARE THE ".addOrdinalNumberSuffix($orderObj->countOrders())." ORDER !!"; ?></strong></th>
                                            <th colspan="2" style="color:#ff0000">- £50.00  <?php $html .= "<strong>- £50.00</strong>"; ?>  </th>
                                        </tr>
					
				<?php $html .= "<td></tr>"; ?>
				
				<?php $html .= "<tr><td colspan='3'><strong>New Total</strong></td><td style='text-align:right'>"; ?>
					
				<tr>
                                            <th colspan="4"><strong>New Total</strong></th>
                                            <th colspan="2"><strong>£<?= number_format($cartObj->newTotal(), 2); $html .= "<strong>£".number_format($cartObj->newTotal(), 2)."</strong>"; ?></strong></th>
                                        </tr>
					
					<?php $html .= "<td></tr>"; ?>
				
				<?php } ?>	
				
                                    </tfoot>
                                </table>

                            </div>
                            <!-- /.table-responsive -->
			    
			<?php $html .= "</table>"; ?>
			    
			    
			    
			    
			    
			    
			    
			    
			    
			    
			    
			    