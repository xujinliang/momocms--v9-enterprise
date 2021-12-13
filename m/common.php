<nav id="menu">
   <ul class="listview-icons">
	<?php
	$id_tmp='';
	$sql_tmp="select * from ".DB_PREFIX."pages where isProduct=1";
	$query_tmp=$db->query($sql_tmp);
	$num_tmp=$db->query("select count(*) from ".DB_PREFIX."pages where isProduct=1")->fetchColumn();
	if($num_tmp>0){
		$arr_tmp=$query_tmp->fetch();
		$id_tmp=$arr_tmp['id'];
	}
	$sql="select * from ".DB_PREFIX."pages where isMenu=1 order by sort desc,time desc";
	$query=$db->query($sql);
	while($arr=$query->fetch()){	?>
		<li class="<?php if($_GET['id']==$arr['id'])echo 'mm-selected'; 
				$child_sql="select * from ".DB_PREFIX."pages where id=".intval($_GET['id']);
				$child_query=$db->query($child_sql);
				$child_num=$db->query("select count(*) from ".DB_PREFIX."pages where id=".intval($_GET['id']))->fetchColumn();
				if($child_num>0){
					$child_arr=$child_query->fetch();
					if($child_arr['pid']==$arr['id']){echo 'mm-selected';}
				}
				?>">
			<a href="
				<?php	if(!empty($arr['ext_url'])){
					echo $arr['ext_url'];
				}else{if(!empty($arr['nickname'])){
						echo URL_M."/contents/".$arr['nickname'];
					}else{
						echo URL_M."/contents/".$arr['id'];
					}}?>
				"><span><?php echo $arr['title']; ?></span></a>
			<?php if($arr['pid']=='-1'){
				$sec_sql="select * from ".DB_PREFIX."pages where pid=".$arr['id']." order by sort desc,time desc";
				$sec_query=$db->query($sec_sql);
				$sec_query_num=$db->query("select count(*) from ".DB_PREFIX."pages where pid=".$arr['id']." order by sort desc,time desc")->fetchColumn();
				if($sec_query_num>0){	?>
				<ul>
   			<?php while($sec_arr=$sec_query->fetch()){
					 if($sec_arr['module']=='news_module.php'){
						?>
   				<li class="<?php if($_GET['ncat']==$sec_arr['id'])echo 'mm-selected';?>"><a href="
   					<?php if(!empty($sec_arr['ext_url'])){
					echo $sec_arr['ext_url'];
				}else{echo URL_M.'/contents/'.$arr['id'].'/ncat/'.$sec_arr['id'];}	?>
   					"><?php echo $sec_arr['title']; ?></a></li>
   			<?php	}else{	?>
   				<li class="<?php if($_GET['nd']==$sec_arr['id'])echo 'mm-selected';?>"><a href="
   					<?php if(!empty($sec_arr['ext_url'])){
					echo $sec_arr['ext_url'];
				}else{echo URL_M.'/contents/'.$arr['id'].'/nd/'.$sec_arr['id'];}?>
   					"><?php echo $sec_arr['title']; ?></a></li>
   			<?php	}}	?>
   			</ul><?php	}	?>
   		<?php	}	?>
			<?php if($arr['isProduct']==1){
				$p_sql="select * from ".DB_PREFIX."product_cat order by sort desc";
				$p_query=$db->query($p_sql);
					?>
				<ul>
				<?php while($p_arr=$p_query->fetch()){	?>
   				<li>
   					<span><?php echo $p_arr['name']; ?></span>
   					<?php
   						$sql_pro="select * from ".DB_PREFIX."product where cat=".$p_arr['id']." order by sort desc";
   						$p_query_pro=$db->query($sql_pro);
   						$child_num_pro=$db->query("select count(*) from ".DB_PREFIX."product where cat=".$p_arr['id']." order by sort desc")->fetchColumn();
		   					if($child_num_pro>0){	?>
		   						<ul>
		   				<?php
		   						while($child_arr_pro=$p_query_pro->fetch()){
   					?>
   						<li class="<?php if($_GET['cat']==$child_arr_pro['id'])echo 'mm-selected';?>"><a href="<?php
						        	if(!empty($id_tmp)){
						        		echo URL_M.'/contents/'.$id_tmp.'/cat/'.$child_arr_pro['id'];	
						        	}
						        	?>"><?php echo $child_arr_pro['name'];?></a></li>
   					<?php	}	?>			
   							</ul>
   					<?php	}	?>
   				</li>
   			<?php	}	?>
   			</ul>
   		<?php	}	?>
		</li>
	<?php	}	?>
    </ul>
</nav>