<?php

class Mageguru_Totalipsecurity_Helper_Data extends Mage_Core_Helper_Abstract
{
	public function __construct() {
		$this->cacheFile = Mage::getBaseDir('cache') . '/blocked_ips.dat';
		$this->cacheFileWhite = Mage::getBaseDir('cache') . '/white_ips.dat';
	}
	
	public function getBlocked() {
		if(file_exists($this->cacheFile)) {
			$arrBlocked = unserialize(file_get_contents($this->cacheFile));
		} else {
			file_put_contents($this->cacheFile,'');
		}
		if(empty($arrBlocked)){
			$arrBlocked = array();
		}
		return $arrBlocked;
	}
	public function getWhite() {
		if(file_exists($this->cacheFileWhite)) {
			$arrWhite = unserialize(file_get_contents($this->cacheFileWhite));
		} else {
			file_put_contents($this->cacheFileWhite,'');
		}
		if(empty($arrWhite)){
			$arrWhite = array();
		}
		return $arrWhite;
	}
	
	public function checkIfBlocked($ip){
		
		if(stripos($ip, '.')===false){
			$ip = long2ip($ip);
		}
		
		$arrIp = explode('.', $ip);
		
		if(file_exists($this->cacheFile)) {
			$arrBlocked = unserialize(file_get_contents($this->cacheFile));
		}
		if(!empty($arrBlocked)){
			foreach($arrBlocked as $v){
				
				$tmp_ip = explode('.', $v);
				$found = 0;
				foreach($tmp_ip as $key => $val){
					if($val == '*'){
						$found++;
					}elseif($arrIp[$key] == $val){
						$found++;
					}
				}
				if($found == 4){
					return true;
				}
			}
		}
		return false;
	}
	
	public function checkIfWhite($ip){
	
		if(stripos($ip, '.')===false){
			$ip = long2ip($ip);
		}
	
		$arrIp = explode('.', $ip);
	
		if(file_exists($this->cacheFileWhite)) {
			$arrWhite = unserialize(file_get_contents($this->cacheFileWhite));
		}
		if(!empty($arrWhite)){
			foreach($arrWhite as $v){
					
				$tmp_ip = explode('.', $v);
				$found = 0;
				foreach($tmp_ip as $key => $val){
					if($val == '*'){
						$found++;
					}elseif($arrIp[$key] == $val){
						$found++;
					}
				}
				if($found == 4){
					return true;
				}
			}
		}
	
		return false;
	}
	public function checkIfWatch($ip){
		
		$model = Mage::getModel('totalipsecurity/log_remoteaddr_notes');
		$collection = $model->getCollection();
		
		$select = $collection->getSelect();
		$select->where("main_table.watch = '1'");
		$select->where("main_table.remote_addr = '".$ip."'");
		
		$arrData = $collection->getData();
		
		if(empty($arrData)){
			return false;
		}else{
			return true;
		}
		
		
	}
	public function clearCache() {
		unlink($this->cacheFile);
		unlink($this->cacheFileWhite);
	}
}
