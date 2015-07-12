<?php
/**
 * CodeByJoe Ltd :: http://www.codebyjoe.com
 *
 * @category CodeByJoe
 * @package CodeByJoe_Toolbox
 * @author Joseph McDermott <code@josephmcdermott.co.uk>
 * @license http://choosealicense.com/licenses/mit/ MIT License
 */
class CodeByJoe_Toolbox_Helper_Attribute_Customer extends CodeByJoe_Toolbox_Helper_Attribute_AttributeAbstract
{
    /**
     * @param int $attributeId
     * @return Mage_Eav_Model_Entity_Attribute
     * @author Joseph McDermott <code@josephmcdermott.co.uk>
     */
    public function getAddressAttributeById($attributeId)
    {
        $attribute = $this->getAddressAttribute($attributeId, 'attribute_id');

        return $attribute;
    }

    /**
     * @param string $attributeCode
     * @return Mage_Eav_Model_Entity_Attribute
     * @author Joseph McDermott <code@josephmcdermott.co.uk>
     */
    public function getAddressAttributeByCode($attributeCode)
    {
        $attribute = $this->getAddressAttribute($attributeCode, 'attribute_code');

        return $attribute;
    }

    /**
     * @param int|string $identifier
     * @param string $identifierType
     * @return mixed
     * @throws Exception
     * @author Joseph McDermott <code@josephmcdermott.co.uk>
     */
    public function getAddressAttribute($identifier, $identifierType)
    {
        $collection = Mage::getResourceModel('customer/address_attribute_collection')
            ->addFieldToFilter($identifierType, $identifier);
        if ($collection->count() > 1) {
            throw new CodeByJoe_Toolbox_Exception_TooManyException(
                "Too many results returned for filter: {$identifierType} / {$identifier}"
            );
        }

        $attribute = $collection->getFirstItem();
        if (!$attribute instanceof Mage_Eav_Model_Entity_Attribute || !$attribute->getId()) {
            throw new Exception("Unable to load customer address attribute: {$identifierType} / {$identifier}");
        }

        // fully load the group so we have a safe-to-save, up-to-date version
        $attribute->load($attribute->getId());

        return $attribute;
    }
}