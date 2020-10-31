<?php

namespace Classes;

use Exception;

class Valid
{
    private $_db;
    private $errors = [];

    public function __construct($db)
    {
        $this->_db = $db;
    }

    public function checkEmpty(string $name, string $value): void
    {
        $name = ucfirst(str_replace("_", " ", $name));

        if (empty($value)) {
            $this->setError("Пожалустай, заполните поле " . $name);
        }
    }

    public function checkMatch($name1, $value1, $name2, $value2): void
    {
        $name1 = ucfirst(str_replace("_", " ", $name1));
        $name2 = ucfirst(str_replace("_", " ", $name2));

        if ($value1 !== $value2) {
            $this->setError("Ваш " . $name2 . " не соответствует " . $name1 . '!');
        }
    }

    public function checkMaxLen(string $name, string $value, string $table, string $column): void
    {
        $name = ucfirst(str_replace("_", " ", $name));
        $maxLen = $this->_db->getMaxLen($table, $column);

        if(strlen($value) > $maxLen) {
            $this->setError($name . "слишком много символов" . $maxLen . " максимальная длинна!");
        }
    }

    public function checkMinLen(string $name, string $value, int $len): void
    {
        $name = ucfirst(str_replace("_", " ", $name));

        if(strlen($value) < $len) {
            $this->setError($name . " слишком короткий! " . $len . " минимальное количество символов!");
        }
    }

    public function isUsernameAvailable(string $userName): bool
    {
        if ($this->_db->getUserName($userName)) {
            $this->throwIsAvailableError($userName);
        }

        return false;
    }

    public function isEmailAvailable(string $email): bool
    {
        if ($this->_db->getEmail($email)) {
            $this->throwIsAvailableError($email);
        }

        return false;
    }

    public function throwIsAvailableError(string $entity): Exception
    {
        throw new Exception($entity . " уже используется!");
    }

    private function setError(string $error): void
    {
        $this->errors[] = $error;
    }
}