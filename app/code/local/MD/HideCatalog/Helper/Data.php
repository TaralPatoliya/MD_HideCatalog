<?php
class MD
_HideCatalog_Helper_Data extends Mage_Core_Helper_Abstract
{
    const REDIRECT_NO_ROUTE = 1;
    const REDIRECT_TARGET_ROUTE = 2;
    const USE_DEFAULT = -2;
    const USE_NONE = -1;
    const LABEL_DEFAULT = '[ USE DEFAULT ]';
    const LABEL_NONE = '[ NONE ]';
    const HIDE_GROUPS_ATTRIBUTE = 'hide_category_from';

	protected $_groups;
	public function getGroups()
    {
        if (is_null($this->_groups)) {
            $this->_groups = Mage::getResourceModel('customer/group_collection')->load();
        }
        return $this->_groups;
    }

    public function getConfig($field,$group = 'general',$section='hidecategory')
    {
    	return Mage::getStoreConfig($section.'/'.$group.'/'.$field);
    }

    public function getDefaultHide()
    {
    	return explode(',',$this->getConfig('hidefrom'));
    }

    public function getGroup()
    {
        $group_id = 0;
        if(Mage::getSingleton('customer/session')->isLoggedIn()){
            $group_id  = Mage::getSingleton('customer/session')->getCustomerGroupId();
        }
        return $group_id;
    }

    public function handleRedirection(Mage_Catalog_Model_Category $category)
    {
        $hide = $category->getData(self::HIDE_GROUPS_ATTRIBUTE);
        $group_id = $this->getGroup();
        if(!is_array($hide) && $group_id!= $hide && in_array($group_id,$this->getDefaultHide()))
        {
           $this->_redirectToRoute(); 
        }
        elseif(is_array($hide) && !empty($hide) && in_array($group_id, $hide))
        {
            $this->_redirectToRoute(); 
        }
    }


    public function handleProductRedirection(Mage_Catalog_Model_Product $product)
    {
        /*
            Here we are showinf the products to the selected groups in the product form
        */
        $show = $product->getData(self::HIDE_GROUPS_ATTRIBUTE);
        $group_id = $this->getGroup();
        if((!is_array($show) && $group_id == $show) || (is_array($show) && in_array(self::USE_NONE, $show)) || (is_array($show) && !in_array($group_id,$show)))
        {
            $this->_redirectToRoute();
        }
    }

    public function _redirectToRoute()
    {
        switch($this->getConfig('redirect'))
        {
            case self::REDIRECT_TARGET_ROUTE:
                $targetUrl = $this->getConfig('redirect_action');
                if('customer/account/login' == $targetUrl)
                {
                    $currentUrl = $this->_getCurrentUrl();
                    Mage::getSingleton('customer/session')->setAfterAuthUrl($currentUrl);
                }
                $this->_sendRedirectHeaders($targetUrl,307);
            break;
            case self::REDIRECT_NO_ROUTE:
            default:
                $targetUrl = $this->getConfig('no_route','default','web');
                $this->_sendRedirectHeaders($targetUrl,404);
            break;

        }

    }

    public function _continueToOriginalRoute()
    {
        $this->_sendRedirectHeaders($this->_getCurrentUrl());
    }

    protected function _sendRedirectHeaders($url,$code = 307, $isMagentoRoute = true)
    {
        if ($isMagentoRoute) {
            $url = Mage::getSingleton('core/url')->sessionUrlVar(Mage::getUrl($url));
        }
        Mage::app()->getResponse()
        ->setRedirect($url, $code)
        ->sendHeaders();
        Mage::app()->getRequest()->setDispatched(true);

        return $this;
    }

    protected function _getCurrentUrl()
    {
        $currentUrl = Mage::helper('core/url')->getCurrentUrl();
        $currentUrl = Mage::getSingleton('core/url')->sessionUrlVar($currentUrl);
        return $currentUrl;
    }
}
