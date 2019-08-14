<?php
/**
 * @category    Mageguru
 * @package     Mageguru_TotalSecurity
 * @version     1.0.0
 * @copyright   Copyright (c) 2016 OSL 
 */
class Mageguru_Totalsecurity_Block_Totalsecurity extends Mage_Adminhtml_Block_Template
{
	public function _prepareLayout()
    {
		return parent::_prepareLayout();
    }
    
     public function getTotalsecurity()
     { 
        if (!$this->hasData('totalsecurity')) {
            $this->setData('totalsecurity', Mage::registry('totalsecurity'));
        }
        return $this->getData('totalsecurity');
    }

    /**
     * @return bool
     */
    public function getTotalsecurityEnabled(){
        return Mage::getStoreConfigFlag('totalsecurity/settings/is_enabled');
    }

    /**
     * @return bool
     */
    public function getTotalsecurityUseAdmin(){
        return Mage::getStoreConfigFlag('totalsecurity/settings/use_admin');
    }

    /**
     * @return bool
     */
   
   
   
   

    /**
     * @return array
     */
    public function getTotalsecurityAdminMethod(){
        return Mage::getStoreConfig('totalsecurity/settings/admin_method');
    }

    /**
     * @return string
     */
    public function getTotalsecurityAjaxUrl(){
        return Mage::getUrl('totalsecurity/index/ajaxpost/');
    }

    /**
     * @return string
     */
    public function getTotalsecurityBaseUrl(){
        return Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_WEB);
    }

    /**
     * Check if logintype cookie is set & if it's value == 'admin'
     */
    public function getTotalsecurityAdmin(){
        if ($_COOKIE['logintype'] == 'admin' ) {
            return True;
        } else {
            return False;
        }
    }

    /**
     * Check if logintype cookie is set & if it's value == 'customer'
     */
    public function getTotalsecurityCustomer(){
        if ($_COOKIE['logintype'] == 'customer' ) {
            return True;
        } else {
            return False;
        }
    }

}
