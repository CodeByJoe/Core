<?php
/**
 * CodeByJoe Ltd :: http://www.codebyjoe.com
 *
 * @category CodeByJoe
 * @package CodeByJoe_Toolbox
 * @author Joseph McDermott <code@josephmcdermott.co.uk>
 * @license http://choosealicense.com/licenses/mit/ MIT License
 */
class CodeByJoe_Toolbox_Model_Database extends Mage_Core_Helper_Abstract
{
    protected $_resource = null;
    protected $_connections = array();
    protected $_tableNamesByAlias = array();

    /**
     * @param string $alias
     * @return string
     * @author Joseph McDermott <code@josephmcdermott.co.uk>
     */
    public function getTableName($alias)
    {
        if (!array_key_exists($alias, $this->_tableNamesByAlias)) {
            $resource = $this->getResource();
            $tableName = $resource->getTableName($alias);
            $this->_tableNamesByAlias[$alias] = $tableName;
        }

        return $this->_tableNamesByAlias[$alias];
    }

    /**
     * @return Mage_Core_Model_Resource
     * @author Joseph McDermott <code@josephmcdermott.co.uk>
     */
    public function getResource()
    {
        if (is_null($this->_resource)) {
            $this->_resource = Mage::getSingleton('core/resource');
        }

        return $this->_resource;
    }

    /**
     * @return Varien_Db_Adapter_Interface
     * @author Joseph McDermott <code@josephmcdermott.co.uk>
     */
    public function getSetupConnection()
    {
        $connection = $this->getConnection('core_setup');

        return $connection;
    }

    /**
     * @return Varien_Db_Adapter_Interface
     * @author Joseph McDermott <code@josephmcdermott.co.uk>
     */
    public function getReadConnection()
    {
        $connection = $this->getConnection('core_read');

        return $connection;
    }

    /**
     * @return Varien_Db_Adapter_Interface
     * @author Joseph McDermott <code@josephmcdermott.co.uk>
     */
    public function getWriteConnection()
    {
        $connection = $this->getConnection('core_write');

        return $connection;
    }

    /**
     * @param string $type
     * @return Varien_Db_Adapter_Interface
     * @author Joseph McDermott <code@josephmcdermott.co.uk>
     */
    public function getConnection($type)
    {
        if (!array_key_exists($type, $this->_connections)) {
            $resource = $this->getResource();
            $this->_connections[$type] = $resource->getConnection($type);
        }

        return $this->_connections[$type];
    }
}