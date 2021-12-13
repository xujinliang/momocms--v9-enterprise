<?php
require("./database.php");
if(stristr($_SERVER['HTTP_USER_AGENT'], 'android') || stristr($_SERVER['HTTP_USER_AGENT'], 'iphone') || stristr($_SERVER['HTTP_USER_AGENT'], 'ipad')) {
	header("Location:".URL."/m");
}else{
	$rooturl = URL;
}
?>
<!DOCTYPE html>
<html><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta charset="utf-8">
<title>MoMoCMS -- 更好用的企业建站系统</title>
<meta name="description" content="MoMoCMS -- 更好用的企业建站系统">
<meta name="keywords" content="MoMoCMS">
<?php include("common.php");?>
<div class="index">
  <div class="inner">
    <div class="content">
<?php
	$sql_mixsidebar="select * from ".DB_PREFIX."modules where pid='-1' order by sort desc";
     $query_mixsidebar=$db->query($sql_mixsidebar);
     $num_mixsidebar=$db->query("select count(*) from ".DB_PREFIX."modules where pid='-1' order by sort desc")->fetchColumn();
   	if($num_mixsidebar>0){
   		while($arr_mixsidebar=$query_mixsidebar->fetch()){
   			eval("?>".base64_decode($arr_mixsidebar['codes']));
   		}
   	}
?>
      <div class="product">
        <div class="title">产品展示</div>
      	<div id="move" style="width:1000px;padding-top:4px;border-radius:10px;font-family: 'Microsoft YaHei',微软雅黑,Arial,Helvetica,sans-serif;"></div>
      <?php
      $str='';
      $sql="select * from ".DB_PREFIX."product_sub where isshow=1 order by sort desc";
      $query=$db->query($sql);
      $num=$db->query("select count(*) from ".DB_PREFIX."product_sub where isshow=1 order by sort desc")->fetchColumn();
      if($num>0){
      	while($arr=$query->fetch()){
      		$str.='<a href="'.URL.'/contents/'.$id_tmp.'/sid/'.$arr['id'].'"><img src="./admin/'.$arr['pic'].'" border="0" style="margin-right:20px;"></a>';
      	}
      }
      ?>
      </div>
	 <script type="text/javascript">Move_level("move",1000,282,'<?php echo $str; ?>');</script>
      <div class="index-link">
        <fieldset>
        	<legend>友情链接</legend>
	        		<?php
   		$sql="select * from ".DB_PREFIX."mix where pid=2 order by sort desc";
   		$query=$db->query($sql);
   		$num=$db->query("select count(*) from ".DB_PREFIX."mix where pid=2 order by sort desc")->fetchColumn();
   		if($num>0){
   			$count=0;
   			while($arr=$query->fetch()){$count++;	?>
   				<a target="_blank" href="<?php echo $arr['value'];?>"><?php echo $arr['name'];?></a>
   <?php			}
   		}
   		?>
   		</fieldset>
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