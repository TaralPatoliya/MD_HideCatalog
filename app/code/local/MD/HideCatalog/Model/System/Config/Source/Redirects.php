<?php 

class MD
_Hidecatalog_Model_System_Config_Source_Redirects
{
	const REDIRECT_NO_ROUTE = 1;
	const REDIRECT_TARGET_ROUTE = 2;
	
	public function toOptionArray()
	{
		return array(
				array('value'=>self::REDIRECT_NO_ROUTE,'label'=>'404 No Route'),
				array('value'=>self::REDIRECT_TARGET_ROUTE,'label'=>'Target path')
			);
	}
}