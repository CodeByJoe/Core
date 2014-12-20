<?php
/**
 * CodeByJoe Ltd :: http://www.codebyjoe.com
 *
 * @category CodeByJoe
 * @package CodeByJoe_Core
 * @author Joseph McDermott <code@josephmcdermott.co.uk>
 * @license http://choosealicense.com/licenses/mit/ MIT License
 */
class CodeByJoe_Core_Helper_Attribute extends Mage_Core_Helper_Abstract
{
    const TYPE_YESNO = 'yesno';
    const TYPE_SELECT = 'select';
    const TYPE_MULTISELECT = 'multiselect';
    
    protected $_catalogEavSetup = null;
    protected $_entityTypesById = array();

    protected $_defaultAttributeOptions = array(
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
    protected $_defaultAttributeOptionsYesno = array(
        'type'                       => 'int',
        'input'                      => 'select',
        'source'                     => 'eav/entity_attribute_source_boolean',
        'backend'                    => 'eav/entity_attribute_backend_array',
    );
    protected $_defaultAttributeOptionsSelect = array(
        'type'                       => 'int',
        'input'                      => 'select',
        'backend'                    => 'eav/entity_attribute_backend_array',
    );
    protected $_defaultAttributeOptionsMultiselect = array(
        'input'                      => 'multiselect',
        'backend'                    => 'eav/entity_attribute_backend_array',
    );

    /**
     * @return int
     * @author Joseph McDermott <code@josephmcdermott.co.uk>
     */
    public function getProductEntityTypeId()
    {
        $entityTypeId = $this->_getEntityTypeId('catalog_product');

        return $entityTypeId;
    }

    /**
     * @return int
     * @author Joseph McDermott <code@josephmcdermott.co.uk>
     */
    public function getCategoryEntityTypeId()
    {
        $entityTypeId = $this->_getEntityTypeId('catalog_category');

        return $entityTypeId;
    }

    /**
     * @param string $type
     * @return int
     * @author Joseph McDermott <code@josephmcdermott.co.uk>
     */
    protected function _getEntityTypeId($type)
    {
        if (!array_key_exists($type, $this->_entityTypesById)) {
            $catalogEavSetup = $this->_getCatalogEavSetup();
            $entityTypeId = $catalogEavSetup->getEntityTypeId($type);

            $this->_entityTypesById[$type] = $entityTypeId;
        }

        return $this->_entityTypesById[$type];
    }

    /**
     * @return Mage_Catalog_Model_Resource_Eav_Mysql4_Setup|null
     * @author Joseph McDermott <code@josephmcdermott.co.uk>
     */
    protected function _getCatalogEavSetup()
    {
        if (is_null($this->_catalogEavSetup)) {
            $this->_catalogEavSetup = new Mage_Catalog_Model_Resource_Eav_Mysql4_Setup('core_setup');
        }

        return $this->_catalogEavSetup;
    }

    /**
     * @param int $attributeId
     * @return Mage_Catalog_Model_Resource_Eav_Attribute
     * @author Joseph McDermott <code@josephmcdermott.co.uk>
     */
    public function getProductAttributeById($attributeId)
    {
        $attribute = $this->getProductAttribute($attributeId, 'attribute_id');

        return $attribute;
    }

    /**
     * @param string $attributeCode
     * @return Mage_Catalog_Model_Resource_Eav_Attribute
     * @author Joseph McDermott <code@josephmcdermott.co.uk>
     */
    public function getProductAttributeByCode($attributeCode)
    {
        $attribute = $this->getProductAttribute($attributeCode, 'attribute_code');

        return $attribute;
    }

    /**
     * @param int|string $identifier
     * @param string $identifierType
     * @return Mage_Catalog_Model_Resource_Eav_Attribute
     * @throws Exception
     * @author Joseph McDermott <code@josephmcdermott.co.uk>
     */
    public function getProductAttribute($identifier, $identifierType)
    {
        $attribute = Mage::getResourceModel('catalog/product_attribute_collection')
            ->addFieldToFilter($identifierType, $identifier)
            ->getFirstItem();

        if (!$attribute instanceof Mage_Catalog_Model_Resource_Eav_Attribute || !$attribute->getId()) {
            throw new Exception("Unable to load product attribute: {$identifierType} / {$identifier}");
        }

        // fully load the group so we have a safe-to-save, up-to-date version
        $attribute->load($attribute->getId());

        return $attribute;
    }

    /**
     * @param string $attributeCode
     * @param array $data
     * @return $this
     * @author Joseph McDermott <code@josephmcdermott.co.uk>
     */
    public function updateProductAttribute($attributeCode, array $data)
    {
        $setup = $this->_getCatalogEavSetup();
        $entityTypeId = $this->getProductEntityTypeId();

        $setup->updateAttribute($entityTypeId, $attributeCode, $data);

        return $this;
    }

    /**
     * @param int $attributeGroupId
     * @param int $attributeSetid
     * @return Mage_Eav_Model_Entity_Attribute_Group
     * @author Joseph McDermott <code@josephmcdermott.co.uk>
     */
    public function getProductAttributeGroupById($attributeGroupId, $attributeSetid)
    {
        $attributeGroup = $this->getProductAttributeGroup($attributeGroupId, $attributeSetid, 'attribute_group_id');

        return $attributeGroup;
    }

    /**
     * @param string $attributeGroupName
     * @param int $attributeSetid
     * @param bool $createIfNotExist
     * @return Mage_Eav_Model_Entity_Attribute_Group
     * @throws CodeByJoe_Core_Exception_Attribute_Group_NotExistException
     * @throws Exception
     * @author Joseph McDermott <code@josephmcdermott.co.uk>
     */
    public function getProductAttributeGroupByName($attributeGroupName, $attributeSetid, $createIfNotExist = false)
    {
        try {
            $attributeGroup = $this->getProductAttributeGroup($attributeGroupName, 'attribute_group_name', $attributeSetid);
        } catch (CodeByJoe_Core_Exception_Attribute_Group_NotExistException $e) {
            if (!$createIfNotExist) {
                throw $e;
            }

            $attributeGroup = $this->createProductAttributeGroup($attributeGroupName, $attributeSetid);
        }

        return $attributeGroup;
    }

    /**
     * @param int|string $identifier
     * @param string $identifierType
     * @param int $attributeSetid
     * @return Mage_Eav_Model_Entity_Attribute_Group
     * @throws CodeByJoe_Core_Exception_Attribute_Group_NotExistException
     * @author Joseph McDermott <code@josephmcdermott.co.uk>
     */
    public function getProductAttributeGroup($identifier, $identifierType, $attributeSetid)
    {
        $attributeGroup = Mage::getResourceModel('eav/entity_attribute_group_collection')
            ->addFieldToFilter($identifierType, $identifier)
            ->addFieldToFilter('attribute_set_id', $attributeSetid)
            ->getFirstItem();

        if (!$attributeGroup instanceof Mage_Eav_Model_Entity_Attribute_Group || !$attributeGroup->getId()) {
            throw new CodeByJoe_Core_Exception_Attribute_Group_NotExistException(
                "Unable to load product attribute group: {$identifierType} / {$identifier} / {$attributeSetid}"
            );
        }

        // fully load the group so we have a safe-to-save, up-to-date version
        $attributeGroup->load($attributeGroup->getId());

        return $attributeGroup;
    }

    /**
     * @param string $groupName
     * @param int $attributeSetId
     * @param int $sortOrder
     * @return mixed
     * @author Joseph McDermott <code@josephmcdermott.co.uk>
     */
    public function createProductAttributeGroup($groupName, $attributeSetId, $sortOrder = 10)
    {
        $attributeGroup = Mage::getModel('eav/entity_attribute_group')
            ->setAttributeGroupName($groupName)
            ->setAttributeSetId($attributeSetId)
            ->setSortOrder($sortOrder)
            ->save();

        return $attributeGroup;
    }

    /**
     * @param int $attributeId
     * @param int $attributeSetId
     * @param int $attributeGroupId
     * @param int $sortOrder
     * @return $this
     * @throws CodeByJoe_Core_Exception_Attribute_NotInSetException
     * @author Joseph McDermott <code@josephmcdermott.co.uk>
     */
    public function assignProductAttributeToGroup($attributeId, $attributeSetId, $attributeGroupId, $sortOrder = 10)
    {
        $connection = $this->_getDatabaseHelper()->getWriteConnection();
        $tableName = $this->_getDatabaseHelper()->getTableName('eav/entity_attribute');
        $entityTypeId = $this->getProductEntityTypeId();

        // fetch existing assignment to be updated
        $select = $connection->select()
            ->from($tableName)
            ->where('entity_type_id = ?', $entityTypeId)
            ->where('attribute_set_id = ?', $attributeSetId)
            ->where('attribute_id = ?', $attributeId);
        $result = $connection->fetchRow($select);
        if (!$result) {
            throw new CodeByJoe_Core_Exception_Attribute_NotInSetException(
                "Attribute does not belong to attribute set ID: {$attributeSetId}"
            );
        }

        // update the existing assignment with new group and sort order
        $entityAttributeId = $result['entity_attribute_id'];
        $connection->update(
            $tableName,
            array(
                'attribute_group_id' => $attributeGroupId,
                'sort_order' => $sortOrder,
            ),
            array(
                'entity_attribute_id = ?' => $entityAttributeId,
            )
        );

        return $this;
    }

    /**
     * @return Mage_Eav_Model_Resource_Entity_Attribute_Set_Collection
     * @author Joseph McDermott <code@josephmcdermott.co.uk>
     */
    public function getProductAttributeSets()
    {
        $entityTypeId = $this->getProductEntityTypeId();
        $collection = Mage::getResourceModel('eav/entity_attribute_set_collection')
            ->addFieldToFilter('entity_type_id', $entityTypeId);

        return $collection;
    }

    /**
     * @return CodeByJoe_Core_Model_Database
     * @author Joseph McDermott <code@josephmcdermott.co.uk>
     */
    protected function _getDatabaseHelper()
    {
        return Mage::getSingleton('codebyjoe_core/database');
    }

    /**
     * @param int $attributeId
     * @param array $optionsToAdd
     * @return $this
     * @author Joseph McDermott <code@josephmcdermott.co.uk>
     */
    public function addProductAttributeOptions($attributeId, array $optionsToAdd)
    {
        $counter = 0;
        $options = array();
        foreach ($optionsToAdd as $_optionToAdd) {
            $options['attribute_id'] = $attributeId;
            $options['value']['option_' . $counter++][0] = $_optionToAdd;
        }

        $setup = $this->_getCatalogEavSetup();
        $setup->addAttributeOption($options);

        return $this;
    }

    /**
     * @param Mage_Catalog_Model_Resource_Eav_Attribute $attribute
     * @param array $optionsToRemove
     * @return $this
     * @author Joseph McDermott <code@josephmcdermott.co.uk>
     */
    public function removeProductAttributeOptions(Mage_Catalog_Model_Resource_Eav_Attribute $attribute, array $optionsToRemove)
    {
        $options = array();
        $existingOptions = $attribute->getSource()->getAllOptions();
        foreach ($existingOptions as $_value) {
            if ($_optionId = $_value['value']) {
                if (in_array($_value['label'], $optionsToRemove)) {
                    $options['delete'][$_optionId] = true;
                    $options['value'][$_optionId] = true;
                }
            }
        }

        $setup = $this->_getCatalogEavSetup();
        $setup->addAttributeOption($options);

        return $this;
    }

    /**
     * @param int $attributeId
     * @return Mage_Eav_Model_Entity_Attribute
     * @author Joseph McDermott <code@josephmcdermott.co.uk>
     */
    public function getCategoryAttributeById($attributeId)
    {
        $attribute = $this->getCategoryAttribute($attributeId, 'attribute_id');

        return $attribute;
    }

    /**
     * @param string $attributeCode
     * @return Mage_Eav_Model_Entity_Attribute
     * @author Joseph McDermott <code@josephmcdermott.co.uk>
     */
    public function getCategoryAttributeByCode($attributeCode)
    {
        $attribute = $this->getCategoryAttribute($attributeCode, 'attribute_code');

        return $attribute;
    }

    /**
     * @param int|string $identifier
     * @param string $identifierType
     * @return Mage_Eav_Model_Entity_Attribute
     * @throws Exception
     * @author Joseph McDermott <code@josephmcdermott.co.uk>
     */
    public function getCategoryAttribute($identifier, $identifierType)
    {
        $attribute = Mage::getResourceModel('catalog/category_attribute_collection')
            ->addFieldToFilter($identifierType, $identifier)
            ->getFirstItem();

        if (!$attribute instanceof Mage_Eav_Model_Entity_Attribute || !$attribute->getId()) {
            throw new Exception("Unable to load category attribute: {$identifierType} / {$identifier}");
        }

        // fully load the group so we have a safe-to-save, up-to-date version
        $attribute->load($attribute->getId());

        return $attribute;
    }

    /**
     * @param string $code
     * @param string $type
     * @param array $data
     * @param array $options
     * @return $this
     * @author Joseph McDermott <code@josephmcdermott.co.uk>
     */
    public function addProductAttribute($code, $type = null, array $data = array(), array $options = array())
    {
        // prepare default values
        $defaultData = $this->_defaultAttributeOptions;
        switch ($type) {
            case self::TYPE_YESNO:
                $defaultData = array_merge($defaultData, $this->_defaultAttributeOptionsYesno);
                break;
            
            case self::TYPE_SELECT:
                $defaultData = array_merge($defaultData, $this->_defaultAttributeOptionsSelect);
                break;
            
            case self::TYPE_MULTISELECT:
                $defaultData = array_merge($defaultData, $this->_defaultAttributeOptionsMultiselect);
                break;
            
            default:
                break;
        }
        
        // set additional defaults and override with provided $data
        $defaultData['label'] = $code;
        $data = array_merge($defaultData, $data);

        // prepare options, if provided
        if (!is_null($options)) {
            $data['option']['values'] = $options;
        }

        // add the attribute
        $entityTypeId = $this->getProductEntityTypeId();
        $setup = new Mage_Catalog_Model_Resource_Setup('core_setup');
        $setup->addAttribute($entityTypeId, $code, $data);
        
        return $this;
    }

    /**
     * @param string $code
     * @return $this
     * @author Joseph McDermott <code@josephmcdermott.co.uk>
     */
    public function removeProductAttribute($code)
    {
        $entityTypeId = $this->getProductEntityTypeId();
        $setup = new Mage_Catalog_Model_Resource_Setup('core_setup');
        $setup->removeAttribute($entityTypeId, $code);

        return $this;
    }

    /**
     * @param int $attributeId
     * @return Mage_Eav_Model_Entity_Attribute
     * @author Joseph McDermott <code@josephmcdermott.co.uk>
     */
    public function getCustomerAddressAttributeById($attributeId)
    {
        $attribute = $this->getCustomerAddressAttribute($attributeId, 'attribute_id');

        return $attribute;
    }

    /**
     * @param string $attributeCode
     * @return Mage_Eav_Model_Entity_Attribute
     * @author Joseph McDermott <code@josephmcdermott.co.uk>
     */
    public function getCustomerAddressAttributeByCode($attributeCode)
    {
        $attribute = $this->getCustomerAddressAttribute($attributeCode, 'attribute_code');

        return $attribute;
    }

    /**
     * @param int|string $identifier
     * @param string $identifierType
     * @return mixed
     * @throws Exception
     * @author Joseph McDermott <code@josephmcdermott.co.uk>
     */
    public function getCustomerAddressAttribute($identifier, $identifierType)
    {
        $attribute = Mage::getResourceModel('customer/address_attribute_collection')
            ->addFieldToFilter($identifierType, $identifier)
            ->getFirstItem();

        if (!$attribute instanceof Mage_Eav_Model_Entity_Attribute || !$attribute->getId()) {
            throw new Exception("Unable to load customer address attribute: {$identifierType} / {$identifier}");
        }

        // fully load the group so we have a safe-to-save, up-to-date version
        $attribute->load($attribute->getId());

        return $attribute;
    }
}