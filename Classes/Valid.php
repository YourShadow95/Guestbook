<?php


class Valid
{
    private $_db;
    public $errors = [];

    public function __construct($db)
    {
        $this->_db = $db;
    }

    public function checkEmpty($name, $value)
    {
        $name = ucfirst(str_replace("_", " ", $name));
        if (empty($value))
        {
            return $this->errors[] = "Пожалустай, заполните поле ". $name;
        } else { return 0;}
    }

    public function checkMatch($name1, $value1, $name2, $value2)
    {
        $name1 = ucfirst(str_replace("_", " ", $name1));
        $name2 = ucfirst(str_replace("_", " ", $name2));
        if ($value1 !== $value2)
        {
            return $this->errors [] = "Ваш ".$name2. " не соответствует ".$name1.'!';
        } else { return 0;}
    }
    public function checkMaxLen($name, $value, $table, $column)
    {
        $name = ucfirst(str_replace("_", " ", $name));
        $maxLen = $this->_db->getMaxLen($table, $column);
        if(strlen($value) > $maxLen)
        {
            return $this->errors[] = $name."слишком много символов".$maxLen." максимальная длинна!";
        } else {return 0;}
    }
    public function checkMinLen($name, $value, $minLen)
    {
        $name = ucfirst(str_replace("_", " ", $name));
        if(strlen($value)< $minLen)
        {
            return $this->errors[] = $name." слишком мало символов".$minLen." минимальное количество символов!";
        } else {return 0;}

    }

    public function checkMinxLen($name, $value, $int)
    {
        $name = ucfirst(str_replace("_", " ", $name));
        if(strlen($value)<$int)
        {
            return $this->errors[]= $name." слишком короткий! ".$int." минимальное количество символов!";
        }
    }
    public function isUsernameAvailable($userName)
    {
        $isExist = $this->_db->getUserName($userName);
        if(!$isExist)
        {
            return false;
        } else { return $this->errors = $userName." уже используется!";}
    }

    public function isEmailAvailable($email)
    {
        $isExist = $this->_db->getEmail($email);
        if(!$isExist)
        {
            return false;
        } else { return $this->errors = $email." уже используется!";}
    }
}