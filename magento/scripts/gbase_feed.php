<?php
   /**
* Google Based Catalog Feed 
* 
* 
* Licensed under the MIT license.
* Copyright 2013 Zaria Ruiz
* https://github.com/zruiz
*/
	define('SAVE_FEED_LOCATION','var/export/google_base_feed.txt');//you can set a new folder and file if you want, don't forget to chmod the folder to 777

	// make sure we don't time out
	set_time_limit(0);	

	require_once 'app/Mage.php';
        Mage::app('default');
        
	try{
		$handle = fopen(SAVE_FEED_LOCATION, 'w');

		
		$heading = array('Unique Internal Code','Product Name','Product Description', 'Stock Status','Image URL', 'Product URL', 'Product Price','Category', 'Condition', 'MPN', 'Shipping Weight', 'Manufacturer', 'Payment Type', 'Promotional Message', 'Size', 'Quantity', 'Keywords', 'MSRP', 'UPC Code');
		$feed_line=implode("\t", $heading)."\r\n";
		fwrite($handle, $feed_line);
		
		//---------------------- GET THE PRODUCTS	
		$products = Mage::getModel('catalog/product')->getCollection();
		$products->joinField(
			'qty',
			'cataloginventory/stock_item',
			'qty',
			'product_id=entity_id',
			'{{table}}.stock_id=1',
			'left'
			);
		$products->addAttributeToFilter('status', 1);//enabled
		$products->addAttributeToFilter('visibility', 4);//catalog, search
		//$products->addAttributeToFilter('qty', array('gt' => 0));//inventory > 0
		$products->addAttributeToFilter('qty', array('gteq' => 1));
		$products->addAttributeToSelect('*');
		$prodIds=$products->getAllIds();
		
		$product = Mage::getModel('catalog/product');
		
		foreach($products as $product) {   
		    		    
		if ($product->getQty() != 0) {				
		    $product_data = array();	
		    $product_data['Unique Internal Code']=$product->getSku();	
		    $product_data['Product Name']=$product->getName();
		    $product_data['Product Description']=$product->getDescription();
			$product_data['Stock Status']='y';
		    $product_data['Image URL']=Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA).'catalog/product'.$product->getImage();
			$product_data['Product URL']=$product->getProductUrl();
		    $product_data['Product Price']=$product->getPrice();
		    $product_data['Category']='Food, Beverages & Tobacco > Tobacco Products';	
            $product_data['Condition']='new';	
            $product_data['MPN']=$product->getSku();
            $product_data['Shipping Weight']='1';	
            //get the product brands            		
            foreach($product->getCategoryIds() as $_categoryId){
			 $category = Mage::getModel('catalog/category')->load($_categoryId);
			 $product_data['Manufacturer']=$category->getName();
		    }
		    $product_data['Manufacturer']=rtrim($product_data['Manufacturer'],', ');	
			//$product_data['Manufacturer']='Cigars';		
            $product_data['Payment Type']='Visa, MasterCard, AmericanExpress, Discover';
            $product_data['Promotional Message']='Free Shipping Over $150';			
			$product_data['Size']=$product->getResource()->getAttribute('size')->getFrontend()->getValue($product);
			$product_data['Quantity']=$product->getResource()->getAttribute('quantity')->getFrontend()->getValue($product);
			$product_data['Keywords']=$product->getResource()->getAttribute('meta_keyword')->getFrontend()->getValue($product);
			$product_data['MSRP']=$product->getResource()->getAttribute('msrp')->getFrontend()->getValue($product);
			$product_data['UPC Code']='';
		}
		    		
		    //sanitize data	
		    foreach($product_data as $k=>$val){
			$bad=array('"',"\r\n","\n","\r","\t");
			$good=array(""," "," "," ","");
			$product_data[$k] = '"'.str_replace($bad,$good,$val).'"';
		    }
			
		    $feed_line .= implode("\t", $product_data)."\r\n";
		    
		}
		
		header("Cache-control: private");
		header("Content-type: txt/plain");
	    header("Content-Disposition: attachment; filename=CPCSfeed.txt");
		header("Pragma: public");
		echo $feed_line;
		
		//---------------------- WRITE THE FEED	
				
	}
	catch(Exception $e){
		die($e->getMessage());
	}

?>