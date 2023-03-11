<?php
	date_default_timezone_set('Asia/Seoul');

	include "./control/config_info.php";

	session_start();

	if($config['debug']){
		error_reporting(E_ALL);
		ini_set('display_errors', '1');
	}

	$page=false;
	if($config['is_htaccess']){

		$getStr=$_SERVER['QUERY_STRING'];
		if(strpos($getStr,"/")!==false) {
			$getEx=explode("/",$getStr);
			$page=$getEx[0];
			$getCount=count($getEx);
			if(strpos($getEx[$getCount-1],"|")!==false) {
				$actEx=explode("|",$getEx[$getCount-1]);
				$action=$actEx[0];
				$rowid=$actEx[1];
			}
		} else {
			if(strpos($getStr,"&")!==false) {
				$tmp=explode("&",$_SERVER['QUERY_STRING']);
				$page=$tmp[0];
			} else {
				$page=$_SERVER['QUERY_STRING'];
			}
		}


	}
	else{

		if(isset($_GET['p'])){
			$page=$_GET['p'];

		}
	
	}

	if(!$page) $page=$config['default_page'];

	if(!file_exists('./page/'.$page.'.php')){
		if(!file_exists('./page/'.$page.'.html')){
			header("HTTP/1.0 404 Not Found");
			exit;
		}		
	}
	

	include "./control/func_db.php";
	include "./control/func.php";

	$mem_info=array();
	$like_cnt=0;
	$user_check = 'user';
	if($config['site_type'] == 'admin'){
		$user_check = 'admin';
	}


	if(isset($_SESSION[$user_check]['email'])) {
		$mem_info=select("Member", "*", "email='".$_SESSION[$user_check]['email']."' and state=1");
		/*
		$checkPages = array(
			"login",
			"join",
		);

		if(in_array($page, $checkPages)) {
			echo '<script>location.replace("/");</script>';
			exit;
		}
		*/

	}
	else{
		$checkPages = array(
			"home",
		);

		if(in_array($page, $checkPages)) {
			echo '<script>location.replace("./");</script>';
			exit;
		}
	}

	if(!isset($_SESSION['loc'])){
		$_SESSION['loc']='kr';
	}

	if($config['site_type'] == 'admin'){

		$get_ip = $_SERVER["REMOTE_ADDR"];
		if($_GET['code_check'] == '{CODE}'){
			$_SESSION['code_check']='yes';
			$get_ip="{IP_ADDRESS}";
		}

		if(isset($_SESSION['code_check'])){
			$get_ip="{IP_ADDRESS}";
		}

		$ips = array(
			"{IP_ADDRESS}", 
		);

		if(!in_array($get_ip, $ips)) {
			echo '
			<div style="width: 100%;height: 100%;display: flex;justify-content: center;align-items: center;flex-direction: column;">
			<h1>등록되지 않은 IP주소입니다. IP주소 등록후 다시시도해주세요.</h1>
			<div>IP: <input type="password" value="'.$_SERVER["REMOTE_ADDR"].'" id="myInput"></div>
			<div><input type="checkbox" onclick="myFunction()">Show IP</div>
			</div>
			<script>
			function myFunction() {
			  var x = document.getElementById("myInput");
			  if (x.type === "password") {
				x.type = "text";
			  } else {
				x.type = "password";
			  }
			}
			</script>
			';
			exit;
		}

		$admin_menu = array(
			array(
				"name"=>"OO 관리",
				"key"=>"c_member2",
				"check_m_names"=>array("3", "4" ),
				"subs"=>array(
					array("name"=>"OO 내역", "link"=>"./?p=admintype_list_base&code=".urlencode( mobileEncrypt('table_name1') ), "link_option"=>"", "m_name"=>"3"),
				),
			),
		);

		$admin_first_page='./';
		if(isset($admin_menu[0]['subs'][0])){
			$admin_first_page = $admin_menu[0]['subs'][0]['link']."&m_name=".$admin_menu[0]['subs'][0]['m_name'];
		}

		$admin_opitons = array();


		include "./control/admin_options.php";

		$cur_name = 'admintype_list_base';
		if( isset($_GET['m_name']) ){
			$cur_name = $_GET['m_name'];
		}
	}



	if($config['site_type'] == 'app'){
		$header_show = false;
		$footer_show = true;

		$left_back_event=false;

		$headerSet = array(
			"left"=>'<i class="fas fa-search" style="font-size:18px; margin:auto;"></i>',
			"center"=>'<img src="./assets/app/images/icon.png" style="width: 45px;height: 45px; border-radius: 200px;">',
			"right"=>'<i class="fas fa-bars" style="font-size:18px; margin:auto;"></i>',
		);

		$headerAdd = array(
			"left"=>'',
			"center"=>'',
			"right"=>'',
		);

		$footerSet = array(
			array("link"=>"./page_name1", "name"=>"홈", "icon"=>"fas fa-home font-22 cu_icon_mtb", "checks"=>array("page_name1", ) ),
			array("link"=>"./page_name2", "name"=>"OO주문", "icon"=>"fa fa-shopping-bag font-22 cu_icon_mtb", "checks"=>array("page_name2",) ),
			array("link"=>"./page_name3", "name"=>"OO내역", "icon"=>"fa fa-file font-22 cu_icon_mtb", "checks"=>array("page_name3", ) ),
			array("link"=>"#", "name"=>"Settings", "icon"=>"fas fa-cog font-22 cu_icon_mtb", "add"=>' data-menu="menu-settings" ', "checks"=>array("page_name4") ),
		);


		if(strpos($page,'home') !== false){

			$headerAdd = array(
				"left"=>'id="searchBtn" ',
				"center"=>'',
				"right"=>' data-menu="menu_sidebar" ',
			);
			
		}

		if(strpos($page,'login') !== false){

			$footer_show = false;
			
		}

		if(strpos($page,'live_guide') !== false){

			$headerSet['left']='<i class="fas fa-arrow-left" style="font-size:18px; margin:auto;"></i>';

			$left_back_event=true;

			$headerAdd = array(
				"left"=>'',
				"center"=>'',
				"right"=>' data-menu="menu_sidebar" ',
			);
		}

		if(strpos($page,'view') !== false){
			$header_show = false;
			$customStyle1 = '';
		}

	}


	include "./control/apiControl.php";

	if(file_exists('./control/'.$page.'Control.php')){
		include './control/'.$page.'Control.php';
    }
?>