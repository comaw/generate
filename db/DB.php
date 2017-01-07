<?php

include_once (__DIR__ . '/PDOMySQL.php');

class DB
{

    /**
     * @var null|PDOMySQL
     */
    protected static $db = null;

    /**
     * @return null|PDOMySQL
     */
    public static function setDb(){
        if(!self::$db){
            $dbConfig = include (__DIR__ . '/config.php');
            self::$db = new PDOMySQL($dbConfig['dsn'], $dbConfig['user'], $dbConfig['password'], $dbConfig['charset']);
        }
        return self::$db;
    }

    /**
     * @return null|PDOMySQL
     */
    public static function getDB(){
        if(!self::$db){
            self::setDb();
        }
        return self::$db;
    }
}