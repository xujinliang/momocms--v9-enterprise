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
			echo out_menu(3,$sec_li);
			?>
			<!-- End of Main navigation -->
		</div>
	</header>
	<!-- End of Header -->
	<!-- Page title -->
	<div id="pagetitle">
		<div class="wrapper">
			<h1>
				<?php
				$sql="select * from ".DB_PREFIX."product where id=".intval($_GET['id']);
				$query=$db->query($sql);
				$arr=$query->fetch();
				echo '< '.$arr['name'].' > 详细列表';
				?>
				</h1>
		</div>
	</div>
	<!-- End of Page title -->
	
	<!-- Page content -->
	<div id="page">
		<!-- Wrapper -->
		<div class="wrapper">
				<!-- Left column/section -->
				<section class="column width6 first">
				<a style="float:right;margin:10px 0 5px 0;" href="./create_sub_product.php?id=<?php echo $arr['id']; ?>" class="btn"><span class="icon icon-add">&nbsp;</span>新建产品</a>
				<table id="report" class="stylized full" style="">
						<thead>
							<tr>
								<th>说明文字</th>
								<th class="ta-center">展示图片名称</th>
								<th class="ta-center">是否展示？</th>
								<th class="ta-right">操作</th>
							</tr>
						</thead>
						<tbody>
							<?php
								$sql="select * from ".DB_PREFIX."product_sub where category=".$arr['id']." order by sort desc";
								$query=$db->query($sql);
								while($arr=$query->fetch()){
							?>
							<tr>
								<td class="title"><?php echo $arr['name']; ?></td>
								<td class="ta-center"><?php echo $arr['pic']; ?></td>
								<td class="ta-center"><?php if($arr['isshow']){echo '<font color=green>√</font>';}else{echo '<font color=red>×</font>';} ?></td>
								<td class="ta-right"><a href="./detail_sub_product.php?id=<?php echo $arr['id']; ?>">详细</a>&nbsp;&nbsp;
								<a onclick="return confirm('您确定要删除该产品?')" href="./delete_sub_product.php?id=<?php echo $arr['id']; ?>&token=<?php echo $_SESSION['token'];?>">删除</a></td>
							</tr>
						<?php	}	?>
						</tbody>
					</table>
				</section>
				<!-- End of Left column/section -->
<?php require("./public_side_foot.php"); ?>