<?php
	function check(){
		global $config;
		$res = array('code'=>100, 'msg'=>'Fail', 'result'=>array() );

		$res['code']=0;
        $res['msg']='success';

		return json_encode($res);
	}


	function order_call(){
		global $config, $mem_info;
		$res = array('code'=>100, 'msg'=>'Fail', 'result'=>array() );

		if(!isset($mem_info[0])){
			return json_encode(array('code' => '100', 'msg'=>'Please log in.', ));
		}

		$check = select('table_name', '*', 'field="'.$mem_info[0]['email'].'" and field=1 ');
		if(!isset($check[0])){
			return json_encode(array('code' => '100', 'msg'=>'OOO이 등록되지 않은 사용자입니다.', ));
		}

		$m_code = $check[0]['field'];

		$g_list = json_decode($_POST['g_list'], true);

		if ($g_list === null && json_last_error() !== JSON_ERROR_NONE) {
		   return json_encode(array('code' => '100', 'msg'=>'OO정보 불러오는데 실패했습니다.', ));
		}

		$total = 0;

		foreach($g_list as $key => $value) {
			if( !preg_match( "/^[0-9]/i", $value['cnt'] ) ){
				return json_encode(array('code' => '100', 'msg'=>'수량은 숫자만 입력이 가능합니다.', ));
			}

			if( $value['cnt'] < 1 ){
				return json_encode(array('code' => '100', 'msg'=>'최소수량은 1개까지만 가능합니다.', ));
			}

			$check = select('table_name', '*', "field='".$key."' and field=1 limit 1");
			if(!isset($check[0])){
				return json_encode(array('code' => '100', 'msg'=>'OO 정보가 존재하지 않습니다.', ));
			}

			$total += ($check[0]['price']*$value['cnt']);
		}

		$pay_code = cre_codes("OOO");

		foreach($g_list as $key => $value) {
			$g_info = select('table_name', '*', "field='".$key."' and field=1 limit 1");
			insert('table_name', array(
				'field'=>$m_code,
				'field'=>$g_info[0]['v_code'],
				'field'=>$key,
				'field'=>$pay_code,
				'field'=>$total,
				'field'=>$g_info[0]['name'],
				'field'=>$value['cnt'],
				'field'=>($g_info[0]['price']*$value['cnt']),
				'field'=>$g_info[0]['delivery_fee'],
				'field'=>time(),
				'field'=>$_SERVER["REMOTE_ADDR"],
				'field'=>date("Y-m-d H:i:s",time()),
			));
		}
		

		$res['code']=0;
        $res['msg']='success';
		
		return json_encode($res);
	}


	function admintype_get_list(){
		global $config, $admin_opitons;
		$res = array('code'=>100, 'msg'=>'Fail', 'result'=>array() );

		$showItemCnt = 10;
		$allItemCnt = 0;
		$currentCnt = $_POST['page'];

		$file_url='';

		if(trim($_POST['showCnt']) != ''){
			$showItemCnt = $_POST['showCnt'];
		}

		if($showItemCnt >= 5000){
			$showItemCnt = 5000;
		}

		$table_name="";
		if(trim($_POST['code']) != ''){
			$table_name = mobileDecrypt($_POST['code']);
		}

		$list_options = array();
		if(isset( $admin_opitons[ $table_name ]['list_options'] ) ){
			$list_options=$admin_opitons[ $table_name ]['list_options'];
		}

		$set_f = "*";
		if(isset( $admin_opitons[ $table_name ]['set_f'] ) ){
			$set_f = $admin_opitons[ $table_name ]['set_f'];
		}

		$where="1 ";
		if(isset( $admin_opitons[ $table_name ]['d_where'] ) ){
			$where = $admin_opitons[ $table_name ]['d_where']; 
		}

		
		$get_values=array();
		if(trim($_POST['search']) != ''){
			$get_s = json_decode($_POST['search'], true);
			for($i=0;$i<count($get_s);$i++){
				$where .= ' '.$get_s[$i]['logical'].' '.$get_s[$i]['f_key'].' '.$get_s[$i]['operation'].' ?';

				if($get_s[$i]['operation'] == 'like'){
					array_push($get_values, '%'.$get_s[$i]['value'].'%');
				}
				else{
					array_push($get_values, $get_s[$i]['value']);
				}
			}
		}

		$order = " order by rowid desc";
		if(trim($_POST['order']) != ''){
			$order = " order by ".$_POST['order'];
		}

		$limitStart = ($currentCnt-1)*$showItemCnt;

		$limitStr = 'limit '.$limitStart.','.$showItemCnt;

		

		$datas = select($table_name, $set_f, $where." ".$order." ".$limitStr, $get_values);
		if(!isset($datas[0])){
			$datas=array();
		}
		else{
			$datas = admintype_loop_datas($datas, $table_name);
		}

		if(isset($_POST['excel_down'])){
			$file_url = creExcel($datas);
		}

		$data_cnt = select($table_name, "count(*) as cnt", $where, $get_values);
		if(isset($data_cnt[0])){
			$data_cnt = $data_cnt[0]['cnt'];
		}
		else{
			$data_cnt = 0;
		}

		if(isset($list_options['show_sum_data'])){
			$set_sum_f = "sum(state) as state";
			if(isset($list_options['set_sum_f'])){
				$set_sum_f = $list_options['set_sum_f'];
			}

			$sum_datas = select($table_name, $set_sum_f, $where, $get_values);
			$res['sum_result']=admintype_sum_datas($sum_datas, $table_name);
		}

		$endCheckCnt = ceil($data_cnt/$showItemCnt);

		$res['code']=0;
        $res['msg']='success';
		$res['result']=$datas;
		$res['endcnt']=$endCheckCnt;
		$res['data_cnt']=$data_cnt;
		$res['excel_url']=$file_url;
		$res['0x']=$where;

		return json_encode($res);
	}

	function admintype_loop_datas($arr, $t_name=''){
		global $config, $admin_opitons;

		if(trim($t_name) == ''){
			return $arr;
		}

		for($i=0;$i<count($arr);$i++){

			if($t_name == ''){
				$arr[$i]['field']='<textarea class="form-control">'.$arr[$i]['field'].'</textarea>';
				$arr[$i]['field'] = '<div class="txt_line200">'.$arr[$i]['field'].'</div>';
				
			}

		}

		return $arr;
	
	}

	function admintype_sum_datas($sum_datas, $table_name='' ){
		global $config, $admin_opitons;

		$list_options = array();
		if(isset( $admin_opitons[ $table_name ]['list_options'] ) ){
			$list_options=$admin_opitons[ $table_name ]['list_options'];
		}

		$sum_result = array();

		if(isset($sum_datas[0])){
			if($table_name == 'Member'){
				$sum_result[0] = array('type'=>'colspan', 'value'=>15);

				$sum_result[1] = array('type'=>'n', 'value'=>$sum_datas[0]['state']);

				$sum_result[2] = array('type'=>'colspan', 'value'=>1);
			}
		}

		return $sum_result;
	}


	function admintype_sel_del(){
		global $config, $admin_opitons;
		$res = array('code'=>100, 'msg'=>'Fail', 'result'=>array() );

		$table_name="";
		if(trim($_POST['code']) != ''){
			$table_name = mobileDecrypt($_POST['code']);
		}

		if(trim($_POST['values']) == ''){
			$res['msg']='삭제할 데이터를 선택해주세요.';
			return json_encode($res);
		}

		$id_level = 0;
		if( isset($config["admin_login_info"]["idToLevel"][ $_SESSION['admin']['email'] ]) ){
			$id_level = $config["admin_login_info"]["idToLevel"][ $_SESSION['admin']['email'] ];
		}

		if($id_level != 0){
			if(isset($config["admin_login_info"]["levelInfo"][$id_level]['edit'])){
				$t_check = $config["admin_login_info"]["levelInfo"][$id_level]['edit'];

				if(in_array($table_name, $t_check)) {
					$res['msg']='해당 계정의 권한이 없습니다.';
					return json_encode($res);
				}
			}
		}

		update($table_name, array(
			'state'=> 0,
		), 'rowid in ('.$_POST['values'].')' );


		$res['code']=0;
        $res['msg']='해당 데이터가 삭제되었습니다.';

		return json_encode($res);
	}

	function admintype_new_or_edit(){
		global $config, $admin_opitons;
		$res = array('code'=>100, 'msg'=>'Fail', 'result'=>array() );

		$table_name="";
		if(trim($_POST['code']) != ''){
			$table_name = mobileDecrypt($_POST['code']);
		}

		$set_datas=array();

		$check_res = admintype_new_or_edit_check($table_name, $_POST);
		if($check_res['code'] != 0){
			return json_encode($check_res);
		}
		
		foreach($_POST as $key => $value) {
			if($key == 'type'){
				continue;
			}

			if($key == 'option'){
				continue;
			}

			if($key == 'code'){
				continue;
			}

			if($key == 'w_key'){
				continue;
			}

			if(trim($value) != ''){
				$set_datas[ str_replace ("para_", "", $key) ] = admintype_value_set($table_name, str_replace ("para_", "", $key), $value);
			}
		}

		foreach($_FILES as $key => $value) {
			$upload_path = $_SERVER['DOCUMENT_ROOT']."/admin/assets/admin/upload/";

			$filename = basename($_FILES[$key]['name']);

			$ext = array_pop(explode(".", strtolower($filename)));

			$md5_filename = md5(time().$ext);
			$md5_filename .= '.'.$ext;

			$file_path = $_SERVER["SCRIPT_URI"]."assets/admin/upload/".$md5_filename;
			
			$uploadfile = $upload_path . $md5_filename;

			if (!move_uploaded_file($_FILES[$key]['tmp_name'], $uploadfile)) {
				$res['msg']='upload fail';
				return json_encode($res);
			} 

			$set_datas[ str_replace ("para_", "", $key) ] = $file_path;
		}

		
		if(isset($_POST['w_key'])){
			update($table_name, $set_datas, "rowid=?", array($_POST['w_key']));
		}
		else{
			$set_datas = admintype_value_insert_add($table_name, $set_datas);
			insert($table_name, $set_datas);
		}

		$res['code']=0;
        $res['msg']='데이터가 추가 또는 수정되었습니다.';

		return json_encode($res);
	}

	function admintype_value_insert_add($table_name, $set_datas){
		if($table_name == ''){
			$set_datas['field'] = cre_codes();
		}
		
		if($table_name == ''){
			$set_datas['field'] = cre_codes('V');
		}

		return $set_datas;
	}

	function admintype_value_set($table_name, $key, $value){
		if($table_name == ''){

			if($key == 'field'){
				$value = hash('sha256', $value.'1234567890');
			}
		
		}

		return $value;
	}

	function admintype_new_or_edit_check($table_name, $base){
		$res = array('code'=>100, 'msg'=>'Fail', 'result'=>array() );

		if($table_name == ''){
			if(!isset($base['para_field'])){
				$res['msg']='아이디를 입력해주세요.';
				return $res;
			}

			if(trim($base['para_field']) == ''){
				$res['msg']='아이디를 입력해주세요.';
				return $res;
			}

			if(!isset($base['para_field'])){
				$res['msg']='비밀번호를 입력해주세요.';
				return $res;
			}

			if(trim($base['para_field']) == ''){
				$res['msg']='비밀번호를 입력해주세요.';
				return $res;
			}

			if(!preg_match('/^(?=.*[a-zA-Z])(?=.*[0-9]).{8,20}$/', $base['para_field'] )){
				$res['msg']='비밀번호는 영문과 숫자를 포함한 8~20자리로 작성해주세요.';
				return json_encode($res);
			}

			if(!isset($base['para_field'])){
				$res['msg']='이름을 입력해주세요.';
				return $res;
			}

			if(trim($base['para_field']) == ''){
				$res['msg']='이름을 입력해주세요.';
				return $res;
			}

			if(!isset($base['para_field'])){
				$res['msg']='연락처을 입력해주세요.';
				return $res;
			}

			if(trim($base['para_field']) == ''){
				$res['msg']='연락처을 입력해주세요.';
				return $res;
			}
		
		}


		$res['code']=0;
		$res['msg']='success';

		return $res;
	}

	function admintype_login(){
		global $config, $admin_opitons;
		$res = array('code'=>100, 'msg'=>'Fail', 'result'=>array() );


		if(!isset($_POST['email'])){
			$res['msg']='아이디를 입력해주세요.';
			return json_encode($res);
		}

		if(trim($_POST['email']) == ''){
			$res['msg']='아이디를 입력해주세요.';
			return json_encode($res);
		}

		if(!isset($_POST['pw'])){
			$res['msg']='비밀번호를 입력해주세요.';
			return json_encode($res);
		}

		if(trim($_POST['pw']) == ''){
			$res['msg']='비밀번호를 입력해주세요.';
			return json_encode($res);
		}

		$email_num = array_search($_POST['email'], $config['admin_login_info']['ids']);

		if(!isset($email_num)){
			return json_encode(array('code' => '100', 'msg'=>'존재하지 않는 아이디 또는 비밀번호가 일치하지 않습니다.', ));
		}

		if($_POST['pw'] != $config['admin_login_info']['pws'][$email_num]){
			return json_encode(array('code' => '101', 'msg'=>'존재하지 않는 아이디 또는 비밀번호가 일치하지 않습니다.', ));
		}

		$_SESSION['admin']['email']=$_POST['email'];

		$res['code']=0;
        $res['msg']='success';

		return json_encode($res);
	}


	if( isset($_POST['type']) ){
		if($_POST['type'] == 'api'){
			/*
			header('Access-Control-Allow-Origin: *');
			header('Access-Control-Max-Age: 86400');
			header('Access-Control-Allow-Headers: x-requested-with');
			header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
			*/

			header('Content-Type: application/json; charset=UTF-8');
			$contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';
			if ($contentType === "application/json") {
				$content = trim(file_get_contents("php://input"));

				$decoded = json_decode($content, true);
			}

			foreach($decoded as $key => $value) { 
				$_POST[$key] = $value; 
			}

			if (function_exists($_POST['option'])){
				echo $_POST['option']();
				exit;
			}
			else{
				echo json_encode(array('code'=>1011, 'msg'=>'Fail', 'result'=>array() ));
				exit;
			}
			
		}
    }
?>