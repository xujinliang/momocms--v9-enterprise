<?php
require("./database.php");
if(stristr($_SERVER['HTTP_USER_AGENT'], 'android') || stristr($_SERVER['HTTP_USER_AGENT'], 'iphone') || stristr($_SERVER['HTTP_USER_AGENT'], 'ipad')) {
	header("Location:".URL."/m");
}else{
	$rooturl = URL;
}
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
<!DOCTYPE html>
<html><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta charset="utf-8">
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
<?php include("common.php");?>
<div class="index">
  <div class="inner">
    <div class="content lists">
 	 <div id="sidebar">
         <?php
			$tmp_side = '';
			if(!empty($_GET['nd'])){$tmp_side=intval($_GET['nd']);}
			if(!empty($_GET['nid'])){$tmp_side=intval($_GET['nid']);}
			if(!empty($_GET['ncat'])){$tmp_side=intval($_GET['ncat']);}
			$sql_side="select * from ".DB_PREFIX."modules where pid='".$tmp_side."' and pid !='' order by sort desc";
			$query_side=$db->query($sql_side);
			$num_side=$db->query("select count(*) from ".DB_PREFIX."modules where pid='".$tmp_side."' and pid !='' order by sort desc")->fetchColumn();
			if($num_side>0){
			while($arr_side=$query_side->fetch()){
					eval("?>".base64_decode($arr_side['codes']));
				}
			}else{
			$sql_mixsidebar="select * from ".DB_PREFIX."modules where pid='".$arr_main['id']."' and pid !='' order by sort desc";
			$query_mixsidebar=$db->query($sql_mixsidebar);
			$num_mixsidebar=$db->query("select count(*) from ".DB_PREFIX."modules where pid='".$arr_main['id']."' and pid !='' order by sort desc")->fetchColumn();	
			if($num_mixsidebar>0 && empty($tmp_side)){
				$sql_mixsidebar="select * from ".DB_PREFIX."modules where pid='".$arr_main['id']."' order by sort desc";
				$query_mixsidebar=$db->query($sql_mixsidebar);
				$num_mixsidebar=$db->query("select count(*) from ".DB_PREFIX."modules where pid='".$arr_main['id']."' order by sort desc")->fetchColumn();
			}else{
				$sql_mixsidebar="select * from ".DB_PREFIX."modules where pid ='0' order by sort desc";
				$query_mixsidebar=$db->query($sql_mixsidebar);
				$num_mixsidebar=$db->query("select count(*) from ".DB_PREFIX."modules where pid ='0' order by sort desc")->fetchColumn();
			}
			 	if($num_mixsidebar>0){
			 		while($arr_mixsidebar=$query_mixsidebar->fetch()){
			 			eval("?>".base64_decode($arr_mixsidebar['codes']));
			 		}
			 	}
			}
         ?>
      </div>
      <div id="main">
      	<div id="main_content">
      		<ol class="breadcrumb">
               <li><a href="<?php echo URL; ?>">主页</a></li>
			   	<li><script>if(ltie8()){document.write('<span style="padding:0 5px;color:#ccc;">/ </span>');}</script>
			   		<a href="<?php echo URL; ?>/contents/<?php if(!empty($arr_main['nickname'])){echo $arr_main['nickname'];}else{echo intval($_GET['id']);} ?>"><?php echo $arr_main['title']; ?></a>
			   	</li>
			   <?php if(!empty($_GET['cat'])){	
			   		$sql_cid="select * from ".DB_PREFIX."product where id=".intval($_GET['cat']);
			   		$query_cid=$db->query($sql_cid);
			   		$num_cid=$db->query("select count(*) from ".DB_PREFIX."product where id=".intval($_GET['cat']))->fetchColumn();
			   		if($num_cid>0){
			   			$arr_cid=$query_cid->fetch();
			   			echo '<li><script>if(ltie8()){document.write(\'<span style="padding:0 5px;color:#ccc;">/ </span>\');}</script><a href="'.$cat_url.'">'.$arr_cid['name'].'</a></li>';	
			   		}}	?>
			   		<?php if(!empty($_GET['nid'])){	
			   		$sql_sid="select * from ".DB_PREFIX."pages where id=".intval($_GET['nid']);
			   		$query_sid=$db->query($sql_sid);
			   		$num_sid=$db->query("select count(*) from ".DB_PREFIX."pages where id=".intval($_GET['nid']))->fetchColumn();
			   		if($num_sid>0){
			   			$arr_sid=$query_sid->fetch();
			   			$nid_title_tmp = '<li><script>if(ltie8()){document.write(\'<span style="padding:0 5px;color:#ccc;">/ </span>\');}</script>'.$arr_sid['title'].'</li>';	
			   		}}	?>
			   		<?php if(!empty($_GET['ncat'])){	
			   		$sql_sid="select * from ".DB_PREFIX."pages where id=".intval($_GET['ncat']);
			   		$query_sid=$db->query($sql_sid);
			   		$num_sid=$db->query("select count(*) from ".DB_PREFIX."pages where id=".intval($_GET['ncat']))->fetchColumn();
			   		if($num_sid>0){
			   			$arr_sid=$query_sid->fetch();
			   			$ncat_title_tmp = '<li><script>if(ltie8()){document.write(\'<span style="padding:0 5px;color:#ccc;">/ </span>\');}</script><a href="'. URL.'/contents/'.intval($_GET['id']).'/ncat/'.intval($_GET['ncat']).'">'.$arr_sid['title'].'</a></li>';	
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
			   			echo '<li><script>if(ltie8()){document.write(\'<span style="padding:0 5px;color:#ccc;">/ </span>\');}</script>'.$arr_sid['title'].'</li>';	
			   		}}	?>
			   		<?php if(!empty($_GET['sid'])){	
			   		$sql_sid="select * from ".DB_PREFIX."product_sub where id=".intval($_GET['sid']);
			   		$query_sid=$db->query($sql_sid);
			   		$num_sid=$db->query("select count(*) from ".DB_PREFIX."product_sub where id=".intval($_GET['sid']))->fetchColumn();
			   		if($num_sid>0){
			   			$arr_sid=$query_sid->fetch();
			   			echo '<li><script>if(ltie8()){document.write(\'<span style="padding:0 5px;color:#ccc;">/ </span>\');}</script>'.$arr_sid['name'].'</li>';	
			   		}}	?>
              </ol>
              <?php if(!empty($arr_sid['module'])){
              		require("./admin/".$arr_sid['module']);
            	}else if(!empty($arr_main['module'])){
              		require("./admin/".$arr_main['module']);
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
    </div>
  </div>
</div>
<footer>
	<div class="inner">
		<div class="foot-nav">
			<?php
   		$sql="select * from ".DB_PREFIX."mix where pid=3 order by sort desc";
   		$query=$db->query($sql);
   		$num=$db->query("select count(*) from ".DB_PREFIX."mix where pid=3 order by sort desc")->fetchColumn();
   		if($num>0){
   			$count=0;
   			while($arr=$query->fetch()){$count++;	?>
   		<a href="<?php echo $arr['value'];?>"><?php echo $arr['name'];?></a>
   		<?php if($count!=$num){	?>
      	<span> | </span>
   <?php			}}
   		}
   		?>
		</div>			
		<div class="foot-text">
			<p>默默企业建站，版权所有 &copy; <?php echo date('Y');?><span style="height:6px;display:block;clear:both;"></span>更好用的企业建站系统，Powered BY MoMoCMS</p>
		</div>
	</div>
</footer>
</body></html>