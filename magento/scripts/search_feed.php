<?php
   /**
* Magento Products Feed 
* 
* 
* Licensed under the MIT license.
* Copyright 2013 Zaria Ruiz
* https://github.com/zruiz
*/

	define('SAVE_FEED_LOCATION','var/export/SearchSpringfeed_temp.csv');//you can set a new folder and file if you want, don't forget to chmod the folder to 777
    
	// make sure we don't time out
	set_time_limit(0);	

	require_once 'app/Mage.php';
        Mage::app('default');
        
	try{
		
		$tmpfname = tempnam($_ENV['DOCUMENT_ROOT'].'/var/export', 'FOO');
		$handle = fopen($tmpfname, 'w');
		
		$heading = array('id', 'sku','name','description','sdescription','imageUrl', 'productUrl', 'price', 'msrp', 'type', 'package_type', 'country_origin', 'shape', 'length', 'ring_gauge', 'strength', 'wrapper_color', 'wrapper_origin', 'flavor', 'tube', 'e_flavor', 'e_type', 'left_marketing_image', 'right_marketing_image', 'free_shipping', 'qty', 'availability', 'savings', 'reviewrating', 'reviewcount', 'category', 'parent_category');
		$feed_line=implode(",", $heading)."\r\n";
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
		//$products->addAttributeToFilter('qty', array('gteq' => 1));
		$products->addAttributeToSelect('*');
		$prodIds=$products->getAllIds();
		
		$product = Mage::getModel('catalog/product');
		
		foreach($products as $product) {   
		    		    			
		    $product_data = array();	
		    $product_data['id']=$product->getId();
		    $product_data['sku']=$product->getSku();	
		    $product_data['name']=$product->getName();
		    $product_data['description']=$product->getDescription();
			$product_data['sdescription']=$product->getShortDescription();
			$product_data['imageUrl']=Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA).'catalog/product'.$product->getImage();
			$product_data['productUrl']=$product->getProductUrl();
		    if ($product->getSku() == 'GFT25') {
			  $product_data['price']=25;}
			elseif ($product->getSku() == 'GFT50') {
			  $product_data['price']=50;}
            elseif ($product->getSku() == 'GFT100') {
			  $product_data['price']=100;}
            else { $product_data['price']=$product->getPrice(); }
			
			// getting product attributes
			$product_data['msrp']=$product->getResource()->getAttribute('msrp')->getFrontend()->getValue($product);
			$product_data['type']=$product->getResource()->getAttribute('type')->getFrontend()->getValue($product);
			$product_data['package_type']=$product->getResource()->getAttribute('package_type')->getFrontend()->getValue($product);
			$product_data['country_origin']=$product->getResource()->getAttribute('country_origin')->getFrontend()->getValue($product);
			$product_data['shape']=$product->getResource()->getAttribute('shape')->getFrontend()->getValue($product);
			$product_data['length']=$product->getResource()->getAttribute('length')->getFrontend()->getValue($product);
			$product_data['ring_gauge']=$product->getResource()->getAttribute('ring_gauge')->getFrontend()->getValue($product);
			$product_data['strength']=$product->getResource()->getAttribute('strength')->getFrontend()->getValue($product);
			$product_data['wrapper_color']=$product->getResource()->getAttribute('wrapper_color')->getFrontend()->getValue($product);
			$product_data['wrapper_origin']=$product->getResource()->getAttribute('wrapper_origin')->getFrontend()->getValue($product);
			$product_data['flavor']=$product->getResource()->getAttribute('flavor')->getFrontend()->getValue($product);
			$product_data['tube']=$product->getResource()->getAttribute('tube')->getFrontend()->getValue($product);
			$product_data['e_flavor']=$product->getResource()->getAttribute('e_cigarettes_flavor')->getFrontend()->getValue($product);
			$product_data['e_type']=$product->getResource()->getAttribute('e_cigarettes_types')->getFrontend()->getValue($product);
					
			
			$pr_20_off=$product->getResource()->getAttribute('pr_20_off')->getFrontend()->getValue($product);
			$pr_25_off=$product->getResource()->getAttribute('pr_25_off')->getFrontend()->getValue($product);
			$closeout=$product->getResource()->getAttribute('closeout')->getFrontend()->getValue($product);
			$new_item=$product->getResource()->getAttribute('new_item')->getFrontend()->getValue($product);
			$free_vertigo_lighter=$product->getResource()->getAttribute('free_vertigo_lighter')->getFrontend()->getValue($product);
			$sale_price=$product->getResource()->getAttribute('sale_price')->getFrontend()->getValue($product);
			$buy_1_get_1=$product->getResource()->getAttribute('buy_1_get_1')->getFrontend()->getValue($product);
			$buy_10_get_10=$product->getResource()->getAttribute('buy_10_get_10')->getFrontend()->getValue($product);
			$buy_25_get_25=$product->getResource()->getAttribute('buy_25_get_25')->getFrontend()->getValue($product);
			$buy_40_get_10=$product->getResource()->getAttribute('buy_40_get_10')->getFrontend()->getValue($product);
			$buy_40_get_20=$product->getResource()->getAttribute('buy_40_get_20')->getFrontend()->getValue($product);
			$buy_50_get_10=$product->getResource()->getAttribute('buy_50_get_10')->getFrontend()->getValue($product);
			$buy_60_get_30=$product->getResource()->getAttribute('buy_60_get_30')->getFrontend()->getValue($product);
			$rated_90=$product->getResource()->getAttribute('rated_90')->getFrontend()->getValue($product);
			$rated_91=$product->getResource()->getAttribute('rated_91')->getFrontend()->getValue($product);
			$rated_92=$product->getResource()->getAttribute('rated_92')->getFrontend()->getValue($product);
			$rated_93=$product->getResource()->getAttribute('rated_93')->getFrontend()->getValue($product);
			$rated_94=$product->getResource()->getAttribute('rated_94')->getFrontend()->getValue($product);
			$rated_95=$product->getResource()->getAttribute('rated_95')->getFrontend()->getValue($product);
			$pack_5=$product->getResource()->getAttribute('pack_5')->getFrontend()->getValue($product);
			$off_10=$product->getResource()->getAttribute('off_10')->getFrontend()->getValue($product);
			$off_2=$product->getResource()->getAttribute('off_2')->getFrontend()->getValue($product);
			$off_5=$product->getResource()->getAttribute('off_5')->getFrontend()->getValue($product);
			$off_399=$product->getResource()->getAttribute('off_399')->getFrontend()->getValue($product);
			$off_20=$product->getResource()->getAttribute('off_20')->getFrontend()->getValue($product);
			$off_3=$product->getResource()->getAttribute('off_3')->getFrontend()->getValue($product);
			$free_hoyo=$product->getResource()->getAttribute('free_hoyo')->getFrontend()->getValue($product);
			$pack_alec=$product->getResource()->getAttribute('pack_alec')->getFrontend()->getValue($product);
			$free_cao=$product->getResource()->getAttribute('free_cao')->getFrontend()->getValue($product);
			$three_off_5=$product->getResource()->getAttribute('three_off_5')->getFrontend()->getValue($product);
			$two_off_10=$product->getResource()->getAttribute('two_off_10')->getFrontend()->getValue($product);
			$two_off_5=$product->getResource()->getAttribute('two_off_5')->getFrontend()->getValue($product);
			$two_off_6=$product->getResource()->getAttribute('two_off_6')->getFrontend()->getValue($product);
			$two_off_5_minus=$product->getResource()->getAttribute('two_off_5_minus')->getFrontend()->getValue($product);
			$three_off_5_minus=$product->getResource()->getAttribute('three_off_5_minus')->getFrontend()->getValue($product);
			$two_off_10_minus=$product->getResource()->getAttribute('two_off_10_minus')->getFrontend()->getValue($product);
			$free_ab=$product->getResource()->getAttribute('free_ab')->getFrontend()->getValue($product);
			$free_shipping_25=$product->getResource()->getAttribute('free_shipping_25')->getFrontend()->getValue($product);
			$off_6=$product->getResource()->getAttribute('off_6')->getFrontend()->getValue($product);
			$super_deal=$product->getResource()->getAttribute('super_deal')->getFrontend()->getValue($product);
			$free_acid=$product->getResource()->getAttribute('free_acid')->getFrontend()->getValue($product);
			$free_oliva=$product->getResource()->getAttribute('free_oliva')->getFrontend()->getValue($product);
			$free_ab_tempus=$product->getResource()->getAttribute('free_ab_tempus')->getFrontend()->getValue($product);
			$closeout_20=$product->getResource()->getAttribute('closeout_20')->getFrontend()->getValue($product);
			$free_don_lino=$product->getResource()->getAttribute('free_don_lino')->getFrontend()->getValue($product);
			$free_asti_humidor=$product->getResource()->getAttribute('free_asti_humidor')->getFrontend()->getValue($product);
			$free_cao_last=$product->getResource()->getAttribute('free_cao_last')->getFrontend()->getValue($product);
			$free_shipping=$product->getResource()->getAttribute('free_shipping')->getFrontend()->getValue($product);
			$fathers_day=$product->getResource()->getAttribute('fathers_day')->getFrontend()->getValue($product);
			$free_oliva_sampler=$product->getResource()->getAttribute('free_oliva_sampler')->getFrontend()->getValue($product);
			$off_25=$product->getResource()->getAttribute('off_25')->getFrontend()->getValue($product);
			$custom_1=$product->getResource()->getAttribute('custom_1')->getFrontend()->getValue($product);
			$custom_2=$product->getResource()->getAttribute('custom_2')->getFrontend()->getValue($product);
			$custom_3=$product->getResource()->getAttribute('custom_3')->getFrontend()->getValue($product);
			$custom_4=$product->getResource()->getAttribute('custom_4')->getFrontend()->getValue($product);
			$free_capri_humidor=$product->getResource()->getAttribute('free_capri_humidor')->getFrontend()->getValue($product);
			$free_ab_hendrix_lighter=$product->getResource()->getAttribute('free_ab_hendrix_lighter')->getFrontend()->getValue($product);
			$s100off=$product->getResource()->getAttribute('s100off')->getFrontend()->getValue($product);
			$items_left_3=$product->getResource()->getAttribute('items_left_3')->getFrontend()->getValue($product);
			$free_cao_gold4sm=$product->getResource()->getAttribute('free_cao_gold4sm')->getFrontend()->getValue($product);
			$free_cao_com_sm=$product->getResource()->getAttribute('free_cao_com_sm')->getFrontend()->getValue($product);
			$free_golf_ball=$product->getResource()->getAttribute('free_golf_ball')->getFrontend()->getValue($product);
			$buy3get1=$product->getResource()->getAttribute('buy3get1')->getFrontend()->getValue($product);
			$menthol_flavor_icon=$product->getResource()->getAttribute('menthol_flavor_icon')->getFrontend()->getValue($product);
			$full_flavor_icon=$product->getResource()->getAttribute('full_flavor_icon')->getFrontend()->getValue($product);
			$buy6get1=$product->getResource()->getAttribute('buy6get1')->getFrontend()->getValue($product);
			$free_gotham_lighter=$product->getResource()->getAttribute('free_gotham_lighter')->getFrontend()->getValue($product);
			$pr_10_off=$product->getResource()->getAttribute('pr_10_off')->getFrontend()->getValue($product);
			$free_butane=$product->getResource()->getAttribute('free_butane')->getFrontend()->getValue($product);
			$super_deal_o=$product->getResource()->getAttribute('super_deal_o')->getFrontend()->getValue($product);
			$buy4get1=$product->getResource()->getAttribute('buy4get1')->getFrontend()->getValue($product);
			$soldout=$product->getResource()->getAttribute('soldout')->getFrontend()->getValue($product);
			$discontinued=$product->getResource()->getAttribute('discontinued')->getFrontend()->getValue($product);
			$free_ab_connecticut_r_5pk=$product->getResource()->getAttribute('free_ab_connecticut_r_5pk')->getFrontend()->getValue($product);
			$free_ab_pr_ch_sm_w_lgh=$product->getResource()->getAttribute('free_ab_pr_ch_sm_w_lgh')->getFrontend()->getValue($product);
			$free_rp_renais_t_5pk=$product->getResource()->getAttribute('free_rp_renais_t_5pk')->getFrontend()->getValue($product);
			$buy5get1=$product->getResource()->getAttribute('buy5get1')->getFrontend()->getValue($product);
			$free_nub_ashtray=$product->getResource()->getAttribute('free_nub_ashtray')->getFrontend()->getValue($product);
			$free_ab_sungrown_r_5pk=$product->getResource()->getAttribute('free_ab_sungrown_r_5pk')->getFrontend()->getValue($product);
			$free_avo_n2_4=$product->getResource()->getAttribute('free_avo_n2_4')->getFrontend()->getValue($product);
			
			$right = 'Yes- Right ';
            $left = 'Yes- Left ';
			
			$right_ = 'Yes- Right';
            $left_ = 'Yes- Left';
			
            $product_data['left_marketing_image']= '';
			$product_data['right_marketing_image']= '';			
			
			if ($pr_20_off == $left_) {
			   $product_data['left_marketing_image']= 'http://gothamcigars.com/media/Icons/pr_20_off.png'; }
			else if ($pr_20_off == $right_) {
			      $product_data['right_marketing_image']= 'http://gothamcigars.com/media/Icons/pr_20_off.png'; }
				  
			if ($pr_25_off == $left_) {
			   $product_data['left_marketing_image']= 'http://gothamcigars.com/media/Icons/pr_25_off.png'; }
			else if ($pr_25_off == $right_) {
			      $product_data['right_marketing_image']= 'http://gothamcigars.com/media/Icons/pr_25_off.png'; }	  
			
			if ($items_left_3 == $left_) {
			   $product_data['left_marketing_image']= 'http://gothamcigars.com/media/Icons/items_left_3.png'; }
			else if ($items_left_3 == $right_) {
			      $product_data['right_marketing_image']= 'http://gothamcigars.com/media/Icons/items_left_3.png'; }
			
			if ($s100off == $left_) {
			   $product_data['left_marketing_image']= 'http://gothamcigars.com/media/Icons/s100off.png'; }
			else if ($s100off == $right_) {
			      $product_data['right_marketing_image']= 'http://gothamcigars.com/media/Icons/s100off.png'; }
            			
			if ($free_ab_hendrix_lighter == $left_) {
			   $product_data['left_marketing_image']= 'http://gothamcigars.com/media/Icons/free_ab_hendrix_lighter.png'; }
			else if ($free_ab_hendrix_lighter == $right_) {
			      $product_data['right_marketing_image']= 'http://gothamcigars.com/media/Icons/free_ab_hendrix_lighter.png'; }
				  
			if ($free_capri_humidor == $left_) {
			   $product_data['left_marketing_image']= 'http://gothamcigars.com/media/Icons/free_capri_humidor.png'; }
			else if ($free_capri_humidor == $right_) {
			      $product_data['right_marketing_image']= 'http://gothamcigars.com/media/Icons/free_capri_humidor.png'; }

            if ($custom_4 == $left) {
			   $product_data['left_marketing_image']= 'http://gothamcigars.com/media/Icons/custom_4.png'; }
			else if ($custom_4 == $right) {
			      $product_data['right_marketing_image']= 'http://gothamcigars.com/media/Icons/custom_4.png'; }

            if ($custom_3 == $left) {
			   $product_data['left_marketing_image']= 'http://gothamcigars.com/media/Icons/custom_3.png'; }
			else if ($custom_3 == $right) {
			      $product_data['right_marketing_image']= 'http://gothamcigars.com/media/Icons/custom_3.png'; }		  
				  
				   if ($custom_2 == $left) {
			   $product_data['left_marketing_image']= 'http://gothamcigars.com/media/Icons/custom_2.png'; }
			else if ($custom_2 == $right) {
			      $product_data['right_marketing_image']= 'http://gothamcigars.com/media/Icons/custom_2.png'; }	
				  
				   if ($custom_1 == $left) {
			   $product_data['left_marketing_image']= 'http://gothamcigars.com/media/Icons/custom_1.png'; }
			else if ($custom_1 == $right) {
			      $product_data['right_marketing_image']= 'http://gothamcigars.com/media/Icons/custom_1.png'; }	
				  
			if ($off_25 == $left) {
			   $product_data['left_marketing_image']= 'http://gothamcigars.com/media/Icons/off_25.png'; }
			else if ($off_25 == $right) {
			      $product_data['right_marketing_image']= 'http://gothamcigars.com/media/Icons/off_25.png'; }	
				  
				  
		    if ($free_oliva_sampler == $left_) {
			   $product_data['left_marketing_image']= 'http://gothamcigars.com/media/Icons/free_oliva_sampler.png'; }
			else if ($free_oliva_sampler == $right_) {
			      $product_data['right_marketing_image']= 'http://gothamcigars.com/media/Icons/free_oliva_sampler.png'; }	
				 
            if ($free_shipping == $left) {
			   $product_data['left_marketing_image']= 'http://gothamcigars.com/media/Icons/FreeShipping.jpg'; }
			else if ($free_shipping == $right) {
			      $product_data['right_marketing_image']= 'http://gothamcigars.com/media/Icons/FreeShipping.jpg'; }	

			if ($free_cao_last == $left) {
			   $product_data['left_marketing_image']= 'http://gothamcigars.com/media/Icons/FreeCAOstick.jpg'; }
			else if ($free_cao_last == $right) {
			      $product_data['right_marketing_image']= 'http://gothamcigars.com/media/Icons/FreeCAOstick.jpg'; }	  
				  
			if ($free_asti_humidor == $left) {
			   $product_data['left_marketing_image']= 'http://gothamcigars.com/media/Icons/FreeAstiHumidor.jpg'; }
			else if ($free_asti_humidor == $right) {
			      $product_data['right_marketing_image']= 'http://gothamcigars.com/media/Icons/FreeAstiHumidor.jpg'; }
			
			if ($free_don_lino == $left) {
			   $product_data['left_marketing_image']= 'http://gothamcigars.com/media/Icons/FreeDonLinoAfrica.jpg'; }
			else if ($free_don_lino == $right) {
			      $product_data['right_marketing_image']= 'http://gothamcigars.com/media/Icons/FreeDonLinoAfrica.jpg'; }
				  
			if ($closeout_20 == $left) {
			   $product_data['left_marketing_image']= 'http://gothamcigars.com/media/Icons/20PrOFF.jpg'; }
			else if ($closeout_20 == $right) {
			      $product_data['right_marketing_image']= 'http://gothamcigars.com/media/Icons/20PrOFF.jpg'; }
				  
			if ($free_ab_tempus == $left) {
			   $product_data['left_marketing_image']= 'http://gothamcigars.com/media/Icons/FreeABTEmpus5P.jpg'; }
			else if ($free_ab_tempus == $right) {
			      $product_data['right_marketing_image']= 'http://gothamcigars.com/media/Icons/FreeABTEmpus5P.jpg'; }

			if ($free_oliva == $left) {
			   $product_data['left_marketing_image']= 'http://gothamcigars.com/media/Icons/FreeOlivAshTRay.jpg'; }
			else if ($free_oliva == $right) {
			      $product_data['right_marketing_image']= 'http://gothamcigars.com/media/Icons/FreeOlivAshTRay.jpg'; }

			if ($free_acid == $left) {
			   $product_data['left_marketing_image']= 'http://gothamcigars.com/media/Icons/FreeAcidKKCig5P.jpg'; }
			else if ($free_acid == $right) {
			      $product_data['right_marketing_image']= 'http://gothamcigars.com/media/Icons/FreeAcidKKCig5P.jpg'; }

			if ($super_deal == $left) {
			   $product_data['left_marketing_image']= 'http://gothamcigars.com/media/Icons/SuperDeal8oFF.jpg'; }
			else if ($super_deal == $right) {
			      $product_data['right_marketing_image']= 'http://gothamcigars.com/media/Icons/SuperDeal8oFF.jpg'; }

			if ($off_6 == $left) {
			   $product_data['left_marketing_image']= 'http://gothamcigars.com/media/Icons/6OFF.png'; }
			else if ($off_6 == $right) {
			      $product_data['right_marketing_image']= 'http://gothamcigars.com/media/Icons/6OFF.png'; }

			if ($free_shipping_25 == $left) {
			   $product_data['left_marketing_image']= 'http://gothamcigars.com/media/Icons/FreeShipping.jpg'; }
			else if ($free_shipping_25 == $right) {
			      $product_data['right_marketing_image']= 'http://gothamcigars.com/media/Icons/FreeShipping.jpg'; }

			if ($free_ab == $left) {
			   $product_data['left_marketing_image']= 'http://gothamcigars.com/media/Icons/FreeABMaxx4Pack.jpg'; }
			else if ($free_ab == $right) {
			      $product_data['right_marketing_image']= 'http://gothamcigars.com/media/Icons/FreeABMaxx4Pack.jpg'; }	  
				  
			if ($two_off_10_minus == $left) {
			   $product_data['left_marketing_image']= 'http://gothamcigars.com/media/Icons/2off10-1.jpg'; }
			else if ($two_off_10_minus == $right) {
			      $product_data['right_marketing_image']= 'http://gothamcigars.com/media/Icons/2off10-1.jpg'; }

			if ($three_off_5_minus == $left) {
			   $product_data['left_marketing_image']= 'http://gothamcigars.com/media/Icons/3off5-1.jpg'; }
			else if ($three_off_5_minus == $right) {
			      $product_data['right_marketing_image']= 'http://gothamcigars.com/media/Icons/3off5-1.jpg'; }

			if ($two_off_5_minus == $left) {
			   $product_data['left_marketing_image']= 'http://gothamcigars.com/media/Icons/2off5-1.jpg'; }
			else if ($two_off_5_minus == $right) {
			      $product_data['right_marketing_image']= 'http://gothamcigars.com/media/Icons/2off5-1.jpg'; }

			if ($two_off_6 == $left) {
			   $product_data['left_marketing_image']= 'http://gothamcigars.com/media/Icons/2off6.jpg'; }
			else if ($two_off_6 == $right) {
			      $product_data['right_marketing_image']= 'http://gothamcigars.com/media/Icons/2off6.jpg'; }

			if ($two_off_5 == $left) {
			   $product_data['left_marketing_image']= 'http://gothamcigars.com/media/Icons/2off5.jpg'; }
			else if ($two_off_5 == $right) {
			      $product_data['right_marketing_image']= 'http://gothamcigars.com/media/Icons/2off5.jpg'; }

			if ($two_off_10 == $left) {
			   $product_data['left_marketing_image']= 'http://gothamcigars.com/media/Icons/2off10.jpg'; }
			else if ($two_off_10 == $right) {
			      $product_data['right_marketing_image']= 'http://gothamcigars.com/media/Icons/2off10.jpg'; }	 

			if ($three_off_5 == $left) {
			   $product_data['left_marketing_image']= 'http://gothamcigars.com/media/Icons/3off5.jpg'; }
			else if ($three_off_5 == $right) {
			      $product_data['right_marketing_image']= 'http://gothamcigars.com/media/Icons/3off5.jpg'; }

			if ($free_cao == $left) {
			   $product_data['left_marketing_image']= 'http://gothamcigars.com/media/Icons/FreeCAOgift.jpg'; }
			else if ($free_cao == $right) {
			      $product_data['right_marketing_image']= 'http://gothamcigars.com/media/Icons/FreeCAOgift.jpg'; }

			if ($pack_alec == $left) {
			   $product_data['left_marketing_image']= 'http://gothamcigars.com/media/Icons/FreeAlec.jpg'; }
			else if ($pack_alec == $right) {
			      $product_data['right_marketing_image']= 'http://gothamcigars.com/media/Icons/FreeAlec.jpg'; }

			if ($free_hoyo == $left) {
			   $product_data['left_marketing_image']= 'http://gothamcigars.com/media/Icons/FreeHoyodeMonterreySampler.jpg'; }
			else if ($free_hoyo == $right) {
			      $product_data['right_marketing_image']= 'http://gothamcigars.com/media/Icons/FreeHoyodeMonterreySampler.jpg'; }

			if ($off_3 == $left) {
			   $product_data['left_marketing_image']= 'http://gothamcigars.com/media/Icons/3OFF.png'; }
			else if ($off_3 == $right) {
			      $product_data['right_marketing_image']= 'http://gothamcigars.com/media/Icons/3OFF.png'; }

			if ($off_20 == $left) {
			   $product_data['left_marketing_image']= 'http://gothamcigars.com/media/Icons/20OFF.png'; }
			else if ($off_20 == $right) {
			      $product_data['right_marketing_image']= 'http://gothamcigars.com/media/Icons/20OFF.png'; }	

			if ($off_399 == $left) {
			   $product_data['left_marketing_image']= 'http://gothamcigars.com/media/Icons/399OFF.png'; }
			else if ($off_399 == $right) {
			      $product_data['right_marketing_image']= 'http://gothamcigars.com/media/Icons/399OFF.png'; }

			if ($off_5 == $left) {
			   $product_data['left_marketing_image']= 'http://gothamcigars.com/media/Icons/5OFF.png'; }
			else if ($off_5 == $right) {
			      $product_data['right_marketing_image']= 'http://gothamcigars.com/media/Icons/5OFF.png'; }	 

			if ($off_2 == $left) {
			   $product_data['left_marketing_image']= 'http://gothamcigars.com/media/Icons/2OFF.png'; }
			else if ($off_2 == $right) {
			      $product_data['right_marketing_image']= 'http://gothamcigars.com/media/Icons/2OFF.png'; }

			if ($off_10 == $left) {
			   $product_data['left_marketing_image']= 'http://gothamcigars.com/media/Icons/10OFF.png'; }
			else if ($off_10 == $right) {
			      $product_data['right_marketing_image']= 'http://gothamcigars.com/media/Icons/10OFF.png'; }

			if ($pack_5 == $left) {
			   $product_data['left_marketing_image']= 'http://gothamcigars.com/media/Icons/5pk.png'; }
			else if ($pack_5 == $right) {
			      $product_data['right_marketing_image']= 'http://gothamcigars.com/media/Icons/5pk.png'; }

			if ($free_hoyo == $left) {
			   $product_data['left_marketing_image']= 'http://gothamcigars.com/media/Icons/FreeHoyodeMonterreySampler.jpg'; }
			else if ($free_hoyo == $right) {
			      $product_data['right_marketing_image']= 'http://gothamcigars.com/media/Icons/FreeHoyodeMonterreySampler.jpg'; }

			if ($rated_95 == $left) {
			   $product_data['left_marketing_image']= 'http://gothamcigars.com/media/Icons/rated_95.png'; }
			else if ($rated_95 == $right) {
			      $product_data['right_marketing_image']= 'http://gothamcigars.com/media/Icons/rated_95.png'; }

			if ($rated_94 == $left) {
			   $product_data['left_marketing_image']= 'http://gothamcigars.com/media/Icons/rated_94.png'; }
			else if ($rated_94 == $right) {
			      $product_data['right_marketing_image']= 'http://gothamcigars.com/media/Icons/rated_94.png'; }

			if ($rated_93 == $left) {
			   $product_data['left_marketing_image']= 'http://gothamcigars.com/media/Icons/rated_93.png'; }
			else if ($rated_93 == $right) {
			      $product_data['right_marketing_image']= 'http://gothamcigars.com/media/Icons/rated_93.png'; }

			if ($rated_92 == $left) {
			   $product_data['left_marketing_image']= 'http://gothamcigars.com/media/Icons/rated_92.png'; }
			else if ($rated_92 == $right) {
			      $product_data['right_marketing_image']= 'http://gothamcigars.com/media/Icons/rated_92.png'; }

			if ($rated_91 == $left) {
			   $product_data['left_marketing_image']= 'http://gothamcigars.com/media/Icons/rated_91.png'; }
			else if ($rated_91 == $right) {
			      $product_data['right_marketing_image']= 'http://gothamcigars.com/media/Icons/rated_91.png'; }

			if ($rated_90 == $left) {
			   $product_data['left_marketing_image']= 'http://gothamcigars.com/media/Icons/rated_90.png'; }
			else if ($rated_90 == $right) {
			      $product_data['right_marketing_image']= 'http://gothamcigars.com/media/Icons/rated_90.png'; }	  
				  
			if ($buy_60_get_30 == $left) {
			   $product_data['left_marketing_image']= 'http://gothamcigars.com/media/Icons/buy60get30.png'; }
			else if ($buy_60_get_30 == $right) {
			      $product_data['right_marketing_image']= 'http://gothamcigars.com/media/Icons/buy60get30.png'; }

			if ($buy_50_get_10 == $left) {
			   $product_data['left_marketing_image']= 'http://gothamcigars.com/media/Icons/buy50get10.png'; }
			else if ($buy_50_get_10 == $right) {
			      $product_data['right_marketing_image']= 'http://gothamcigars.com/media/Icons/buy50get10.png'; }

			if ($buy_40_get_20 == $left) {
			   $product_data['left_marketing_image']= 'http://gothamcigars.com/media/Icons/buy40get20.png'; }
			else if ($buy_40_get_20 == $right) {
			      $product_data['right_marketing_image']= 'http://gothamcigars.com/media/Icons/buy40get20.png'; }

			if ($buy_40_get_10 == $left) {
			   $product_data['left_marketing_image']= 'http://gothamcigars.com/media/Icons/buy40get10.jpg'; }
			else if ($buy_40_get_10 == $right) {
			      $product_data['right_marketing_image']= 'http://gothamcigars.com/media/Icons/buy40get10.jpg'; }

			if ($buy_25_get_25 == $left) {
			   $product_data['left_marketing_image']= 'http://gothamcigars.com/media/Icons/buy25get25.png'; }
			else if ($buy_25_get_25 == $right) {
			      $product_data['right_marketing_image']= 'http://gothamcigars.com/media/Icons/buy25get25.png'; }

			if ($buy_10_get_10 == $left) {
			   $product_data['left_marketing_image']= 'http://gothamcigars.com/media/Icons/buy10get10.png'; }
			else if ($buy_10_get_10 == $right) {
			      $product_data['right_marketing_image']= 'http://gothamcigars.com/media/Icons/buy10get10.png'; }

			if ($buy_1_get_1 == $left) {
			   $product_data['left_marketing_image']= 'http://gothamcigars.com/media/Icons/Buy1Get1.png'; }
			else if ($buy_1_get_1 == $right) {
			      $product_data['right_marketing_image']= 'http://gothamcigars.com/media/Icons/Buy1Get1.png'; }

			if ($sale_price == $left) {
			   $product_data['left_marketing_image']= 'http://gothamcigars.com/media/Icons/sale_price.png'; }
			else if ($sale_price == $right) {
			      $product_data['right_marketing_image']= 'http://gothamcigars.com/media/Icons/sale_price.png'; }

			if ($free_vertigo_lighter == $left_) {
			   $product_data['left_marketing_image']= 'http://gothamcigars.com/media/Icons/free_vertigo_lighter.png'; }
			else if ($free_vertigo_lighter == $right_) {
			      $product_data['right_marketing_image']= 'http://gothamcigars.com/media/Icons/free_vertigo_lighter.png'; }

			if ($new_item == $left) {
			   $product_data['left_marketing_image']= 'http://gothamcigars.com/media/Icons/new.png'; }
			else if ($new_item == $right) {
			      $product_data['right_marketing_image']= 'http://gothamcigars.com/media/Icons/new.png'; }
				  
			if ($closeout == $left) {
			   $product_data['left_marketing_image']= 'http://gothamcigars.com/media/Icons/closeout.png'; }
			else if ($closeout == $right) {
			      $product_data['right_marketing_image']= 'http://gothamcigars.com/media/Icons/closeout.png'; }
				  
		    if ($free_cao_gold4sm == $left_) {
			   $product_data['left_marketing_image']= 'http://gothamcigars.com/media/Icons/free_cao_gold4sm.png'; }
			else if ($free_cao_gold4sm == $right_) {
			      $product_data['right_marketing_image']= 'http://gothamcigars.com/media/Icons/free_cao_gold4sm.png'; }		  

            if ($free_cao_com_sm == $left_) {
			   $product_data['left_marketing_image']= 'http://gothamcigars.com/media/Icons/free_cao_com_sm.png'; }
			else if ($free_cao_com_sm == $right_) {
			      $product_data['right_marketing_image']= 'http://gothamcigars.com/media/Icons/free_cao_com_sm.png'; }	
				  
				  if ($free_golf_ball == $left_) {
			   $product_data['left_marketing_image']= 'http://gothamcigars.com/media/Icons/free_golf_ball.png'; }
			else if ($free_golf_ball == $right_) {
			      $product_data['right_marketing_image']= 'http://gothamcigars.com/media/Icons/free_golf_ball.png'; }	
				  
				  if ($buy3get1 == $left_) {
			   $product_data['left_marketing_image']= 'http://gothamcigars.com/media/Icons/buy3get1.png'; }
			else if ($buy3get1 == $right_) {
			      $product_data['right_marketing_image']= 'http://gothamcigars.com/media/Icons/buy3get1.png'; }	
				  
				   if ($menthol_flavor_icon == $left_) {
			   $product_data['left_marketing_image']= 'http://gothamcigars.com/media/Icons/menthol_flavor_icon.png'; }
			else if ($menthol_flavor_icon == $right_) {
			      $product_data['right_marketing_image']= 'http://gothamcigars.com/media/Icons/menthol_flavor_icon.png'; }
				  
				  if ($full_flavor_icon == $left_) {
			   $product_data['left_marketing_image']= 'http://gothamcigars.com/media/Icons/full_flavor_icon.png'; }
			else if ($full_flavor_icon == $right_) {
			      $product_data['right_marketing_image']= 'http://gothamcigars.com/media/Icons/full_flavor_icon.png'; }
				  
				   if ($buy6get1 == $left_) {
			   $product_data['left_marketing_image']= 'http://gothamcigars.com/media/Icons/buy6get1.png'; }
			else if ($buy6get1 == $right_) {
			      $product_data['right_marketing_image']= 'http://gothamcigars.com/media/Icons/buy6get1.png'; }
				  
				  if ($free_gotham_lighter == $left_) {
			   $product_data['left_marketing_image']= 'http://gothamcigars.com/media/Icons/free_gotham_lighter.png'; }
			else if ($free_gotham_lighter == $right_) {
			      $product_data['right_marketing_image']= 'http://gothamcigars.com/media/Icons/free_gotham_lighter.png'; }
				  
				   if ($pr_10_off == $left_) {
			   $product_data['left_marketing_image']= 'http://gothamcigars.com/media/Icons/pr_10_off.png'; }
			else if ($pr_10_off == $right_) {
			      $product_data['right_marketing_image']= 'http://gothamcigars.com/media/Icons/pr_10_off.png'; }
				  
				  if ($free_butane == $left_) {
			   $product_data['left_marketing_image']= 'http://gothamcigars.com/media/Icons/free_butane.png'; }
			else if ($free_butane == $right_) {
			      $product_data['right_marketing_image']= 'http://gothamcigars.com/media/Icons/free_butane.png'; }
				  
				  if ($super_deal_o == $left_) {
			   $product_data['left_marketing_image']= 'http://gothamcigars.com/media/Icons/super_deal_o.png'; }
			else if ($super_deal_o == $right_) {
			      $product_data['right_marketing_image']= 'http://gothamcigars.com/media/Icons/super_deal_o.png'; }
				  
				  if ($buy4get1 == $left_) {
			   $product_data['left_marketing_image']= 'http://gothamcigars.com/media/Icons/buy4get1.png'; }
			else if ($buy4get1 == $right_) {
			      $product_data['right_marketing_image']= 'http://gothamcigars.com/media/Icons/buy4get1.png'; }
				  
				  
				   if ($soldout == $left_) {
			   $product_data['left_marketing_image']= 'http://gothamcigars.com/media/Icons/soldout.png'; }
			else if ($soldout == $right_) {
			      $product_data['right_marketing_image']= 'http://gothamcigars.com/media/Icons/soldout.png'; }
				  
				  
				   if ($discontinued == $left_) {
			   $product_data['left_marketing_image']= 'http://gothamcigars.com/media/Icons/discontinued.png'; }
			else if ($discontinued == $right_) {
			      $product_data['right_marketing_image']= 'http://gothamcigars.com/media/Icons/discontinued.png'; }
				  
				  if ($free_ab_connecticut_r_5pk == $left_) {
			   $product_data['left_marketing_image']= 'http://gothamcigars.com/media/Icons/free_ab_connecticut_r_5pk.png'; }
			else if ($free_ab_connecticut_r_5pk == $right_) {
			      $product_data['right_marketing_image']= 'http://gothamcigars.com/media/Icons/free_ab_connecticut_r_5pk.png'; }
				  
				  if ($free_ab_pr_ch_sm_w_lgh == $left_) {
			   $product_data['left_marketing_image']= 'http://gothamcigars.com/media/Icons/free_ab_pr_ch_sm_w_lgh.png'; }
			else if ($free_ab_pr_ch_sm_w_lgh == $right_) {
			      $product_data['right_marketing_image']= 'http://gothamcigars.com/media/Icons/free_ab_pr_ch_sm_w_lgh.png'; }
				  
				  if ($free_rp_renais_t_5pk == $left_) {
			   $product_data['left_marketing_image']= 'http://gothamcigars.com/media/Icons/free_rp_renais_t_5pk.png'; }
			else if ($free_rp_renais_t_5pk == $right_) {
			      $product_data['right_marketing_image']= 'http://gothamcigars.com/media/Icons/free_rp_renais_t_5pk.png'; }
				  
				  if ($buy5get1 == $left_) {
			   $product_data['left_marketing_image']= 'http://gothamcigars.com/media/Icons/buy5get1.png'; }
			else if ($buy5get1 == $right_) {
			      $product_data['right_marketing_image']= 'http://gothamcigars.com/media/Icons/buy5get1.png'; }
				  
				  if ($free_nub_ashtray == $left_) {
			   $product_data['left_marketing_image']= 'http://gothamcigars.com/media/Icons/free_nub_ashtray.png'; }
			else if ($free_nub_ashtray == $right_) {
			      $product_data['right_marketing_image']= 'http://gothamcigars.com/media/Icons/free_nub_ashtray.png'; }
				  
				  if ($free_ab_sungrown_r_5pk == $left_) {
			   $product_data['left_marketing_image']= 'http://gothamcigars.com/media/Icons/free_ab_sungrown_r_5pk.png'; }
			else if ($free_ab_sungrown_r_5pk == $right_) {
			      $product_data['right_marketing_image']= 'http://gothamcigars.com/media/Icons/free_ab_sungrown_r_5pk.png'; }
				  
				  if ($free_avo_n2_4 == $left_) {
			   $product_data['left_marketing_image']= 'http://gothamcigars.com/media/Icons/free_avo_n2_4.png'; }
			else if ($free_avo_n2_4 == $right_) {
			      $product_data['right_marketing_image']= 'http://gothamcigars.com/media/Icons/free_avo_n2_4.png'; }
				  
				  
			if ($product->getPrice()>149) {
			    $product_data['free_shipping']= 'http://www.gothamcigars.com/skin/frontend/default/gotham/images/freegroundshipping.png';}
				else { $product_data['free_shipping']= '';}			  
			
			$product_data['qty']=Mage::getModel('cataloginventory/stock_item')->loadByProduct($product)->getQty();
			if ($product_data['qty'] > 0) {
			$product_data['availability']='In Stock';
			} else $product_data['availability']='Item on Backorder';
			$percentage = floor(100 - (($product_data['price'] * 100) / $product_data['msrp']));
            $product_data['savings']='You Save '.$percentage.'%';
		  
		    /**
			* Getting reviews collection object
			*/
			$productId = $product->getId();
			$reviews = Mage::getModel('review/review')
			->getResourceCollection()
			->addStoreFilter(Mage::app()->getStore()->getId()) 
			->addEntityFilter('product', $productId)
			->addStatusFilter(Mage_Review_Model_Review::STATUS_APPROVED)
			->setDateOrder()
			->addRateVotes();
			/**
			* Getting average of ratings/reviews
			*/
			$avg = 0;
			$ratings = array();
			$i = 0;
			if (count($reviews) > 0) {
			foreach ($reviews->getItems() as $review) {
			foreach( $review->getRatingVotes() as $vote ) {
			$ratings[] = $vote->getPercent();
			}
			$i += 1;
			}
			$rating = array_sum($ratings)/count($ratings);
			$product_data['reviewrating'] = floor($rating);
			$product_data['reviewcount'] = $i;
			} else {
			$product_data['reviewrating'] = 0;
			$product_data['reviewcount'] = 0; }
						 
		    	  
		    //get the product categories            		
            foreach($product->getCategoryIds() as $_categoryId){
			 $category = Mage::getModel('catalog/category')->load($_categoryId);
			 		 
			 $_category = rtrim($category->getName());
             $_parent = rtrim($category->getParentCategory()->getName());
			 
			 if (($_category == 'Search') or ($_parent == 'Search') or ($_category == 'LAP Deal') or ($_parent == 'LAP Deal')) {
			 }
			 else {$product_data['category'] .= $category->getName().', ';}
			 
			 if (($_parent == 'Default Category') or ($_parent == 'Search') or ($_parent == 'Cigars') or ($_parent == 'LAP Deal')) {
			 }
			 else {$product_data['parent_category'] .= $category->getParentCategory()->getName().', ';}
			           		 
		    }
			
		    $product_data['category']=rtrim($product_data['category'],', ');	
			$product_data['parent_category']=rtrim($product_data['parent_category'],', ');	

		    		
		    //sanitize data	
		    foreach($product_data as $k=>$val){
			$bad=array('"',"\r\n","\n","\r","\t");
			$good=array(""," "," "," ","");
			$product_data[$k] = '"'.str_replace($bad,$good,$val).'"';
		    }
			
		    $feed_line = implode(",", $product_data)."\r\n";
		    fwrite($handle, $feed_line);
			
		}

				
		//---------------------- WRITE THE FEED	
		fclose($handle);
		
		copy($tmpfname, 'feeds/SearchSpringfeed.csv') or die("Unable to copy to.");
		
	}
	catch(Exception $e){
		die($e->getMessage());
	}

