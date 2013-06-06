<?php
class PHPUnit_TestModule_TestModuleController extends Mage_Core_Controller_Front_Action
{
	public function addAction()
	{
		$entry = Mage::getModel('phpunit_testmodule/entry')
				->addData($this->getRequest()->getPost());
		
		if ($entry->validate() === true)
		{
			$entry->save();
		}
	}
	
}