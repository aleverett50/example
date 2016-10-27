<?php

class Order extends ObjectModel{

		protected $table = 'orders';
		protected $fillable = ['user_id', 'shipping', 'cost', 'is_hundred'];
		
		public $user_id;
		public $shipping;
		public $cost;
		public $order_id;
		
		protected $user;
		protected $cart;
		protected $productsFromOrder;

		public function __construct(User $user, Cart $cart, ProductsFromOrder $productsFromOrder){
		
			$this->user = $user;	/* USER OBJECT */
			$this->cart = $cart;	/* CART OBJECT */
			$this->productsFromOrder = $productsFromOrder;	/* PRODUCTS_FROM_ORDER OBJECT */
		
		}

	
		public function getAll($status){
			
			if( $status == 'All' ){
				
				/*  IF CUSTOMER IS VIEWING ORDERS  */
			
			return $this->execute("SELECT *, orders.id AS order_id, orders.created_at AS order_date FROM orders WHERE user_id = ? AND deleted_at IS NULL AND status != 'Pending' ORDER BY id DESC ", [$this->user->auth()->id]);
			
			} else {
			
				/*  IF ADMIN IS VIEWING ORDERS  */
		
			return $this->execute("SELECT *, orders.id AS order_id, orders.created_at AS order_date FROM orders LEFT JOIN users ON users.id = orders.user_id WHERE orders.status = ? AND orders.deleted_at IS NULL AND orders.status != 'Pending'  ORDER BY orders.id DESC  ", [$status] );

			}
		
		}
		
