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
<?php require("./public_header.php");	?>
<script type="text/javascript" src="fancybox/jquery.fancybox-1.3.4.pack.js"></script>
<link rel="stylesheet" type="text/css" href="fancybox/jquery.fancybox-1.3.4.css" media="screen" />
<script type="text/javascript">
$(document).ready(function(){	
	/* setup navigation, content boxes, etc... */
	Administry.setup();
	Administry.expandableRows();
	$(".addcodes").fancybox({
				'width'				: '75%',
				'height'			: '70%',
				'autoScale'			: false,
				'transitionIn'		: 'none',
				'transitionOut'		: 'none',
				'type'				: 'iframe'
	});
});
</script>
</head>
<body>
	<!-- Header -->
	<header id="top">
		<div class="wrapper">
			<!-- Title/Logo - can use text instead of image -->
			<div id="title"><img SRC="../resource/logo.gif" /><!--<span>Administry</span> demo--></div>
			<!-- Top navigation -->
			<div id="topnav">
				管理员 <b><?php echo $_SESSION['momocms_admin']; ?></b>
				<span>|</span> <a href="./logout.php">注销</a><br />
			</div>
			<!-- End of Top navigation -->
			<!-- Main navigation -->
			<?php
			require("./public_menu.php");
			echo out_menu(6,$sec_li);
			?>
			<!-- End of Main navigation -->
		</div>
	</header>
	<!-- End of Header -->
	<!-- Page title -->
	<div id="pagetitle">
		<div class="wrapper">
			<h1>挂件设置</h1>
		</div>
	</div>
	<!-- End of Page title -->
	
	<!-- Page content -->
	<div id="page">
		<!-- Wrapper -->
		<div class="wrapper">
				<!-- Left column/section -->
				<section class="column width6 first">
				<div id="successMsg" style="display:none" class="box box-success">操作成功</div>
				<form name="modules" enctype="multipart/form-data" method="post" action="./create_modules.php" target="hiddenframe">
					<div style="float:right;margin-top:10px;overflow:hidden;height: 34px;">
						<label>挂件名称</label>
						<input type="text" required="required" name="name">
						<input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>">
						<a href="javascript:;" class="btn" style="position:relative;top:2px;top:0px\9;" onclick="if(document.forms['modules'].name.value!=''){document.forms['modules'].submit()}"><span class="icon icon-add">&nbsp;</span>增加挂件</a>
					</div>
				</form>
				<table class="stylized full" style="">
						<thead>
							<tr>
								<th>挂件名称</th>
								<th>添加代码</th>
								<th class="ta-right">操作</th>
							</tr>
						</thead>
						<tbody>
							<?php
						   $sql="select * from ".DB_PREFIX."modules  order by sort desc";
						   $query=$db->query($sql);
						   $num=$db->query("select count(*) from ".DB_PREFIX."modules  order by sort desc")->fetchColumn();
						   $options = '';
							if($num>0){
								while($arr=$query->fetch()){
									$options.="<option value=".$arr['id'].">".$arr['name']."</options>";
							?>
							<tr>
								<td class="title">
									<b><?php echo $arr['name']; ?></b>
								</td>
								<td><?php echo !empty($arr['codes'])?'<span style="color:green">√</span>':'<span style="color:red">×</span>'; ?></td>
								<td class="ta-right">
									<a class="addcodes" href="./modules_add_codes.php?id=<?php echo $arr['id']; ?>&token=<?php echo $_SESSION['token'];?>">更新代码</a>&nbsp;
									<a onclick="return confirm('您确定要删除吗？')" href="./delete_modules.php?id=<?php echo $arr['id']; ?>&token=<?php echo $_SESSION['token'];?>">删除</a></td>
							</tr>
						<?php	}}	?>
						</tbody>
					</table>
				<div style="clear:both;border-bottom:1px solid #ddd;height:2px;margin-top: 10px;"></div>
				<form name="form" enctype="multipart/form-data" method="post" action="./create_mix_sidebar.php" target="hiddenframe">
				<input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>">
				<div style="float:right;margin-top:10px;overflow:hidden;height: 34px;">
					<label>侧栏挂件</label>
					<select name="bars" style="width:150px;">
						<?php echo $options; ?>
					</select>&nbsp;
					<label>隶属页面</label>
					<select name="bars_page" style="width:150px;">
						<option value="-2">初始挂件状态 (PID = -2)</option>
						<option value="-1">网站首页挂件 (PID = -1)</option>
						<option value="0">列表页公共挂件 (PID = 0)</option>
						<?php 
						$sql="select * from ".DB_PREFIX."pages where barsid=1";
						$query=$db->query($sql);
						$num=$db->query("select count(*) from ".DB_PREFIX."pages where barsid=1")->fetchColumn();
						if($num>0){
							while($arr=$query->fetch()){	?>
								<option value="<?php echo $arr['id']; ?>"><?php echo $arr['title']; ?> (PID > 0)</option>
					<?php
							}
						}
						?>
					</select>
					<a href="javascript:;" class="btn" style="position:relative;top:2px;top:0px\9;" onclick="if(document.forms['form'].name.value!=''){document.forms['form'].submit()}"><span class="icon icon-add">&nbsp;</span>增加侧边栏</a>
				</div>
				</form>
				<iframe id="hiddenframe" name="hiddenframe" style="width:0;height:0;"></iframe>
				<label class="required" style="color:#ff0000;margin-top:2px;">注意：modules数据表中<br>pid = -2 ，表示新增加的挂件初始状态&nbsp&nbsp;&nbsp&nbsp;|&nbsp&nbsp;&nbsp&nbsp;pid = -1，表示网站首页上挂件<br>
					pid = 0，表示所有列表页公共挂件&nbsp&nbsp;&nbsp&nbsp;|&nbsp&nbsp;&nbsp&nbsp;pid > 0，表示某个列表页上的挂件</label>
				<table class="stylized full" style="">
						<thead>
							<tr>
								<th>侧边栏挂件名称</th>
								<th>排列序号</th>
								<th>隶属</th>
							</tr>
						</thead>
						<tbody>
							<?php
						   $sql="select * from ".DB_PREFIX."modules where pid!='-2' order by sort desc";
						   $query=$db->query($sql);
						   $num=$db->query("select count(*) from ".DB_PREFIX."modules where pid!='-2' order by sort desc")->fetchColumn();
							if($num>0){
								while($arr=$query->fetch()){
							?>
							<tr>
								<td class="title">
									<div>
										<a href="#"><b><?php echo $arr['name']; ?></b></a>
										<div class="listingDetails">
											<div class="pad">
												<b>更新排序</b>
												<form name="form_mix_sidebar<?php echo $arr['id']; ?>" action="./update_modules.php" method="post" target="hiddenframe" style="height: 34px;">
													<input type="text" value="<?php echo $arr['sort']; ?>" name="sort" placeholder="排列序号">
													<input type="hidden" name="id" value="<?php echo $arr['id']; ?>">
													<input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>">
													<a href="javascript:;" class="btn btn-green" style="position:relative;top:2px;top:0px\9;" onclick="document.forms['form_mix_sidebar<?php echo $arr['id']; ?>'].submit()">更新</a>
												</form>
											</div>
										</div>
									</div>
								</td>
								<td><?php echo $arr['sort']; ?></td>
								<td><?php
									if($arr['pid']=='-1'){
									 	echo '网站首页挂件';
									 }if($arr['pid']=='0'){
									 	echo '列表页公共挂件';
									 }else{
										$sql_sub="select * from ".DB_PREFIX."pages where id=".$arr['pid'];
										$query_sub=$db->query($sql_sub);
										$arr_sub = $query_sub->fetch();
										echo $arr_sub['title'];} ?></td>
							</tr>
						<?php	}}	?>
						</tbody>
					</table>
				</section>
				<!-- End of Left column/section -->
<?php require("./public_side_foot.php"); ?>