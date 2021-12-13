<?php
require("./database.php");
if(empty($_SESSION['momocms_admin'])){
	header("Location:./index.php");	
	exit;
}
if($_SESSION['momocms_isAdmin']==1 && ($_REQUEST['token'] == $_SESSION['token'])){
$db->exec("delete from ".DB_PREFIX."pages where id=".intval($_GET['id']));
$sql_child="select * from ".DB_PREFIX."pages where pid=".intval($_GET['id']);
$sql_child_query=$db->query($sql_child);
$sql_child_num=$db->query("select count(*) from ".DB_PREFIX."pages where pid=".intval($_GET['id']))->fetchColumn();
if($sql_child_num>0){
	while($sql_child_arr=$sql_child_query->fetch()){
		$db->exec("delete from ".DB_PREFIX."pages where id=".intval($sql_child_arr['id']));
	}
}
echo '<script>
parent.window.location.href="./page.php";
</script>';
}
?>
