<?php
require("./database.php");
if(empty($_SESSION['momocms_admin'])){
	header("Location:./index.php");	
	exit;
}
if($_SESSION['momocms_isAdmin']==1 && ($_REQUEST['token'] == $_SESSION['token'])){
	$_POST=array_map("htmlspecialchars",$_POST);
	$_POST=array_map("addslashes",$_POST);
	$sql="select * from ".DB_PREFIX."admin where user='".$_SESSION['momocms_admin']."' and psw='".md5($_POST['oldpsw'])."'";
	$query=$db->query($sql);
	$num=count($query->fetchAll());
	if($num>0){
		  $db->exec("update ".DB_PREFIX."admin set
		  psw = '".md5($_POST['newpsw'])."' where user='".$_SESSION['momocms_admin']."'");
		  echo '<script>
				parent.document.getElementById("successMsg").style.display="block";
				setTimeout(function(){
				parent.window.location.href="./dashboard.php";
				},1500);
				</script>';
	}else{
		echo "<script>alert('原密码输入错误，请重试。');</script>";
	}	
}
?>
