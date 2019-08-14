<?php
/**
 * @category    Mageguru
 * @package     Mageguru_TotalSecurity
 * @version     1.0.0
 * @copyright   Copyright (c) 2016 OSL 
 */

require_once(Mage::getModuleDir('controllers','Mage_Adminhtml').DS.'IndexController.php');
class Mageguru_Totalsecurity_Adminhtml_IndexController extends Mage_Adminhtml_IndexController
{
    /**
     * Administrator login action
     * Delete cookies and start a fresh every attempt
     */
    public function loginAction()
    {
        if (Mage::getSingleton('admin/session')->isLoggedIn()) {
            $this->_redirect('*');
            return;
        }
        $loginData = $this->getRequest()->getParam('login');
        $username = (is_array($loginData) && array_key_exists('username', $loginData)) ? $loginData['username'] : null;

        $this->loadLayout();
        $this->renderLayout();
        Mage::getModel('core/cookie')->delete('admin_id');
        Mage::getModel('core/cookie')->delete('admin_logout');
    }

    /**
     * Admin area entry point
     * If Totalsecurity is enabled for Admins redirect to /totalsecurity
     * Otherwise redirect to the startup page url
     */
    public function indexAction()
    {
        $totalsecurity = Mage::getBlockSingleton('totalsecurity/totalsecurity');
        $session = Mage::getSingleton('admin/session');
        $url = $session->getUser()->getStartupPageUrl();

        if($totalsecurity->getTotalsecurityEnabled() == '1' && $totalsecurity->getTotalsecurityUseAdmin() == '1') {
            Mage::getModel('core/cookie')->set('logintype', 'admin');
            $url = 'totalsecurity-authentication';
        } else {
            if ($session->isFirstPageAfterLogin()) {
                $session->setIsFirstPageAfterLogin(true);
            }
        }
        $this->_redirect($url);
        $adminID = $session->getUser()->getUserID();
        Mage::getModel('core/cookie')->set('admin_id', $adminID);
        Mage::getModel('core/cookie')->set('admin_logout', $this->getUrl('adminhtml/index/logout'));
    }
}
