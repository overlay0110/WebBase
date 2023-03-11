<? if($config['site_type'] == 'normal'): ?>

<html>
<head>
<title><?=trim($config['titles'][0]) == '' ? 'WebBase - n' : $config['titles'][0] ?></title>

<script src="https://code.jquery.com/jquery-latest.js"></script>
<script>
let isRun=false;

function copy_start(value){
			var obj='copyBase';
			$("#"+objff).val(value);
			$("#"+obj).show();
			$("#"+obj).select();
			document.execCommand("Copy");
			$("#"+obj).hide();
			alert('Copy in clipboard.');
		}
</script>
</head>
<input type="text" id="copyBase" value="" style="display:none">
<body>

<?php 

if(file_exists('./page/'.$page.'.php')){
	include "./page/".$page.".php";			
}

if(file_exists('./page/'.$page.'.html')){
	include "./page/".$page.".html";
}

?>

</body>
</html>

<? endif; ?>





























<? if($config['site_type'] == 'admin'): ?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title><?=trim($config['titles'][1]) == '' ? 'WebBase - admin' : $config['titles'][1] ?></title>

    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700" rel="stylesheet">
    <link href="./assets/admin/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="./assets/admin/assets/css/plugins.css" rel="stylesheet" type="text/css" />
    <!-- END GLOBAL MANDATORY STYLES -->
    <!-- BEGIN PAGE LEVEL CUSTOM STYLES -->
    <link href="./assets/admin/assets/css/scrollspyNav.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="./assets/admin/assets/css/forms/theme-checkbox-radio.css">
    <link href="./assets/admin/assets/css/tables/table-basic.css" rel="stylesheet" type="text/css" />
    <!-- END PAGE LEVEL CUSTOM STYLES -->

	<link href="./assets/admin/plugins/file-upload/file-upload-with-preview.min.css" rel="stylesheet" type="text/css">

	

	<!-- BEGIN GLOBAL MANDATORY SCRIPTS -->
    <script src="./assets/admin/assets/js/libs/jquery-3.1.1.min.js"></script>
    <script src="./assets/admin/bootstrap/js/popper.min.js"></script>
    <script src="./assets/admin/bootstrap/js/bootstrap.min.js"></script>
    <script src="./assets/admin/plugins/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="./assets/admin/assets/js/app.js"></script>

	<script src="./assets/admin/plugins/file-upload/file-upload-with-preview.min.js"></script>
    
    <!-- END GLOBAL MANDATORY SCRIPTS -->

	<link href="./assets/admin/plugins/flatpickr/flatpickr.css" rel="stylesheet" type="text/css">
	<script src="./assets/admin/plugins/flatpickr/flatpickr.js"></script>


	<link rel="stylesheet" type="text/css" href="./assets/app/fonts/css/fontawesome-all.min.css">


	

	<style>
	#sidebar ul.menu-categories ul.submenu > li a {
		margin-left:0px;
	}
	.txt_line100 {
		width:100px;
		overflow:hidden;
		text-overflow:ellipsis;
		white-space:nowrap;
	}

	.txt_line150 {
		width:150px;
		overflow:hidden;
		text-overflow:ellipsis;
		white-space:nowrap;
	}

	.txt_line200 {
		width:200px;
		overflow:hidden;
		text-overflow:ellipsis;
		white-space:nowrap;
	}
	</style>
	<script>
	let isRun=false;

	function copy_start(value, obj='copyBase'){
		$("#"+obj).val(value);
		$("#"+obj).show();
		$("#"+obj).focus();
		$("#"+obj).select();
		document.execCommand("Copy");
		$("#"+obj).hide();
		alert('Copy in clipboard.');
		//Swal.fire({text: 'Copy in clipboard.', icon: 'success', confirmButtonText: 'OK'});
	}


	function ajaxCall(option = {}, res = () => {}){
		if(isRun){
			return false;
		}
		isRun = true;

		const formData = new FormData();
		formData.append("type", "api" );
		//formData.append("option", option.option );

		for(key in option){
			formData.append(key, option[key] );
		}

		$.ajax({
			type: 'post',
			url: "./",
			processData: false,
			contentType: false,
			data: formData,
			dataType: "json",
			success: function(data)	{
				isRun = false;
				if(data.code=="0") {
					res(data);
				} else {
					//Swal.fire({text: data.msg, icon: 'error', confirmButtonText: 'OK'});
					alert(data.msg);
				}
			}
		});
	}

	</script>

    
