<?php

class Mageguru_Totalipsecurity_Block_Adminhtml_Totalipsecurity_Renderer_Pretty extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
	public function render(Varien_Object $row)
	{
		
		$url = $row->_data['url'];
		$base_url = Mage::getBaseUrl();
		
		$url = str_ireplace($base_url, '', $url);
		
		$collection = Mage::getModel('core/url_rewrite')->getCollection();
		
		$select = $collection->getSelect();
		$select->where("main_table.target_path LIKE '".$url."'");
		
		//$collection->printLogQuery(true);
		
		$arrData = $collection->getData();
		
		
		if(!empty($arrData)){
			foreach ($arrData as $k => $v){
				if(!empty($v['request_path'])){
					$pretty = $base_url.$v['request_path'];
					break;
				}
			}
		}
		if(!empty($pretty)){
			echo $pretty;
		}else{
			echo $row->_data['url'];
		}

	}
}
