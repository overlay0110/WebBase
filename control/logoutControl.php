<?php

	$_SESSION['admin']=array();
	$_SESSION['user']=array();
	session_destroy();

	header('Location: ./');
	exit;
?>