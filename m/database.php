<?php
error_reporting(E_ALL & ~E_NOTICE);
session_start();
define("DB_HOST","{DB_HOST}");
define("DB_USER","{DB_USER}");
define("DB_PSW","{DB_PSW}");
define("DB_NAME","{DB_NAME}");
define("DB_PREFIX","{DB_PREFIX}");
define("URL_M","{URL_M}");
define("URL","{URL}");
date_default_timezone_set('PRC');
try {
    $db = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME, DB_USER, DB_PSW); //��ʼ��һ��PDO����
} catch (PDOException $e) {
    die ("Error!: " . $e->getMessage() . "<br/>");
}
$db->exec("SET character_set_connection=utf8, character_set_results=utf8, character_set_client=binary");
$db->exec("SET sql_mode=''");
?>