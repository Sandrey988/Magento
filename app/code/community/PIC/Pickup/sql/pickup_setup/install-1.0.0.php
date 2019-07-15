<?php

/** @var Mage_Core_Model_Resource_Setup $installer*/

$installer = $this;
$installer->startSetup();


$installer->run("
	CREATE TABLE IF NOT EXISTS {$this->getTable('pickup/block')} (
	  id int(11) unsigned NOT NULL auto_increment,
	  order_id int(11) NOT NULL,
	  store varchar(255) NOT NULL default '',
	  PRIMARY KEY (id)
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;
");

$installer->endSetup();