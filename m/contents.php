<?php
require("./database.php");
$rooturl = URL_M;
if(!is_numeric($_GET['id'])){
	$sql_main="select * from ".DB_PREFIX."pages where nickname='".addslashes($_GET['id'])."'";
	$query_main=$db->query($sql_main);
	$arr_main=$query_main->fetch();
	$_GET['id'] = $arr_main['id'];
}else{
	$sql_main="select * from ".DB_PREFIX."pages where id=".intval($_GET['id']);
	$query_main=$db->query($sql_main);
	$arr_main=$query_main->fetch();
}
define("MAIN_ID",intval($_GET['id']));
?>
<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width initial-scale=1.0 maximum-scale=1.0 user-scalable=yes" />
<title><?php 
	if(!empty($_GET['nd'])){$tmp_title=$_GET['nd'];}
	if(!empty($_GET['ncat'])){$tmp_title=$_GET['ncat'];}
	if(!empty($_GET['nid'])){$tmp_title=$_GET['nid'];}
	$sql_title="select * from ".DB_PREFIX."pages where id=".intval($tmp_title);
	$query_title=$db->query($sql_title);
	$num_title=$db->query("select count(*) from ".DB_PREFIX."pages where id=".intval($tmp_title))->fetchColumn();
	if($num_title>0){
		$arr_title=$query_title->fetch();
		echo $arr_title['title']." -- ";
	}else{
		echo $arr_main['title']." -- ";} ?>MoMoCMS -- 更好用的企业建站系统</title>
