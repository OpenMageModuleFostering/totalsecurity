<?php


class Mageguru_Totalsecurity_Model_Adminhtml_Session extends Mage_Adminhtml_Model_Session
{
    public function __construct()
    {
        $this->init('adminhtml');

        $TotalsecurityAuth = Mage::getModel('core/cookie')->get('2FA');
        if($TotalsecurityAuth == "pending"){
            $totalsecurity = Mage::getBlockSingleton('totalsecurity/totalsecurity');
            if($TotalsecurityAuth == "pending" && $totalsecurity->getTotalsecurityEnabled() == '1' && $totalsecurity->getTotalsecurityUseAdmin() == '1'){
                $url = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_WEB).'totalsecurity-authentication';
                $response = Mage::app()->getFrontController()->getResponse();
                $response->setRedirect($url);
            }
        }
    }
}
