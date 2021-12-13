<?php
require("./database.php");
$_POST=array_map("addslashes",$_POST);
if($_POST['token']==$_SESSION['momocms_time']){
	$sql="select * from ".DB_PREFIX."admin where user='".$_POST['username']."' and psw='".md5($_POST['password'])."'";
	$query=$db->query($sql);
	$num=$db->query("select count(*) from ".DB_PREFIX."admin where user='".$_POST['username']."' and psw='".md5($_POST['password'])."'")->fetchColumn();
	if($num>0){
		$arr = $query->fetch();
		$_SESSION['momocms_admin']=$_POST['username'];
		$_SESSION['momocms_isAdmin']=$arr['isAdmin'];
		if (!empty($_SERVER['HTTP_CLIENT_IP']))
            $myIp = $_SERVER['HTTP_CLIENT_IP'];
        else if (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
            $myIp = $_SERVER['HTTP_X_FORWARDED_FOR'];
        else
            $myIp = $_SERVER['REMOTE_ADDR'];
        if(filter_var($myIp, FILTER_VALIDATE_IP)){
			$db->exec("insert into ".DB_PREFIX."access_log(ip,name,time) values('".$myIp."','".$_POST['username']."','".time()."')");
			echo '<script>
			parent.xlert({
        content:"登陆成功！",
        pos:3,
        callback:function(){
            parent.window.location.href="./dashboard.php";
        },
    });</script>';
		}else{
			echo '<script>parent.xlert("IP地址非法",2); </script>';
		}
	}else{
		$_SESSION['momocms_error']=true;
		echo '<script>parent.window.location.href="./index.php";</script>';
	}
}
?>