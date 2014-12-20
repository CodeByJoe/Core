<?php
/**
 * CodeByJoe Ltd :: http://www.codebyjoe.com
 *
 * @category CodeByJoe
 * @package CodeByJoe_Core
 * @author Joseph McDermott <code@josephmcdermott.co.uk>
 * @license http://choosealicense.com/licenses/mit/ MIT License
 */
class CodeByJoe_Core_Helper_Cache extends Mage_Core_Helper_Abstract
{
    const TYPE_CONFIGURATION = 'config';
    const TYPE_LAYOUTS = 'layout';
    const TYPE_BLOCKS_HTML_OUTPUT = 'block_html';
    const TYPE_TRANSLATIONS = 'translate';
    const TYPE_COLLECTIONS_DATA = 'collections';
    const TYPE_EAV_TYPES_AND_ATTRIBUTES = 'eav';
    const TYPE_WEB_SERVICES_CONFIGURATION_V1 = 'config_api';
    const TYPE_WEB_SERVICES_CONFIGURATION_V2 = 'config_api2';
    const TYPE_PAGE_CACHE = 'full_page';

    /**
     * @return $this
     * @author Joseph McDermott <code@josephmcdermott.co.uk>
     */
    public function enableAll()
    {
        $this->massEnable(array(
            self::TYPE_CONFIGURATION,
            self::TYPE_LAYOUTS,
            self::TYPE_BLOCKS_HTML_OUTPUT,
            self::TYPE_TRANSLATIONS,
            self::TYPE_COLLECTIONS_DATA,
            self::TYPE_EAV_TYPES_AND_ATTRIBUTES,
            self::TYPE_WEB_SERVICES_CONFIGURATION_V1,
            self::TYPE_WEB_SERVICES_CONFIGURATION_V2,
            self::TYPE_PAGE_CACHE,
        ));

        return $this;
    }

    /**
     * @return $this
     * @author Joseph McDermott <code@josephmcdermott.co.uk>
     */
    public function enableConfiguration()
    {
        $this->massEnable(array(
            self::TYPE_CONFIGURATION,
        ));
    }

    /**
     * @return $this
     * @author Joseph McDermott <code@josephmcdermott.co.uk>
     */
    public function enableLayouts()
    {
        $this->massEnable(array(
            self::TYPE_LAYOUTS,
        ));
    }

    /**
     * @return $this
     * @author Joseph McDermott <code@josephmcdermott.co.uk>
     */
    public function enableBlocksHtmlOutput()
    {
        $this->massEnable(array(
            self::TYPE_BLOCKS_HTML_OUTPUT,
        ));
    }

    /**
     * @return $this
     * @author Joseph McDermott <code@josephmcdermott.co.uk>
     */
    public function enableTranslations()
    {
        $this->massEnable(array(
            self::TYPE_TRANSLATIONS,
        ));
    }

    /**
     * @return $this
     * @author Joseph McDermott <code@josephmcdermott.co.uk>
     */
    public function enableCollectionsData()
    {
        $this->massEnable(array(
            self::TYPE_COLLECTIONS_DATA,
        ));
    }

    /**
     * @return $this
     * @author Joseph McDermott <code@josephmcdermott.co.uk>
     */
    public function enableEavTypesAndAttributes()
    {
        $this->massEnable(array(
            self::TYPE_EAV_TYPES_AND_ATTRIBUTES,
        ));
    }

    /**
     * @return $this
     * @author Joseph McDermott <code@josephmcdermott.co.uk>
     */
    public function enableWebServicesConfiguration()
    {
        $this->massEnable(array(
            self::TYPE_WEB_SERVICES_CONFIGURATION_V1,
            self::TYPE_WEB_SERVICES_CONFIGURATION_V2,
        ));
    }

    /**
     * @return $this
     * @author Joseph McDermott <code@josephmcdermott.co.uk>
     */
    public function enableWebServicesConfigurationV1()
    {
        $this->massEnable(array(
            self::TYPE_WEB_SERVICES_CONFIGURATION_V1,
        ));
    }

    /**
     * @return $this
     * @author Joseph McDermott <code@josephmcdermott.co.uk>
     */
    public function enableWebServicesConfigurationV2()
    {
        $this->massEnable(array(
            self::TYPE_WEB_SERVICES_CONFIGURATION_V2,
        ));
    }

    /**
     * @return $this
     * @author Joseph McDermott <code@josephmcdermott.co.uk>
     */
    public function enablePageCache()
    {
        $this->massEnable(array(
            self::TYPE_PAGE_CACHE,
        ));
    }

    /**
     * @param array $types
     * @return $this
     * @author Joseph McDermott <code@josephmcdermott.co.uk>
     */
    public function massEnable(array $types)
    {
        $allTypes = Mage::app()->useCache();

        $updatedTypes = 0;
        foreach ($types as $code) {
            if (empty($allTypes[$code])) {
                $allTypes[$code] = 1;
                $updatedTypes++;
            }
        }

        if ($updatedTypes > 0) {
            Mage::app()->saveUseCache($allTypes);
        }

        return $this;
    }

