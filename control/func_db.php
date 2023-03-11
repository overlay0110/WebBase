<?php
function getConn(){
	global $config;

	$conn=null;
	if($config['db_api'] == 'mysqli'){
		$conn= mysqli_connect($config['db_host'],$config['db_user'],$config['db_password'],$config['db_name']);
		mysqli_set_charset($conn, 'utf8');
	}
	else if($config['db_api'] == 'pdo'){
		$pdo = new PDO("mysql:host=".$config['db_host'].";dbname=".$config['db_name'].";charset=utf8", $config['db_user'], $config['db_password']);
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$conn=$pdo;
	}
	
	return $conn;
}

function select($setTable,$selField,$where,$setdata=array()){
	// select("Contract_log","*","call_type=? and fun_name=? and state=1", array('start', 'sendERC20_k') );
	global $config;
	$conn = getConn();

	$result=array();

	$sql="select ".$selField." from ".$setTable." where ".$where;

	if($config['db_api'] == 'mysqli'){
		for($i=0;$i<count($setdata);$i++){
			$where = str_replace_first("?", '"'.sqlFilter_mysqli($setdata[$i]).'"', $where);
		}

		$sql="select ".$selField." from ".$setTable." where ".$where;
		//echo $sql;
		$result = mysqli_query($conn, $sql);
		$result = mysqli_fetch_all($result, MYSQLI_ASSOC);
		mysqli_close($conn);
	}
	else if($config['db_api'] == 'pdo'){
		$stmt = $conn->prepare($sql);
		$stmt->execute( $setdata );
		$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
		$conn=null;
	}

	return $result;
}

function insert($setTable,$data){
	// insert('nfc_test', array('nfc_id'=>'dshafjklasdjfklasdf','nfc_code'=>23452345) );
	global $config;
	$conn = getConn();

	if($config['db_api'] == 'mysqli'){
		$sql="insert into ".$setTable." set ";
		$i=0;
		foreach($data as $key=>$val) {
			if( count($data) == ($i+1) ){
				$sql.=$key."='".sqlFilter_mysqli($val)."' ";
			}
			else{
				$sql.=$key."='".sqlFilter_mysqli($val)."', ";
			}
			
			$i++;
		}

		//echo $sql;
		$rs=mysqli_query($conn,$sql);
		mysqli_close($conn);
	}
	else if($config['db_api'] == 'pdo'){
		$keys = array_keys($data);
		$values = array_values($data);

		$sql="insert into ".$setTable;
		$sql.='(';
		for($i=0;$i<count($keys);$i++){
			$sql.=$keys[$i];
			if( ($i+1) != count($keys) ){
				$sql.=',';
			}
		}
		$sql.=') values (';
		for($i=0;$i<count($values);$i++){
			$sql.='?';
			if( ($i+1) != count($values) ){
				$sql.=',';
			}
		}
		$sql.=');';
		//echo $sql;
		$stmt = $conn->prepare($sql);
		$stmt->execute( $values );
		$conn=null;
	}
}

function update($setTable, $data, $where='', $setdata=array()){
	// update('nfc_test', array('nfc_id'=>'test1234'), 'id=?', array(22) );
	global $config;
	$conn = getConn();
	$sql="update ".$setTable." set ";
	$i=0;

	if($config['db_api'] == 'mysqli'){
		foreach($data as $key=>$val) {
			if( count($data) == ($i+1) ){
				$sql.=$key."='".sqlFilter_mysqli($val)."' ";
			}
			else{
				$sql.=$key."='".sqlFilter_mysqli($val)."', ";
			}
			$i++;
		}
		for($i=0;$i<count($setdata);$i++){
			$where = str_replace_first("?", '"'.sqlFilter_mysqli($setdata[$i]).'"', $where);
		}
		$sql.=" where ".$where;
		$rs=mysqli_query($conn,$sql);
		mysqli_close($conn);
	}
	else if($config['db_api'] == 'pdo'){
		$values = array_values($data);

		foreach($data as $key=>$val) {
			$sql.=$key.'=?';
			if( ($i+1) != count($data) ){
				$sql.=',';
			}
			$i++;
		}

		$sql.=' where '.$where;

		for($i=0;$i<count($setdata);$i++){
			array_push($values, $setdata[$i]);
		}

		//echo $sql;
		$stmt = $conn->prepare($sql);
		$stmt->execute( $values );
		$conn=null;
	}
}

function del($setTable,$where='',$setdata=array()){
	// del('nfc_test','id=?',array(20));
	global $config;
	$conn = getConn();

	$sql="delete from ".$setTable;

	if(trim($where) != ''){
		$sql.=' where '.$where;
	}

	if($config['db_api'] == 'mysqli'){
		for($i=0;$i<count($setdata);$i++){
			$where = str_replace_first("?", '"'.sqlFilter_mysqli($setdata[$i]).'"', $where);
		}
		
		//echo $sql;
		$rs=mysqli_query($conn,$sql);
		mysqli_close($conn);
	}
	else if($config['db_api'] == 'pdo'){
		//echo $sql;
		$stmt = $conn->prepare($sql);
		$stmt->execute( $setdata );
		$conn=null;
	}
}

if (!function_exists('mysqli_fetch_all')) {
	function mysqli_fetch_all(mysqli_result $result) {
		$data = [];
		while ($data[] = $result->fetch_assoc()) {
		}

		$unNum = 999999999999;

		for($i=0;$i<count($data);$i++){
			if( !isset($data[$i]) ){
				$unNum = $i;
			}
		}

		if($unNum != 999999999999 ){
			unset($data[$unNum]);
		}

		return $data;
	}
}

function sqlFilter_mysqli($value){
	global $config;

	if($config['db_api'] != 'mysqli'){
		return $value;
	}

	$conn = getConn();
	return mysqli_real_escape_string($conn, $value);
}

?>