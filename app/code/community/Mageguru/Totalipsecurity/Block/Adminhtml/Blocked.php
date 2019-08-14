<?php
/**
 * @category    Mageguru
 * @package     Mageguru_TotalSecurity
 * @version     1.0.0
 * @copyright   Copyright (c) 2016 OSL 
 */
class Mageguru_Totalipsecurity_Block_Adminhtml_Blocked extends Mage_Adminhtml_Block_Widget_Grid_Container
{
	public function __construct()
	{
		
		$this->_controller = 'adminhtml_totalipsecurity_blocked';
		$this->_blockGroup = 'totalipsecurity';
		$this->_headerText = Mage::helper('totalipsecurity')->__('Blocked ip list');
		
		
		$this->_addButton("view_list", array('label' => Mage::helper('totalipsecurity')->__('View list'),
				'onclick' => "setLocation('".$this->getUrl('*/*/index')."')"));
		$this->_addButton("view_blocked", array('label' => Mage::helper('totalipsecurity')->__('View blocked'), 
												'onclick' => "setLocation('".$this->getUrl('*/*/blocked')."')"));
		$this->_addButton("view_white", array('label' => Mage::helper('totalipsecurity')->__('View white list'),
				'onclick' => "setLocation('".$this->getUrl('*/*/white')."')"));
		$this->_addButton("view_watch", array('label' => Mage::helper('totalipsecurity')->__('View watch list'),
				'onclick' => "setLocation('".$this->getUrl('*/*/watch')."')"));
		$this->_addButton("one_ip", array('label' => Mage::helper('totalipsecurity')->__('Block ip classes'),
				'onclick' => "setLocation('".$this->getUrl('*/*/oneip')."')"));
		
		
		parent::__construct();
		$this->removeButton('add');
		
	}
}
