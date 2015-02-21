<?php
class MD
_HideCatalog_Model_Observer
{
	const ACTION_NAME_CATEGORY = 'catalog_category_view';
	const ACTION_NAME_PRODUCT = 'catalog_product_view';
	public function catalogCategoryCollectionLoadBefore(Varien_Event_Observer $observer)
	{
		if ($this->_isApiRequest()) return;
		$event = $observer->getEvent();

		$collection = $event->getCategoryCollection();
		$this->_removeHiddenCollectionItems($collection);
	}

	private function _removeHiddenCollectionItems($collection)
	{
		$helper = Mage::helper('hidecatalog');

		$group_id = $helper->getGroup();
		$default = $helper->getDefaultHide();
		foreach($collection as $key => $item)
		{
			$hide_from = $item->load()->getData(MD
_HideCatalog_Helper_Data::HIDE_GROUPS_ATTRIBUTE);
			if($item->getData('is_active') && $item->getData('include_in_menu'))
			{
				if(is_array($hide_from) && !empty($hide_from))
				{	
					if(in_array($group_id,$hide_from) && !in_array(MD
_HideCatalog_Helper_Data::USE_NONE,$hide_from)){
						$collection->removeItemByKey($key);
					}
				}elseif(in_array($group_id,$default)){
					$collection->removeItemByKey($key);
				}
			}
		}
		
	}

	protected function _isApiRequest()
	{
		return Mage::app()->getRequest()->getModuleName() === 'api';
	}

	public function unAuthorisedRouteAccess(Varien_Event_Observer $observer)
	{
		$event = $observer->getEvent();
		$action = $event->getControllerAction();
		$helper = Mage::helper('hidecatalog');
		//$group_id = $helper->getGroup();
		if($action->getFullActionName() == self::ACTION_NAME_CATEGORY)
		{
			$params = $action->getRequest()->getParam('id');
			$category = Mage::getModel('catalog/category')->load($params);
			$helper->handleRedirection($category);
		}elseif($action->getFullActionName() == self::ACTION_NAME_PRODUCT)
		{
			$params = $action->getRequest()->getParam('id');
			$product = Mage::getModel('catalog/product')->load($params);
			$helper->handleProductRedirection($product);
		}

	}

	/*public function catalogProductCollectionLoadBefore(Varien_Event_Observer $observer)
	{
		$event = $observer->getEvent();
		$collection = $event->getCollection();
		
	}*/

	

}
