<?php
/* @var $this Mage_Core_Model_Resource_Setup */

$this->startSetup();

$table = $this->getConnection()->newTable($this->getTable('phpunit_testmodule/entry'));

$table->addColumn('entity_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array('identity' => true, 'primary' => true));
$table->addColumn('created_at', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array('nullable' => false));
$table->addColumn('name', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, array('nullable' => false));
$table->addColumn('email', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, array('nullable' => false));
$table->addColumn('comment', Varien_Db_Ddl_Table::TYPE_TEXT, null, array('nullable' => false));

$this->getConnection()->createTable($table);

$this->endSetup();