<?php

class Mageguru_Totalipsecurity_Model_Notes extends Mage_Core_Model_Abstract{
	
	protected function _construct(){
		parent::_construct();
		$this->_init('totalipsecurity/log_remoteaddr_notes');
	}
	
}
