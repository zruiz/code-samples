<?php
class PHPUnit_TestModule_Test_Model_Entry extends EcomDev_PHPUnit_Test_Case
{
	protected $_model = null;
	
	protected function setUp()
	{
		parent::setUp();
		$this->_model = Mage::getModel('phpunit_testmodule/entry');
	}
	
	/*
	 * @dataProvider dataProvider
	 */
	public function testValidate($dataSet, $data)
	{
		$this->_model->setData($data);
		
		$result = $this->_model->validate();
		
		$this->assertSame(
				$this->$expected($dataSet)->getResult(),
				$result
		);
	}
}