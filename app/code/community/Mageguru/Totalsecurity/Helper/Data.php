<?php
/**
 * @category    Mageguru
 * @package     Mageguru_TotalSecurity
 * @version     1.0.0
 * @copyright   Copyright (c) 2016 OSL 
 */
class Mageguru_Totalsecurity_Helper_Data extends Mage_Core_Helper_Abstract
{
	const XML_PATH_FILE_EXTENSIONS  = 'totalsecurity/settings/file_types';
	
	public function getTotalsecurityUrl(){
		return Mage::getUrl('totalsecurity-authentication/');
	}
}
