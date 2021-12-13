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
<script type="text/javascript" charset="utf-8" src="./ueditor/ueditor.config.js"></script>
<script type="text/javascript" charset="utf-8" src="./ueditor/ueditor.all.min.js"> </script>
<script type="text/javascript" SRC="js/custom.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	/* setup navigation, content boxes, etc... */
	Administry.setup();
	$("#sampleform").validate({
		rules: {
			producttitle: "required"
		},
		messages: {
			producttitle: "页面名称必填"
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
			echo out_menu(2,$sec_li);
			?>
			<!-- End of Main navigation -->
		</div>
	</header>
	<!-- End of Header -->
	<!-- Page title -->
	<div id="pagetitle">
		<div class="wrapper">
			<h1>编辑页面</h1>
		</div>
	</div>
	<!-- End of Page title -->
<?php
	$sql="select * from ".DB_PREFIX."pages where id=".intval($_GET['id']);
	$query=$db->query($sql);
	$arr=$query->fetch();
?>
	<!-- Page content -->
	<div id="page">
		<!-- Wrapper -->
		<div class="wrapper">
				<!-- Left column/section -->
				<section class="column width6 first">					
					<div id="successMsg" style="display:none" class="box box-success">页面更新成功</div>
					<h3>更新一个页面</h3>
					
					<form id="sampleform" enctype="multipart/form-data" method="post" action="./create_page_update.php" target="hiddenframe" onsubmit="document.documentElement.scrollTop = document.body.scrollTop =0;">
					<iframe id="hiddenframe" name="hiddenframe" style="width:0;height:0;"></iframe>
					<input type="hidden" name="id" value="<?php echo intval($_GET['id']); ?>">
					<input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>">
						<fieldset>
							<legend>页面信息</legend>

							<p>
								<label class="required" for="producttitle">页面名称</label><br/>
								<input type="text" id="producttitle" class="half title required" value="<?php echo $arr['title']; ?>" name="producttitle"/>
								<small>e.g. 公司简介</small>
							</p>
							
							<?php	if($arr['isMenu']==1 && empty($arr['ext_url'])){	?>	
							<p>
								<label for="productkeywords">主菜单页面URL别名</label><br/>
								<input type="text" id="productnickname" class="half title" value="<?php echo $arr['nickname']; ?>" name="productnickname"/>
								<small>例如：<?php echo "http://".$_SERVER['HTTP_HOST']."/contents/(个人自定义别名，但不能为纯数字)";?></small>
							</p>
							<?php	}	?>
							
							<p>
								<label for="productkeywords">页面关键字</label><br/>
								<input type="text" id="productkeywords" class="half title" value="<?php echo $arr['keywords']; ?>" name="productkeywords"/>
								<small>多个关键字之间使用英文逗号隔开</small>
							</p>
							
							<p>
								<label for="productdepict">页面描述</label><br/>
								<input type="text" id="productdepict" class="half title" value="<?php echo $arr['depict']; ?>" name="productdepict"/>
							</p>
							
							<p>
								<label class="" for="exturl">链接到外部URL</label><br/>
								<input type="text" id="exturl" class="half title" value="<?php echo $arr['ext_url']; ?>" name="exturl"/>
								<small>小提示: 当输入外部URL的时候，即可实现外部URL跳转</small>
							</p>

							<div>
								<label for="productdesc">详细描述</label><br/>
								<textarea id="productdesc" class="large full" name="productdesc" style="height:300px;width:728px;"><?php  
									if (ini_get('magic_quotes_gpc')){
					              		echo stripslashes(htmlspecialchars_decode($arr['content']));
					              	}else{
					              		echo htmlspecialchars_decode($arr['content']);
					              	}
									 ?></textarea>
							<?php if($arr['customcss']=='0'){	?>
									<script>
										var editor = new UE.ui.Editor();
	    									editor.render("productdesc");
									</script>
							<?php	}	?>
							</div>
							
							<div class="clearfix leading">
								<div class="column width3 first">
									<p>
										<label for="productcat">是否加载模块?</label><br/>
										<select id="productcat" class="full" name="module">
											<option value="" selected>默认不加载</option>
											<option value="product_module.php">产品列表模块</option>
											<option value="news_module.php">新闻列表模块</option>
											<option value="leave_module.php">留言模块</option>
										</select>
										<?php
											echo '<script>
											for(var i=0;i<document.getElementById("productcat").options.length;i++)
											{
											   if(document.getElementById("productcat").options[i].value =="'.$arr['module'].'")
											   {
											      document.getElementById("productcat").options[i].selected = true;
											      break;
											   }
											  }
											</script>';
										?>
										<small>可以选择，也可以不选择。</small>
									</p>
									<p><label><input type="checkbox" name="connect_product" <?php  if($arr['isProduct']==1)echo 'checked value="1"'; ?>  onclick="if(this.checked){this.value=1;}else{this.value=0;}"> 是否将此页面关联到产品管理? </label></p>
									<p><label><input type="checkbox" name="connect_menu" <?php  if($arr['isMenu']==1)echo 'checked value="1"'; ?>  onclick="if(this.checked){this.value=1;}else{this.value=0;}"> 是否将此页面名称设置为主菜单导航?</label></p>
									<p><label><input type="checkbox" name="connect_sec_menu" <?php  if($arr['isSecondaryMenu']==1)echo 'checked value="1"'; ?>  onclick="if(this.checked){this.value=1;}else{this.value=0;}"> 是否将此页面名称设置为二级菜单导航?</label>
										<select style="margin-left: 24px;" name="connect_sec_menu_pid">
										<option value="0">— 选择隶属主菜单 —</option>
										<?php if($arr['pid']=='-1'){ ?>
											<option value="-1" selected>— 含有二级菜单 —</option>
										<?php	}	?>
										 <?php
										 $sql2="select * from ".DB_PREFIX."pages where isMenu=1 and isSecondaryMenu=0 and isProduct=0 order by sort desc";
										 $query2=$db->query($sql2);
										 $num2=$db->query("select count(*) from ".DB_PREFIX."pages where isMenu=1 and isSecondaryMenu=0 and isProduct=0 order by sort desc")->fetchColumn();
										 if($num2>0){
										 	while($arr2=$query2->fetch()){	?>
										 		<option <?php if($arr['pid']==$arr2['id'])echo "selected"; ?> value="<?php echo $arr2['id'];?>"><?php echo $arr2['title'];?></option>
									<?php	
										}
									}
										 ?>
										</select> ( 二级导航隶属 )</p>
									<p><label><input type="checkbox" name="connect_news" <?php  if($arr['isNews']==1)echo 'checked value="1"'; ?>  onclick="if(this.checked){this.value=1;}else{this.value=0;}"> 是否将此页面设置为新闻?</label>
										<select style="margin-left: 24px;" name="connect_sec_news_cat">
										<option value="0">— 选择隶属子新闻 —</option>
										 <?php
										 $sql3="select * from ".DB_PREFIX."pages where module='news_module.php' and pid!='-1' and isMenu=0 order by sort desc";
										 $query3=$db->query($sql3);
										 $num3=$db->query("select count(*) from ".DB_PREFIX."pages where module='news_module.php' and pid!='-1' and isMenu=0 order by sort desc")->fetchColumn();
										 if($num3>0){
										 	while($arr3=$query3->fetch()){	?>
										 		<option <?php if($arr['news_cat']==$arr3['id'])echo "selected"; ?> value="<?php echo $arr3['id'];?>"><?php echo $arr3['title'];?></option>
									<?php	
										}
									}
										 ?>
										</select></p>
								</div>
								<div class="column width3">
									<p>
										<label for="productvendor">排列序号</label><br/>
										<input type="text" name="sort" value="<?php echo $arr['sort']; ?>">
										<small>e.g. 输入数字1</small>
									</p>
									<p>
										<label><input type="checkbox" name="customcss" <?php  if($arr['customcss']==1)echo 'checked value="1"'; ?>  onclick="if(this.checked){UE.getEditor('productdesc').destroy();this.value=1;}else{UE.getEditor('productdesc', {initialFrameWidth:'100%'});this.value=0;}"> 是否使用自定义代码描述单页?</label>
										<small>注意：如果勾选将去掉 '详细描述' 编辑器，使用更丰富的自定义代码完善单页</small>
									</p>
									<p>
										<label><input type="checkbox" name="barsid" <?php  if($arr['barsid']==1)echo 'checked value="1"'; ?>  onclick="if(this.checked){this.value=1;}else{this.value=0;}"> 是否自定义侧边栏?</label>
										<small>注意：如果不勾选，默认显示产品列表 ; 如果勾选，请在'菜单 - 挂件设置'中进行设置</small>
									</p>
								</div>
								
							</div>
						
							<p class="box"><input type="submit" class="btn btn-green big" value="更新"/></p>

						</fieldset>

					</form>

				</section>
				<!-- End of Left column/section -->
<?php require("./public_side_foot.php"); ?>