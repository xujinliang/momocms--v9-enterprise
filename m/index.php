<?php
require("./database.php");
$rooturl = URL_M;
?>
<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width initial-scale=1.0 maximum-scale=1.0 user-scalable=yes" />
<title>MoMoCMS手机版</title>
<meta name="description" content="MoMoCMS -- 更好用的企业建站系统">
<meta name="keywords" content="MoMoCMS">
<link rel="icon" href="<?php echo URL; ?>/resource/favicon.ico" type="image/x-icon">
<link rel="shortcut icon" href="<?php echo URL; ?>/resource/favicon.ico" type="image/x-icon">
<link rel="bookmark" href="<?php echo URL; ?>/resource/favicon.ico" type="image/x-icon">
<script src="<?php echo URL; ?>/resource/jquery-1.11.1.min.js"></script>
<script src="<?php echo URL_M; ?>/js/jquery.mmenu.min.all.js"></script>
<link href="<?php echo URL_M; ?>/css/jquery.mmenu.all.css?<?php echo time();?>" rel="stylesheet" type="text/css">
<link href="<?php echo URL_M; ?>/css/style.css?<?php echo time();?>" rel="stylesheet" type="text/css">
<link href="<?php echo URL_M; ?>/css/font-face.css?<?php echo time();?>" rel="stylesheet" type="text/css">
<script type="text/javascript" src="<?php echo URL_M; ?>/bxslider/jquery.bxslider.min.js"></script>
<link href="<?php echo URL_M; ?>/bxslider/jquery.bxslider.css" rel="stylesheet" />
</head>
<body>
<div id="page">
	<header>
    	<div class="l_tbn"><a href="#menu" id="navigation"></a></div>
        <a style="font-size:14px;color:#fff;font-weight:bold;text-decoration:none;" href="<?php echo URL_M; ?>">MoMoCMS手机版</a>
    </header>
<ul class="bxslider" style="margin:0;padding:0;display:none">
<?php
//打开 images 目录
$dir = dir("../resource/slide/images");
//列出 images 目录中的文件
while (($file = $dir->read()) !== false)
{
	if($file!="." && $file!=".."){
	?>
<li><img style="border:0;width:100%;" src="<?php echo URL; ?>/resource/slide/images/<?php echo $file; ?>" /></li>
<?php
	}
}
$dir->close();
?> 
</ul>
<script type="text/javascript">
    $(function() {
    	var callback = function () {
		var reg=/mm-opened/;
		if(reg.test(document.getElementById("menu").className)){
            document.getElementById("navigation").style.backgroundPosition="8px -28px";
          }else{
          	 document.getElementById("navigation").style.backgroundPosition="8px 7px";
          }
        }
       document.body.addEventListener('webkitTransitionEnd', callback);
       $('nav#menu').mmenu({
			extensions: [ 'widescreen', 'theme-white', 'effect-slide-menu' ],navbar:{title:'欢迎访问MoMoCMS官网'}
		});
       $(".bxslider").css({display:"block"});
       $('.bxslider').bxSlider({
       	auto: true,
       	pager:false,
       	pause:'5000'
       	});
    });
    </script>
    <div class="content">
      <div id="main">
<?php
	$sql_mixsidebar="select * from ".DB_PREFIX."modules where pid='-1' order by sort desc";
     $query_mixsidebar=$db->query($sql_mixsidebar);
     $num_mixsidebar=$db->query("select count(*) from ".DB_PREFIX."modules where pid='-1' order by sort desc")->fetchColumn();
   	if($num_mixsidebar>0){
   		while($arr_mixsidebar=$query_mixsidebar->fetch()){
   			eval("?>".base64_decode($arr_mixsidebar['codes']));
   		}
   	}
?>
    	 </div>
	<footer class="footer">
	    <div class="footer-inner">
	       默默企业建站，版权所有 &copy; <?php echo date('Y');?>
	     </div>
	</footer>
</div>
<?php include("common.php");?>
</div>
</body>
</html>