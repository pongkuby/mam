<?php
header("Content-type: text/html; charset=utf-8"); 
/**
 * Created by
 * User: Thammarak
 * Date: 8/5/2556
 * Time: 7:51 �.
 */
error_reporting(E_ALL ^ E_NOTICE);
class Database
{
    public static function getPDO()
    {
        return new PDO('mysql:host=localhost;dbname=mam;charset=utf8', 'mam', 'mam1234',array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
    }
}