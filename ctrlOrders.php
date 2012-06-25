<?php

//require_once('FirePHPCore/lib/FirePHPCore/FirePHP.class.php');
//$firephp = FirePHP::getInstance(true);
//ob_start(); // Starts FirePHP output buffering

require_once("local_config/config.php");
require_once("inc/database.php");
require_once("utilities.php");
require_once("utilities_orders.php");


if (!isset($_SESSION)) {
    session_start();
}

try{
	

    switch (get_param('oper')) {
    	
    	//returns a list of all orders summarized by provider within a given date range
    	case 'getOrdersListing':
    		echo get_orders_in_range(get_param('filter'), get_param('uf_id',0));
    		exit; 
    	
    	//returns a list of all orders for the given uf
    	case 'getOrdersListingForUf':
    		echo get_orders_in_range(get_param('filter'), get_session_user_id());
    		exit; 

    	//retrieves list of products that have been ordered
    	case 'getOrderedProductsList':
    		printXML(stored_query_XML_fields('get_ordered_products_list', get_param('order_id')));
    		exit;

    	//retrieves the order detail uf/quantities for given order
    	case 'getProductQuantiesForUfs':
    		printXML(stored_query_XML_fields('get_order_item_detail', get_param('order_id')));
    		exit;
    		
    	//edits, modifies individual product quanties for order
    	case 'editQuantity':
    		$splitParams = explode("_", get_param('product_uf'));
    		$ok = do_stored_query('modify_order_item_detail', get_param('order_id'), $splitParams[0], $splitParams[1] , get_param('quantity'));
    		if ($ok){
	    		echo get_param('quantity');
    		} else {
    			throw new Exception("An error occured during saving the new quantity!!");      			
    		}
    		exit;
    		
    	case 'setOrderItemStatus':
    		echo do_stored_query('set_order_item_status', get_param('order_id'), get_param('product_id'), get_param('has_arrived'), get_param('is_revised')  ); 
    		exit;

    	//have the given order items be already validated?
    	case 'checkValidationStatus':
    		printXML(stored_query_XML_fields('get_validated_status', get_param('order_id',0), get_param('cart_id',0)));
    		exit;
    		
		//moves an order from revision to shop_item (into people's cart for the given date) 
    	case 'moveOrderToShop':
    		echo do_stored_query('move_order_to_shop', get_param('order_id'), get_param('date'));
    		exit;
    		
    	
  		case 'getDiffOrderShop':
    		printXML(stored_query_XML_fields('diff_order_shop', get_param('order_id'), get_session_user_id()));    	
  			exit;
    		
    		
    default:  
    	 throw new Exception("ctrlOrders: oper={$_REQUEST['oper']} not supported");  
        break;
    }


} 

catch(Exception $e) {
    header('HTTP/1.0 401 ' . $e->getMessage());
    die ($e->getMessage());
}  


?>