<?php
/**
	新闻模块
*/
if(strpos($_SERVER['REQUEST_URI'],"page")){
	$_SERVER['REQUEST_URI'] = substr($_SERVER['REQUEST_URI'],0,strpos($_SERVER['REQUEST_URI'],"page")-1);
}
if(empty($_GET['nid']) && empty($_GET['ncat'])){	?>
<ul class="news_ul" style="margin:0;padding:0;">
<?php
$sql="select * from ".DB_PREFIX."pages where isNews=1 order by sort desc";
$query=$db->query($sql);
$num_all=count($query->fetchAll());
$page_size=3;
$page_count=ceil($num_all/$page_size);
$offset=$page_size*intval(!empty($_GET['page'])?($_GET['page']-1):0);
$sql="select * from ".DB_PREFIX."pages where isNews=1 order by time desc,sort desc limit ".$offset." , ".$page_size;
$query=$db->query($sql);
$num=$db->query("select count(*) from (select * from ".DB_PREFIX."pages where isNews=1 order by time desc,sort desc limit ".$offset." , ".$page_size.")tmp")->fetchColumn();
if($num>0){
	while($arr_list=$query->fetch()){
		$nurl= $rooturl.'/contents/'.MAIN_ID."/nid/".$arr_list['id'];
		echo '<li style="list-style-type:none;"><div class="part_left"><a onmouseover="this.style.textDecoration=\'underline\'" onmouseout="this.style.textDecoration=\'none\'" href="'.$nurl.'">'.$arr_list['title'].'</a></div><div class="part_right">'.date('Y-m-d H:i:s',$arr_list['time']).'</div></li>';	
	}
}
?>	
</ul>
<div class="part_bottom"><a href="<?php
	if(intval($_GET['page'])>1){
	echo $rooturl.'/contents/'.MAIN_ID."/page/".($_GET['page']-1);} ?>
	">上一页</a>&nbsp;<a href="<?php
		if((intval($_GET['page'])<$page_count) && ($num_all>$page_size)){
		echo $rooturl.'/contents/'.MAIN_ID."/page/".((empty($_GET['page'])?1:$_GET['page'])+1);} ?>
		">下一页</a>，<?php if(empty($page_count)){echo '0';}else{echo empty($_GET['page'])?1:intval($_GET['page']);} ?> / <?php echo $page_count; ?></div>
<?php
}else if(empty($_GET['nid']) && !empty($_GET['ncat'])){	?>
<ul class="news_ul" style="margin:0;padding:0;display:table;width:100%;">
<?php
$sql="select * from ".DB_PREFIX."pages where isNews=1 and news_cat='".intval($_GET['ncat'])."' order by sort desc";
$query=$db->query($sql);
$num_all=count($query->fetchAll());
$page_size=3;
$page_count=ceil($num_all/$page_size);
$offset=$page_size*intval(!empty($_GET['page'])?($_GET['page']-1):0);
$sql="select * from ".DB_PREFIX."pages where isNews=1 and news_cat='".intval($_GET['ncat'])."' order by time desc,sort desc limit ".$offset." , ".$page_size;
$query=$db->query($sql);
$num=$db->query("select count(*) from (select * from ".DB_PREFIX."pages where isNews=1 and news_cat='".intval($_GET['ncat'])."' order by time desc,sort desc limit ".$offset." , ".$page_size.")tmp")->fetchColumn();
if($num>0){
	while($arr_list=$query->fetch()){
		$nurl= $_SERVER['REQUEST_URI']."/nid/".$arr_list['id'];
		echo '<li style="list-style-type:none;"><div class="part_left"><a onmouseover="this.style.textDecoration=\'underline\'" onmouseout="this.style.textDecoration=\'none\'" href="'.$nurl.'">'.$arr_list['title'].'</a></div><div class="part_right">'.date('Y-m-d H:i:s',$arr_list['time']).'</div></li>';	
	}
}
?>	
</ul>
<div class="part_bottom"><a href="<?php
	if(intval($_GET['page'])>1){
	echo $_SERVER['REQUEST_URI']."/page/".($_GET['page']-1);} ?>
	">上一页</a>&nbsp;<a href="<?php
		if((intval($_GET['page'])<$page_count) && ($num_all>$page_size)){
		echo $_SERVER['REQUEST_URI']."/page/".((empty($_GET['page'])?1:$_GET['page'])+1);} ?>
		">下一页</a>，<?php if(empty($page_count)){echo '0';}else{echo empty($_GET['page'])?1:intval($_GET['page']);} ?> / <?php echo $page_count; ?></div>
<?php
}else{
	$sql="select * from ".DB_PREFIX."pages where id=".intval($_GET['nid']);
	$query=$db->query($sql);
	$num=$db->query("select count(*) from ".DB_PREFIX."pages where id=".intval($_GET['nid']))->fetchColumn();
	if($num>0){
	$arr=$query->fetch();
	echo "<div style='text-align:center;line-height:40px;margin-bottom:10px;border-bottom:1px solid #cdcdcd'><p style='color:#666;'>发布时间：".date('Y-m-d H:i:s',$arr['time'])."</p></div>";
	if (ini_get('magic_quotes_gpc')){
    		$content_news=stripslashes(htmlspecialchars_decode($arr['content']));
    	}else{
    		$content_news=htmlspecialchars_decode($arr['content']);
    	}
	echo "<div class='text'>".$content_news."</div>";
	}
}
?>