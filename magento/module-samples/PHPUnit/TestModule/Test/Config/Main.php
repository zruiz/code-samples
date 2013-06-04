<?php
class PHPUnit_TestModule_Test_Config_Main extends EcomDev_PHPUnit_Test_Case_Config
{
	public function testSetUpResource()
	{
		$this->assertSetupResourceDefined();
		$this->assertSetupResourceExists();
	}
	
	public function testTableAlias()
	{
		$this->assertTableAlias('phpunit_testmodule/entry', 'phpunit_testmodule_entry');
	}
	
	public function testClassAlias()
	{
		$this->assertModelAlias('phpunit_testmodule/entry', 'PHPUnit_TestModule_Model_Entry');
		$this->assertResourceModelAlias('phpunit_testmodule/entry', 'PHPUnit_TestModule_Model_Resource_Entry');
		$this->assertHelperAlias('phpunit_testmodule', 'PHPUnit_TestModule_Helper_Data');
	}
}