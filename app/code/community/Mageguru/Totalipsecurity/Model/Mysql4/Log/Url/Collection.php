<?php
class Mageguru_Totalipsecurity_Model_Mysql4_Log_Url_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
	public function _construct()
	{
		parent::_construct();
		$this->_init('totalipsecurity/log_url');
	}
}