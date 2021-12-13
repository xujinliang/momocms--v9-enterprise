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
<script type="text/javascript">
$(document).ready(function(){	
	/* setup navigation, content boxes, etc... */
	Administry.setup();
	Administry.expandableRows();
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
			echo out_menu(5,$sec_li);
			?>
			<!-- End of Main navigation -->
		</div>
	</header>
	<!-- End of Header -->
	<!-- Page title -->
	<div id="pagetitle">
		<div class="wrapper">
			<h1>杂项设置</h1>
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
				<form name="form" enctype="multipart/form-data" method="post" action="./create_mix.php" target="hiddenframe">
				<input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>">
				<iframe id="hiddenframe" name="hiddenframe" style="width:0;height:0;"></iframe>
				<div style="float:right;margin-top:10px;overflow:hidden;height: 34px;">
					<input type="text" required="required" name="name">
					<select name="pid">
						<option value="1">顶部导航</option>
						<option value="2">友情链接</option>
						<option value="3">底部导航</option>
					</select>
					<a href="javascript:;" class="btn" style="position:relative;top:2px;top:0px\9;" onclick="if(document.forms['form'].name.value!=''){document.forms['form'].submit()}"><span class="icon icon-add">&nbsp;</span>增加导航</a>
				</div>
				</form>
				<table class="stylized full" style="">
						<thead>
							<tr>
								<th>导航名称</th>
								<th>导航链接</th>
								<th>排列序号</th>
								<th>隶属</th>
								<th class="ta-right">操作</th>
							</tr>
						</thead>
						<tbody>
							<?php
						   $sql="select * from ".DB_PREFIX."mix  order by sort desc";
						   $query=$db->query($sql);
						   $num=$db->query("select count(*) from ".DB_PREFIX."mix  order by sort desc")->fetchColumn();
							if($num>0){
								while($arr=$query->fetch()){
							?>
							<tr>
								<td class="title">
									<div>
										<a href="#"><b><?php echo $arr['name']; ?></b></a>
										<div class="listingDetails">
											<div class="pad">
												<b>更新导航及排序</b>
												<form name="form_mix<?php echo $arr['id']; ?>" action="./update_mix.php" method="post" target="hiddenframe" style="height: 34px;">
													<input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>">
													<input type="text" value="<?php echo $arr['name']; ?>" name="newname" placeholder="输入新的导航名称">
													<input type="text" value="<?php echo $arr['value']; ?>" name="newvalues" placeholder="输入导航链接">
													<input type="text" value="<?php echo $arr['sort']; ?>" name="sort" placeholder="排列序号">
													<input type="hidden" name="id" value="<?php echo $arr['id']; ?>">
													<a href="javascript:;" class="btn btn-green" style="position:relative;top:2px;top:0px\9" onclick="document.forms['form_mix<?php echo $arr['id']; ?>'].submit()">更新</a>
												</form>
											</div>
										</div>
									</div>
								</td>
								<td><?php echo $arr['value']; ?></td>
								<td><?php echo $arr['sort']; ?></td>
								<td><?php $array=array('','顶部导航','友情链接','底部导航');echo $array[$arr['pid']]; ?></td>
								<td class="ta-right">
									<a onclick="return confirm('您确定要删除吗？')" href="./delete_mix.php?id=<?php echo $arr['id']; ?>&token=<?php echo $_SESSION['token'];?>">删除</a></td>
							</tr>
						<?php	}}	?>
						</tbody>
					</table>
				</section>
				<!-- End of Left column/section -->
<?php require("./public_side_foot.php"); ?>