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
			echo out_menu(7,$sec_li);
			?>
			<!-- End of Main navigation -->
		</div>
	</header>
	<!-- End of Header -->
	<!-- Page title -->
	<div id="pagetitle">
		<div class="wrapper">
			<h1>数据库管理</h1>
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
				<table class="stylized full" style="">
						<thead>
							<tr>
								<th>数据表名</th>
								<th>存储类型</th>
								<th>整理</th>
								<th>行数</th>
								<th>大小</th>
								<th>多余</th>
								<th class="ta-right">操作</th>
							</tr>
						</thead>
						<tbody>
							<?php
							$tb_lists=$db->query("SHOW TABLES FROM ".DB_NAME);
							while ($row= $tb_lists->fetch()) {
								$query=$db->query("SHOW TABLE STATUS LIKE '".$row[0]."'");
								$arr=$query->fetch(PDO::FETCH_ASSOC);
							?>
							<tr>
								<td><?php echo $row[0]; ?></td>
								<td><?php echo $arr['Engine']; ?></td>
								<td><?php echo $arr['Collation']; ?></td>
								<td><?php echo $arr['Rows']; ?></td>
								<td><?php 
									if(ceil($arr['Data_length']/1024)>1000){
										echo number_format($arr['Data_length']/1024/1024,2)." MB"; 
									}else{
										echo number_format($arr['Data_length']/1024,2)." KB"; 
									}	?></td>
								<td><?php if($arr['Engine']=='MyISAM'){
										if(ceil($arr['Data_free']/1024)>1000){
											echo number_format($arr['Data_free']/1024/1024,2)." MB"; 
										}else{
											echo number_format($arr['Data_free']/1024,2)." KB"; 
										}
									}else{echo '无信息';}  ?></td>
								<td class="ta-right"><a target="hiddenframe" href="./optimizeSQL.php?table=<?php echo $row[0]; ?>&token=<?php echo $_SESSION['token'];?>">优化</a></td>
							</tr>
							<?php
							}
							?>
						</tbody>
					</table>
					<a target="hiddenframe" href="./dobackupSQL.php?token=<?php echo $_SESSION['token'];?>" class="btn" style="float:right;bottom: 4px;position: relative;top: -8px;"><span class="icon icon-add">&nbsp;</span>备份数据库</a>
<div style="width:100%;clear:both;margin-bottom:10px;display: table;">
<?php
$dir = @ dir("./phpmysqlautobackup/backups");
while (($file = $dir->read()) !== false)
{
	if(($file!=".") && ($file!="..")){
?>
<div style="width:100%;margin-bottom:4px;display: table;">
	<span style="float:left;"><?php echo '数据库备份文件 —— '.$file; ?></span>
	<span style="float:right;">
		<a target="hiddenframe" href="./downloadSQL.php?file=<?php echo base64_encode($file); ?>&token=<?php echo $_SESSION['token'];?>">下载</a>&nbsp;&nbsp;
		<a target="hiddenframe" onclick="return confirm('您确定要删除?');" href="./deleteSQL.php?file=<?php echo base64_encode($file); ?>&token=<?php echo $_SESSION['token'];?>">删除</a>	
	</span>
</div>
<?php
	}
}
$dir->close();
?>
</div>
				<iframe id="hiddenframe" name="hiddenframe" style="width:0;height:0;"></iframe>
				</section>
				<!-- End of Left column/section -->
<?php require("./public_side_foot.php"); ?>