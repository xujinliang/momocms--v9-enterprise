<?php
require("./database.php");
if(empty($_SESSION['momocms_admin'])){
	header("Location:./index.php");	
	exit;
}
if($_SESSION['momocms_isAdmin']==1 && ($_REQUEST['token'] == $_SESSION['token'])){
$_POST=array_map("htmlspecialchars",$_POST);
$_POST=array_map("addslashes",$_POST);
if(intval($_POST['connect_sec_menu_pid'])>0){
$db->exec("update ".DB_PREFIX."pages set
					keywords ='".$_POST['productkeywords']."',
					depict ='".$_POST['productdepict']."',
					nickname ='".$_POST['productnickname']."',
					title ='".$_POST['producttitle']."',
					content = '".$_POST['productdesc']."',
					module = '".$_POST['module']."',
					sort = '".$_POST['sort']."',
					isProduct = '".$_POST['connect_product']."',
					isMenu = '".$_POST['connect_menu']."',
					isSecondaryMenu = '".$_POST['connect_sec_menu']."',
					pid = '".$_POST['connect_sec_menu_pid']."',
					barsid = '".$_POST['barsid']."',
					customcss = '".$_POST['customcss']."',
					isNews = '".$_POST['connect_news']."',
					ext_url = '".$_POST['exturl']."',
					news_cat = '".$_POST['connect_sec_news_cat']."',
					time = '".time()."' where id=".intval($_POST['id']));
}else{
	$db->exec("update ".DB_PREFIX."pages set
					keywords ='".$_POST['productkeywords']."',
					depict ='".$_POST['productdepict']."',
					nickname ='".$_POST['productnickname']."',
					title ='".$_POST['producttitle']."',
					content = '".$_POST['productdesc']."',
					module = '".$_POST['module']."',
					sort = '".$_POST['sort']."',
					isProduct = '".$_POST['connect_product']."',
					isMenu = '".$_POST['connect_menu']."',
					isSecondaryMenu = '".$_POST['connect_sec_menu']."',
					barsid = '".$_POST['barsid']."',
					customcss = '".$_POST['customcss']."',
					isNews = '".$_POST['connect_news']."',
					ext_url = '".$_POST['exturl']."',
					news_cat = '".$_POST['connect_sec_news_cat']."',
					time = '".time()."' where id=".intval($_POST['id']));
}
if(intval($_POST['connect_sec_menu_pid'])>0){
	$db->exec("update ".DB_PREFIX."pages set
 					pid = '-1' where id=".$_POST['connect_sec_menu_pid']);
 				}
echo '<script>
parent.document.getElementById("successMsg").style.display="block";
setTimeout(function(){
parent.window.location.href="./page.php";
},1500);
</script>';
}
?>
