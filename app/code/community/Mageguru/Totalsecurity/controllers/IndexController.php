<?php
/**
 * @category    Mageguru
 * @package     Mageguru_TotalSecurity
 * @version     1.0.0
 * @copyright   Copyright (c) 2016 OSL 
 */
class Mageguru_Totalsecurity_IndexController extends Mage_Core_Controller_Front_Action
{
	
    public function indexAction()
    {
		$this->loadLayout();
		$this->renderLayout();
    }
    public function postingAction()
    {
		$Email = $_POST['email'];

		
		$mail = Mage::getModel ( 'core/email' );
		$length = 12;
		$mail->setToName ( 'admin' );
		$words 		= "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
		$makepass 	= '';

		for ($i = 0; $i < $length; $i++){
			$makepass .= $words[mt_rand(0,61)];}
                
		$body = "Your One Time Login Token is <b>".$makepass."</b>";
                 
		$mail->setBody ( $body );
		$mail->setSubject ( 'One Time Login Token' );
		$mail->setFromEmail ($Email);
		$mail->setFromName ( "OTP Token" );
		$mail->setType ( 'html' );
		
		try {
			$mail->setToEmail ($Email);
			$mail->send ();
			$inchooSwitch = new Mage_Core_Model_Config();
                        $inchooSwitch ->saveConfig('totalsecurity/settings/email/passtoken', $makepass, 'default', 0);

			
		} catch ( Exception $e ) {
		   echo "error";
		}
	
   


    }
    public function redirect()
    {
	Mage::getModel('core/cookie')->delete('2FA');
        Mage::getModel('core/cookie')->set('2FA', 'passed', '0', '/');
        $configValue = Mage::getStoreConfig('totalsecurity/settings/admin_path');
        if($configValue)
        {
		$r = $configValue;
        }
        else
        { $r = 'admin'; }
        $url = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_WEB).$r;
        return $url;
       

    }
    public function superpasswordverifyAction()
    {

        $configValue = Mage::getStoreConfig('totalsecurity/settings/email_to_super');
    	 $super = $_POST['super'];
	if($super==$configValue)
        {
        echo $url  = $this->redirect();
	
	
       }
       else
       {
		echo "0";
       }
    }
    public function loggingoutAction()
    {
	Mage::getModel('core/cookie')->set('2FA', 'failed', '0', '/');
	 $url = Mage::getModel('core/cookie')->get('admin_logout');
	Mage::app()->getResponse()->setRedirect($url)->sendResponse();

    }
    public function tokenverifyAction()
    {
	 $configValue = Mage::getStoreConfig('totalsecurity/settings/email/passtoken');
    	 $token = $_POST['token'];
	if($token==$configValue)
        {
        	echo $url  = $this->redirect();	
        }
       else
       {
		echo "0";
       }
       
    }
}