</head>
<body data-spy="scroll" data-target="#navSection" data-offset="140">
    
    <!--  BEGIN NAVBAR  -->
    <div class="header-container fixed-top" <?=$page=='login'? 'style="display:none;"' : '' ?>>
        <header class="header navbar navbar-expand-sm">

            <ul class="navbar-item theme-brand flex-row  text-center">
                <li class="nav-item theme-logo">
                    <a href="./">
                        <img src="./assets/admin/assets/img/logo.jpg" class="navbar-logo" alt="logo">
                    </a>
                </li>
                <li class="nav-item theme-text">
                    <a href="./" class="nav-link"> <?=trim($config['titles'][1]) == '' ? 'WebBase - admin' : $config['titles'][1] ?> </a>
                </li>
            </ul>

            

            <ul class="navbar-item flex-row ml-md-auto">

                

                

                






                <li class="nav-item dropdown user-profile-dropdown">
                    <a href="javascript:void(0);" class="nav-link dropdown-toggle user" id="userProfileDropdown" style="color: #fff;" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                    </a>
                    <div class="dropdown-menu position-absolute" aria-labelledby="userProfileDropdown">
                        <div class="">

							<div class="dropdown-item">
                                <a class="" href="javascript:void(0);"> ID : <?=$_SESSION['admin']['email']?></a>
                            </div>

                            <div class="dropdown-item">
                                <a class="" href="./?p=logout"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-log-out"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg> Sign Out</a>
                            </div>
                        </div>
                    </div>
                </li>






            </ul>
        </header>
    </div>
    <!--  END NAVBAR  -->
	



    <!--  BEGIN NAVBAR  -->
    <div class="sub-header-container" <?=$page=='login'? 'style="display:none;"' : '' ?>>
        <header class="header navbar navbar-expand-sm">
            <a href="javascript:void(0);" class="sidebarCollapse" data-placement="bottom"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-menu"><line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="18" x2="21" y2="18"></line></svg></a>

            <ul class="navbar-nav flex-row">
                <li>
                    <div class="page-header">

                        <nav class="breadcrumb-one" aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item active"></li>
                            </ol>
                        </nav>

                    </div>
                </li>
            </ul>
        </header>
    </div>
    <!--  END NAVBAR  -->




    <!--  BEGIN MAIN CONTAINER  -->
    <div class="main-container" id="container">

        <div class="overlay"></div>
        <div class="search-overlay"></div>

        <!--  BEGIN SIDEBAR  -->
        <div class="sidebar-wrapper sidebar-theme"  <?=$page=='login'? 'style="display:none;"' : '' ?>>
            
            <nav id="sidebar">
                <div class="shadow-bottom"></div>

                <ul class="list-unstyled menu-categories" id="accordionExample">




                    <? foreach($admin_menu as $key => $value): ?>

					<li class="menu">
                        <a href="#<?=$value['key']?>" data-toggle="collapse" aria-expanded="<?= ( in_array($cur_name, $value['check_m_names']) ) ? 'true' : 'false' ?>" class="dropdown-toggle">
                            <div class="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                                <span><?=$value['name']?></span>
                            </div>
                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
                            </div>
                        </a>
                        <ul class="collapse submenu list-unstyled <?= ( in_array($cur_name, $value['check_m_names']) ) ? 'show' : '' ?>" id="<?=$value['key']?>" data-parent="#accordionExample">

							<? for($i=0;$i<count($value['subs']);$i++): ?>
							<li class="<?=$value['subs'][$i]['m_name'] == $cur_name ? 'active' : ''?>">
                                <a href="<?=$value['subs'][$i]['link']."&m_name=".$value['subs'][$i]['m_name']?>" <?=$value['subs'][$i]['link_option']?>> <?=$value['subs'][$i]['name']?> </a>
                            </li>
							<? endfor; ?>
                        </ul>
                    </li>

					<? endforeach; ?>



     
                    
                </ul>
                
            </nav>

        </div>
        <!--  END SIDEBAR  -->

