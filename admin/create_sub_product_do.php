<?php
require("./database.php");
if(empty($_SESSION['momocms_admin'])){
	header("Location:./index.php");	
	exit;
}
if($_SESSION['momocms_isAdmin']==1 && ($_REQUEST['token'] == $_SESSION['token'])){
$type = array('image/jpeg','image/pjpeg','image/gif','image/png','image/x-png');
$type2 = array('jpg','jpeg','gif','png');
$type3 = "|.jpeg|.gif|.png|.jpg";
$hz = substr(strrchr($_FILES["pic"]["name"],"."),1);  
if (in_array($_FILES["pic"]["type"], $type) && in_array(strtolower($hz),$type2)){
  if ($_FILES["pic"]["error"] > 0){
    echo "Return Code: " . $_FILES["pic"]["error"] . "<br />";
    }else{
    	if(!is_dir("./upload/shows")){
    		mkdir("./upload/shows");
    	}
      $_FILES["pic"]["name"] = time() . "." . $hz;
      move_uploaded_file($_FILES["pic"]["tmp_name"],
      "./upload/shows/".  $_FILES["pic"]["name"]);
        $pic="./upload/shows/".  $_FILES["pic"]["name"];
        $info = getimagesize($pic);
		$ext = image_type_to_extension($info[2]);
		if(!stripos($type3,$ext)) {
			@unlink($pic);
			echo "<script>alert('Invalid file');</script>";
			exit;
		}
	}
}
$_POST=array_map("htmlspecialchars",$_POST);
$_POST=array_map("addslashes",$_POST);

$db->exec("insert into ".DB_PREFIX."product_sub set
					name ='".$_POST['producttitle']."',
					pic = '".$pic."',
					category = '".intval($_POST['category'])."',
					description = '".$_POST['productdesc']."',
					isshow = '".$_POST['isshow']."',
					sort = '".$_POST['sort']."'");
echo '<script>
parent.document.getElementById("successMsg").style.display="block";
setTimeout(function(){
parent.window.location.href="./detail_product.php?id='.intval($_POST['category']).'";
},1500);
</script>';
}
?>
