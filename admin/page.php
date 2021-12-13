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
			echo out_menu(2,$sec_li);
			?>
			<!-- End of Main navigation -->
		</div>
	</header>
	<!-- End of Header -->
	<!-- Page title -->
	<div id="pagetitle">
		<div class="wrapper">
			<h1>页面管理</h1>
		</div>
	</div>
	<!-- End of Page title -->
	
	<!-- Page content -->
	<div id="page">
		<!-- Wrapper -->
		<div class="wrapper">
				<!-- Left column/section -->
				<section class="column width6 first">
				<div style="float:left;margin-top:10px;"><form name="form_search" method="get" action=""><input type="text" name="stext" placeholder="输入需要搜索的内容"><a style="padding: 1px 10px 3px 10px;" href="javascript:;" class="btn" onclick="document.forms['form_search'].submit()">搜索</a></form></div>
				<a style="float:right;margin:10px 0 5px 0;" href="./create_page.php" class="btn"><span class="icon icon-add">&nbsp;</span>创建页面</a>
				<table id="report" class="stylized full" style="">
						<thead>
							<tr>
								<th width="200">页面名称</th>
								<th class="ta-center">主菜单?</th>
								<th class="ta-center">二级菜单?</th>
								<th class="ta-center">新闻?</th>
								<th class="ta-center">关联产品?</th>
								<th class="ta-center">侧栏定制?</th>
								<th class="ta-center">序号</th>
								<th class="ta-right">操作</th>
							</tr>
						</thead>
						<tbody>
							<?php