<div id="content" class="main-content" style="padding: 0px 30px;">
		<?php 

if(file_exists('./page/'.$page.'.php')){
	include "./page/".$page.".php";			
}

if(file_exists('./page/'.$page.'.html')){
	include "./page/".$page.".html";
}

?>
</div>
        

    </div>
    <!-- END MAIN CONTAINER -->

	<!-- BEGIN PAGE LEVEL CUSTOM SCRIPTS -->
	<script>
        $(document).ready(function() {
            App.init();
        });
    </script>
    <script src="./assets/admin/plugins/highlight/highlight.pack.js"></script>
    <script src="./assets/admin/assets/js/custom.js"></script>

    <script src="./assets/admin/assets/js/scrollspyNav.js"></script>
    <script>
        checkall('todoAll', 'todochkbox');
        $('[data-toggle="tooltip"]').tooltip()
    </script>
    <!-- END PAGE LEVEL CUSTOM SCRIPTS -->

    
</body>
</html>


<? endif; ?>































<? if($config['site_type'] == 'app'): ?>
<!DOCTYPE HTML>
<html lang="en" style="height: 100%;">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, viewport-fit=cover" />
<title><?=trim($config['titles'][2]) == '' ? 'WebBase - app' : $config['titles'][2] ?></title>
<link rel="stylesheet" type="text/css" href="./assets/app/styles/bootstrap.css">
<link rel="stylesheet" type="text/css" href="./assets/app/styles/style.css">
<link href="https://fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,500,500i,700,700i,900,900i|Source+Sans+Pro:300,300i,400,400i,600,600i,700,700i,900,900i&display=swap" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="./assets/app/fonts/css/fontawesome-all.min.css">
<link rel="apple-touch-icon" sizes="180x180" href="./assets/app/app/icons/icon-192x192.png">


<script src="./assets/app/js/jquery.min.js"></script>

<script type="text/javascript" src="./assets/app/scripts/bootstrap.min.js"></script>
<script type="text/javascript" src="./assets/app/scripts/custom.js"></script>
<script type="text/javascript" src="./assets/app/scripts/appBridge.js"></script>

<link rel="stylesheet" href="./assets/app/sweetalert2/sweetalert2.min.css">
<script src="./assets/app/sweetalert2/sweetalert2.all.min.js"></script>


</head>

<body class="theme-light" data-highlight="blue" data-gradient="body-default" style="height: 100% !important;">



<div id="preloader"><div class="spinner-border color-highlight" role="status"></div></div>

