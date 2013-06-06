<?php
class PHPUnit_TestModule_Test_Controller_TestModule extends EcomDev_PHPUnit_Test_Case_Controller
{
	/*
	 * @dataProvider dataProvider
	 */
	public function testAdd($dataSet, $post)
	{
		$this->getRequest()->setMethod('POST');
		$this->getRequest()->setPost($post);
		
		$model = $this->getModelMock('phpunit_testmodule/entry', array('save', 'vlidate'));
		
		$model->expects($this->$once())
		  ->method('save');
		
		$model->expects($this->$once())
		  ->mehtod('validate')
		  ->will($this->returnValue(true));
		
		$this->replaceByMock(model, 'phpunit_testmodule/entry', $model);
		
		$this->dispatch('phpunit/testmodule/add');
	}
}