if(empty($_GET['stext'])){
	$where='1=1';	
	$sql="select * from ".DB_PREFIX."pages where ".$where." and isSecondaryMenu=0 order by isMenu desc,sort desc,time desc";
}else{
	$where="title like '%".addslashes(htmlspecialchars($_GET['stext']))."%'";
	$sql="select * from ".DB_PREFIX."pages where ".$where." order by isMenu desc,sort desc,time desc";
}
$query=$db->query($sql);
$num_all=count($query->fetchAll());
$page_size=20;
$page_count=ceil($num_all/$page_size);
$offset=$page_size*intval(!empty($_GET['page'])?($_GET['page']-1):0);
if(empty($_GET['stext'])){
	$sql="select * from ".DB_PREFIX."pages where ".$where." and isSecondaryMenu=0 order by isMenu desc,sort desc,time desc limit ".$offset." , ".$page_size;
	$query=$db->query($sql);
	$num=$db->query("select count(*) from (select * from ".DB_PREFIX."pages where ".$where." and isSecondaryMenu=0 order by isMenu desc,sort desc,time desc limit ".$offset." , ".$page_size.")tmp")->fetchColumn();
}else{
	$sql="select * from ".DB_PREFIX."pages where ".$where." order by isMenu desc,sort desc,time desc limit ".$offset." , ".$page_size;
	$query=$db->query($sql);
	$num=$db->query("select count(*) from (select * from ".DB_PREFIX."pages where ".$where." order by isMenu desc,sort desc,time desc limit ".$offset." , ".$page_size.")tmp")->fetchColumn();
}
if($num>0){
	while($arr=$query->fetch()){	?>
		<tr>
			<td class="title" width="200">
				<div>
					<a target="_blank" href="../contents.php?id=<?php echo $arr['id']; ?>"><b><?php echo $arr['title']; ?></b></a>
				</div>
			</td>
			<td class="ta-center"><?php echo $arr['isMenu']==1?'<span style="color:green">√</span>':'<span style="color:red">×</span>'; ?></td>
			<td class="ta-center"><?php echo $arr['isSecondaryMenu']==1?'<span style="color:green">√</span>':'<span style="color:red">×</span>'; ?></td>
			<td class="ta-center"><?php echo $arr['isNews']==1?'<span style="color:green">√</span>':'<span style="color:red">×</span>'; ?></td>
			<td class="ta-center"><?php echo $arr['isProduct']==1?'<span style="color:green">√</span>':'<span style="color:red">×</span>'; ?></td>
			<td class="ta-center"><?php echo $arr['barsid']==1?'<span style="color:green">√</span>':'<span style="color:red">×</span>'; ?></td>
			<td class="ta-center"><?php echo $arr['sort']; ?></td>
			<td class="ta-right"><a href="./edit_page.php?id=<?php echo $arr['id']; ?>">编辑</a>&nbsp;&nbsp;
				<a onclick="return confirm('您确定要删除吗？')" href="./delete_page.php?id=<?php echo $arr['id']; ?>&token=<?php echo $_SESSION['token'];?>">删除</a></td>
		</tr>		
	<?php	if($arr['pid']=='-1' && empty($_GET['stext'])){
			$sql2="select * from ".DB_PREFIX."pages where ".$where." and isSecondaryMenu=1 and pid=".$arr['id']." order by isMenu desc,sort desc,time desc";
			$query2=$db->query($sql2);
			$num2=$db->query("select count(*) from ".DB_PREFIX."pages where ".$where." and isSecondaryMenu=1 and pid=".$arr['id']." order by isMenu desc,sort desc,time desc")->fetchColumn();
			if($num2>0){
				while($arr2=$query2->fetch()){
							?>
							<tr>
								<td class="title" width="200">
									<div>
										<a target="_blank" href="../contents.php?id=<?php echo $arr2['id']; ?>"><b><?php echo "&nbsp;&nbsp; —— ".$arr2['title']; ?></b></a>
									</div>
								</td>
								<td class="ta-center"><?php echo $arr2['isMenu']==1?'<span style="color:green">√</span>':'<span style="color:red">×</span>'; ?></td>
								<td class="ta-center"><?php echo $arr2['isSecondaryMenu']==1?'<span style="color:green">√</span>':'<span style="color:red">×</span>'; ?></td>
								<td class="ta-center"><?php echo $arr2['isNews']==1?'<span style="color:green">√</span>':'<span style="color:red">×</span>'; ?></td>
								<td class="ta-center"><?php echo $arr2['isProduct']==1?'<span style="color:green">√</span>':'<span style="color:red">×</span>'; ?></td>
								<td class="ta-center"><?php echo $arr2['barsid']==1?'<span style="color:green">√</span>':'<span style="color:red">×</span>'; ?></td>
								<td class="ta-center"><?php echo $arr2['sort']; ?></td>
								<td class="ta-right"><a href="./edit_page.php?id=<?php echo $arr2['id']; ?>">编辑</a>&nbsp;&nbsp;
									<a onclick="return confirm('您确定要删除吗？')" href="./delete_page.php?id=<?php echo $arr2['id']; ?>&token=<?php echo $_SESSION['token'];?>">删除</a></td>
							</tr>
						<?php	}}}}} ?>
						</tbody>
					</table>
<?php	if(empty($_GET['stext'])){?>
<div style="text-align:center"><a href="<?php
	if(intval($_GET['page'])>1){
	parse_str($_SERVER['QUERY_STRING'],$myArray);
			$myArray['page']=$_GET['page']-1;
		echo "./page.php?".http_build_query($myArray);}?>
	">上一页</a>&nbsp;<a href="<?php
		if((intval($_GET['page'])<$page_count) && ($num_all>$page_size)){
		parse_str($_SERVER['QUERY_STRING'],$myArray);
			$myArray['page']=(empty($_GET['page'])?1:$_GET['page'])+1;
		echo "./page.php?".http_build_query($myArray);}?>
		">下一页</a>&nbsp;,&nbsp;<?php if(empty($page_count)){echo '0';}else{echo empty($_GET['page'])?1:intval($_GET['page']);} ?> / <?php echo $page_count; ?></div>
<?php	}	?>
				</section>
				<!-- End of Left column/section -->
<?php require("./public_side_foot.php"); ?>