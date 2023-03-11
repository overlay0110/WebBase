<?
	$config = array(
		"db_host"=>"localhost",
		"db_user"=>"",
		"db_password"=>"",
		"db_name"=>"",
		"db_api"=>"pdo", // mysqli, pdo
		"is_htaccess"=>false, // true : /pageName, false : /?p=pageName
		"site_type"=>"admin", // normal, admin, app
		"default_page"=>"load",
		"debug"=>false,
		"from_email_info"=>array('[EMAIL]', '[PASSWORD]'),
		"titles"=>array('','',''),
		"admin_login_info"=>array(),
	);


	$config["admin_login_info"] = array(
		"ids"=>array("admin", "read" ),
		"pws"=>array("admin", "1234"),
		"idToLevel"=>array(
			"admin"=>0,
			"read"=>1,
		),
		"levelInfo"=>array(
			1=>array(
				'admintype_list_base'=>array(
					'table_name'
				),
				'admintype_edit_base'=>array(
					'table_name'
				),
			),
		),
	);



?>