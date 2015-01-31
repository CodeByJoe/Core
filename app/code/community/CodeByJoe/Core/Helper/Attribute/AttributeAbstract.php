<?php
/**
 * CodeByJoe Ltd :: http://www.codebyjoe.com
 *
 * @category CodeByJoe
 * @package CodeByJoe_Core
 * @author Joseph McDermott <code@josephmcdermott.co.uk>
 * @license http://choosealicense.com/licenses/mit/ MIT License
 */
abstract class CodeByJoe_Core_Helper_Attribute_AttributeAbstract extends Mage_Core_Helper_Abstract
{
    const TYPE_YESNO = 'yesno';
    const TYPE_SELECT = 'select';
    const TYPE_MULTISELECT = 'multiselect';

    protected $_defaultEavValues = array(
        'backend'                    => null,
        'type'                       => 'varchar',
        'table'                      => null,
        'frontend'                   => null,
        'input'                      => 'text',
        'label'                      => null,
        'frontend_class'             => null,
        'source'                     => null,
        'required'                   => 0,
        'user_defined'               => 1,
        'default'                    => null,
        'unique'                     => 0,
        'note'                       => null,
        'input_renderer'             => null,
        'global'                     => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
        'visible'                    => 1,
        'searchable'                 => 0,
        'filterable'                 => 0,
        'comparable'                 => 0,
        'visible_on_front'           => 0,
        'wysiwyg_enabled'            => 0,
        'is_html_allowed_on_front'   => 0,
        'visible_in_advanced_search' => 0,
        'filterable_in_search'       => 0,
        'used_in_product_listing'    => 0,
        'used_for_sort_by'           => 0,
        'apply_to'                   => null,
        'position'                   => 0,
        'is_configurable'            => 0,
        'used_for_promo_rules'       => 0,
        'group'                      => 'General',
        'sort_order'                 => null,
    );

    protected $_defaultEavValuesYesno = array(
        'type'                       => 'int',
        'input'                      => 'select',
        'source'                     => 'eav/entity_attribute_source_boolean',
        'backend'                    => 'eav/entity_attribute_backend_array',
    );

    protected $_defaultEavValuesSelect = array(
        'type'                       => 'int',
        'input'                      => 'select',
        'backend'                    => 'eav/entity_attribute_backend_array',
    );

    protected $_defaultEavValuesMultiselect = array(
        'input'                      => 'multiselect',
        'backend'                    => 'eav/entity_attribute_backend_array',
    );
}