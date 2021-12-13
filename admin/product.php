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
			echo out_menu(3,$sec_li);
			?>
			<!-- End of Main navigation -->
		</div>
	</header>
	<!-- End of Header -->
	<!-- Page title -->
	<div id="pagetitle">
		<div class="wrapper">
			<h1>产品管理</h1>
		</div>
	</div>
	<!-- End of Page title -->
	
	<!-- Page content -->
	<div id="page">
		<!-- Wrapper -->
		<div class="wrapper">
				<!-- Left column/section -->
				<section class="column width6 first">
					
				<div id="successCatMsg" style="display:none" class="box box-success">产品分类创建成功</div>
				<div id="successMsg" style="display:none" class="box box-success">产品创建成功</div>
				<iframe id="hiddenframe" name="hiddenframe" style="width:0;height:0;"></iframe>
				<iframe id="hiddenframe_cat" name="hiddenframe_cat" style="width:0;height:0;"></iframe>
				
				<form name="form_cat" enctype="multipart/form-data" method="post" action="./create_product_cat.php" target="hiddenframe_cat">
				<div style="float:right;margin-top:10px;overflow:hidden;height: 34px;">
					<input type="text" required="required" name="productcat">
					<input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>">
					<a href="javascript:;" class="btn" style="position:relative;top:2px;top:0px\9;" onclick="if(document.forms['form_cat'].productcat.value!=''){document.forms['form_cat'].submit()}"><span class="icon icon-add">&nbsp;</span>增加产品分类</a>
				</div>
				</form>
			<?php
				$sql_cat="select * from ".DB_PREFIX."product_cat order by sort desc";
				$query_cat=$db->query($sql_cat);
		   	$num_cat=$db->query("select count(*) from ".DB_PREFIX."product_cat order by sort desc")->fetchColumn();
		   	if($num_cat>0){
		   		while($arr_cat=$query_cat->fetch()){
		    ?>
					<table id="report" class="stylized full" style="">
						<thead>
							<tr>
								<td class="title title_td">
								  <div>
									<a href="#"><b><?php echo $arr_cat['name']; ?></b></a>
										<div class="listingDetails">
											<div class="pad">
												<b>更新产品分类名称</b>
												<form name="form_product_cat<?php echo $arr_cat['id']; ?>" action="./update_product_cat.php" method="post" target="hiddenframe" style="height: 34px;">
													<input type="text" value="<?php echo $arr_cat['name']; ?>" name="product_newcatname" placeholder="输入新的产品名称">
													<input type="text" value="<?php echo $arr_cat['sort']; ?>" name="product_catsort" placeholder="排列序号">
													<input type="hidden" name="product_catid" value="<?php echo $arr_cat['id']; ?>">
													<input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>">
													<a href="javascript:;" class="btn btn-green" style="position:relative;top:2px;top:0px\9;" onclick="document.forms['form_product_cat<?php echo $arr_cat['id']; ?>'].submit()">更新</a>
												</form>
											</div>
										</div>
									</div>
								</td>
								<th class="ta-right title_td"><div><a onclick="return confirm('您确定全部删除该分类及其子集产品?')" href="./delete_product_cat.php?id=<?php echo $arr_cat['id']; ?>&token=<?php echo $_SESSION['token'];?>">删除</a></div></th>
							</tr>
						</thead>
						<tbody>
							<tr><td colspan="2" align="right">
								<form name="form<?php echo $arr_cat['id']; ?>" enctype="multipart/form-data" method="post" action="./create_product.php" target="hiddenframe">
								<div style="overflow:hidden;height: 34px;">
									<input type="text" required="required" name="productname">
									<input type="hidden" name="cat" value="<?php echo $arr_cat['id']; ?>">
									<input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>">
									<a href="javascript:;" class="btn" style="position:relative;top:2px;top:0px\9;" onclick="if(document.forms['form<?php echo $arr_cat['id']; ?>'].productname.value!=''){document.forms['form<?php echo $arr_cat['id']; ?>'].submit()}"><span class="icon icon-add">&nbsp;</span>增加产品</a>
								</div>
								</form>
							  </td></tr>
							<?php
							$sql_cat_pro="select * from ".DB_PREFIX."product where cat=".$arr_cat['id']." order by sort desc";
							$query_cat_pro=$db->query($sql_cat_pro);
					   	$num_cat_pro=$db->query("select count(*) from ".DB_PREFIX."product where cat=".$arr_cat['id']." order by sort desc")->fetchColumn();
					   	if($num_cat_pro>0){
					   		while($arr_cat_pro=$query_cat_pro->fetch()){
							?>
							<tr>
								<td class="title">
									<div>
										<a href="#"><b><?php echo $arr_cat_pro['name']; ?></b></a>
										<div class="listingDetails">
											<div class="pad">
												<b>更新产品分类名称</b>
												<form name="form_product<?php echo $arr_cat_pro['id']; ?>" action="./update_product.php" method="post" target="hiddenframe" style="height: 34px;">
													<input type="text" value="<?php echo $arr_cat_pro['name']; ?>" name="product_newname" placeholder="输入新的产品名称">
													<input type="text" value="<?php echo $arr_cat_pro['sort']; ?>" name="product_sort" placeholder="排列序号">
													<input type="hidden" name="product_id" value="<?php echo $arr_cat_pro['id']; ?>">
													<input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>">
													<a href="javascript:;" class="btn btn-green" style="position:relative;top:2px;top:0px\9;" onclick="document.forms['form_product<?php echo $arr_cat_pro['id']; ?>'].submit()">更新</a>
												</form>
											</div>
										</div>
									</div>
								</td>
								<td class="ta-right">
									<a href="./detail_product.php?id=<?php echo $arr_cat_pro['id']; ?>">详细</a>&nbsp;&nbsp;
									<a onclick="return confirm('您确定要删除该产品?')" href="./delete_product.php?id=<?php echo $arr_cat_pro['id']; ?>&token=<?php echo $_SESSION['token'];?>">删除</a></td>
							</tr>
						<?php	}}	?>
						</tbody>
					</table>
			<?php	}}	?>	
				</section>
				<!-- End of Left column/section -->
<?php require("./public_side_foot.php"); ?>