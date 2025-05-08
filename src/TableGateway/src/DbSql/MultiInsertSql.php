<?php

/**
 * Created by PhpStorm.
 * User: root
 * Date: 21.07.16
 * Time: 13:39
 */

namespace rollun\tableGateway\DbSql;

use Laminas\Db\Sql\Exception\InvalidArgumentException;
use Laminas\Db\Sql\Sql;

class MultiInsertSql extends Sql
{
    public function insert($table = null)
    {
        if ($this->table !== null && $table !== null) {
            throw new InvalidArgumentException(sprintf(
                'This Sql object is intended to work with only the table "%s" provided at construction time.',
                $this->table
            ));
        }
        return new MultiInsert(($table) ?: $this->table);
    }
}
