<?php

class Mageguru_Totalipsecurity_Block_Adminhtml_Totalipsecurity_Renderer_Notes extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Input
{
	public function render(Varien_Object $row)
	{
		
		//$html = parent::render($row);
		
		$html = '<input class="input-text " type="text" value="'.$row->_data['note'].'" onblur="updateNote(this, '. $row->_data['remote_addr'] .'); return false" name="note">';
		
        //$html .= '<button onclick="updateNote(this, '. $row->_data['remote_addr'] .'); return false">' . Mage::helper('totalipsecurity')->__('Update') . '</button>';
 
        return $html;
	}
	
}
