<?php
error_reporting(E_ALL & ~E_NOTICE);
session_start();
define("DB_HOST","{DB_HOST}");
define("DB_USER","{DB_USER}");
define("DB_PSW","{DB_PSW}");
define("DB_NAME","{DB_NAME}");
define("DB_PREFIX","{DB_PREFIX}");
define("URL","{URL}");
date_default_timezone_set('PRC');
try {
    $db = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME, DB_USER, DB_PSW); //初始化一个PDO对象
} catch (PDOException $e) {
    die ("Error!: " . $e->getMessage() . "<br/>");
}
$db->exec("SET character_set_connection=utf8, character_set_results=utf8, character_set_client=binary");
$db->exec("SET sql_mode=''");
$sec_li='';
$sql_cat="select * from ".DB_PREFIX."product_cat order by sort desc";
$query_cat=$db->query($sql_cat);
$num_cat=$db->query("select count(*) from ".DB_PREFIX."product_cat order by sort desc")->fetchColumn();
if($num_cat>0){
	while($arr_cat=$query_cat->fetch()){
		$sql_cat_pro="select * from ".DB_PREFIX."product where cat=".$arr_cat['id']." order by sort desc";
		$query_cat_pro=$db->query($sql_cat_pro);
	   	$num_cat_pro=$db->query("select count(*) from ".DB_PREFIX."product where cat=".$arr_cat['id']." order by sort desc")->fetchColumn();
	   	if($num_cat_pro>0){
	   		$sec_li.='<li><a href="javascript:;">'.$arr_cat['name'].' <span style="color:#ccc">&gt;</span></a>';
	   		$sec_li.='<ul>';
	   		while($arr_cat_pro=$query_cat_pro->fetch()){
	   			$sec_li.='<li><a href="./detail_product.php?id='.$arr_cat_pro['id'].'">'.$arr_cat_pro['name'].'</a></li>';
	   		}
	   		$sec_li.='</ul>';
	   	}else{
	   		$sec_li.='<li><a href="javascript:;">'.$arr_cat['name'].'</a>';	
	   	}
	   	$sec_li.='</li>';
	}
}
?>