    /**
     * @return $this
     * @author Joseph McDermott <code@josephmcdermott.co.uk>
     */
    public function disableAll()
    {
        $this->massDisable(array(
            self::TYPE_CONFIGURATION,
            self::TYPE_LAYOUTS,
            self::TYPE_BLOCKS_HTML_OUTPUT,
            self::TYPE_TRANSLATIONS,
            self::TYPE_COLLECTIONS_DATA,
            self::TYPE_EAV_TYPES_AND_ATTRIBUTES,
            self::TYPE_WEB_SERVICES_CONFIGURATION_V1,
            self::TYPE_WEB_SERVICES_CONFIGURATION_V2,
            self::TYPE_PAGE_CACHE,
        ));

        return $this;
    }

    /**
     * @return $this
     * @author Joseph McDermott <code@josephmcdermott.co.uk>
     */
    public function disableConfiguration()
    {
        $this->massDisable(array(
            self::TYPE_CONFIGURATION,
        ));
    }

    /**
     * @return $this
     * @author Joseph McDermott <code@josephmcdermott.co.uk>
     */
    public function disableLayouts()
    {
        $this->massDisable(array(
            self::TYPE_LAYOUTS,
        ));
    }

    /**
     * @return $this
     * @author Joseph McDermott <code@josephmcdermott.co.uk>
     */
    public function disableBlocksHtmlOutput()
    {
        $this->massDisable(array(
            self::TYPE_BLOCKS_HTML_OUTPUT,
        ));
    }

    /**
     * @return $this
     * @author Joseph McDermott <code@josephmcdermott.co.uk>
     */
    public function disableTranslations()
    {
        $this->massDisable(array(
            self::TYPE_TRANSLATIONS,
        ));
    }

    /**
     * @return $this
     * @author Joseph McDermott <code@josephmcdermott.co.uk>
     */
    public function disableCollectionsData()
    {
        $this->massDisable(array(
            self::TYPE_COLLECTIONS_DATA,
        ));
    }

    /**
     * @return $this
     * @author Joseph McDermott <code@josephmcdermott.co.uk>
     */
    public function disableEavTypesAndAttributes()
    {
        $this->massDisable(array(
            self::TYPE_EAV_TYPES_AND_ATTRIBUTES,
        ));
    }

    /**
     * @return $this
     * @author Joseph McDermott <code@josephmcdermott.co.uk>
     */
    public function disableWebServicesConfiguration()
    {
        $this->massDisable(array(
            self::TYPE_WEB_SERVICES_CONFIGURATION_V1,
            self::TYPE_WEB_SERVICES_CONFIGURATION_V2,
        ));
    }

    /**
     * @return $this
     * @author Joseph McDermott <code@josephmcdermott.co.uk>
     */
    public function disableWebServicesConfigurationV1()
    {
        $this->massDisable(array(
            self::TYPE_WEB_SERVICES_CONFIGURATION_V1,
        ));
    }

    /**
     * @return $this
     * @author Joseph McDermott <code@josephmcdermott.co.uk>
     */
    public function disableWebServicesConfigurationV2()
    {
        $this->massDisable(array(
            self::TYPE_WEB_SERVICES_CONFIGURATION_V2,
        ));
    }

    /**
     * @return $this
     * @author Joseph McDermott <code@josephmcdermott.co.uk>
     */
    public function disablePageCache()
    {
        $this->massDisable(array(
            self::TYPE_PAGE_CACHE,
        ));
    }

    /**
     * @param array $types
     * @return $this
     * @author Joseph McDermott <code@josephmcdermott.co.uk>
     */
    public function massDisable(array $types)
    {
        $allTypes = Mage::app()->useCache();

        $updatedTypes = 0;
        foreach ($types as $code) {
            if (!empty($allTypes[$code])) {
                $allTypes[$code] = 0;
                $updatedTypes++;
            }
            Mage::app()->getCacheInstance()->cleanType($code);
        }

        if ($updatedTypes > 0) {
            Mage::app()->saveUseCache($allTypes);
        }

        return $this;
    }
    
    /**
     * @return $this
     * @author Joseph McDermott <code@josephmcdermott.co.uk>
     */
    public function refreshAll()
    {
        $this->massRefresh(array(
            self::TYPE_CONFIGURATION,
            self::TYPE_LAYOUTS,
            self::TYPE_BLOCKS_HTML_OUTPUT,
            self::TYPE_TRANSLATIONS,
            self::TYPE_COLLECTIONS_DATA,
            self::TYPE_EAV_TYPES_AND_ATTRIBUTES,
            self::TYPE_WEB_SERVICES_CONFIGURATION_V1,
            self::TYPE_WEB_SERVICES_CONFIGURATION_V2,
            self::TYPE_PAGE_CACHE,
        ));

        return $this;
    }