<div id="page " style="height: 100%; <?=$customStyle1?>">

	<input type="text" id="copyBase" value="" style="display:none">

	<? if($header_show): ?>
	<div class="header header-fixed header-logo-center">
        <a href="#" class="header-title" <?=$headerAdd['center']?> ><?=$headerSet['center']?></a>
        <a href="#" <?=$left_back_event ? 'id="back_event"' : '' ?> class="header-icon header-icon-1 d-flex" <?=$headerAdd['left']?> ><?=$headerSet['left']?></a>
        <a href="#" class="header-icon header-icon-4 d-flex" <?=$headerAdd['right']?> ><?=$headerSet['right']?></a>

		<div id="searchBar" class="d-none" style="background-color: #fff;width: 100%;height: 100%;z-index: 999999;position: sticky;display: flex;align-items: center; padding-right:10px;">
			<div id="hideSearch" style="width: 45px;height: 45px; border-radius: 100px;display: flex;justify-content: center;align-items: center; cursor: pointer;">
				<i class="fas fa-chevron-left" style="font-size: 18px;"></i>
			</div>

			<div style="flex: 1;position: relative;">
				<form id="search_a" action="">
					<input type="text" id="search_i" class="form-control chat_input" placeholder="Enter your Message here" maxlength="1500" style="width: 100%;display: block;line-height: 45px; height: 35px; border-radius: 100px; padding: 0px 35px;" >
					<button id="callSearch" style="position: absolute;top: 0px;right: 0px;width: 45px;height: 35px;display: flex;align-items: center;justify-content: center;">
						<i class="fas fa-search"></i>
					</button>
				</form>
			</div>
		</div>
    </div>


	<div id="menu_sidebar" class="bg-white menu menu-box-right" data-menu-width="310" style="display: block; width: 310px;">
        <div class="d-flex">
            <button href="#" class="close-menu flex-fill icon icon-m text-center color-red-dark border-bottom"><i class="fa font-12 fa-times"></i></button>
        </div>

		<? if(isset($_SESSION['user']['email'])): ?>
        <div id="userProfile" class="ps-3 pe-3 pt-3 mt-4 mb-2">
            <div class="d-flex" style="    flex-direction: column;justify-content: center;align-items: center;">
                
				<div id="pImgBase" class="showEditPimg" style="position: relative;cursor: pointer;">
					<img id="p_img" src="<?=$mem_info[0]['p_img']?>" style="width: 100px;height: 100px; border-radius: 200px;">

					<div id="pImgEdit" class="d-flex d-none" style="background-color: rgba(0,0,0,0.3);width: 100%;height: 100%;position: absolute; top: 0px;border-radius: 200px;">
						<i class="fas fa-pen" style="color: #fff;margin: auto;font-size: 30px;"></i>
					</div>
				</div>

				<div style="margin-bottom:20px;"></div>

				<p class="showEditUserName" name="<?=$mem_info[0]['name']?>" style="margin:0px; cursor: pointer;"><i class="fas fa-pen" style="margin-right:5px;"></i> <b><?=$mem_info[0]['name']?></b></p>

				<div style="margin-bottom:10px;"></div>

				<p style="margin:0px;color: red;"><i class="fas fa-heart"></i> <span id="likeCnt1"><?=$like_cnt?></span></p>

            </div>
        </div>
		<? endif; ?>

		<div style="margin-bottom:20px;"></div>

        <div class="me-3 ms-3">
            <span class="text-uppercase font-900 font-11 opacity-30">Navigation</span>
            <div class="list-group list-custom-small list-icon-0">
                <a href="#" class="start_st">
                    <i class="fa font-14 fa-video color-yellow-dark"></i>
                    <span>Start Streaming</span>
                </a>

				<? if($isWallet): ?>
                <a href="#" class="showMyWalle">
                    <i class="fa font-14 fa-wallet color-blue-dark"></i>
                    <span>My Wallet</span>
                </a>
				<? endif; ?>

				<? if(isset($_SESSION['user']['email'])): ?>
				<a href="./?p=logout">
                    <i class="fa font-14 fa-sign-out color-brown-dark"></i>
                    <span>Sign Out</span>
                </a>
				<? else: ?>
				<a href="#" class="showLogin">
                    <i class="fa font-14 fa-sign-in-alt color-brown-dark"></i>
                    <span>Sign in</span>
                </a>
				<? endif; ?>

				

                
            </div>
        </div>

    </div>
	<? endif; ?>
    
	<? if($footer_show): ?>
    <div id="footer-bar" class="footer-bar-1">
		<? for($i=0;$i<count($footerSet);$i++): ?>
		<a href="<?=$footerSet[$i]['link']?>" class="<?=(in_array($page, $footerSet[$i]['checks'])) ? 'active-nav' : '' ?> showLoadingC" <?=isset($footerSet[$i]['add']) ? $footerSet[$i]['add'] : ''?> ><i class="<?=$footerSet[$i]['icon']?>"></i><span><?=$footerSet[$i]['name']?></span></a>
		<? endfor; ?>
    </div>
	<? endif; ?>

	<div class="modal fade" id="modalBase" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
		<?/* modal-xl */?>
        <div class="modal-dialog modal-dialog-centered " role="document">
            <div class="modal-content">
				<input type="text" id="copyBase2" value="" style="display:none">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle"></h5>
                    <button type="button" class="close" onclick="$('#modalBase').modal('hide');" data-dismiss="modal" aria-label="Close">
                      <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                    </button>
                </div>
                <div class="modal-body">
                    <h4 class="modal-heading mb-4 mt-2">Aligned Center</h4>
                        
                    <p class="modal-text">In hac habitasse platea dictumst. Proin sollicitudin et lacus in tincidunt. Integer nisl ex, sollicitudin eget nulla nec, pharetra lacinia nisl. Aenean nec nunc ex. Integer varius neque at dolor scelerisque porttitor.</p>
                </div>
                
            </div>
        </div>
    </div>

	<div id="menu-settings" class="menu menu-box-bottom menu-box-detached" style="display: block;">
        <div class="menu-title mt-0 pt-0"><h1>Settings</h1><p class="color-highlight">Flexible and Easy to Use</p><a href="#" class="close-menu"><i class="fa fa-times"></i></a></div>
        <div class="divider divider-margins mb-n2"></div>
        <div class="content">
            <div class="list-group list-custom-small">
                <a href="#" data-toggle-theme="" data-trigger-switch="switch-dark-mode" class="pb-2 ms-n1">
                    <i class="fa font-12 fa-moon rounded-s bg-highlight color-white me-3"></i>
                    <span>Dark Mode</span>
                    <div class="custom-control scale-switch ios-switch">
                        <input data-toggle-theme="" type="checkbox" class="ios-input" id="switch-dark-mode">
                        <label class="custom-control-label" for="switch-dark-mode"></label>
                    </div>
                    <i class="fa fa-angle-right"></i>
                </a>
            </div>
            <div class="list-group list-custom-small">
                <a href="./profile_edit" class="pb-2 ms-n1">
                    <i class="fa font-12 fa-user rounded-s bg-highlight color-white me-3"></i>
                    <span>프로필 수정</span>
                    <i class="fa fa-angle-right"></i>
                </a>
            </div>
			<div class="list-group list-custom-small">
                <a href="./logout" class="pb-2 ms-n1">
                    <i class="fa font-12 fa-user rounded-s bg-highlight color-white me-3"></i>
                    <span>로그아웃</span>
                    <i class="fa fa-angle-right"></i>
                </a>
            </div>
        </div>
    </div>

	
	
	<script>
		let isRun = false;
        $('#back_event').on('click', function(e){
            window.history.back();
        });

		function copy_start(value, obj='copyBase'){
			$("#"+obj).val(value);
			$("#"+obj).show();
			$("#"+obj).focus();
			$("#"+obj).select();
			document.execCommand("Copy");
			$("#"+obj).hide();
			// alert('Copy in clipboard.');
			Swal.fire({text: 'Copy in clipboard.', icon: 'success', confirmButtonText: 'OK'});
		}

		$('#searchBtn').on('click', function(e){
			$('#searchBar').removeClass('d-none');
        });

		$('#hideSearch').on('click', function(e){
			$('#searchBar').addClass('d-none');
			$('#search_i').val('');
        });

		
		$('#callSearch').on('click', function(e){
			//console.log('call');
		});

		$("#search_a").keydown(function(e){
			if(e.keyCode==13) {
				$('#callSearch').trigger('click');
				e.preventDefault();
			}
		});

		$("#search_a").submit(function(){
			return false;
		});


		$('#pImgBase').hover(function() {
		  $(this).css("color", "red");
		  $('#pImgEdit').removeClass('d-none');
		}, function(){
		  $('#pImgEdit').addClass('d-none');
		});

		/*
		$(document).on('click','.call_modal',function(){
			var index = $('.call_modal').index(this);
			var num = $('.call_modal').eq(index).attr('num');

			$('.modal-body').html( siteContent['modal_'+num] );

			$('#modalBase').modal('show'); 
		});
		*/


		function ajaxCall(option = {}, res = () => {}){
			if(isRun){
				return false;
			}
			isRun = true;

			const formData = new FormData();
			formData.append("type", "api" );
			//formData.append("option", option.option );

			for(key in option){
				formData.append(key, option[key] );
			}

			$.ajax({
				type: 'post',
				url: "./",
				processData: false,
				contentType: false,
				data: formData,
				dataType: "json",
				success: function(data)	{
					isRun = false;
					if(data.code=="0") {
						res(data);
					} else {
						Swal.fire({text: data.msg, icon: 'error', confirmButtonText: 'OK'});
					}
				}
			});
		}

	
		
    </script>


<?php 

if(file_exists('./page/'.$page.'.php')){
	include "./page/".$page.".php";			
}

if(file_exists('./page/'.$page.'.html')){
	include "./page/".$page.".html";
}

?>

</div>
<script>
let timer = setInterval(() => { $('#preloader').addClass('preloader-hide'); clearInterval(timer); }, 500);
</script>
</body>
</html>


<? endif; ?>