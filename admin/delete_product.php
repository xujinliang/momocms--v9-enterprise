<?php
require("./database.php");
if(empty($_SESSION['momocms_admin'])){
	header("Location:./index.php");	
	exit;
}
if($_SESSION['momocms_isAdmin']==1 && ($_REQUEST['token'] == $_SESSION['token'])){
$db->exec("delete from  ".DB_PREFIX."product where id=".intval($_GET['id']));
$sql="select * from ".DB_PREFIX."product_sub where category=".intval($_GET['id']);
$query=$db->query($sql);
$num=$db->query("select count(*) from ".DB_PREFIX."product_sub where category=".intval($_GET['id']))->fetchColumn();
if($num>0){
	while($tmp=$query->fetch()){
		if(file_exists($tmp['pic'])){
			@unlink($tmp['pic']);	
		}
	}
}
$db->exec("delete from  ".DB_PREFIX."product_sub where category=".intval($_GET['id']));
echo '<script>
parent.window.location.href="./product.php";
</script>';
}
?>