    /**
     * @return $this
     * @author Joseph McDermott <code@josephmcdermott.co.uk>
     */
    public function refreshConfiguration()
    {
        $this->massRefresh(array(
            self::TYPE_CONFIGURATION,
        ));
    }

    /**
     * @return $this
     * @author Joseph McDermott <code@josephmcdermott.co.uk>
     */
    public function refreshLayouts()
    {
        $this->massRefresh(array(
            self::TYPE_LAYOUTS,
        ));
    }

    /**
     * @return $this
     * @author Joseph McDermott <code@josephmcdermott.co.uk>
     */
    public function refreshBlocksHtmlOutput()
    {
        $this->massRefresh(array(
            self::TYPE_BLOCKS_HTML_OUTPUT,
        ));
    }

    /**
     * @return $this
     * @author Joseph McDermott <code@josephmcdermott.co.uk>
     */
    public function refreshTranslations()
    {
        $this->massRefresh(array(
            self::TYPE_TRANSLATIONS,
        ));
    }

    /**
     * @return $this
     * @author Joseph McDermott <code@josephmcdermott.co.uk>
     */
    public function refreshCollectionsData()
    {
        $this->massRefresh(array(
            self::TYPE_COLLECTIONS_DATA,
        ));
    }

    /**
     * @return $this
     * @author Joseph McDermott <code@josephmcdermott.co.uk>
     */
    public function refreshEavTypesAndAttributes()
    {
        $this->massRefresh(array(
            self::TYPE_EAV_TYPES_AND_ATTRIBUTES,
        ));
    }

    /**
     * @return $this
     * @author Joseph McDermott <code@josephmcdermott.co.uk>
     */
    public function refreshWebServicesConfiguration()
    {
        $this->massRefresh(array(
            self::TYPE_WEB_SERVICES_CONFIGURATION_V1,
            self::TYPE_WEB_SERVICES_CONFIGURATION_V2,
        ));
    }

    /**
     * @return $this
     * @author Joseph McDermott <code@josephmcdermott.co.uk>
     */
    public function refreshWebServicesConfigurationV1()
    {
        $this->massRefresh(array(
            self::TYPE_WEB_SERVICES_CONFIGURATION_V1,
        ));
    }

    /**
     * @return $this
     * @author Joseph McDermott <code@josephmcdermott.co.uk>
     */
    public function refreshWebServicesConfigurationV2()
    {
        $this->massRefresh(array(
            self::TYPE_WEB_SERVICES_CONFIGURATION_V2,
        ));
    }

    /**
     * @return $this
     * @author Joseph McDermott <code@josephmcdermott.co.uk>
     */
    public function refreshPageCache()
    {
        $this->massRefresh(array(
            self::TYPE_PAGE_CACHE,
        ));
    }

    /**
     * @param array $types
     * @return $this
     * @author Joseph McDermott <code@josephmcdermott.co.uk>
     */
    public function massRefresh(array $types)
    {
        foreach ($types as $type) {
            Mage::app()->getCacheInstance()->cleanType($type);
            Mage::dispatchEvent('adminhtml_cache_refresh_type', array('type' => $type));
        }

        return $this;
    }

    /**
     * @return $this
     * @author Joseph McDermott <code@josephmcdermott.co.uk>
     */
    public function flushAll()
    {
        if (function_exists('apc_clear_cache')) {
            apc_clear_cache();
            apc_clear_cache('user');
            apc_clear_cache('opcode');
        }

        Mage::dispatchEvent('adminhtml_cache_flush_all');
        Mage::app()->getCacheInstance()->flush();

        return $this;
    }

    /**
     * @return $this
     * @author Joseph McDermott <code@josephmcdermott.co.uk>
     */
    public function flushSystem()
    {
        Mage::app()->cleanCache();
        Mage::dispatchEvent('adminhtml_cache_flush_system');

        return $this;
    }

    /**
     * @return $this
     * @author Joseph McDermott <code@josephmcdermott.co.uk>
     */
    public function cleanMedia()
    {
        Mage::getModel('core/design_package')->cleanMergedJsCss();
        Mage::dispatchEvent('clean_media_cache_after');

        return $this;
    }

    /**
     * @return $this
     * @author Joseph McDermott <code@josephmcdermott.co.uk>
     */
    public function cleanImages()
    {
        Mage::getModel('catalog/product_image')->clearCache();
        Mage::dispatchEvent('clean_catalog_images_cache_after');

        return $this;
    }

    /**
     * @return $this
     * @author Joseph McDermott <code@josephmcdermott.co.uk>
     */
    public function cleanSwatches()
    {
        Mage::helper('configurableswatches/productimg')->clearSwatchesCache();
        Mage::dispatchEvent('clean_configurable_swatches_cache_after');

        return $this;
    }
}