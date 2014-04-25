<?php

namespace nGenZfc\Mapper;

use ZfcBase\Mapper\AbstractDbMapper;

abstract class ExtendedAbstractDbMapper extends AbstractDbMapper {

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
    
}
