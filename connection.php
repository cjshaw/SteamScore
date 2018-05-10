<?php
require ("db_config.php");
class Db
{
    private static $instance = NULL;

    private function __construct()
    {
    }

    public static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE, DB_PORT);
        }
        return self::$instance;
    }
}
?>