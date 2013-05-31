<?php

   /**
* Magento Orders Feed 
* 
* 
* Licensed under the MIT license.
* Copyright 2013 Zaria Ruiz
* https://github.com/zruiz
*/

	define('SAVE_FEED_LOCATION','var/export/orders_feed.txt');//you can set a new folder and file if you want, don't forget to chmod the folder to 777

	// make sure we don't time out
	set_time_limit(0);	

	require_once 'app/Mage.php';
        Mage::app('default');
        
	try{
		$handle = fopen(SAVE_FEED_LOCATION, 'w');

		
		$heading = array('customer_id','order_no','order_date','grand_total','sub_total','tax_amount','shipping_amount','discount_amount','shipping_method');
		$feed_line=implode(",", $heading)."\r\n";
		fwrite($handle, $feed_line);
		
		
		//---------------------- GET THE PRODUCTS	
		$orders = Mage::getModel('sales/order')->getCollection();
		
		$orders->addAttributeToSelect('*');
		$ordIds=$orders->getAllIds();
				
		foreach($ordIds as $ordId) {
		    
	        $order = Mage::getSingleton('sales/order');
		    $order->load($ordId);
		    
			$_totalData = $order->getData();
			$_date = $_totalData['created_at'];
			$_grand = number_format($_totalData['grand_total'],2);
			$_sub = number_format($_totalData['subtotal'],2);
			$_tax = number_format($_totalData['tax_amount'],2);
			$_shipping = number_format($_totalData['shipping_amount'],2);
			$_discount = number_format($_totalData['discount_amount'],2);
			
			$_amount = $_sub + $_discount;
			
			$amount = number_format($_amount,2);			
			
		    $ord_data = array();	
		    
			$customerId = $order->getCustomerId();
			if ($customerId){
						
			$ord_data['customer_id']=$customerId;
			$ord_data['order_no']=$order->getIncrementId();
		    $ord_data['order_date']=$_date;
		    $ord_data['grand_total']=$_grand;
			$ord_data['sub_total']=$_sub;
		    $ord_data['tax_amount']=$_tax;
			$ord_data['shipping_amount']=$_shipping;
			$ord_data['discount_amount']=$_discount;
					
		    //$_payment = $order->getPayment();
			//$_method = $_payment->getMethod();
			//if ($_method == 'authorizenetcim'): 
            //    $ord_data['payment_method'] = $_payment->getCcType();
			    
			//else: 
			//if ($_method == 'checkmo'): 
            //    $ord_data['payment_method'] = 'Check / Money order';
			// else: 
			//  $ord_data['payment_method'] ='Paypal';
			//endif; 
			//endif; 
			
			
			$ord_data['shipping_method']=str_replace('Select Shipping Method -', '', $order->getShippingDescription());
													   	  		    			
		    //sanitize data	
		    foreach($ord_data as $k=>$val){
			$bad=array('"',"\r\n","\n","\r","\t");
			$good=array(""," "," "," ","");
			$ord_data[$k] = '"'.str_replace($bad,$good,$val).'"';
		    }
			
		    $feed_line .= implode(",", $ord_data)."\r\n";
		    
			} 
			
			
			
		}

		header("Cache-control: private");
		header("Content-type: txt/plain");
	    header("Content-Disposition: attachment; filename=OrderFeed.csv");
		header("Pragma: public");
		echo $feed_line;
		
		//---------------------- WRITE THE FEED	
				
	}
	catch(Exception $e){
		die($e->getMessage());
	}

