<?
	$tableName='';
	if(isset($_GET['code'])){
		$tableName=$_GET['code'];
	}

	$search_table = mobileDecrypt($tableName);

	$edit_options = array();
	if(isset( $admin_opitons[ $search_table ]['edit_options'] ) ){
		$edit_options=$admin_opitons[ $search_table ]['edit_options'];
	}

	$keys = array();
	$data = array();

	$set_f = "*";
	$where = "1 ";

	$fieldToText = array();
	$hide_f = array();
	$fieldType = array();


	if(isset($edit_options['set_f'])){
		$set_f = $edit_options['set_f'];
	}

	if(isset($edit_options['d_where'])){
		$where = $edit_options['d_where'];
	}

	if(isset($edit_options['fieldToText'])){
		$fieldToText = $edit_options['fieldToText'];
	}

	if(isset($edit_options['fieldType'])){
		$fieldType = $edit_options['fieldType'];
	}

	if(isset($edit_options['hide_f'])){
		$hide_f = $edit_options['hide_f'];
	}

	if(isset($_GET['w_key'])){
		$where .= "and rowid=".$_GET['w_key']." ";
	}

	$check = select($search_table, $set_f, $where." limit 1");
	if(isset($check[0])){
		$data = $check[0];
	}

	foreach($data as $key => $value) {
		array_push($keys, $key);
	}


	$id_level = 0;
	if( isset($config["admin_login_info"]["idToLevel"][ $_SESSION['admin']['email'] ]) ){
		$id_level = $config["admin_login_info"]["idToLevel"][ $_SESSION['admin']['email'] ];
	}

	if($id_level != 0){
		if(isset($config["admin_login_info"]["levelInfo"][$id_level][$page])){
			$t_check = $config["admin_login_info"]["levelInfo"][$id_level][$page];

			if(in_array($search_table, $t_check)) {
				echo '<script>alert("해당 계정의 권한이 없습니다.");window.history.back();</script>';
				exit;
			}
		}
	}

?>

<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>