		public function getOrderNumber(){
		
			if( isset($_COOKIE[SALT.'order_number']) && $_COOKIE[SALT.'order_number'] != '' && $_COOKIE[SALT.'order_number'] != null ){
			
				return $_COOKIE[SALT.'order_number'];
			
			}
			
			if( isset($_SESSION[SALT.'order_number']) && $_SESSION[SALT.'order_number'] != '' && $_SESSION[SALT.'order_number'] != null ){
			
				return $_SESSION[SALT.'order_number'];
			
			}
			
			return false;		
		
		}
		
		
		public function getOrderDescription(){
		
				$description = '';
	
				$i = 0;

				foreach( $this->cart->getAll() as $row ){
				
					$description .= $i == 0 ? $row->quantity.' X '.$row->title : ' : '.$row->quantity.' X '.$row->title;
					
				$i++;
				
				}
				
				return $description;
		
		}
		
		
		public function getOrderEmailHtml(){
		
			if(isset($_SESSION[SALT.'order-for-email'])){
			
				return $_SESSION[SALT.'order-for-email'];
			
			}
			
			return NULL;
		
		}
		
		
		public function setOrderToCompleted($order_number, $redirect){
		
			$this->updateRow($this->table, ['status' => 'New'], 'order_number = :order_number LIMIT 1 ', [ 'order_number' => $order_number ] );
			
			$this->updateStock($order_number);

			$this->emailOrder($order_number);
			
			if( $redirect ){
			
				return redirect( 'complete.php');
			
			}
		
		}
		
		
		public function updateStock($order_number){
		
			$this->id = $order_number - 100000;
			
			$query = $this->execute("SELECT * FROM products_from_order WHERE order_id = ? AND deleted_at IS NULL ", [$this->id]);
			
			foreach( $query as $row ){
			
				$stock = $this->execute("SELECT * FROM products WHERE id = ?  ", [$row->product_id])[0]->stock_amount;

				Mail::send('alexe@wts-group.com', $stock, 'Product ID: '.$row->product_id, COMPANY_NAME);
			
				$this->updateRow('products', ['stock_amount' => $stock - $row->quantity], 'id = :id LIMIT 1 ', [ 'id' => $row->product_id ] );
			
			}
		
		}
		
		
		public function emailOrder($order_number){
		
			$this->id = $order_number - 100000;				/* ORDER ID */
			
			$order_row = $this->find($this->id);				/* ROW WITH ORDER DETAILS */
			
			$user_row = $this->user->find($order_row->user_id);	/* ROW WITH USER DETAILS */
			
			$html = "<p>Dear ".ucwords($user_row->first_name).",<br /><br />Thank you for your order. Your order number is ".$order_number.".<br /><br />Please see below details of your order.<br /><br /></p>";
		
			$html .= @file_get_contents('cache/'.$order_number.'.txt');
			
			Mail::send(trim($user_row->email), $html, 'Order Confirmation - '.$order_number, COMPANY_NAME);
			
			$shipping_type = '';
			
			if($order_row->shipping == "0.00"){ $shipping_type = 'Royal mail 1st class post'; } else 
			if($order_row->shipping == "3.00"){ $shipping_type = 'Royal mail 1st class signed for post'; } else 
			if($order_row->shipping == "12.00"){ $shipping_type = 'Royal Mail International Tracked &amp; Signed (2-5 days)'; } else 
			if($order_row->shipping == "18.00"){ $shipping_type = 'DHL Europe Tracked &amp; Signed (1-3 days)'; } else 
			if($order_row->shipping == "35.00"){ $shipping_type = 'DHL Rest of World Tracked &amp; Signed (3-5 days)'; }

			
	$html .= "Shipping Type: ".$shipping_type." <br /><br /><center>----------------------------</center><br /><br />".$user_row->first_name." ".$user_row->last_name."<br />".$user_row->address_1."<br />".$user_row->address_2."<br />".$user_row->town."<br />".$user_row->postcode;
			
			Mail::send('sales@', $html, 'Order Confirmation - '.$order_number, COMPANY_NAME);
		
		}
		
		
		public function emailStatus($order_number){
		
			$this->id = $order_number - 100000;				/* ORDER ID */
			
			$order_row = $this->find($this->id);				/* ROW WITH ORDER DETAILS */
			
			$user_row = $this->user->find($order_row->user_id);	/* ROW WITH USER DETAILS */
			
			$html = "<p>Dear ".ucwords($user_row->first_name).",<br /><br />Your order ".$order_number." has been dispatched to;<br /><br />".$user_row->first_name." ".$user_row->last_name."<br />".$user_row->address_1."<br />".$user_row->address_2."<br />".$user_row->town."<br />".$user_row->postcode."<br /><br /></p>";
		
			$html .= @file_get_contents('../cache/'.$order_number.'.txt');
			
			Mail::send(trim($user_row->email), $html, 'Order Dispatched - '.$order_number, COMPANY_NAME);
			
			$this->updateRow($this->table, ['is_dispatched' => 1], 'id = :id', [ 'id' => $this->id ] );
			
			return redirect( 'account.php?page=orders&status=Completed', 'The dispatched email has been sent' );
		
		}
		
		
		public function createOrder($payment_type){
		
			if(!isset($_POST['terms_check'])){
			
				return redirect( 'checkout.php', 'You must agree to our terms and conditions', 'e' );
			
			}
		
			if( $this->user->auth() ){
			
				$this->user->updateCustomerFromCheckout( array('password') );	/* PASS THE RULES TO UNSET ON USER CLASS */
				
				$this->user_id = $this->user->auth()->id;
			
			} else {
			
				$this->user_id = $this->user->add();
				
			}
				
				$this->is_hundred = $this->isHundred() ? 1 : 0;
				$this->shipping = $this->cart->shipping();
				$this->cost = $this->cart->total();
				
				if($this->is_hundred){
				
					$this->cost = $this->cost - 50;
				
				}
				
				if( $this->cost < 0 ){
				
					$this->cost = 0;
				
				}
				
				$this->order_id = $this->add();
				
				$order_number = $this->order_id + 100000;
				
				$this->updateRow($this->table, ['order_number' => $order_number], 'id = :id', [ 'id' => $this->order_id ] );

				$this->productsFromOrder->addOrderProducts($this->order_id);
				
				$_SESSION[SALT.'order_number'] = $order_number;
				setcookie(SALT.'order_number', $order_number, time()+7200);
				$_SESSION[SALT.'name'] = $_POST['first_name'].' '.$_POST['last_name'];
				$_SESSION[SALT.'add1'] = $_POST['address_1'];
				$_SESSION[SALT.'add2'] = $_POST['address_2'];
				$_SESSION[SALT.'town'] = $_POST['town'];
				$_SESSION[SALT.'postcode'] = $_POST['postcode'];
				$_SESSION[SALT.'email'] = $_POST['email'];
				$_SESSION[SALT.'phone'] = $_POST['phone'];
				
				$file_open = fopen("cache/$order_number.txt", "w");  //  Write a file with cart HTML
				fwrite($file_open, $this->getOrderEmailHtml());
				
				return redirect( 'payment.php?payment_type='.$payment_type );
		
		}
		
		
		public function updateStatus($id){
		
			$this->updateRow($this->table, ['status' => $_POST['status']], 'id = :id LIMIT 1 ', [ 'id' => $id ] );
			
			return redirect( 'account.php?page=orders&status='.$_POST['status'], 'The order has been updated' );
		
		}
		
		public function canView($id){
		
			$row = $this->find($id);
			
			if( $row->user_id !== $this->user->auth()->id ){
				
				return false;
			
			}
			
			if( $row->status == 'Pending' ){
				
				return false;
			
			}
			
			return true;
		
		}
		
		
		public function countOrders(){
		
			$query = $this->execute("SELECT * FROM orders WHERE status != ? AND deleted_at IS NULL  ", ['Pending']);
			
			return count($query);
		
		
		}
		
		
		public function isHundred(){
		
			$countOrders = $this->countOrders();
			
			if( basename($_SERVER['SCRIPT_NAME']) == 'complete.php' ){
				
				$isZero = $countOrders % 100;
			
			} else {
			
				$isZero = ($countOrders+1) % 100;
			
			}
			
			if( !$isZero && $countOrders > 0 ){
			
				return true;
			
			}
			
			return false;			
		
		}
		
		
		public function getOrderSubTotal($order_id){
		
		$subTotal = 0;
		
			$query = $this->productsFromOrder->getAll($order_id);
			
			foreach( $query as $row ){
			
				$subTotal += ($row->quantity * $row->price * $row->discount);
			
			}
			
			return $subTotal;
		
		}
		
		
		public function countPreviousOrders($order_id){
		
			$query = $this->execute("SELECT * FROM orders WHERE id < ? AND deleted_at IS NULL AND status != 'Pending'  ", [$order_id]);
			
			return addOrdinalNumberSuffix(count($query)+1);
		
		
		}



}







