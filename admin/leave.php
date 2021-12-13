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
			echo out_menu(4,$sec_li);
			?>
			<!-- End of Main navigation -->
		</div>
	</header>
	<!-- End of Header -->
	<!-- Page title -->
	<div id="pagetitle">
		<div class="wrapper">
			<h1>留言管理</h1>
		</div>
	</div>
	<!-- End of Page title -->
	
	<!-- Page content -->
	<div id="page">
		<!-- Wrapper -->
		<div class="wrapper">
				<!-- Left column/section -->
				<section class="column width6 first">
				<table id="report" class="stylized full" style="">
						<thead>
							<tr>
								<th width="270">留言内容</th>
								<th width="50" class="ta-center">留言人</th>
								<th class="ta-center">留言时间</th>
								<th class="ta-center">通过?</th>
								<th class="ta-center">回复?</th>
								<th class="ta-right">操作</th>
							</tr>
						</thead>
						<tbody>
							<?php							
							$sql="select * from ".DB_PREFIX."leave order by status asc,id desc";
							$query=$db->query($sql);
							$num_all=count($query->fetchAll());
							$page_size=5;
							$page_count=ceil($num_all/$page_size);
							$offset=$page_size*intval(!empty($_GET['page'])?($_GET['page']-1):0);
							$sql="select * from ".DB_PREFIX."leave order by status asc,id desc limit ".$offset." , ".$page_size;
							$query=$db->query($sql);
							$num=$db->query("select count(*) from (select * from ".DB_PREFIX."leave order by status asc,id desc limit ".$offset." , ".$page_size.")tmp")->fetchColumn();
							if($num>0){
								while($arr=$query->fetch()){
							?>
							<tr>
								<td class="title">
									<span style="width:270px;display:inline-block;word-break:break-all;">
										<?php echo $arr['con1']; ?>
									</span>
								</td>
								<td class="ta-center"><?php echo $arr['user']; ?></td>
								<td class="ta-center"><?php echo date('Y-m-d H:i:s',$arr['time1']); ?></td>
								<td class="ta-center"><?php echo $arr['status']==1?'<span style="color:green">√</span>':'<span style="color:red">×</span>'; ?></td>
								<td class="ta-center"><?php echo !empty($arr['con2'])?'<span style="color:green">√</span>':'<span style="color:red">×</span>'; ?></td>
								<td class="ta-right">
									<a href="./leave_pass.php?id=<?php echo $arr['id']; ?>&token=<?php echo $_SESSION['token'];?>">通过</a>&nbsp;&nbsp;
									<a href="./leave_reply.php?id=<?php echo $arr['id']; ?>">回复</a>&nbsp;&nbsp;
									<a onclick="return confirm('您确定要删除吗？')" href="./leave_delete.php?id=<?php echo $arr['id']; ?>&token=<?php echo $_SESSION['token'];?>">删除</a></td>
							</tr>
						<?php	}}	?>
						</tbody>
					</table>
<div style="text-align:center"><a href="<?php
	if(intval($_GET['page'])>1){
	parse_str($_SERVER['QUERY_STRING'],$myArray);
			$myArray['page']=$_GET['page']-1;
		echo "./leave.php?".http_build_query($myArray);}?>
	">上一页</a>&nbsp;<a href="<?php
		if((intval($_GET['page'])<$page_count) && ($num_all>$page_size)){
		parse_str($_SERVER['QUERY_STRING'],$myArray);
			$myArray['page']=(empty($_GET['page'])?1:$_GET['page'])+1;
		echo "./leave.php?".http_build_query($myArray);}?>
		">下一页</a>&nbsp;,&nbsp;<?php if(empty($page_count)){echo '0';}else{echo empty($_GET['page'])?1:intval($_GET['page']);} ?> / <?php echo $page_count; ?></div>
				</section>
				<!-- End of Left column/section -->
<?php require("./public_side_foot.php"); ?>