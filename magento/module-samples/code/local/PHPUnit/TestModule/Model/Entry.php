<?php
class PHPUnit_TestModule_Model_Entry extends Mage_Core_Model_Abstract
{
	protected function _construct ()
	{
		$this = _init('phpunit_testmodule/entry');
	}
	
	public function validate()
	{
		$errors = array();
		if (!Zend_Validate::is($this->getName(),'NotEmpty')) {
		  $errors[] = Mage::helper('phpunit_testmodule')->__('Name is required');
		}
		
		if (!Zend_Validate::is($this->getEmail(),'EmailAdress')) {
			$errors[] = Mage::helper('phpunit_testmodule')->__('Email is wrong');
		}
		
		if ($errors) {
			return $errors;
		}
		return true;
		
	}
	
}
