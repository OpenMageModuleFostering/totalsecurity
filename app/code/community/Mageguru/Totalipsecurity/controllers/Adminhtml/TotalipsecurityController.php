<?php

class Mageguru_Totalipsecurity_Adminhtml_TotalipsecurityController extends Mage_Adminhtml_Controller_Action
{

	protected function _initAction()
	{
		$this->loadLayout()
		->_setActiveMenu('totalipsecurity/items')
		->_addBreadcrumb(Mage::helper('adminhtml')->__('Items Manager'), Mage::helper('adminhtml')->__('Item Manager'));
		return $this;
	}
	 
	public function indexAction() {
		
		$this->_initAction();
		$this->renderLayout();
		
	}
	
	public function logurlAction() {
	
		$this->_initAction();
		$this->renderLayout();
	
	}
	public function blockedAction() {
	
		$this->_initAction();
		$this->renderLayout();
	
	}
	
	public function whiteAction() {
	
		$this->_initAction();
		$this->renderLayout();
	
	}
	public function watchAction() {
	
		$this->_initAction();
		$this->renderLayout();
	
	}
	public function oneipAction() {
	
		$this->_initAction();
		$this->_addContent($this->getLayout()->createBlock('totalipsecurity/adminhtml_totalipsecurity_oneip_block'));
		$this->renderLayout();
	
	}

	public function updateNoteAction()
	{
		$remote_addr = (int) $this->getRequest()->getParam('id');
		$note = $this->getRequest()->getParam('note');
		
		
		if ($remote_addr) {
			$rs = Mage::getSingleton('core/resource');
			$table = $rs->getTableName('log_remoteaddr_notes');			 
			$model = Mage::getModel('totalipsecurity/log_remoteaddr_notes');
			$collection = $model->getCollection();
			$select = $collection->getSelect();
			$select->where("remote_addr = '".$remote_addr."'");
			
			
			$arrData = $collection->getData();
			
			
			if(!empty($arrData)){
				//update
				$model->load($arrData[0]['id']);
				$model->setData('note', $note);
				$model->save();
				
			}else{
				//insert
				
				$model = Mage::getModel('totalipsecurity/log_remoteaddr_notes');
				$data = array('remote_addr'=>$remote_addr, 'note'=>$note);
				$model->setData($data);
				$model->save();
				
			}
			
		}
	}
	
