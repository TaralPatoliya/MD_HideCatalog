<?php
$installer = $this;
$installer->startSetup();


$installer->addAttribute("catalog_category", MD
_HideCatalog_Helper_Data::HIDE_GROUPS_ATTRIBUTE,  array(
    "type"     => "text",
    "backend"  => "hidecatalog/eav_entity_attribute_backend_categoryoptions14242404551",
    "frontend" => "",
    "label"    => "Hide Category From",
    "input"    => "multiselect",
    "class"    => "",
    "source"   => "hidecatalog/eav_entity_attribute_source_categoryoptions14242404551",
    "global"   => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE,
    "visible"  => true,
    "required" => false,
    "user_defined"  => false,
    "default" => "",
    "searchable" => false,
    "filterable" => false,
    "comparable" => false,
	
    "visible_on_front"  => false,
    "unique"     => false,
    "note"       => ""

	));

$installer->addAttribute("catalog_product", MD
_HideCatalog_Helper_Data::HIDE_GROUPS_ATTRIBUTE,  array(
    "type"     => "text",
    "backend"  => "hidecatalog/eav_entity_attribute_backend_categoryoptions14242404551",
    "frontend" => "",
    "label"    => "Show Product To",
    "input"    => "multiselect",
    "class"    => "",
    "source"   => "hidecatalog/eav_entity_attribute_source_categoryoptions14242404551",
    "global"   => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE,
    "visible"  => true,
    "required" => false,
    "user_defined"  => false,
    "default" => "",
    "searchable" => false,
    "filterable" => false,
    "comparable" => false,
    
    "visible_on_front"  => false,
    "unique"     => false,
    "note"       => ""

    ));
$installer->endSetup();
	 