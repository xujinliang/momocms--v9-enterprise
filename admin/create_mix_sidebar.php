<?php
require("./database.php");
if(empty($_SESSION['momocms_admin'])){
	header("Location:./index.php");	
	exit;
}
if($_SESSION['momocms_isAdmin']==1 && ($_REQUEST['token'] == $_SESSION['token'])){
	$_POST=array_map("htmlspecialchars",$_POST);
	$_POST=array_map("addslashes",$_POST);
	$db->exec("update ".DB_PREFIX."modules set
						pid='".intval($_POST['bars_page'])."' where id=".intval($_POST['bars']));
	echo '<script>
	parent.document.getElementById("successMsg").style.display="block";
	setTimeout(function(){
	parent.window.location.href="./modules.php";
	},1500);
	</script>';
}
?>
