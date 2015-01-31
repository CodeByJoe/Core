<?php
/**
 * CodeByJoe Ltd :: http://www.codebyjoe.com
 *
 * @category CodeByJoe
 * @package CodeByJoe_Core
 * @author Joseph McDermott <code@josephmcdermott.co.uk>
 * @license http://choosealicense.com/licenses/mit/ MIT License
 */
class CodeByJoe_Core_Helper_Attribute_Category extends CodeByJoe_Core_Helper_Attribute_AttributeAbstract
{
    /**
     * @param int $attributeId
     * @return Mage_Eav_Model_Entity_Attribute
     * @author Joseph McDermott <code@josephmcdermott.co.uk>
     */
    public function getAttributeById($attributeId)
    {
        $attribute = $this->getAttribute($attributeId, 'attribute_id');

        return $attribute;
    }

    /**
     * @param string $attributeCode
     * @return Mage_Eav_Model_Entity_Attribute
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
     * @return Mage_Eav_Model_Entity_Attribute
     * @throws Exception
     * @author Joseph McDermott <code@josephmcdermott.co.uk>
     */
    public function getAttribute($identifier, $identifierType)
    {
        $collection = Mage::getResourceModel('catalog/category_attribute_collection')
            ->addFieldToFilter($identifierType, $identifier);
        if ($collection->count() > 1) {
            throw new CodeByJoe_Core_Exception_TooManyException(
                "Too many results returned for filter: {$identifierType} / {$identifier}"
            );
        }

        $attribute = $collection->getFirstItem();
        if (!$attribute instanceof Mage_Eav_Model_Entity_Attribute || !$attribute->getId()) {
            throw new Exception("Unable to load category attribute: {$identifierType} / {$identifier}");
        }

        // fully load the group so we have a safe-to-save, up-to-date version
        $attribute->load($attribute->getId());

        return $attribute;
    }

    /**
     * @return int
     * @author Joseph McDermott <code@josephmcdermott.co.uk>
     */
    public function getEntityTypeId()
    {
        $catalogEavSetup = $this->_getCatalogEavSetup();
        $entityTypeId = $catalogEavSetup->getEntityTypeId('catalog_category');

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
}