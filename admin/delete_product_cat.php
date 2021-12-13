<?php
require("./database.php");
if(empty($_SESSION['momocms_admin'])){
	header("Location:./index.php");	
	exit;
}
if($_SESSION['momocms_isAdmin']==1 && ($_REQUEST['token'] == $_SESSION['token'])){
$sql_cat_pro="select * from ".DB_PREFIX."product where cat=".intval($_GET['id']);
							$query_cat_pro=$db->query($sql_cat_pro);
							if($query_cat_pro){
					   	$num_cat_pro=$db->query("select count(*) from ".DB_PREFIX."product where cat=".intval($_GET['id']))->fetchColumn();
					   	if($num_cat_pro>0){
					   		while($arr_cat_pro=$query_cat_pro->fetch()){					   			
$sql_cat_pro_sub="select * from ".DB_PREFIX."product_sub where category=".intval($arr_cat_pro['id']);
							$query_cat_pro_sub=$db->query($sql_cat_pro_sub);
							if($query_cat_pro_sub){
					   	$num_cat_pro_sub=$db->query("select count(*) from ".DB_PREFIX."product_sub where category=".intval($arr_cat_pro['id']))->fetchColumn();
					   	if($num_cat_pro_sub>0){
					   		while($arr_cat_pro_sub=$query_cat_pro_sub->fetch()){
									if(file_exists($arr_cat_pro_sub['pic'])){
										@unlink($arr_cat_pro_sub['pic']);	
										}
					   			}
					   	  }
					   	  $db->exec("delete from  ".DB_PREFIX."product_sub where category=".intval($arr_cat_pro['id']));
					   	}
		}
		$db->exec("delete from  ".DB_PREFIX."product where cat=".intval($_GET['id']));
  }
}
$db->exec("delete from  ".DB_PREFIX."product_cat where id=".intval($_GET['id']));
echo '<script>
parent.window.location.href="./product.php";
</script>';
}
?>
