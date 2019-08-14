<?php
/**
 * @category    Mageguru
 * @package     Mageguru_TotalSecurity
 * @version     1.0.0
 * @copyright   Copyright (c) 2016 OSL (www.magento.mageguru.in)
 */
require_once(Mage::getModuleDir('','Mage_Customer').DS.'Model/Session.php');
class Mageguru_Totalsecurity_Model_Session extends Mage_Customer_Model_Session
{
    public function __construct()
    {
        $url = $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
        $totalsecurity = Mage::getBlockSingleton('totalsecurity/totalsecurity');
        if (strpos($url,'totalsecurity-authentication') == false && strpos($url,'totalsecurity') == false && strpos($url,'totalsecurity_api') == false) {
            $TotalsecurityAuth = Mage::getModel('core/cookie')->get('2FA');
            if ($TotalsecurityAuth == "pending") {
                if ($TotalsecurityAuth != "passed" && $totalsecurity->getTotalsecurityEnabled() == '1' && $totalsecurity->getTotalsecurityUseCustomer() == '1') {
                    $url = Mage::helper('customer')->getLogoutUrl();
                    Mage::app()->getResponse()->setRedirect($url);
                    Mage::getModel('core/cookie')->set('2FA', 'failed', '0', '/');
                }
            }
        }
        $namespace = 'customer';
        if ($this->getCustomerConfigShare()->isWebsiteScope()) {
            $namespace .= '_' . (Mage::app()->getStore()->getWebsite()->getCode());
        }

        $this->init($namespace);
        Mage::dispatchEvent('customer_session_init', array('customer_session' => $this));
    }
}
