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
	$("#sampleform").validate({
		rules: {
			reply_back: "required"
		},
		messages: {
			reply_back: "内容必填"
		}
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
					<form id="sampleform" enctype="multipart/form-data" method="post" action="./leave_reply_do.php" target="hiddenframe" onsubmit="document.documentElement.scrollTop = document.body.scrollTop =0;">
					<iframe id="hiddenframe" name="hiddenframe" style="width:0;height:0;"></iframe>
					<?php
						$sql="select * from ".DB_PREFIX."leave where id=".intval($_GET['id']);
						$query=$db->query($sql);
						$arr=$query->fetch();
					?>
						<fieldset>
							<legend>回复留言</legend>
							<duv class="box"><?php echo $arr['con1']; ?></duv>
							<p>
								<input type="hidden" name="id" value="<?php echo $arr['id']; ?>">
								<input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>">
								<textarea id="area2" class="medium half required" name="reply_back"></textarea>
							</p>
							<p>
								<input type="submit" class="btn btn-green big" value="回复" />	
							</p>
						</fieldset>
					</form>
				</section>
				<!-- End of Left column/section -->
<?php require("./public_side_foot.php"); ?>