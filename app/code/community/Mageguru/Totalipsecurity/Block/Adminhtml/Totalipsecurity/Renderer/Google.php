<?php

 class Mageguru_Totalipsecurity_Block_Adminhtml_Totalipsecurity_Renderer_Google extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    public function render(Varien_Object $row)
    {
        /* Get The Email Address Using query From Model Using id of the customer as
        $id=$row->getId();
        */
    	$ip = long2ip($row->getData($this->getColumn()->getIndex()));
        
        return '<a href="http://www.google.com/search?q=whois:+'.$ip.'" target="_blank">'.$ip.'</a>';
    } 
} 

?>
