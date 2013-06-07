<?php
class CustomWork_CheckoutComments_Model_Resource_Comment extends Mage_Core_Model_Resource_Db_Abstract
{
	public function _construct()
	{
		$this->_init('checkoutcomments/comments', 'comment_id');
	}
	
}