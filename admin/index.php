<?php
error_reporting(0);
session_start();
if(!empty($_SESSION['momocms_admin'])){
	header("Location:./dashboard.php");	
	exit;
}
$_SESSION['momocms_time'] = md5(microtime(true));
?>
<!DOCTYPE html>
<html lang="en">
<head>
<?php require("./public_header.php");	?>
<script type="text/javascript">

$(document).ready(function(){
	
	/* setup navigation, content boxes, etc... */
	
	// validate signup form on keyup and submit
	var validator = $("#loginform").validate({
		rules: {
			username: "required",
			password: "required"
		},
		messages: {
			username: "管理员账号必填",
			password: "管理员密码必填"
		},
		// the errorPlacement has to take the layout into account
		errorPlacement: function(error, element) {
			error.insertAfter(element.parent().find('label:first'));
		}
	});
});
</script>
<script type="text/javascript" src="js/xlert.js"></script>
</head>
<body>
	<!-- Header -->
	<header id="top">
		<div class="wrapper-login">
			<!-- Title/Logo - can use text instead of image -->
			<div id="title"><img SRC="../resource/logo.gif" /><!--<span>Administry</span> demo--></div>
			<!-- Main navigation -->
			<nav id="menu">
				<ul class="sf-menu">
					<li class="current"><a href="javascript:;">登录面板</a></li>
				</ul>
			</nav>
		</div>
	</header>
	<!-- End of Header -->
	<!-- Page title -->
	<div id="pagetitle" style="height:1px;"></div>
	<!-- End of Page title -->
	
	<!-- Page content -->
	<div id="page">
		<!-- Wrapper -->
		<div class="wrapper-login">
				<!-- Login form -->
				<section class="full">					
					<h3></h3>
				<?php if($_SESSION['momocms_error']):	?>
					<?php unset($_SESSION['momocms_error']); ?>
					<div class="box box-error"><span style="margin-left:32px;">账号或密码输入有误</span></div>
				<?php	else:	?>
					<div class="box box-info"><span style="margin-left:32px;">在下方输入帐号和密码进行登录</span></div>
				<?php endif; ?>
					<form id="loginform" method="post" action="validate.php" target="_iframe">

						<p>
							<label class="required" for="username">管理帐号:</label><br/>
							<input type="text" id="username" class="full" value="" name="username"/>
						</p>
						
						<p>
							<label class="required" for="password">管理密码:</label><br/>
							<input type="password" id="password" class="full" value="" name="password"/>
						</p>

						<input type="hidden" name="token" value="<?php echo $_SESSION['momocms_time']; ?>">
						<p>
							<input type="submit" class="btn btn-green big" value="登录"/><!-- &nbsp; <a href="javascript: //;" onClick="$('#emailform').slideDown(); return false;">忘记密码?</a>-->
						</p>
						<div class="clear">&nbsp;</div>

					</form>
					<iframe name="_iframe" style="width:0;height:0;display:none"></iframe>
				</section>
				<!-- End of login form -->
		</div>
		<!-- End of Wrapper -->
	</div>
	<!-- End of Page content -->
	
	<!-- Page footer -->
	<footer id="bottom">
		<div class="wrapper-login">
			<p>Copyright &copy; <?php echo date('Y');?> | Powered BY MoMoCMS</p>
		</div>
	</footer>
	<!-- End of Page footer -->
	</body>
</html>