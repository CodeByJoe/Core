<?php
/**
 * CodeByJoe Ltd :: http://www.codebyjoe.com
 *
 * @category CodeByJoe
 * @package CodeByJoe_Toolbox
 * @author Joseph McDermott <code@josephmcdermott.co.uk>
 * @license http://choosealicense.com/licenses/mit/ MIT License
 */
class CodeByJoe_Toolbox_Helper_Product extends Mage_Core_Helper_Abstract
{
    /**
     * The following does not work for catalog entites:
     * Mage::getModel('catalog/product')->load($sku, 'sku');
     *
     * The following works, however you get a result from a collection, which can be incomplete:
     * Mage::getModel('catalog/product')->loadByAttribute('sku', $sku);
     *
     * Therefore, the best method is to load by the product ID retrieved from the SKU.
     *
     * @param string $sku
     * @return Mage_Catalog_Model_Product
     * @author Joseph McDermott <code@josephmcdermott.co.uk>
     */
    public function loadProductBySku($sku)
    {
        $productModel = Mage::getModel('catalog/product');
        $productId = $productModel->getIdBySku($sku);
        if ($productId) {
            $productModel->load($productId);
        }

        return $productModel;
    }

    /**
     * @todo
     * getAttributeText()
     */
}