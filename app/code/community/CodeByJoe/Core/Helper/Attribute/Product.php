<?php
/**
 * CodeByJoe Ltd :: http://www.codebyjoe.com
 *
 * @category CodeByJoe
 * @package CodeByJoe_Core
 * @author Joseph McDermott <code@josephmcdermott.co.uk>
 * @license http://choosealicense.com/licenses/mit/ MIT License
 */
class CodeByJoe_Core_Helper_Attribute_Product extends CodeByJoe_Core_Helper_Attribute_AttributeAbstract
{
    /**
     * @param int $attributeId
     * @return Mage_Catalog_Model_Resource_Eav_Attribute
     * @author Joseph McDermott <code@josephmcdermott.co.uk>
     */
    public function getAttributeById($attributeId)
    {
        $attribute = $this->getAttribute($attributeId, 'attribute_id');

        return $attribute;
    }

    /**
     * @param string $attributeCode
     * @return Mage_Catalog_Model_Resource_Eav_Attribute
     * @author Joseph McDermott <code@josephmcdermott.co.uk>
     */
    public function getAttributeByCode($attributeCode)
    {
        $attribute = $this->getAttribute($attributeCode, 'attribute_code');

        return $attribute;
    }

    /**
     * @param int|string $identifier
     * @param string $identifierType
     * @return Mage_Catalog_Model_Resource_Eav_Attribute
     * @throws CodeByJoe_Core_Exception_Attribute_NotExist
     * @author Joseph McDermott <code@josephmcdermott.co.uk>
     */
    public function getAttribute($identifier, $identifierType)
    {
        $collection = Mage::getResourceModel('catalog/product_attribute_collection')
            ->addFieldToFilter($identifierType, $identifier);
        if ($collection->count() > 1) {
            throw new CodeByJoe_Core_Exception_TooManyException(
                "Too many results returned for filter: {$identifierType} / {$identifier}"
            );
        }

        $attribute = $collection->getFirstItem();
        if (!$attribute instanceof Mage_Catalog_Model_Resource_Eav_Attribute || !$attribute->getId()) {
            throw new CodeByJoe_Core_Exception_Attribute_NotExist(
                "Unable to load product attribute: {$identifierType} / {$identifier}"
            );
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
    public function addAttribute($code, $type = null, array $data = array(), array $options = array())
    {
        $defaultData = $this->_defaultEavValues;
        
        switch ($type) {
            case self::TYPE_YESNO:
                $defaultData = array_merge($defaultData, $this->_defaultEavValuesYesno);
                break;

            case self::TYPE_SELECT:
                $defaultData = array_merge($defaultData, $this->_defaultEavValuesSelect);
                break;

            case self::TYPE_MULTISELECT:
                $defaultData = array_merge($defaultData, $this->_defaultEavValuesMultiselect);
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
        $entityTypeId = $this->getEntityTypeId();
        $setup = $this->_getCatalogEavSetup();
        $setup->addAttribute($entityTypeId, $code, $data);

        return $this;
    }

    /**
     * @param string $attributeCode
     * @param array $data
     * @return $this
     * @author Joseph McDermott <code@josephmcdermott.co.uk>
     */
    public function updateAttribute($attributeCode, array $data)
    {
        $setup = $this->_getCatalogEavSetup();
        $entityTypeId = $this->getEntityTypeId();

        $setup->updateAttribute($entityTypeId, $attributeCode, $data);

        return $this;
    }

    /**
     * @param string $code
     * @return $this
     * @author Joseph McDermott <code@josephmcdermott.co.uk>
     */
    public function removeAttribute($code)
    {
        $entityTypeId = $this->getEntityTypeId();
        $setup = $this->_getCatalogEavSetup();
        $setup->removeAttribute($entityTypeId, $code);

        return $this;
    }
    
    /**
     * @param int $attributeId
     * @param array $optionsToAdd
     * @return $this
     * @author Joseph McDermott <code@josephmcdermott.co.uk>
     */
    public function addAttributeOptions($attributeId, array $optionsToAdd)
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
    public function removeAttributeOptions(Mage_Catalog_Model_Resource_Eav_Attribute $attribute, array $optionsToRemove)
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
     * @param int $attributeGroupId
     * @param int $attributeSetId
     * @return Mage_Eav_Model_Entity_Attribute_Group
     * @author Joseph McDermott <code@josephmcdermott.co.uk>
     */
    public function getAttributeGroupById($attributeGroupId, $attributeSetId)
    {
        $attributeGroup = $this->getAttributeGroup($attributeGroupId, $attributeSetId, 'attribute_group_id');

        return $attributeGroup;
    }

    /**
     * @param string $attributeGroupName
     * @param int $attributeSetId
     * @param bool $createIfNotExist
     * @return Mage_Eav_Model_Entity_Attribute_Group
     * @throws CodeByJoe_Core_Exception_Attribute_Group_NotExistException
     * @throws Exception
     * @author Joseph McDermott <code@josephmcdermott.co.uk>
     */
    public function getAttributeGroupByName($attributeGroupName, $attributeSetId, $createIfNotExist = false)
    {
        try {
            $attributeGroup = $this->getAttributeGroup($attributeGroupName, 'attribute_group_name', $attributeSetId);
        } catch (CodeByJoe_Core_Exception_Attribute_Group_NotExistException $e) {
            if (!$createIfNotExist) {
                throw $e;
            }

            $attributeGroup = $this->createAttributeGroup($attributeGroupName, $attributeSetId);
        }

        return $attributeGroup;
    }

    /**
     * @param int|string $identifier
     * @param string $identifierType
     * @param int $attributeSetId
     * @return Mage_Eav_Model_Entity_Attribute_Group
     * @throws CodeByJoe_Core_Exception_Attribute_Group_NotExistException
     * @author Joseph McDermott <code@josephmcdermott.co.uk>
     */
    public function getAttributeGroup($identifier, $identifierType, $attributeSetId)
    {
        $collection = Mage::getResourceModel('eav/entity_attribute_group_collection')
            ->addFieldToFilter($identifierType, $identifier)
            ->addFieldToFilter('attribute_set_id', $attributeSetId);
        if ($collection->count() > 1) {
            throw new CodeByJoe_Core_Exception_TooManyException(
                "Too many results returned for filter: {$identifierType} / {$identifier}"
            );
        }

        $attributeGroup = $collection->getFirstItem();
        if (!$attributeGroup instanceof Mage_Eav_Model_Entity_Attribute_Group || !$attributeGroup->getId()) {
            throw new CodeByJoe_Core_Exception_Attribute_Group_NotExistException(
                "Unable to load product attribute group: {$identifierType} / {$identifier} / {$attributeSetId}"
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
    public function createAttributeGroup($groupName, $attributeSetId, $sortOrder = 10)
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
    public function assignAttributeToGroup($attributeId, $attributeSetId, $attributeGroupId, $sortOrder = 10)
    {
        $connection = $this->_getDatabaseHelper()->getWriteConnection();
        $tableName = $this->_getDatabaseHelper()->getTableName('eav/entity_attribute');
        $entityTypeId = $this->getEntityTypeId();

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
    public function getAttributeSets()
    {
        $entityTypeId = $this->getEntityTypeId();
        $collection = Mage::getResourceModel('eav/entity_attribute_set_collection')
            ->addFieldToFilter('entity_type_id', $entityTypeId);

        return $collection;
    }

    /**
     * @return int
     * @author Joseph McDermott <code@josephmcdermott.co.uk>
     */
    public function getEntityTypeId()
    {
        $catalogEavSetup = $this->_getCatalogEavSetup();
        $entityTypeId = $catalogEavSetup->getEntityTypeId('catalog_product');

        return $entityTypeId;
    }

    /**
     * @return Mage_Catalog_Model_Resource_Eav_Mysql4_Setup|null
     * @author Joseph McDermott <code@josephmcdermott.co.uk>
     */
    protected function _getCatalogEavSetup()
    {
        return new Mage_Catalog_Model_Resource_Setup('core_setup');
    }

    /**
     * @return CodeByJoe_Core_Model_Database
     * @author Joseph McDermott <code@josephmcdermott.co.uk>
     */
    protected function _getDatabaseHelper()
    {
        return Mage::getSingleton('codebyjoe_core/database');
    }
}