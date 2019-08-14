<?php

class Mageguru_Totalipsecurity_Model_Mysql4_Totalipsecurity extends Mage_Core_Model_Mysql4_Abstract
{
	public function _construct()
	{
		
		$this->_init('log/visitor', 'visitor_id');
	}
}