<script> var uploadFiles = {};</script>
<div class="row layout-top-spacing">
    <div class="col-lg-12 layout-spacing">
        <div class="statbox widget box box-shadow">
			<div class="widget-content widget-content-area" style="border-radius: 6px;">
















								<div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
                                    
                                        <div class="info">
                                            <h5 class="">New or Edit</h5>
											<div style="margin-bottom:80px;"></div>
                                            <div class="row">
                                                <div class="col-md-11 mx-auto">

                                                    <div class="work-section">
                                                        <div class="row">

														


															<? for($i=0;$i<count($keys);$i++): ?>

															<?	if(in_array($keys[$i], $hide_f)): ?>
															<? continue; ?>
															<? endif; ?>

															<?if(isset($fieldType[$keys[$i]])):?>

																<?if($fieldType[$keys[$i]]["type"] == 'password'):?>
																<div class="col-md-12">
																	<div class="form-group">
																		<label for="l_<?=$keys[$i]?>"><?=isset($fieldToText[$keys[$i]]) ? $fieldToText[$keys[$i]] : $keys[$i]?></label>
																		<input type="password" id="l_<?=$keys[$i]?>" class="form-control mb-4 inputs" f_key="<?=$keys[$i]?>"  placeholder="<?=isset($fieldToText[$keys[$i]]) ? $fieldToText[$keys[$i]] : $keys[$i]?>" value="">
																	</div>
																</div>
																<?elseif($fieldType[$keys[$i]]["type"] == 'select'):?>

																<? $sel_check_val = isset($_GET['w_key']) ? $data[$keys[$i]] : ''; ?>

																<div class="col-md-12">
																	<div class="form-group">
																		<label for="l_<?=$keys[$i]?>"><?=isset($fieldToText[$keys[$i]]) ? $fieldToText[$keys[$i]] : $keys[$i]?></label>
																		<select class="form-control sel_inputs" id="l_<?=$keys[$i]?>">
																			<?for($ii=0;$ii<count($fieldType[$keys[$i]]["datas"]);$ii++):?>
																			<? 
																				$sel_data = $fieldType[$keys[$i]]["datas"][$ii]; 
																				$show_f = $fieldType[$keys[$i]]["show_f"];
																				$set_f = $fieldType[$keys[$i]]["set_f"];
																			?>
																			<option set_f="<?=$set_f?>" value="<?=$sel_data[$set_f]?>" <?= $sel_check_val == $sel_data[$set_f] ? 'selected' : '' ?> ><?=$sel_data[$show_f]?></option>
																			<?endfor;?>
																		</select>
																	</div>
																</div>
																<?elseif($fieldType[$keys[$i]]["type"] == 's_img'):?>
																<div class="col-md-12">
																	<div class="form-group">
																		<label for="l_<?=$keys[$i]?>"><?=isset($fieldToText[$keys[$i]]) ? $fieldToText[$keys[$i]] : $keys[$i]?></label>
																		<div class="custom-file-container" data-upload-id="l_<?=$keys[$i]?>">
																			<label>Upload (Single File) <a href="javascript:void(0)" class="custom-file-container__image-clear" title="Clear Image">x</a></label>
																			<label class="custom-file-container__custom-file" >
																				<input id="f_<?=$keys[$i]?>" type="file" class="custom-file-container__custom-file__custom-file-input" accept="image/*">
																				<input type="hidden" name="MAX_FILE_SIZE" value="10485760" />
																				<span class="custom-file-container__custom-file__custom-file-control"></span>
																			</label>
																			<div class="custom-file-container__image-preview" style="background-image:url('<?= isset($_GET['w_key']) ? $data[$keys[$i]] : 'https://order.bostonyammi.com/admin/assets/admin/assets/img/d_img.jpg'?>');"></div>
																		</div>
																		<script>uploadFiles['<?=$keys[$i]?>'] = new FileUploadWithPreview('l_<?=$keys[$i]?>');</script>
																	</div>
																</div>
																<?elseif($fieldType[$keys[$i]]["type"] == 'editer'):?>
																<div class="col-md-12">
																	<div class="form-group">
																		<label for="l_<?=$keys[$i]?>"><?=isset($fieldToText[$keys[$i]]) ? $fieldToText[$keys[$i]] : $keys[$i]?></label>
																		<div id="<?=$keys[$i]?>_editer" class="editers" f_key="<?=$keys[$i]?>"><?= isset($_GET['w_key']) ? $data[$keys[$i]] : ''?></div>
																		<script>
																		$('#<?=$keys[$i]?>_editer').summernote({
																			placeholder: '',
																			tabsize: 2,
																			height: 300,
																			toolbar: [
																			  ['style', ['style']],
																			  ['font', ['bold', 'underline', 'clear']],
																			  ['color', ['color']],
																			  ['para', ['ul', 'ol', 'paragraph']],
																			  ['table', ['table']],
																			  ['insert', ['link', 'picture', 'video']],
																			  ['view', ['fullscreen', 'codeview', 'help']]
																			]
																		  });
																		</script>
																	</div>
																</div>
																<?endif;?>




															<?else:?>

															<div class="col-md-12">
																<div class="form-group">
																	<label for="l_<?=$keys[$i]?>"><?=isset($fieldToText[$keys[$i]]) ? $fieldToText[$keys[$i]] : $keys[$i]?></label>
																	<input type="text" id="l_<?=$keys[$i]?>" class="form-control mb-4 inputs" f_key="<?=$keys[$i]?>"  placeholder="<?=isset($fieldToText[$keys[$i]]) ? $fieldToText[$keys[$i]] : $keys[$i]?>" value="<?= isset($_GET['w_key']) ? $data[$keys[$i]] : ''?>">
																</div>
															</div>
																
															<?endif;?>

                                                            

															<? endfor; ?>

                                                            

                                                            


															<?/*
                                                            <div class="col-md-12">
																<label for="degree2">Company Name</label>
                                                                <textarea class="form-control" placeholder="Description" rows="10"></textarea>
                                                            </div>
															*/?>

															<div class="col-md-12">
																<button class="btn btn-success w-100" id="updateBtn" >New or Edit</button>
															</div>
					
															
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    
                                </div>





















			</div>
		</div>
	</div>
</div>

<script>
$(document).on('click', '#updateBtn', function(e) {
	var inputs = $('.inputs');
	var sels = $('.sel_inputs');
	var editers = $('.editers');

	var f_key = ''
	var value = '';
	var option = {};

	option['option'] = 'admintype_new_or_edit';
	option['code'] = '<?=$tableName?>';

	<?if(isset($_GET["w_key"])):?>
	option['w_key'] = '<?=$_GET["w_key"]?>';
	<?endif;?>

	for(var i=0;i<inputs.length;i++){
		f_key = inputs.eq(i).attr('f_key');
		value = inputs.eq(i).val();

		option['para_'+f_key] = value;
	}

	for(var i=0;i<editers.length;i++){
		f_key = editers.eq(i).attr('f_key');
		value = editers.eq(i).summernote('code');

		option['para_'+f_key] = value;
	}

	for(var i=0;i<sels.length;i++){
		f_key = sels.eq(i).find('option:selected').attr('set_f');
		value = sels.eq(i).find('option:selected').val();

		option['para_'+f_key] = value;
	}

	for(key in uploadFiles){
		if($('#f_'+key)[0].files[0] != undefined){
			option['para_'+key] = $('#f_'+key)[0].files[0];
		}
	}

	ajaxCall(option, (data) => {
		//console.log(data);
		alert(data.msg);
		window.history.back();
		//location.reload();
	});

});

</script>