	public function blockOneIpAction()
	{
	
		$ip = $this->getRequest()->getParam('ip');
		$ip = trim($ip);
		if(stripos($ip, '.') !== false){
			$long_ip = ip2long($ip);
		}else{
			$long_ip = $ip;
			$ip = long2ip($ip);
		}
		
		$cacheFile = Mage::getBaseDir('cache') . '/blocked_ips.dat';
	
		$arrBlocked = Mage::helper('totalipsecurity')->getBlocked();
		if(!Mage::helper('totalipsecurity')->checkIfBlocked($ip)){
			if(!Mage::helper('totalipsecurity')->checkIfWhite($ip)){
				array_push($arrBlocked, $ip);
			}else{
				echo $html = $this->__('IP ').$ip.$this->__(' is in whitelist');
				return;
			}
		}else{
			echo $html = $this->__('IP ').$ip.$this->__(' is allready blocked');
			return;
		}
	
		file_put_contents($cacheFile,serialize($arrBlocked));
		
		if(stripos($ip, '*') === false){
		
			$model = Mage::getModel('totalipsecurity/log_remoteaddr_notes');
			$collection = $model->getCollection();
			$select = $collection->getSelect();
			$select->where("remote_addr = '".$long_ip."'");
			
			$arrData = $collection->getData();
					
			if(!empty($arrData)){
				//update
				$model->load($arrData[0]['id']);
				$model->setData('blocked', '1');
				$model->save();
			
			}else{
				//insert
			
				$model = Mage::getModel('totalipsecurity/log_remoteaddr_notes');
				$data = array('remote_addr'=>$long_ip, 'blocked'=>'1');
				$model->setData($data);
				$model->save();
			
			}
		}
	
		echo 'blocked';
	}
	public function unblockOneIpAction()
	{
	
		$ip = $this->getRequest()->getParam('ip');
		$ip = trim($ip);
		if(stripos($ip, '.') !== false){
			$long_ip = ip2long($ip);
		}else{
			$long_ip = $ip;
			$ip = long2ip($ip);
		}
	
		$cacheFile = Mage::getBaseDir('cache') . '/blocked_ips.dat';
		$tmp_arr = array();
		$arrBlocked = Mage::helper('totalipsecurity')->getBlocked();
		if(Mage::helper('totalipsecurity')->checkIfBlocked($ip)){
			foreach($arrBlocked as $k => $v){
				if($v != trim($ip)){
					array_push($tmp_arr, $v);
				}
			}
			$arrBlocked = $tmp_arr;
		}else{
			echo $html = 'IP '.$ip.' is not blocked';
			return;
		}
	
		file_put_contents($cacheFile,serialize($arrBlocked));
	
		echo $html = 'IP '.$ip.' was unblocked';
	}
	public function blockThisIpAction()
	{
		
		$ip = $this->getRequest()->getParam('ip');
		$ip = trim($ip);
		$long_ip = $ip;
		$ip = long2ip($ip);
		$cacheFile = Mage::getBaseDir('cache') . '/blocked_ips.dat';
		
		$arrBlocked = Mage::helper('totalipsecurity')->getBlocked();
		if(!Mage::helper('totalipsecurity')->checkIfBlocked($ip)){
			if(!Mage::helper('totalipsecurity')->checkIfWhite($ip)){
				array_push($arrBlocked, $ip);
			}else{
				echo '';
				return;
			}
		}
		
		file_put_contents($cacheFile,serialize($arrBlocked));
		
		$model = Mage::getModel('totalipsecurity/log_remoteaddr_notes');
		$collection = $model->getCollection();
		$select = $collection->getSelect();
		$select->where("remote_addr = '".$long_ip."'");
		
		$arrData = $collection->getData();
			
		if(!empty($arrData)){
			//update
			$model->load($arrData[0]['id']);
			$model->setData('blocked', '1');
			$model->save();
		
		}else{
			//insert
		
			$model = Mage::getModel('totalipsecurity/log_remoteaddr_notes');
			$data = array('remote_addr'=>$long_ip, 'blocked'=>'1');
			$model->setData($data);
			$model->save();
		
		}
		
		echo $html = '<button onclick="unBlockThisIp(this, '. $long_ip .'); return false">' . Mage::helper('totalipsecurity')->__('Unblock') . '</button>';
	}
	public function whiteThisIpAction()
	{
	
		$ip = $this->getRequest()->getParam('ip');
		$ip = trim($ip);
		$long_ip = $ip;
		$ip = long2ip($ip);
		$cacheFile = Mage::getBaseDir('cache') . '/white_ips.dat';
	
		$arrWhite = Mage::helper('totalipsecurity')->getWhite();
		if(!Mage::helper('totalipsecurity')->checkIfWhite($ip)){
			if(!Mage::helper('totalipsecurity')->checkIfBlocked($ip)){
				array_push($arrWhite, $ip);
			}else{
				echo '';
				return;
			}
		}
	
		file_put_contents($cacheFile,serialize($arrWhite));
		
		$model = Mage::getModel('totalipsecurity/log_remoteaddr_notes');
		$collection = $model->getCollection();
		$select = $collection->getSelect();
		$select->where("remote_addr = '".$long_ip."'");
		
		$arrData = $collection->getData();
		if(!empty($arrData)){
			//update
			$model->load($arrData[0]['id']);
			$model->setData('white', '1');
			$model->save();
		
		}else{
			//insert
		
			$model = Mage::getModel('totalipsecurity/log_remoteaddr_notes');
			$data = array('remote_addr'=>$long_ip, 'white'=>'1');
			$model->setData($data);
			$model->save();
		
		}
		
		
		echo $html = '<button onclick="unWhiteThisIp(this, '. $long_ip .'); return false">' . Mage::helper('totalipsecurity')->__('Remove white') . '</button>';
	}
	public function watchThisIpAction()
	{
	
		$ip = $this->getRequest()->getParam('ip');
		$ip = trim($ip);
		$long_ip = $ip;
		$ip = long2ip($ip);
	
		$model = Mage::getModel('totalipsecurity/log_remoteaddr_notes');
		$collection = $model->getCollection();
		$select = $collection->getSelect();
		$select->where("remote_addr = '".$long_ip."'");
	
		$arrData = $collection->getData();
					
		if(!empty($arrData)){
			$model->load($arrData[0]['id']);
			$model->setData('watch', '1');
			$model->save();
	
		}else{
	
			$model = Mage::getModel('totalipsecurity/log_remoteaddr_notes');
			$data = array('remote_addr'=>$long_ip, 'watch'=>'1');
			$model->setData($data);
			$model->save();
	
		}
	
	
		echo $html = '<button onclick="unWhatchThisIp(this, '. $long_ip .'); return false">' . Mage::helper('totalipsecurity')->__('Remove whatch') . '</button>';
	}
	public function unBlockThisIpAction()
	{
	
		$ip = $this->getRequest()->getParam('ip');
		$ip = trim($ip);
		$long_ip = $ip;
		$ip = long2ip($ip);
		$arrIp = explode('.', $ip);
		$cacheFile = Mage::getBaseDir('cache') . '/blocked_ips.dat';
	
		$arrBlocked = Mage::helper('totalipsecurity')->getBlocked();
		$arrData = array();
		if(Mage::helper('totalipsecurity')->checkIfBlocked($ip)){
			foreach ($arrBlocked as $v){
				
				$tmp_ip = explode('.', $v);
				$found = 0;
				foreach($tmp_ip as $key => $val){
					if($val == '*'){
						$found++;
					}elseif($arrIp[$key] == $val){
						$found++;
					}
				}
				if($found != 4){
					array_push($arrData, $v);
				}
				
			}
		}else{
			$arrData = $arrBlocked;
		}

		
		file_put_contents($cacheFile,serialize($arrData));
		
		$model = Mage::getModel('totalipsecurity/log_remoteaddr_notes');
		$collection = $model->getCollection();
		$select = $collection->getSelect();
		$select->where("remote_addr = '".$long_ip."'");
		
		$arrData = $collection->getData();		
			
		if(!empty($arrData)){
			$model->load($arrData[0]['id']);
			$model->setData('blocked', '0');
			$model->save();
		
		}else{
		
			$model = Mage::getModel('totalipsecurity/log_remoteaddr_notes');
			$data = array('remote_addr'=>$long_ip, 'blocked'=>'0');
			$model->setData($data);
			$model->save();
		
		}
		
		echo $html = '<button onclick="blockThisIp(this, '. $long_ip .'); return false">' . Mage::helper('totalipsecurity')->__('Block') . '</button>';
	}
	public function unWhiteThisIpAction()
	{
	
		$ip = $this->getRequest()->getParam('ip');
		$ip = trim($ip);
		$long_ip = $ip;
		$ip = long2ip($ip);
		$arrIp = explode('.', $ip);
		$cacheFile = Mage::getBaseDir('cache') . '/white_ips.dat';
	
		$arrWhite = Mage::helper('totalipsecurity')->getWhite();
		$arrData = array();
		if(Mage::helper('totalipsecurity')->checkIfWhite($ip)){
			foreach ($arrWhite as $v){
	
				$tmp_ip = explode('.', $v);
				$found = 0;
				foreach($tmp_ip as $key => $val){
					if($val == '*'){
						$found++;
					}elseif($arrIp[$key] == $val){
						$found++;
					}
				}
				if($found != 4){
					array_push($arrData, $v);
				}
	
			}
		}else{
			$arrData = $arrWhite;
		}
	
	
		file_put_contents($cacheFile,serialize($arrData));
		
		$model = Mage::getModel('totalipsecurity/log_remoteaddr_notes');
		$collection = $model->getCollection();
		$select = $collection->getSelect();
		$select->where("remote_addr = '".$long_ip."'");
		
		$arrData = $collection->getData();
			
		if(!empty($arrData)){
			//update
			$model->load($arrData[0]['id']);
			$model->setData('white', '0');
			$model->save();
		
		}else{
			//insert
		
			$model = Mage::getModel('totalipsecurity/log_remoteaddr_notes');
			$data = array('remote_addr'=>$long_ip, 'white'=>'0');
			$model->setData($data);
			$model->save();
		
		}
		
		echo $html = '<button onclick="whiteThisIp(this, '. $long_ip .'); return false">' . Mage::helper('totalipsecurity')->__('Whitelist') . '</button>';
	}
	public function unWatchThisIpAction()
	{
	
		$ip = $this->getRequest()->getParam('ip');
		$ip = trim($ip);
		$long_ip = $ip;
		$ip = long2ip($ip);
	
		$model = Mage::getModel('totalipsecurity/log_remoteaddr_notes');
		$collection = $model->getCollection();
		$select = $collection->getSelect();
		$select->where("remote_addr = '".$long_ip."'");
	
		$arrData = $collection->getData();
			
			
		if(!empty($arrData)){
			//update
			$model->load($arrData[0]['id']);
			$model->setData('watch', '0');
			$model->save();
	
		}else{
			//insert
	
			$model = Mage::getModel('totalipsecurity/log_remoteaddr_notes');
			$data = array('remote_addr'=>$long_ip, 'watch'=>'0');
			$model->setData($data);
			$model->save();
	
		}
	
		echo $html = '<button onclick="whatchThisIp(this, '. $long_ip .'); return false">' . Mage::helper('totalipsecurity')->__('Whatchlist') . '</button>';
	}
	
}
