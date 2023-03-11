<?php
	function tran_en($value){
		$result = array(
			""=>"",
		);

		if(isset($result[$value])){
			return $result[$value];
		}
		return $value;
	}
?>