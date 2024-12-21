<?php
namespace Datahihi1\PhpDbConnector;
class Query
{
    protected function __construct() {}

    protected function select(string $table, string $column = '*')
    {
        return null;
    }
    protected function insert(string $table, string $columns = null)
    {
        return null;
    }
    protected function update(string $table)
    {
        return null;
    }
    protected function delete(string $table)
    {
        return null;
    }
    protected function where(string $column, string $value)
    {
        return null;
    }
    protected function join(string $table, string $type = 'INNER')
    {
        return null;
    }
    protected function on(string $table1Column, string $table2Column)
    {
        return null;
    }
    protected function values(...$data)
    {
        return null;
    }
    protected function set(array $data)
    {
        return null;
    }
    protected function execute() {}
}