<meta name="keywords" content="<?php
if(!empty($arr_main['keywords'])){echo $arr_main['keywords'];}else{echo 'MoMoCMS';}?>">
<meta name="description" content="<?php
if(!empty($arr_main['depict'])){echo $arr_main['depict'];}else{echo 'MoMoCMS -- 更好用的企业建站系统';}?>">
<link rel="icon" href="<?php echo URL; ?>/resource/favicon.ico" type="image/x-icon">
<link rel="shortcut icon" href="<?php echo URL; ?>/resource/favicon.ico" type="image/x-icon">
<link rel="bookmark" href="<?php echo URL; ?>/resource/favicon.ico" type="image/x-icon">
<script src="<?php echo URL; ?>/resource/jquery-1.11.1.min.js"></script>
<script src="<?php echo URL_M; ?>/js/jquery.mmenu.min.all.js"></script>
<link href="<?php echo URL_M; ?>/css/jquery.mmenu.all.css?<?php echo time();?>" rel="stylesheet" type="text/css">
<link href="<?php echo URL_M; ?>/css/style.css?<?php echo time();?>" rel="stylesheet" type="text/css">
<link href="<?php echo URL_M; ?>/css/font-face.css?<?php echo time();?>" rel="stylesheet" type="text/css">
</head>
<body>
<div id="page">
	<header>
    	<div class="l_tbn"><a href="#menu" id="navigation"></a></div>
        <a style="font-size:14px;color:#fff;font-weight:bold;text-decoration:none;" href="<?php echo URL_M; ?>">MoMoCMS手机版</a>
    </header>
	<div class="content">
	<script type="text/javascript">
	    $(function() {
	       var callback = function () {
			var reg=/mm-opened/;
			if(reg.test(document.getElementById("menu").className)){
	            document.getElementById("navigation").style.backgroundPosition="8px -28px";
	          }else{
	          	 document.getElementById("navigation").style.backgroundPosition="8px 7px";
	          }
	        }
		   document.body.addEventListener('webkitTransitionEnd', callback);
	       $('nav#menu').mmenu({
				extensions: [ 'widescreen', 'theme-white', 'effect-slide-menu' ],navbar:{title:'欢迎访问MoMoCMS官网'}
			});
    	});
    </script>  
      <div id="main">
      	<ol class="breadcrumb">
          <li><a href="<?php echo URL_M; ?>">主页</a></li>
	   	  <li><a href="<?php echo URL_M; ?>/contents/<?php if(!empty($arr_main['nickname'])){echo $arr_main['nickname'];}else{echo intval($_GET['id']);} ?>"><?php echo $arr_main['title']; ?></a></li>
	   <?php if(!empty($_GET['cat'])){
	   		$sql_cid="select * from ".DB_PREFIX."product where id=".intval($_GET['cat']);
	   		$query_cid=$db->query($sql_cid);
	   		$num_cid=$db->query("select count(*) from ".DB_PREFIX."product where id=".intval($_GET['cat']))->fetchColumn();
	   		if($num_cid>0){
	   			$arr_cid=$query_cid->fetch();
	   			echo '<li><a href="'.$cat_url.'">'.$arr_cid['name'].'</a></li>';	
	   		}}	?>
	   		<?php if(!empty($_GET['nid'])){	
	   		$sql_sid="select * from ".DB_PREFIX."pages where id=".intval($_GET['nid']);
	   		$query_sid=$db->query($sql_sid);
	   		$num_sid=$db->query("select count(*) from ".DB_PREFIX."pages where id=".intval($_GET['nid']))->fetchColumn();
	   		if($num_sid>0){
	   			$arr_sid=$query_sid->fetch();
	   			$nid_title_tmp = '<li>'.$arr_sid['title'].'</li>';	
	   		}}	?>
	   		<?php if(!empty($_GET['ncat'])){	
	   		$sql_sid="select * from ".DB_PREFIX."pages where id=".intval($_GET['ncat']);
	   		$query_sid=$db->query($sql_sid);
	   		$num_sid=$db->query("select count(*) from ".DB_PREFIX."pages where id=".intval($_GET['ncat']))->fetchColumn();
	   		if($num_sid>0){
	   			$arr_sid=$query_sid->fetch();
	   			$ncat_title_tmp = '<li><a href="'. URL_M.'/contents/'.intval($_GET['id']).'/ncat/'.intval($_GET['ncat']).'">'.$arr_sid['title'].'</a></li>';	
	   		}}	?>
	   		<?php if(!empty($_GET['ncat'])){
	   			echo $ncat_title_tmp;
	   		}if(!empty($_GET['nid'])){
	   			echo $nid_title_tmp;
	   		} ?>
	   		<?php if(!empty($_GET['nd'])){	
	   		$sql_sid="select * from ".DB_PREFIX."pages where id=".intval($_GET['nd']);
	   		$query_sid=$db->query($sql_sid);
	   		$num_sid=$db->query("select count(*) from ".DB_PREFIX."pages where id=".intval($_GET['nd']))->fetchColumn();
	   		if($num_sid>0){
	   			$arr_sid=$query_sid->fetch();
	   			echo '<li>'.$arr_sid['title'].'</li>';	
	   		}}	?>
	   		<?php if(!empty($_GET['sid'])){	
	   		$sql_sid="select * from ".DB_PREFIX."product_sub where id=".intval($_GET['sid']);
	   		$query_sid=$db->query($sql_sid);
	   		$num_sid=$db->query("select count(*) from ".DB_PREFIX."product_sub where id=".intval($_GET['sid']))->fetchColumn();
	   		if($num_sid>0){
	   			$arr_sid=$query_sid->fetch();
	   			echo '<li>'.$arr_sid['name'].'</li>';	
	   		}}	?>
          </ol>
      	<div id="main_content">
              <?php  if(!empty($arr_sid['module'])){
              		require("../admin/".$arr_sid['module']);
            	}else if(!empty($arr_main['module'])){
              		require("../admin/".$arr_main['module']);
            	}else{	?>
            		<div class="text"><?php
              	$tmp_content = !empty($arr_sid) ? $arr_sid['content'] : $arr_main['content'];
              	if (ini_get('magic_quotes_gpc')){
              		echo stripslashes(htmlspecialchars_decode($tmp_content));
              	}else{
              		echo htmlspecialchars_decode($tmp_content);
              	}	 ?></div>
            		<?php	}	?>
      	</div>
      </div>
        	<footer class="footer">
		    <div class="footer-inner">
		        默默企业建站，版权所有 &copy; <?php echo date('Y');?>
		     </div>
		</footer>
</div>
<?php include("common.php");?>
</div>
</body>
</html>