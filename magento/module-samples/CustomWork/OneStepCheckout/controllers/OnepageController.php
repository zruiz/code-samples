<?php
require_once('Mage/Checkout/controllers/OnepageController.php');

class CustomWork_OneStepCheckout_OnepageController extends Mage_Checkout_OnepageController
{
	public function saveCartAction()
	{
		$this->saveBillingAction();
		$this->saveShippingAction();
		$this->saveShippingMethodAction();
		$this->savePaymentAction();
		$this->saveOrderAction();
	} 
	
	
}