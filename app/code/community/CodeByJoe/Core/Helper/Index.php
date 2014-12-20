<?php
/**
 * CodeByJoe Ltd :: http://www.codebyjoe.com
 *
 * @category CodeByJoe
 * @package CodeByJoe_Core
 * @author Joseph McDermott <code@josephmcdermott.co.uk>
 * @license http://choosealicense.com/licenses/mit/ MIT License
 */
class CodeByJoe_Core_Helper_Index extends Mage_Core_Helper_Abstract
{
    const INDEX_ALL = 'all';
    const INDEX_PRODUCT_ATTRIBUTES = 'catalog_product_attribute';
    const INDEX_PRODUCT_PRICES = 'catalog_product_price';
    const INDEX_CATALOG_URL_REWRITES = 'catalog_url';
    const INDEX_PRODUCT_FLAT_DATA = 'catalog_product_flat';
    const INDEX_CATEGORY_FLAT_DATA = 'catalog_category_flat';
    const INDEX_CATEGORY_PRODUCTS = 'catalog_category_product';
    const INDEX_CATALOG_SEARCH_INDEX = 'catalogsearch_fulltext';
    const INDEX_STOCK_STATUS = 'cataloginventory_stock';
    const INDEX_TAG_AGGREGATION_DATA = 'tag_summary';
    
    /**
     * @return $this
     * @author Joseph McDermott <code@josephmcdermott.co.uk>
     */
    public function reindexAll()
    {
        $this->reindex(self::INDEX_ALL);
        
        return $this;
    }
    
    /**
     * @return $this
     * @author Joseph McDermott <code@josephmcdermott.co.uk>
     */
    public function reindexProductAttributes()
    {
        $this->reindex(self::INDEX_PRODUCT_ATTRIBUTES);
    }
    
    /**
     * @return $this
     * @author Joseph McDermott <code@josephmcdermott.co.uk>
     */
    public function reindexProductPrices()
    {
        $this->reindex(self::INDEX_PRODUCT_PRICES);
    }
    
    /**
     * @return $this
     * @author Joseph McDermott <code@josephmcdermott.co.uk>
     */
    public function reindexCatalogUrlRewrites()
    {
        $this->reindex(self::INDEX_CATALOG_URL_REWRITES);
    }
    
    /**
     * @return $this
     * @author Joseph McDermott <code@josephmcdermott.co.uk>
     */
    public function reindexProductFlatData()
    {
        $this->reindex(self::INDEX_PRODUCT_FLAT_DATA);
    }
    
    /**
     * @return $this
     * @author Joseph McDermott <code@josephmcdermott.co.uk>
     */
    public function reindexCategoryFlatData()
    {
        $this->reindex(self::INDEX_CATEGORY_FLAT_DATA);
    }
    
    /**
     * @return $this
     * @author Joseph McDermott <code@josephmcdermott.co.uk>
     */
    public function reindexCategoryProducts()
    {
        $this->reindex(self::INDEX_CATEGORY_PRODUCTS);
    }
    
    /**
     * @return $this
     * @author Joseph McDermott <code@josephmcdermott.co.uk>
     */
    public function reindexCatalogSearchIndex()
    {
        $this->reindex(self::INDEX_CATALOG_SEARCH_INDEX);
    }
    
    /**
     * @return $this
     * @author Joseph McDermott <code@josephmcdermott.co.uk>
     */
    public function reindexStockStatus()
    {
        $this->reindex(self::INDEX_STOCK_STATUS);
    }
    
    /**
     * @return $this
     * @author Joseph McDermott <code@josephmcdermott.co.uk>
     */
    public function reindexTagAggregationData()
    {
        $this->reindex(self::INDEX_TAG_AGGREGATION_DATA);
    }

    /**
     * @param string $index
     * @return $this
     * @author Joseph McDermott <code@josephmcdermott.co.uk>
     */
    public function reindex($index)
    {
        $scriptPath = Mage::getBaseDir() . DS . 'shell' . DS . 'indexer.php';
        shell_exec("php {$scriptPath} --reindex {$index}");
        
        return $this;
    }

    /**
     * @return $this
     * @author Joseph McDermott <code@josephmcdermott.co.uk>
     */
    public function synchronizeFlatTables()
    {
        Mage::getResourceModel('catalog/category_flat')->synchronize();
        
        return $this;
    }
}