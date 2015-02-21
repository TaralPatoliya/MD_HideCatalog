<?php

class MD_HideCatalog_Block_Product_List extends Mage_Catalog_Block_Product_List
{
    protected function _getProductCollection()
    {
        if (is_null($this->_productCollection)) {
            $layer = $this->getLayer();
            /* @var $layer Mage_Catalog_Model_Layer */
            if ($this->getShowRootCategory()) {
                $this->setCategoryId(Mage::app()->getStore()->getRootCategoryId());
            }

            // if this is a product view page
            if (Mage::registry('product')) {
                // get collection of categories this product is associated with
                $categories = Mage::registry('product')->getCategoryCollection()
                    ->setPage(1, 1)
                    ->load();
                // if the product is associated with any category
                if ($categories->count()) {
                    // show products from this category
                    $this->setCategoryId(current($categories->getIterator()));
                }
            }

            $origCategory = null;
            if ($this->getCategoryId()) {
                $category = Mage::getModel('catalog/category')->load($this->getCategoryId());
                if ($category->getId()) {
                    $origCategory = $layer->getCurrentCategory();
                    $layer->setCurrentCategory($category);
                    $this->addModelTags($category);
                }
            }
            $this->_productCollection = $this->filterHiddenProducts($layer->getProductCollection());
            $this->prepareSortableFieldsByCategory($layer->getCurrentCategory());

            if ($origCategory) {
                $layer->setCurrentCategory($origCategory);
            }
        }

        return $this->_productCollection;
    }

    protected function filterHiddenProducts(Mage_Catalog_Model_Resource_Product_Collection $collection)
    {
    	$group = Mage::helper('hidecatalog')->getGroup();
        $collection->addAttributeToSelect(MD
_HideCatalog_Helper_Data::HIDE_GROUPS_ATTRIBUTE);
        $collection->addAttributeToFilter(MD
_HideCatalog_Helper_Data::HIDE_GROUPS_ATTRIBUTE,
            array('finset'=>$group)
        );
    	return $collection;

    }

    /*protected function isHidden($group,$hide)
    {
    	if(is_array($hide) && !empty($hide) && in_array($group,$hide))
    	{
    		return true;
    	}elseif(!is_array($hide) && ($hide !='' || $hide !=null ) && $group == $hide)
    	{
    		return true;
    	}else{
    		return false;
    	}

    }*/

}