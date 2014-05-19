<?php

namespace nGenZfc\Mapper;

use Zend\Db\Sql\Sql; 
use ZfcBase\Mapper\AbstractDbMapper;

abstract class ExtendedAbstractDbMapper extends AbstractDbMapper {

    /**
     * Updates only selected Field
     * @param  [Array]  $array      Array of fields to be updated
     * @param  [String] $where      Where condition
     * @param  [String] $tableName  [Optional] Tablename
     * @return [Boolean]            Execution result
     */
    public function updateField($array, $where, $tableName = null)
    {
        $this->initialize();
        $tableName = $tableName ?: $this->tableName;

        $sql = $this->getSql()->setTable($tableName);
        $update = $sql->update();

        $update->set($array)
            ->where($where);

        $statement = $sql->prepareStatementForSqlObject($update);

        return $statement->execute();
    }    

    /**
     * @return int|null|false
     */
    public function lastInsertId()
    {
        return $this -> dbAdapter -> getDriver() -> getConnection() -> getLastGeneratedValue();
    }

    /**
     * @param void
     * @return void
     */
    public function beginTransaction()
    {
        $this -> dbAdapter -> getDriver() -> getConnection() -> beginTransaction();
    }

    /**
     * @param void
     * @return void
     */
    public function commit()
    {
        $this -> dbAdapter -> getDriver() -> getConnection() -> commit();
    }

    /**
     * @return bool
     */
    public function inTransaction()
    {
        return $this -> dbAdapter -> getDriver() -> getConnection() -> getResource() -> inTransaction();
    }

    /**
     * @param void  
     * @return void
     */
    public function rollBack()
    {
        $this -> dbAdapter -> getDriver() -> getConnection() -> rollBack();
    }

    /**
     * @param Zend\Db\Sql\PreparableSqlInterface $sqlObject
     * @return Zend\Db\Adapter\ResultInterface
     */
    protected function execute(PreparableSqlInterface $sqlObject)
    {
        return $this -> getSql() -> prepareStatementForSqlObject($sqlObject)->execute();
    }   

    
    /**
     * @param Zend\Db\Adapter\ResultInterface $source
     * @return array
     */
    protected function toArray(ResultInterface $source)
    {
        $result = array();
        foreach($source as $item) {
            $result[] = $item;
        }
        return $result;
    }

    /**
     *
     */
    protected function toString(SqlInterface $sqlObject)
    {
        return $this->getSql()->getSqlStringForSqlObject($sqlObject);
    }

    /**
     * Get SQL Query String
     * @param  [SqlObject] $sql_object [SQL Object like Select, Update etc]
     * @return [String|Boolen] Query String or False if encounters error.
     */
    protected function getSQLString($sql_object) {
        $sql = new Sql($this -> dbAdapter);
        try {
            $string = $sql->getSqlStringForSqlObject($sql_object);
            return $string;    
        } catch(\Exception $e) {
            return false;
        }
        
    }
    
}
