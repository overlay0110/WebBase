<?
	$admin_opitons[ 'table_name1' ] = array(
		"set_f"=>"field1, field2, field3, field4, field5, field6, field7, field8, field9 ",
		"d_where"=>"1 and field10=1 ",
		"search_options"=>array(
			"hide_f"=>array("field1", "field3", "field7"),
			"field9"=>array(
				"type"=>"date",
			),
			"field2"=>array(
				"operation" => "like",
			),
			"field4"=>array(
				"operation" => "like",
			),
			"field5"=>array(
				"operation" => "like",
			),
			"field6"=>array(
				"operation" => "like",
			),
			"field8"=>array(
				"operation" => "like",
			),
		),
		"list_options"=>array(
			"hide_f"=>array("field1", "field3"),
			"show_editbtn"=>"true",
			"show_checkbox"=>"true",
			//"set_edit_page"=>"edit",
			"order_show_f"=>array("field9"),
			"fieldToText"=>array(
				"field2"=>"아이디",
				"field4"=>"이름",
				"field5"=>"지갑주소",
				"field6"=>"핸드폰 번호",
				"field7"=>"핸드폰 인증 여부",
				"field8"=>"이메일",
				"field9"=>"가입날짜",
			),
		),
		"edit_options"=>array(
			"hide_f"=>array("field1"),
			"set_f"=>"field1, field2, field3, field4, field5, field6, field7, field8, field9 ",
			"fieldToText"=>array(
				"field2"=>"아이디",
				"field4"=>"이름",
				"field5"=>"지갑주소",
				"field6"=>"핸드폰 번호",
				"field7"=>"핸드폰 인증 여부",
				"field8"=>"이메일",
				"field9"=>"가입날짜",
			),
			"fieldType"=>array(
				"field3"=>array( "type"=>"password", ),
			),
		),
	);
?>