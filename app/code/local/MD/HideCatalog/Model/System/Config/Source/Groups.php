<?php 

class MD
_Hidecatalog_Model_System_Config_Source_Groups
{
	protected $_options;

	public function toOptionArray()
	{
		if (is_null($this->_options)) {
			$this->_options = array();
			$helper = Mage::helper('hidecatalog');

			$this->_options[] = array(
				'value' => MD
_HideCatalog_Helper_Data::USE_NONE,
				'label' => $helper->__(MD
_HideCatalog_Helper_Data::LABEL_NONE)
				);
			foreach (Mage::helper('hidecatalog')->getGroups() as $group) {
				/* @var $group Mage_Customer_Model_Group */
				$this->_options[] = array(
					'value' => $group->getId(),
					'label' => $group->getCode(),
					);
			}
		}

		return $this->_options;
	}
}