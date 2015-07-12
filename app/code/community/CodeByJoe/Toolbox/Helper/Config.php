<?php
/**
 * CodeByJoe Ltd :: http://www.codebyjoe.com
 *
 * @category CodeByJoe
 * @package CodeByJoe_Toolbox
 * @author Joseph McDermott <code@josephmcdermott.co.uk>
 * @license http://choosealicense.com/licenses/mit/ MIT License
 */
class CodeByJoe_Toolbox_Helper_Config extends Mage_Core_Helper_Abstract
{
    const SCOPE_DEFAULT = 'default';
    const SCOPE_WEBSITE = 'websites';
    const SCOPE_STORE   = 'stores';
    
    const DEFAULT_SCOPE_ID = 0;

    /**
     * @param string $path
     * @param string $value
     * @param string $scope
     * @param int $scopeId
     * @return $this
     * @author Joseph McDermott <code@josephmcdermott.co.uk>
     */
    public function save($path, $value, $scope = self::SCOPE_DEFAULT, $scopeId = self::DEFAULT_SCOPE_ID)
    {
        $config = $this->_getCoreConfig();
        $config->saveConfig($path, $value, $scope, $scopeId);

        return $this;
    }

    /**
     * @param string $path
     * @param string $scope
     * @param int $scopeId
     * @return $this
     * @author Joseph McDermott <code@josephmcdermott.co.uk>
     */
    public function delete($path, $scope = self::SCOPE_DEFAULT, $scopeId = self::DEFAULT_SCOPE_ID)
    {
        $config = $this->_getCoreConfig();
        $config->deleteConfig($path, $scope, $scopeId);
        
        return $this;
    }

    /**
     * @return Mage_Core_Model_Config
     * @author Joseph McDermott <code@josephmcdermott.co.uk>
     */
    protected function _getCoreConfig()
    {
        $config = Mage::getModel('core/config');
        
        return $config;
    }
}