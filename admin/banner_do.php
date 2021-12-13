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
$hz = substr(strrchr($_FILES["banner"]["name"],"."),1);  
if (in_array($_FILES["banner"]["type"], $type) && in_array(strtolower($hz),$type2)){
  if ($_FILES["banner"]["error"] > 0){
    echo "Return Code: " . $_FILES["banner"]["error"] . "<br />";
    }else{
    	if(!is_dir("../resource/slide/images")){
    		mkdir("../resource/slide/images");
    	}
      $_FILES["banner"]["name"] = time() . "." . $hz;
      move_uploaded_file($_FILES["banner"]["tmp_name"],
      "../resource/slide/images/".  $_FILES["banner"]["name"]);
        $pic="../resource/slide/images/".  $_FILES["banner"]["name"];
        $info = getimagesize($pic);
		$ext = image_type_to_extension($info[2]);
		if(!stripos($type3,$ext)) {
			@unlink($pic);
			echo "<script>alert('Invalid file');</script>";
			exit;
		}
      echo '<script>
				parent.document.getElementById("successMsg").style.display="block";
				setTimeout(function(){
				parent.window.location.href="./banner.php";
				},1500);
				</script>';
    }
  }else{
  	echo "<script>alert('Invalid file');</script>";
	exit;
  }
}
?>