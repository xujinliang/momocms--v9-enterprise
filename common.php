<link rel="icon" href="<?php echo URL; ?>/resource/favicon.ico" type="image/x-icon">
<link rel="shortcut icon" href="<?php echo URL; ?>/resource/favicon.ico" type="image/x-icon">
<link rel="bookmark" href="<?php echo URL; ?>/resource/favicon.ico" type="image/x-icon">
<script src="<?php echo URL; ?>/resource/jquery-1.11.1.min.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo URL; ?>/resource/slide/jquery.nivo.slider.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>/resource/level.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>/resource/html5.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>/resource/ie.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo URL; ?>/resource/momocms.css">
<link rel="stylesheet" href="<?php echo URL; ?>/resource/slide/default/default.css" type="text/css" media="screen" />
<link rel="stylesheet" href="<?php echo URL; ?>/resource/slide/nivo-slider.css" type="text/css" media="screen" />
</head>
<body>
<header>
  <div class="inner headtop">
  <div class="pp">
  	<a href="<?php echo URL; ?>" title="MoMoCMS" id="web_logo"> <img border="0" src="<?php echo URL; ?>/resource/logo.gif" alt="MoMoCMS" title="MoMoCMS"> </a>
  </div>
   <div class="top-nav list-none">
   		<?php
   		$sql="select * from ".DB_PREFIX."mix where pid=1 order by sort desc";
   		$query=$db->query($sql);
   		$num=$db->query("select count(*) from ".DB_PREFIX."mix where pid=1 order by sort desc")->fetchColumn();
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
<?php
$id_tmp='';
$sql_tmp="select * from ".DB_PREFIX."pages where isProduct=1";
$query_tmp=$db->query($sql_tmp);
$num_tmp=$db->query("select count(*) from ".DB_PREFIX."pages where isProduct=1")->fetchColumn();
if($num_tmp>0){
	$arr_tmp=$query_tmp->fetch();
	$id_tmp=$arr_tmp['id'];
}
?>
   <nav>
   	<ul class="list-none">
   		<li><a class="<?php if(empty($_GET['id'])){echo 'active';} ?>" href="<?php echo URL; ?>"><span>首页</span></a></li>
   		<?php
   		$sql="select * from ".DB_PREFIX."pages where isMenu=1 order by sort desc,time desc";
   		$query=$db->query($sql);
   		while($arr=$query->fetch()){	?>
   			<li>
   				<a class="<?php if($_GET['id']==$arr['id'])echo 'active'; 
   					$child_sql="select * from ".DB_PREFIX."pages where id=".intval($_GET['id']);
   					$child_query=$db->query($child_sql);
   					$child_num=$db->query("select count(*) from ".DB_PREFIX."pages where id=".intval($_GET['id']))->fetchColumn();
   					if($child_num>0){
   						$child_arr=$child_query->fetch();
   						if($child_arr['pid']==$arr['id']){echo 'active';}
   					}
   					?>" href="
   					<?php	if(!empty($arr['ext_url'])){
   						echo $arr['ext_url'];
   					}else{
   						if(!empty($arr['nickname'])){
   							echo URL."/contents/".$arr['nickname'];
   						}else{
   							echo URL."/contents/".$arr['id'];
   						}}?>
   					"><span><?php echo $arr['title']; ?></span></a>
   				<?php if($arr['pid']=='-1'){
   					$sec_sql="select * from ".DB_PREFIX."pages where pid=".$arr['id']." order by sort desc,time desc";
   					$sec_query=$db->query($sec_sql);
   						?>
   					<dl style="width: 124px;">
   					<?php while($sec_arr=$sec_query->fetch()){
   						 if($sec_arr['module']=='news_module.php'){
   							?>
		   				<dd><a href="
		   					<?php if(!empty($sec_arr['ext_url'])){
   						echo $sec_arr['ext_url'];
   					}else{echo URL.'/contents/'.$arr['id'].'/ncat/'.$sec_arr['id'];}	?>
		   					"><?php echo $sec_arr['title']; ?></a></dd>
		   			<?php	}else{	?>
		   				<dd><a href="
		   					<?php if(!empty($sec_arr['ext_url'])){
   						echo $sec_arr['ext_url'];
   					}else{echo URL.'/contents/'.$arr['id'].'/nd/'.$sec_arr['id'];}?>
		   					"><?php echo $sec_arr['title']; ?></a></dd>
		   			<?php	}}	?>
		   			</dl>
		   		<?php	}	?>
   				<?php if($arr['isProduct']==1){
   					$p_sql="select * from ".DB_PREFIX."product_cat order by sort desc";
   					$p_query=$db->query($p_sql);
   						?>
   					<dl style="width: 124px;">
   					<?php while($p_arr=$p_query->fetch()){	?>
		   				<dd><a href="javascript:;"><?php echo $p_arr['name']; ?>
		   					<?php
		   						$sql_pro="select * from ".DB_PREFIX."product where cat=".$p_arr['id']." order by sort desc";
		   						$p_query_pro=$db->query($sql_pro);
		   						$child_num_pro=$db->query("select count(*) from ".DB_PREFIX."product where cat=".$p_arr['id']." order by sort desc")->fetchColumn();
				   					if($child_num_pro>0){	?>
				   						<div><ul>
				   				<?php
				   						while($child_arr_pro=$p_query_pro->fetch()){
		   					?>
		   						<li onclick="window.location.href='<?php
								        	if(!empty($id_tmp)){
								        		echo URL.'/contents/'.$id_tmp.'/cat/'.$child_arr_pro['id'];	
								        	}
								        	?>'"><?php echo $child_arr_pro['name'];?></li>
		   					<?php	}	?>			
		   						</ul></div>
		   				<?php	}	?>
		   					</a></dd>
		   			<?php	}	?>
		   			</dl>
		   		<?php	}	?>
   			</li>
   		<?php	}	?>
   	</ul>
   </nav>
  </div>
</header>
<div class="banner slider-wrapper theme-default">
    <div id="slider" class="nivoSlider">
<?php
//打开 images 目录
$dir = dir("./resource/slide/images");
//列出 images 目录中的文件
while (($file = $dir->read()) !== false)
{
	if($file!="." && $file!=".."){
	?>
<img src="<?php echo URL; ?>/resource/slide/images/<?php echo $file; ?>" data-thumb="<?php echo URL; ?>/resource/slide/images/<?php echo $file; ?>" alt="" />
<?php
	}
}
$dir->close();
?> 
    </div>
</div>
<script type="text/javascript">
    $(function() {
        $('#slider').nivoSlider({controlNav: false});
    });
 </script>