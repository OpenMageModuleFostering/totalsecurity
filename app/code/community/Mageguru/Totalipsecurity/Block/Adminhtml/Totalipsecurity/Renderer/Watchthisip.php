<?php

class Mageguru_Totalipsecurity_Block_Adminhtml_Totalipsecurity_Renderer_Watchthisip extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Input
{
	public function render(Varien_Object $row)
	{

		
		if(!Mage::helper('totalipsecurity')->checkIfWatch($row->_data['remote_addr'])){
			$html = '<button onclick="watchThisIp(this, '. $row->_data['remote_addr'] .'); return false">' . Mage::helper('totalipsecurity')->__('Watchlist') . '</button>';
		}else{
			$html = '<button onclick="unWatchThisIp(this, '. $row->_data['remote_addr'] .'); return false">' . Mage::helper('totalipsecurity')->__('Remove watch') . '</button>';
		}
		

		return $html;
	}

}
