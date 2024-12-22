<?php

namespace Datahihi1\PhpDbConnector;

use \mysqli;

class MySqlQuery extends Query
{
    private $connection;
    private $query;
    private $whereClause = '';
    private $joinClause = '';

    // Constructor to initialize the MySQL connection
    public function __construct(string $host, string $username, string $password, string $database)
    {
        $this->connection = new mysqli($host, $username, $password, $database);
        if ($this->connection->connect_error) {
            die("Connection failed: " . $this->connection->connect_error);
        }
        $this->connection->set_charset('utf8mb4');
    }

    // SELECT statement
    public function select(string $table, string $columns = '*')
    {
        $this->query = "SELECT {$columns} FROM {$table}";
        return $this;
    }
    public function insert(string $table, string $columns = null)
    {
        $this->query = "INSERT INTO {$table}";
        if ($columns) {
            $this->query .= " ({$columns})";
        }
        return $this;
    }
    public function update(string $table)
    {
        $this->query = "UPDATE {$table}";
        return $this;
    }
    // DELETE statement
    public function delete(string $table)
    {
        $this->query = "DELETE FROM {$table}";
        return $this;
    }
    // WHERE clause
    public function where(string $columns, string $values, $operator = '=')
    {
        if (is_string($columns)) {
            // Split the columns and values if they are comma-separated
            $columns = explode(',', $columns);
        }
        if (is_string($values)) {
            // Split the values if they are comma-separated
            $values = explode(',', $values);
        }

        if (count($columns) === count($values)) {
            $conditions = [];
            for ($i = 0; $i < count($columns); $i++) {
                // Handle LIKE operator and other operators
                if ($operator === 'LIKE') {
                    // Apply wildcard for LIKE operation
                    $conditions[] = "{$columns[$i]} {$operator} '" . $this->connection->real_escape_string($values[$i]) . "%'";
                } else {
                    // For other operators, use as is
                    $conditions[] = "{$columns[$i]} {$operator} '" . $this->connection->real_escape_string($values[$i]) . "'";
                }
            }

            // Combine the conditions with AND
            if ($this->whereClause === '') {
                $this->whereClause = " WHERE " . implode(" AND ", $conditions);
            } else {
                $this->whereClause .= " AND " . implode(" AND ", $conditions);
            }
        }

        return $this;
    }
    public function limit(int $count = 1)
    {
        if($this->whereClause){
            $this->whereClause .= " LIMIT {$count}";
        }else{
            $this->query .= " LIMIT {$count}";
        }
        return $this;
    }

    // JOIN clause
    public function join(string $table, string $type = '')
    {
        $this->joinClause .= " {$type} JOIN {$table}";
        return $this;
    }

    // ON method for JOIN
    public function on(string $table1Column, string $table2Column)
    {
        $this->joinClause .= " ON {$table1Column} = {$table2Column}";
        return $this;
    }
    public function values(...$data)
    {
        if (is_array($data[0])) {
            // If data is provided as an associative array
            $columns = implode(", ", array_keys($data[0]));
            $values = implode(", ", array_map(function ($value) {
                return "'" . $this->connection->real_escape_string($value) . "'";
            }, $data[0]));
            $this->query .= " ({$columns}) VALUES ({$values})";
        } else {
            // If data is provided as separate arguments
            $values = implode(", ", array_map(function ($value) {
                return "'" . $this->connection->real_escape_string($value) . "'";
            }, $data));
            $this->query .= " VALUES ({$values})";
        }
        return $this;
    }
    public function set(array $data)
    {
        $setClause = [];
        foreach ($data as $column => $value) {
            $setClause[] = "{$column} = '" . $this->connection->real_escape_string($value) . "'";
        }
        $this->query .= " SET " . implode(", ", $setClause);
        return $this;
    }
    // Execute the query
    public function execute(bool $debug = false)
    {
        if ($this->joinClause) {
            $this->query .= $this->joinClause;
        }

        if ($this->whereClause) {
            $this->query .= $this->whereClause;
        }
        if($debug){
            print_r($this->query);
            die();
        }
        $result = $this->connection->query($this->query);
        
        if ($result) {
            if (str_starts_with(trim(strtoupper($this->query)), "SELECT")) {
                // If it's a SELECT query, fetch and return results
                $data = [];
                while ($row = $result->fetch_assoc()) {
                    $data[] = $row;
                }
                return $data;
            } else {
                // For DELETE or other non-SELECT queries
                echo "Query executed successfully.";
                return true;
            }
        } else {
            echo "Error: " . $this->connection->error;
            return false;
        }
       
    }
}
