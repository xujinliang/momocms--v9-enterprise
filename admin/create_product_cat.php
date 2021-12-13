<?php
require("./database.php");
if(empty($_SESSION['momocms_admin'])){
	header("Location:./index.php");	
	exit;
}
if($_SESSION['momocms_isAdmin']==1 && ($_REQUEST['token'] == $_SESSION['token'])){
$_POST=array_map("htmlspecialchars",$_POST);
$_POST=array_map("addslashes",$_POST);
$db->exec("insert into ".DB_PREFIX."product_cat set
					name = '".$_POST['productcat']."'");
echo '<script>
parent.document.getElementById("successCatMsg").style.display="block";
setTimeout(function(){
parent.window.location.href="./product.php";
},1500);
</script>';
}
?>
