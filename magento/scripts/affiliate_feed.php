<?php
   /**
* CJ Catalog Feed 
* An affiliate program Catalog Feed
* 
* Licensed under the MIT license.
* Copyright 2013 Zaria Ruiz
* https://github.com/zruiz
*/
	define('SAVE_FEED_LOCATION','var/export/affiliate_base_feed.txt');//you can set a new folder and file if you want, don't forget to chmod the folder to 777

	// make sure we don't time out
	set_time_limit(0);	

	require_once 'app/Mage.php';
        Mage::app('default');
        
	try{
		$handle = fopen(SAVE_FEED_LOCATION, 'w');
        $time = date("m/d/Y H:i:s");
		$heading = '&CID=3982297';
		$heading .= "\n";
		$heading .= '&SUBID=132530';
		$heading .= "\n";
		$heading .= '&PROCESSTYPE=OVERWRITE';
		$heading .= "\n";
		$heading .= '&AID=11347561';
		$heading .= "\n";
        $heading .= '&PARAMETERS=NAME|KEYWORDS|DESCRIPTION|SKU|BUYURL|AVAILABLE|IMAGEURL|PRICE|RETAILPRICE|UPC|PROMOTIONALTEXT|ADVERTISERCATEGORY|MANUFACTURER|CONDITION|THIRDPARTYCATEGORY';

		$feed_line=$heading."\r\n";
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
		
	    $i = 0;
		foreach($products as $product) {   
		$i = $i + 1;    		    
		if ($product->getQty() != 0 and $product->getSku() !='MISC') {				
		    $product_data = array();	
		    $product_data['Name']=$product->getName();
			$product_data['Keywords']=$product->getResource()->getAttribute('meta_keyword')->getFrontend()->getValue($product);
			$descrip1 = explode('<hr />', $product->getDescription());
			$descrip2 = explode('<hr/>', $product->getDescription());
		    if ($descrip1[0] != '')
			  { $product_data['Description']= $descrip1[0];}
			else { $product_data['Description']= $descrip2[0];}  
			$product_data['SKU']=$product->getSku();
			$product_data['BuyURL']=$product->getProductUrl();
			$product_data['Available']='yes';
		    $product_data['ImageURL']=Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA).'catalog/product'.$product->getImage();
			$product_data['Price']=number_format($product->getPrice(),2);
			$product_data['RetailPrice']=number_format($product->getResource()->getAttribute('msrp')->getFrontend()->getValue($product),2);
			$product_data['UPC']=$product->getId();
			$product_data['PromotionalText']='Free Shipping Over $150';	
		    $product_data['AdvertiserCategory']='Tobacco Products';	
			 //get the product brands            		
            foreach($product->getCategoryIds() as $_categoryId){
			 $category = Mage::getModel('catalog/category')->load($_categoryId);
			 $product_data['Manufacturer']=$category->getName();
		    }
		    $product_data['Manufacturer']=rtrim($product_data['Manufacturer'],', ');	
            $product_data['Condition']='new';	
			
			//get the product categories            		
            foreach($product->getCategoryIds() as $_categoryId){
			 $category = Mage::getModel('catalog/category')->load($_categoryId);
			 		 
			 //$_category = rtrim($category->getName());
             $_parent = rtrim($category->getParentCategory()->getName());
			 
			 if (($_parent == 'Default Category') or ($_parent == 'Search') or ($_parent == 'Cigars') or ($_parent == 'LAP Deal')) {
			 }
			 else {$product_data['ThirdPartyCategory'] = $category->getParentCategory()->getName().', ';}
			           		 
		    }
			
		    $product_data['ThirdPartyCategory']=rtrim($product_data['ThirdPartyCategory'],', ');	
            			
		}
		    		
		    //sanitize data	
		    foreach($product_data as $k=>$val){
			$bad=array('"',"\r\n","\n","\r","\t","<strong>","</strong>","<br />","<br/>","<p>","</p>","&nbsp;","&ldquo;");
			$good=array(""," "," "," ","");
			if ($k == "Name" or $k == "Keywords" or $k == "Description") {
			$product_data[$k] = '"'.str_replace($bad,$good,$val).'"'; 
			} else {$product_data[$k] = str_replace($bad,$good,$val);}
		    }
			
            if ($i != $products->getSize()){
		     $feed_line .= implode(",", $product_data)."\r\n";
		    } else {$feed_line .= implode(",", $product_data);}
			
			
		}
		
		header("Cache-control: private");
		header("Content-type: txt/plain");
	    header("Content-Disposition: attachment; filename=CJCatalogfeed.csv");
		header("Pragma: public");
		echo $feed_line;
		
		//---------------------- WRITE THE FEED	
		
		
	}
	catch(Exception $e){
		die($e->getMessage());
	}

