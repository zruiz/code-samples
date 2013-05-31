<?php
// make sure we don't time out
	set_time_limit(0);	

	require_once 'app/Mage.php';
        Mage::app('default');
        
	try{
    $cust_orderColl = Mage::getResourceModel('enterprise_customer/sales_order');
	$cust_orderColl->addAttributeToFilter('entity_id', array('eq'=> 14253 ));
	$cust_orderColl->addAttributeToSelect('*');
	
	foreach ($cust_orderColl as $cust_order) {
	   $_cust_orderData = $cust_order->getData();
	   $premium = $_cust_orderData['customer_handmade_specials'];
       $machine = $_cust_orderData['customer_machine_made'];
       $little = $_cust_orderData['customer_little_cigars'];
	   
	   echo $premium;
	   echo $machine;
	   echo $little;
	}
?>	
	