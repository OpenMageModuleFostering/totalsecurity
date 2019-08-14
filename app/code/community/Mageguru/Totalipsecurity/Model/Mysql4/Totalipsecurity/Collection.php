<?php

class Mageguru_Totalipsecurity_Model_Mysql4_Totalipsecurity_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
	
	public function getSelectCountSql()
	{
		$this -> _renderFilters();
	
		$rs = Mage::getSingleton('core/resource');
		
		//$log_visitor_info = $rs->getTableName('log_visitor_info');
		$ip_notes = $rs->getTableName('log_remoteaddr_notes');
		
		//echo 'totalipsecurity collection';
		$countSelect = clone $this -> getSelect();
		$countSelect -> reset(Zend_Db_Select::ORDER);
		$countSelect -> reset(Zend_Db_Select::LIMIT_COUNT);
		$countSelect -> reset(Zend_Db_Select::LIMIT_OFFSET);
		$countSelect -> reset(Zend_Db_Select::COLUMNS);
	
		$countSelect -> from('', 'COUNT(DISTINCT vi.remote_addr)');
		
		$countSelect -> resetJoinLeft();
		
		//$countSelect -> joinLeft(array('lrn'=>$ip_notes), 'lrn.remote_addr=vi.remote_addr', array('blocked','white','note'));
        $countSelect -> reset('group');
       	$countSelect -> reset('having');

		return $countSelect;
	}
	
	
}
