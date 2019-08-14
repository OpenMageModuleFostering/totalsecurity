<?php

class Mageguru_Totalipsecurity_Block_Adminhtml_Totalipsecurity_Renderer_Count extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
	public function render(Varien_Object $row)
	{
		/* Get The Email Address Using query From Model Using id of the customer as
		 $id=$row->getId();
		*/
		 
		$rs = Mage::getSingleton('core/resource');
		 
		$visitor_info = $rs->getTableName('log_visitor_info');
		$log_url = $rs->getTableName('log_url');
		$log_url_info = $rs->getTableName('log_url_info');
		 
		 
		$collection = Mage::getModel('log/visitor')->getCollection();
		$this->setCollection($collection);
		$select = $collection->getSelect();
		$select->reset('from');
		$select->from(array('main_table' => $visitor_info));
		$select->where("remote_addr = '".$row->_data['remote_addr']."'");
		 
		//$collection->printLogQuery(true);
		 
		$arrData = $collection->getData();
		if(empty($arrData)){
			return '';
		}
		$in = "(";
		foreach ($arrData as $k =>$v){
			$in .= "'".$v['visitor_id']."',";
		}
		$in = trim($in, ",");
		$in .= ")";
		 
		$collection = Mage::getModel('log/visitor')->getCollection();
		$this->setCollection($collection);
		$select = $collection->getSelect();
		$select->reset();
		$select->from(array('main_table' => $log_url), array(new Zend_Db_Expr('COUNT(main_table.url_id) AS url_c')));
		$select->where(new Zend_Db_Expr('main_table.visitor_id IN'.$in));
		//$collection->printLogQuery(true);

		$arrUrls = $collection->getData();
		
		if(!empty($arrUrls)){
			//var_dump($arrUrls);
			$url_c = $arrUrls[0]['url_c'];
		}else{
			$url_c = '0';
		}
		
		 

		return '<div style="word-wrap: break-word;">'.$url_c.'</div>';
	}
}

?>
