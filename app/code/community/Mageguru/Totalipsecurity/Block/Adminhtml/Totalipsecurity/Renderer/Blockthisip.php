<?php 

class Mageguru_Totalipsecurity_Block_Adminhtml_Totalipsecurity_Renderer_Blockthisip extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Input
{
	public function render(Varien_Object $row)
	{
		
		if(!Mage::helper('totalipsecurity')->checkIfBlocked($row->_data['remote_addr'])){
			if(!Mage::helper('totalipsecurity')->checkIfWhite($row->_data['remote_addr'])){
				$html = '<button onclick="blockThisIp(this, '. $row->_data['remote_addr'] .'); return false">' . Mage::helper('totalipsecurity')->__('Block') . '</button>';
			}else{
				$html = '';
			}
		}else{
			$html = '<button onclick="unBlockThisIp(this, '. $row->_data['remote_addr'] .'); return false">' . Mage::helper('totalipsecurity')->__('UnBlock') . '</button>';
		}
		
        return $html;
	}
	
}
