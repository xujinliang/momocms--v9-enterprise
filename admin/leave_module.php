<?php
/**
	留言模块
*/
if(isset($_POST['sub'])){
	$_POST=array_map("htmlspecialchars",$_POST);
	$_POST=array_map("addslashes",$_POST);
	 if (empty($_SESSION['captcha']) || trim(strtolower($_POST['captcha'])) != $_SESSION['captcha']) {
	              	echo '<script>alert("验证码输入错误，请重新尝试");</script>';
	              }else{
	$db->exec("insert into ".DB_PREFIX."leave set
					status ='0',
					user ='".mb_substr($_POST['user'],0,4,'utf-8')."',
					con1 = '".mb_substr($_POST['leave_txt'],0,50,'utf-8')."',
					time1 = '".time()."'");
echo '<script>alert("留言成功");</script>';
	}
}
?>
<script>
function check(){
	var error='';
	if(document.forms['form'].user.value==''){
		error+='留言人必填\r\n';
	}if(document.forms['form'].leave_txt.value==''){
		error+='留言内容必填\r\n';
	}
	if(error==''){
		return true;	
	}else{
		alert(error);
		return false;	
	}
}
</script>
<form name="form" action="" method="post" onsubmit="return check()">
	<input type="text" class="half" value="" name="user" placeholder="留言人, 最多4个字符">
	<div style="clear:both;height:4px;"></div>
	<textarea name="leave_txt" placeholder="留言内容, 最多为50个字符"></textarea>
	<div style="clear:both;height:4px;"></div>
	<img src="<?php echo URL; ?>/resource/captcha/captcha.php" id="captcha" /><br>
	 <a href="javascript:;" onclick="
    document.getElementById('captcha').src='<?php echo URL; ?>/resource/captcha/captcha.php?'+Math.random();
    document.getElementById('captcha-form').focus();"
    id="change-image">看不清楚 ? 换一个</a><br>
    <input type="text" name="captcha" id="captcha-form" />
    <div style="clear:both;height:4px;"></div>
	<input type="submit" name="sub" class="btn" value="留言">
</form>
<br>
<div class="box leave_lists">
	<?php
	$sql="select * from ".DB_PREFIX."leave where status=1 order by id desc";
	$query=$db->query($sql);
	$num_all=count($query->fetchAll());
	$page_size=5;
	$page_count=ceil($num_all/$page_size);
	$offset=$page_size*intval(!empty($_GET['page'])?($_GET['page']-1):0);
	$sql="select * from ".DB_PREFIX."leave where status=1 order by id desc limit ".$offset." , ".$page_size;
	$query=$db->query($sql);
	$num=$db->query("select count(*) from (select * from ".DB_PREFIX."leave where status=1 order by id desc limit ".$offset." , ".$page_size.")tmp")->fetchColumn();
	if($num>0){
		while($arr_list=$query->fetch()){
		?>
		<div class="leave_bottom">
			<p class="leave_contents"><?php echo $arr_list['con1']; ?></p>
			<div class="comt-meta"><?php echo $arr_list['user']; ?> <span style="margin:0 4px;font-weight:normal;">咨询于</span> <?php echo date('Y-m-d H:i:s',$arr_list['time1']); ?>
			<?php if(!empty($arr_list['con2'])){	?>
				<div style="background: #FFF1F1;margin-left: 20px;padding:4px 0 4px 6px">
					<p class="leave_contents"><?php echo $arr_list['con2']; ?></p>
					<p style="margin-top:-4px"><?php echo $arr_list['admin']; ?> <span style="margin:0 4px;font-weight:normal;">回复于</span> <?php echo date('Y-m-d H:i:s',$arr_list['time2']); ?></p>
				</div>
			<?php	}	?>
			</div>
		</div>
		<?php
		}
	}
	?>
</div>
<div class="part_bottom"><a href="<?php
	if(intval($_GET['page'])>1){
	echo $rooturl.'/contents/'.MAIN_ID."/page/".($_GET['page']-1);} ?>
	">上一页</a>&nbsp;<a href="<?php
		if((intval($_GET['page'])<$page_count) && ($num_all>$page_size)){
		echo $rooturl.'/contents/'.MAIN_ID."/page/".((empty($_GET['page'])?1:$_GET['page'])+1);} ?>
		">下一页</a>，<?php if(empty($page_count)){echo '0';}else{echo empty($_GET['page'])?1:intval($_GET['page']);} ?> / <?php echo $page_count; ?></div>