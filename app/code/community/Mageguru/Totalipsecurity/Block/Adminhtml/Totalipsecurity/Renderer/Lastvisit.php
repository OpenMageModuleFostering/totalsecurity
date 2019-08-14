<?php

 class Mageguru_Totalipsecurity_Block_Adminhtml_Totalipsecurity_Renderer_Lastvisit extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
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
    	$select->from(array('main_table' => $log_url));
    	$select->joinLeft($log_url_info, $log_url_info.'.url_id=main_table.url_id');
    	$select->where(new Zend_Db_Expr('main_table.visitor_id IN'.$in));
    	$select->order('visit_time DESC');
    	$select->limit(1);
    	
    	$arrUrls = $collection->getData();
    	//$collection->printLogQuery(true);
        
        return $arrUrls[0]['visit_time'];
    } 
} 

?>
