<?php

namespace rollun\tableGateway;

use Traversable;
use Laminas\Db\Adapter\Adapter;
use Laminas\Db\Metadata\Source\MysqlMetadata;
use Laminas\Db\Sql\Select;
use Laminas\Db\TableGateway\TableGateway;

class TableGatewayIterator implements \IteratorAggregate
{
    /**
     * TableGatewayIterator constructor.
     * @param TableGateway $tableGateway
     * @param string $primaryKeyName
     */
    public function __construct(private TableGateway $tableGateway, private string $primaryKeyName = "id") {}

    /**
     * @param string $primaryKey
     * @param int $limit
     * @return array
     */
    private function selectRow($primaryKey = null, $limit = 10)
    {
        $select = $this->tableGateway->getSql()->select();
        $select->limit($limit);
        $select->order($this->primaryKeyName . ' ' . Select::ORDER_ASCENDING);
        $select->columns(['*']);
        if (isset($primaryKey)) {
            $select->where("(" .
                "{$this->tableGateway->getAdapter()->getPlatform()->quoteIdentifier($this->primaryKeyName)}" .
                ">" .
                (is_numeric($primaryKey) ? "$primaryKey" : "{$this->tableGateway->getAdapter()->getPlatform()->quoteValue($primaryKey)}") .
            ")");
        }

        //build sql string
        $sql = $this->tableGateway->getSql()->buildSqlString($select);

        /** @var Adapter $adapter */
        $adapter = $this->tableGateway->getAdapter();
        $rowset = $adapter->query($sql, $adapter::QUERY_MODE_EXECUTE);

        return $rowset->toArray();
    }

    /**
     * Retrieve an external iterator
     * @link http://php.net/manual/en/iteratoraggregate.getiterator.php
     * @param int $limit
     * @return Traversable An instance of an object implementing <b>Iterator</b> or
     * <b>Traversable</b>
     * @since 5.0.0
     */
    public function getIterator($limit = 10)
    {
        $hasNext = true;
        $primaryKey = null;
        while ($hasNext) {
            $rows = $this->selectRow($primaryKey, $limit);
            if (!empty($rows)) {
                foreach ($rows as $row) {
                    yield $row;
                }
                $primaryKey = end($rows)[$this->primaryKeyName];
            } else {
                $hasNext = false;
            }
        }
    }
}
