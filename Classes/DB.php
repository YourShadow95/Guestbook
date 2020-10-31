<?php

namespace Classes;

use PDO;
use PDOException;

class DB
{
    protected $conn = null;
    private $_host = HOST;
    private $_dbname = DBNAME;
    private $_user = USER;
    private $_password = PASSWORD;
    private $_error;

    public function __construct()
    {
        $dsn = "mysql:host=".$this->_host.";dbname=".$this->_dbname.";charset=utf8";
        try {

            $this->conn = new PDO($dsn, $this->_user, $this->_password);

        } catch (PDOException $e) {

            $this->conn = null;
            $this->_error = $e->getMessage();
        }
    }

    public function getError()
    {
        return $this->_error;
    }

    public function getMaxLen($table, $column)
    {
        $stmt = $this->conn->prepare('select COLUMN_NAME, CHARACTER_MAXIMUM_LENGTH
                                        from information_schema.COLUMNS
                                        where TABLE_SCHEMA = DATABASE() AND 
                                        TABLE_NAME = :table AND COLUMN_NAME = :column');
        $stmt->execute(array('table' =>$table, 'column' => $column));
        $column = $stmt->fetch(PDO::FETCH_LAZY);

        return $column['CHARACTER_MAXIMUM_LENGTH'];
    }
}