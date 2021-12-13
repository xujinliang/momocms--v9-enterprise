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
	$(".img").fancybox({
				'width'				: '75%',
				'height'			: '75%',
				'autoScale'			: false,
				'transitionIn'		: 'none',
				'transitionOut'		: 'none',
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
			echo out_menu(3,$sec_li);
			?>
			<!-- End of Main navigation -->
		</div>
	</header>
	<!-- End of Header -->
	<!-- Page title -->
	<div id="pagetitle">
		<div class="wrapper">
			<h1>广告显示</h1>
		</div>
	</div>
	<!-- End of Page title -->
	
	<!-- Page content -->
	<div id="page">
		<!-- Wrapper -->
		<div class="wrapper">
				<!-- Left column/section -->
				<section class="column width6 first">
					<div id="successMsg" style="display:none" class="box box-success">图片上传成功</div>
					<form id="sampleform" enctype="multipart/form-data" method="post" action="./banner_do.php" target="hiddenframe">
					<iframe id="hiddenframe" name="hiddenframe" style="width:0;height:0;"></iframe>
					<input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>">
						<p>
							<input type="file" name="banner">
						</p>
						<p>
							<input type="submit" class="btn btn-green big" value="上传" /> 尺寸（1000*310）
						</p>
					</form>
					<p>
<?php
//打开 images 目录
$dir = dir("../resource/slide/images");
//列出 images 目录中的文件
while (($file = $dir->read()) !== false)
{
	if($file!="." && $file!=".."){
		echo '<a class="img" href="../resource/slide/images/'.$file.'">'.$file.'</a>&nbsp;<a onclick="return confirm(\'您确定要删除吗？\')" style="color:red" href="./banner_delete.php?file='.$file.'&token='.$_SESSION['token'].'">删除</a><br>';	
	}
}

$dir->close();
?> 
				</section>
				<!-- End of Left column/section -->
<?php require("./public_side_foot.php"); ?>