<?php

class ProductsFromOrder extends ObjectModel{

		protected $table = 'products_from_order';
		protected $fillable = ['order_id', 'product_id', 'quantity', 'price', 'title', 'discount'];

		public $product_id;
		public $quantity;
		public $price;
		public $title;
		public $discount;
		public $order_id;

		public function __construct(Cart $cart){

			$this->cart = $cart;	/* CART OBJECT */
		
		}
		
		
		public function getAll($order_id){
		
			return $this->execute("SELECT * FROM products_from_order WHERE products_from_order.order_id = ?  ", [$order_id] );		
		
		}
		
		
		public function addOrderProducts($order_id){
		
				foreach( $this->cart->getAll() as $cart_row ){
				
					$this->order_id = $order_id;
					$this->product_id = $cart_row->product_id;
					$this->quantity = $cart_row->quantity;
					$this->price = $cart_row->cart_price;
					$this->title = $cart_row->title;
					$this->discount = $cart_row->discount;
					
					$this->add();
				
				}
		
		}

}