<?php
   /**
* Magento Items Feed 
* 
* 
* Licensed under the MIT license.
* Copyright 2013 Zaria Ruiz
* https://github.com/zruiz
*/
	define('SAVE_FEED_LOCATION','var/export/items_feed.txt');//you can set a new folder and file if you want, don't forget to chmod the folder to 777

	// make sure we don't time out
	set_time_limit(0);	

	require_once 'app/Mage.php';
        Mage::app('default');
        
	try{
		$handle = fopen(SAVE_FEED_LOCATION, 'w');
		
		$heading = array('order_no','sku','description','category','type','qty','price');
		$feed_line=implode(",", $heading)."\r\n";
		fwrite($handle, $feed_line);
		
		
		//---------------------- GET THE PRODUCTS	
		$orders = Mage::getModel('sales/order')->getCollection();
		
		$orders->addAttributeToSelect('*');
		$ordIds=$orders->getAllIds();
		
		foreach($ordIds as $ordId) {
		    	        
		    $order = Mage::getModel('sales/order')->load($ordId);
		    
			$customerId = $order->getCustomerId();
			
			if ($customerId){
			
			$_orderId = $order->getIncrementId();
			$item_data = array();
			
			foreach ($order->getItemsCollection() as $item){ 
			
			$item_data['order_no']= $_orderId;
			$item_data['sku']=$item->getSku(); 
		    $item_data['description']=$item->getName();
			
			$productId = $item->getProductId();
			
			$_product = Mage::getModel('catalog/product')->load($productId);
			$cats = $_product->getCategoryIds();
			$category_id = $cats[0]; // just grab the first id
			$category = Mage::getModel('catalog/category')->load($category_id);
			$category_name = $category->getName();
	        
			$item_data['category']=$category_name;
			
			$_type = $_product->getResource()->getAttribute('type')->getFrontend()->getValue($_product);
			
			if ($_type == 'No') { $item_data['type']= 'No Cigar';} 
			else {$item_data['type']=$_type;}
								 
			$item_data['qty']=$item->getQtyOrdered(); 
			$item_data['price']=$item->getPrice();    			
            
			//sanitize data	
		    foreach($ord_data as $k=>$val){
			$bad=array('"',"\r\n","\n","\r","\t");
			$good=array(""," "," "," ","");
			$item_data[$k] = '"'.str_replace($bad,$good,$val).'"';
		    }
			
		    $feed_line .= implode(",", $item_data)."\r\n";
		    
			} 
			
			} 
			
		}

		header("Cache-control: private");
		header("Content-type: txt/plain");
	    header("Content-Disposition: attachment; filename=ItemsFeed.csv");
		header("Pragma: public");
		echo $feed_line;
		
		//---------------------- WRITE THE FEED	
				
	}
	catch(Exception $e){
		die($e->getMessage());
	}

