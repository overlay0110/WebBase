<?


if(isset($_SESSION['admin']['email'])){
	echo '<script>location.replace("'.$admin_first_page.'");</script>';
	exit;
}
else{
	echo '<script>location.replace("./?p=login");</script>';
	exit;
}



?>