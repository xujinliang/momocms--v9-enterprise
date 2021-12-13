<?php
require("./database.php");
if(empty($_SESSION['momocms_admin'])){
	header("Location:./index.php");	
	exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
<link rel="stylesheet" href="css/style.css" type="text/css" />
</head>
<body>
<?php
if($_SESSION['momocms_isAdmin']==1 && ($_REQUEST['token'] == $_SESSION['token'])){
	if(isset($_POST['cid'])){
		$db->exec("update ".DB_PREFIX."modules set
 					codes='".base64_encode($_POST['codes'])."' where id=".intval($_POST['cid']));
	}
}
$sql="select * from ".DB_PREFIX."modules where id=".intval($_GET['id']);
$query=$db->query($sql);
$arr=$query->fetch();
?>
	<form name="form" method="post" action="">
			<textarea name="codes" style="width:98%;height:340px"><?php $tmp = base64_decode($arr['codes']); echo $tmp;?></textarea>
			<input type="hidden" name="cid" value="<?php echo $arr['id'];?>">
			<input type="hidden" name="token" value="<?php echo $_GET['token'];?>">
			<a class="btn btn-green" onclick="document.forms['form'].submit()">更新代码</a>
	</form>
</body>
</html>