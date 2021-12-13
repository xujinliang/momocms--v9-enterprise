<?php
require("./database.php");
if(empty($_SESSION['momocms_admin'])){
	header("Location:./index.php");	
	exit;
}
if($_SESSION['momocms_isAdmin']==1 && ($_REQUEST['token'] == $_SESSION['token'])){
$_POST=array_map("htmlspecialchars",$_POST);
$_POST=array_map("addslashes",$_POST);
$db->exec("update ".DB_PREFIX."product_cat set
					name ='".$_POST['product_newcatname']."',
					sort ='".$_POST['product_catsort']."' where id=".intval($_POST['product_catid']));
echo '<script>
parent.window.location.href="./product.php";
</script>';
}
?>