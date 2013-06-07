<?php

/* @var $this Mage_Core_Model_Resource_Setup */

$this->startSetup();

$table = $this->getConnection()->newTable($this->getTable('checkoutcomments/comments'));

$table->addColumn('comment_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array('identity' => true, 'primary' => true), 'Comment ID');
$table->addColumn('order_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array('nullable' => false), 'Order ID');
$table->addColumn('comment', Varien_Db_Ddl_Table::TYPE_TEXT, null, array('nullable' => false));

$table->addForeignKey($this->getFkName('checkoutcomments/comments', 'order_id', 'sales/order', 'entity_id'),
		'order_id', $this->getTable('sales/order'), 'entity_id',
		 Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
       ->setComment('Checkout Comments');

$this->getConnection()->createTable($table);

$this->endSetup();