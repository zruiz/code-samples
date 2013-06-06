<?php

class CustomWork_OneStepCheckout_Block extends Mage_Checkout_Block_Onepage
{
	public function getSteps()
	{
		$steps = array();
	
		$stepCodes = array('billing', 'shipping', 'shipping_method', 'payment', 'review');
	
		foreach ($stepCodes as $step) {
			$steps[$step] = $this->getCheckout()->getStepData($step);
		}
		return $steps;
	}	
}