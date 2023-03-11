<?
	$tableName='';
	if(isset($_GET['code'])){
		$tableName=$_GET['code'];
	}

	$search_table = mobileDecrypt($tableName);

	$list_options = array();
	if(isset( $admin_opitons[ $search_table ]['list_options'] ) ){
		$list_options=$admin_opitons[ $search_table ]['list_options'];
	}

	$search_options = array();
	if(isset( $admin_opitons[ $search_table ]['search_options'] ) ){
		$search_options=$admin_opitons[ $search_table ]['search_options'];
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

<style>
.table > thead > tr > th {
    text-transform: none;
}
</style>

<!--  BEGIN CONTENT AREA  -->
<div class="row layout-top-spacing">
    <div class="col-lg-12 layout-spacing">
        <div class="statbox widget box box-shadow">
            <div class="widget-content widget-content-area" style="border-radius: 6px;">

				<button class="btn btn-success" id="ex_down" >
					<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-download-cloud"><polyline points="8 17 12 21 16 17"></polyline><line x1="12" y1="12" x2="12" y2="21"></line><path d="M20.88 18.09A5 5 0 0 0 18 9h-1.26A8 8 0 1 0 3 16.29"></path></svg>
					엑셀 다운로드
				</button>

				<div style="margin-bottom:20px;"></div>


                <div>



					<div id="toggleAccordion">
						<div class="card">
							<div class="card-header" role="menu" data-toggle="collapse" data-target="#defaultAccordionOne" aria-expanded="true" aria-controls="defaultAccordionOne" >
								<section class="mb-0 mt-0">
									<div  style="display: flex;" >
										Filters
										<div class="icons">
											<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down"><polyline points="6 9 12 15 18 9"></polyline></svg>
										</div>
									</div>
								</section>
							</div>

							<div id="defaultAccordionOne" class="collapse" aria-labelledby="..." data-parent="#toggleAccordion">
								<div class="card-body">
								
									<form id="f_form">

											<div class="form" id="filter_body">


											</div>

									</form>

								</div>
							</div>
						</div>
					</div>



                    



                </div>


                <div style="margin-bottom:40px;"></div>

				<div>
					<? for($i=0;$i<count($list_options['custom_btns']);$i++): ?>
					<? $data = $list_options['custom_btns'][$i]; ?>
					<button class="btn btn-primary" id="<?=$data['id']?>" >
						<?=$data['name']?>
					</button>
					<? endfor; ?>

				</div>


				<div style="margin-bottom:40px;"></div>


				<div style="display: flex; align-items: center;">

					<div style="margin-right:20px;">
						<select id="list_cnt" name="list_cnt" class="form-control">
							<option value="10">10</option>
							<option value="20">20</option>
							<option value="50">50</option>
							<option value="100">100</option>
							<option value="500">500</option>
							<option value="1000">1000</option>
							<option value="5000">5000</option>
						</select>
					</div>

					<button class="btn btn-outline-primary" id="show_total">Total 0</button>

				</div>

				
				<div style="margin-bottom:20px;"></div>


				<? if(isset($list_options['show_editbtn'])): ?>
				<div>
					<button class="btn btn-primary" onclick="location.href='./?p=<?=isset($list_options['set_edit_page']) ? $list_options['set_edit_page'] : 'admintype_edit_base' ?>&code=<?=urlencode($tableName)?>'" >New</button>


					<? if(isset($list_options['show_checkbox'])): ?>
						<button class="btn btn-primary" id="delBtn" >Delete</button>
					<? endif; ?>
				</div>
				<? endif; ?>


				




                <div style="margin-bottom:20px;"></div>

                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-condensed mb-4">
                        <thead >
						
                            <tr id="list_head">

                            </tr>
						
                        </thead>
                        <tbody id="list_body">


						




                        </tbody>


                    </table>
                </div>

				
				<div style="margin-bottom:20px;"></div>



                <ul id="pages" class="pagination">
                    <li class="page-item" style="cursor: pointer;" onclick="${onclick}"><span class="page-link"> < </span></li>

                    <li class="paginate_button page-item active"><a href="#" aria-controls="zero-config" data-dt-idx="1" tabindex="0" class="page-link">1</a></li>

                    <li class="paginate_button page-item "><a href="#" aria-controls="zero-config" data-dt-idx="2" tabindex="0" class="page-link">2</a></li>

                    <li class="paginate_button page-item "><a href="#" aria-controls="zero-config" data-dt-idx="3" tabindex="0" class="page-link">3</a></li>

                    <li class="page-item" style="cursor: pointer;" onclick="${onclick}"><span class="page-link"> > </span></li>
                </ul>


            </div>


        </div>
    </div>
</div>





<script>
    let account_c_page = 1;
    let start_cnt = 1;
    let end_cnt = 0;

    let pageShowCnt = 3;

    let search = '';

    let range = 1;

	var list_cnt=10;


	var list_options = JSON.parse('<?=json_encode($list_options)?>');
	var search_options = JSON.parse('<?=json_encode($search_options)?>');

	var order_start = false;

	var order_value = '';

	function getList(option = {}) {
		if (isRun) {
            return false;
        }
        isRun = true;

		$('#list_body').html(`<div style="    display: flex;align-items: center; justify-content: center;padding: 100px;"><div class="spinner-border bg-blue-dark" role="status"></div></div>`);

        if (option.page == undefined) {
            option.page = 1;
        }

        if (option.search == undefined) {
            option.search = '';
        }

		if (option.order == undefined) {
            option.order = order_value;
        }

        const formData = new FormData();
        formData.append("type", "api");
        formData.append("option", 'admintype_get_list');

		formData.append("code", '<?=$tableName?>');

        formData.append("page", option.page);
        formData.append("search", option.search);
		formData.append("order", option.order);
		formData.append("showCnt", list_cnt);


		if (option.excel_down != undefined) {
			formData.append("excel_down", 'true');
		}

        $.ajax({
            type: 'post',
            url: "./",
            processData: false,
            contentType: false,
            data: formData,
            dataType: "json",
            success: function(data) {
				isRun = false;
				$('#list_body').html(``);
                if (data.code == "0") {
					console.log(data);

					let datas = [];
					if(data.result.length != 0){
						datas = data.result;

						if(option.search.trim().length == 0){
							let keys = Object.keys(datas[0]);

							set_filter_tag(keys);

							if(!order_start){
								$('#list_head').html('');

								if(list_options['show_checkbox'] != undefined){
									$('#list_head').append(`<th class="text-center" id="all_sel">${checkbox_tag({ add_class : 'all_sel' })}</th>`);
								}

								if(list_options['show_editbtn'] != undefined){
									$('#list_head').append(`<th class="text-center">Edit</th>`);
								}

								for(var i=0;i<keys.length;i++){
									var show_text = keys[i];
									var add_order = false;

									if(list_options['hide_f'] != undefined){
										if( arraySearch(keys[i], list_options['hide_f']) ){
											continue;
										}
									}

									if(list_options['fieldToText'] != undefined){
										if(list_options['fieldToText'][ keys[i] ] != undefined){
											show_text = list_options['fieldToText'][keys[i]];
										}
									}

									if(list_options['order_show_f'] != undefined){
										if( arraySearch(keys[i], list_options['order_show_f']) ){
											add_order = true;
										}
									}

									if(add_order){
										$('#list_head').append(`<th class="text-center order_btn" order_check="" f_key="${keys[i]}" style="cursor: pointer;">${show_text} <i class="fas fa-caret-left order_left" style="color: #e3e4eb;"></i> <i class="fas fa-caret-right order_right" style="color: #e3e4eb;"></i></th>`);
									}
									else{
										$('#list_head').append(`<th class="text-center" >${show_text} </th>`);
									}

									
								}
							}


							
						}
						
					}

					end_cnt = data.endcnt;
					$('#show_total').html(`Total ${data.data_cnt}`);

					let addTag = '';
					for (var i = 0; i < datas.length; i++) {
                        addTag += list_tag(datas[i])
                    }

					if(list_options['show_sum_data'] != undefined){
						addTag += total_tag(data.sum_result);
					}

					$('#list_body').html(addTag);

					setPage(account_c_page);


					if(data.excel_url.trim().length != 0){
						window.open(data.excel_url);
					}
					

                } else {
                    //Swal.fire({text: data.msg, icon: 'error', confirmButtonText: 'OK'});
                }
            }
        });
    }
    getList();

	function arraySearch(base, arr){
		for(var i=0;i<arr.length;i++){
			if(base.indexOf(arr[i]) != -1){
				return true;
			}
		}
		
		return false;
	}


	$(document).on('click', '.order_btn', function(e) {
		var index = $('.order_btn').index(this);
        var key = $('.order_btn').eq(index).attr('order_check');
		var f_key = $('.order_btn').eq(index).attr('f_key');

		var order_set = 'asc';

		if(key == 'asc'){
			$('.order_btn').eq(index).attr('order_check', 'desc');
			order_set = 'desc';
		}

		if(key == 'desc'){
			$('.order_btn').eq(index).attr('order_check', 'asc');
			order_set = 'asc';
		}

		if(key.trim().length == 0){
			$('.order_btn').eq(index).attr('order_check', 'asc');
			order_set = 'asc';
		}

		for(var i=0;i<$('.order_left').length;i++){
			$('.order_left').eq(i).attr('style', 'color: #e3e4eb;');
		}

		for(var i=0;i<$('.order_right').length;i++){
			$('.order_right').eq(i).attr('style', 'color: #e3e4eb;');
		}

		if(order_set == 'asc'){
			$('.order_left').eq(index).attr('style', '');
		}

		if(order_set == 'desc'){
			$('.order_right').eq(index).attr('style', '');
		}

		order_start = true;
		order_value = `${f_key} ${order_set}`;

		getList({
			page: account_c_page,
			search: search,
			order: order_value,
		});


	});

	$(document).on('click', '#delBtn', function(e) {
		var checks = $('input:checkbox[name=item_sel]:checked');
		var sel_values = [];

		for(var i=0;i<checks.length;i++){
			sel_values.push(checks.eq(i).attr('key'));
		}

		var result = confirm("삭제하시겠습니까?");
		if(result){
			ajaxCall({ option: 'admintype_sel_del', "code": '<?=$tableName?>', 'values' : sel_values }, (data) => {
				location.reload();
			});
		}
	});
	
	$(document).on('click', '.all_sel', function(e) {
		
		if($('.all_sel').prop("checked")){
			$('.item_sel').prop("checked", true);
		}
		else{
			$('.item_sel').prop("checked", false);
		}
	});

	

	$(document).on('change', '#list_cnt', function(e) {
		var value = $('#list_cnt option:selected').text();

		if(value != list_cnt){
			list_cnt = value;
			account_c_page = 1;

			getList({
				page: account_c_page,
				search: search,
			});
		}

	});


	$(document).on('click', '#ex_down', function(e) {
		getList({
			page: account_c_page,
			search: search,
			excel_down: 'true',
		});
	});


	$(document).on('click', '#fBtn', function(e) {
        let set_search = [];
		let value = '';

		let inputs = $('.filter_inputs');

		for(var i=0;i<inputs.length;i++){
			value = inputs.eq(i).val();
			if(value.trim().length != 0){
				set_search.push({
					'logical' : inputs.eq(i).attr('logical'), 
					'f_key' : inputs.eq(i).attr('f_key'), 
					'operation' : inputs.eq(i).attr('operation'), 
					'value' : value, 
					's_type' :  inputs.eq(i).attr('s_type'),
				});
			}
		}

        search = JSON.stringify(set_search);
        account_c_page = 1;

        getList({
            page: account_c_page,
            search: search
        });

    });

    $("#f_form").keydown(function(e) {
        if (e.keyCode == 13) {
            $('#fBtn').trigger('click');
            e.preventDefault();
        }
    });

    $("#f_form").submit(function() {
        return false;
    });

	var datef_info = [];

	function set_filter_tag(data){
		let tag = ``;
		var logical = '';
		var operation = '';
		var s_type='';

		for(var i=0;i<data.length;i++){
			logical = 'and';
			operation = '=';
			s_type='n';

			var show_text = data[i];
			var i_type = "text";

			if(search_options[data[i]] != undefined){
				if(search_options[data[i]]['logical'] != undefined){
					logical = search_options[data[i]]['logical'];
				}

				if(search_options[data[i]]['operation'] != undefined){
					operation = search_options[data[i]]['operation'];
				}

				if(search_options[data[i]]['s_type'] != undefined){
					s_type = search_options[data[i]]['s_type'];
				}
			}

			if(search_options['hide_f'] != undefined){
				if( arraySearch(data[i], search_options['hide_f']) ){
					continue;
				}
			}

			if(list_options['fieldToText'] != undefined){
				if(list_options['fieldToText'][ data[i] ] != undefined){
					show_text = list_options['fieldToText'][data[i]];
				}
			}

			if(search_options[data[i]] != undefined){
				if(search_options[data[i]]['type'] != undefined){
					i_type = search_options[data[i]]['type'];
				}
			}

			if(i_type == 'date'){
				tag+=`
					<div style="margin-bottom:20px;"></div>

					<div id="username-field" class="field-wrapper input">
						<label >${show_text}</label>
						<div style="display: flex;justify-content: center;align-items: center;">
						<input id="${data[i]}_dp_start" f_key="${data[i]}" logical="${logical}" operation=">=" s_type="${s_type}" value="" class="form-control flatpickr flatpickr-input filter_inputs" type="text" placeholder="Select Date.." readonly="readonly" style="width:48%;">
						<div style="margin : 0px 30px;">-</div>
						<input id="${data[i]}_dp_end" f_key="${data[i]}" logical="${logical}" operation="<=" s_type="${s_type}" value="" class="form-control flatpickr flatpickr-input filter_inputs" type="text" placeholder="Select Date.." readonly="readonly" style="width:48%;">
						</div>
					</div>
				`;

				datef_info.push(data[i]+"_dp_start");
				datef_info.push(data[i]+"_dp_end");
			}
			else{
				tag+=`
					<div style="margin-bottom:20px;"></div>

					<div id="username-field" class="field-wrapper input">
						<label >${show_text}</label>
						<input type="text" f_key="${data[i]}" logical="${logical}" operation="${operation}" s_type="${s_type}" class="form-control filter_inputs" placeholder="${show_text}">
					</div>
				`;
			}

		}

		tag+=`
		<div style="margin-bottom:20px;"></div>

		<div class="d-sm-flex justify-content-between">
			<div class="field-wrapper" style="width: 100%;">
				<button id="fBtn" class="btn btn-primary" style="width: 100%;">필터</button>
			</div>
		</div>	
		`;
	
		$('#filter_body').html(tag);

		for(var i=0;i<datef_info.length;i++){
			flatpickr(document.getElementById( datef_info[i] ));
		}
	}

	//var f1 = flatpickr(document.getElementById('basicFlatpickr'));

    function update_data(option) {
        if (isRun) {
            return false;
        }
        isRun = true;

        const formData = new FormData();
        formData.append("type", "api");
        for (var key in option) {
            formData.append(key, option[key]);
        }


        $.ajax({
            type: 'post',
            url: "./",
            processData: false,
            contentType: false,
            data: formData,
            dataType: "json",
            success: function(data) {
                isRun = false;
                if (data.code == "0") {
                    /*
                    Swal.fire({text: data.msg, icon: 'success', confirmButtonText: 'OK'})
                    .then((result) => {
                        if (result.isConfirmed || result.isDismissed){
                            location.reload();             
                        }
                    });
                    */
                    alert(data.msg);
                    getList({
                        page: account_c_page,
                        search: search
                    });

                    //location.replace("./");

                } else {
                    alert(data.msg);
                    //Swal.fire({text: data.msg, icon: 'error', confirmButtonText: 'OK'});
                }
            }
        });
    }

	function checkbox_tag(option = {}){
		return `
			<label class="new-control new-checkbox checkbox-outline-info  m-auto">
					<input type="checkbox" class="new-control-input child-chk select-customers-info ${option.add_class}" key="${option.key}" name="${option.add_class}">
					<span class="new-control-indicator"></span><span style="visibility:hidden">c</span>
			</label>
		`;
	}

    function list_tag(data) {
		let tag = ``;

		tag += `<tr class="text-center">`;

		if(list_options['show_checkbox'] != undefined){
			tag += `<td class="text-center" >${checkbox_tag({ add_class : 'item_sel', key : data.rowid })}</td>`;
		}

		if(list_options['show_editbtn'] != undefined){
			tag += `<td class="text-center"><a class="btn btn-primary rounded-circle" href="./?p=<?=isset($list_options['set_edit_page']) ? $list_options['set_edit_page'] : 'admintype_edit_base' ?>&code=<?=urlencode($tableName)?>&w_key=${data.rowid}"  ><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg></a></td>`;
		}

		for(key in data){
			if(list_options['hide_f'] != undefined){
				if( arraySearch(key, list_options['hide_f']) ){
					continue;
				}
			}

			tag += `<td class="text-center">${data[key]}</td>`;
		}

		tag += `</tr>`;

        return tag;
    }

	function total_tag(datas){
		let tag = ``;

		tag += `<tr class="text-center">`;

		tag += `<td class="text-center" colspan="2"><b>Total : </b></td>`;

		for(var i=0;i<datas.length;i++){
			if(datas[i]['type'] == 'colspan'){
				tag += `<td class="text-center" colspan="${datas[i]['value']}"></td>`;
			}
			else{
				tag += `<td class="text-center" >${datas[i]['value']}</td>`;
			}
		}

		for(var key in datas){
			
		}

		tag += `</tr>`;

        return tag;
	}

    function getNextBtn(onclick = '') {
        let nextTag = `<li class="page-item" style="cursor: pointer;" onclick="${onclick}"><span class="page-link"> > </span></li>`;
        return nextTag;
    }

    function getPrevBtn(onclick = '') {
        let prevTag = `<li class="page-item" style="cursor: pointer;" onclick="${onclick}"><span class="page-link"> < </span></li>`;
        return prevTag;
    }

    function listNext() {
        let add = '';
        if (search.length != 0) {
            add = search;
        }

        if (end_cnt <= account_c_page) {
            account_c_page = end_cnt;
        } else {
            account_c_page += 1;
        }

        getList({
            page: account_c_page,
            search: add
        });

        setPage(account_c_page);

    }

    function listPrev() {
        let add = '';
        if (search.length != 0) {
            add = search;
        }

        if (start_cnt >= account_c_page) {
            account_c_page = start_cnt;
        } else {
            account_c_page -= 1;
        }

        getList({
            page: account_c_page,
            search: add
        });

        setPage(account_c_page);
    }

    function pageMove(page) {
        let add = '';
        if (search.length != 0) {
            add = search;
        }

        if (start_cnt >= page) {
            page = start_cnt;
        }

        if (end_cnt <= page) {
            page = end_cnt;
        }

        getList({
            page: page,
            search: add
        });

        account_c_page = page;
        setPage(page);

    }

    function setPageActive(page) {
        for (var i = 0; i < $('.acc_page_btn_').length; i++) {
            $('.acc_page_btn_').eq(i).removeClass("active");
        }

        $('#acc_page_btn_' + page).addClass("active");
    }

    function setPage(c_page = 1) {
        let start_page = 1;
        let end_page = end_cnt;

        if (end_cnt > range) {
            if (account_c_page <= range) {
                start_page = 1;
            } else {
                start_page = account_c_page - range;
            }

            if (end_cnt - account_c_page >= range) {
                end_page = account_c_page + range;
            } else {
                end_page = end_cnt;
            }
        } else {
            start_page = 1;
            end_page = end_cnt;
        }

        $('#pages').attr('style', 'display: flex;');
        $('#pages').html('');

        $('#pages').append(getPrevBtn('listPrev()'));

        for (var i = start_page; i <= end_page; i++) {
            $('#pages').append(getPageBtn({
                page: i,
                onclick: `pageMove(${i})`
            }));
        }

        $('#pages').append(getNextBtn('listNext()'));

        setPageActive(c_page);
    }

    function getPageBtn(option = {}) {
        if (option.page == undefined) {
            option.page = 0;
        }

        if (option.onclick == undefined) {
            option.onclick = '';
        }

        if (option.active == undefined) {
            option.active = '';
        }

        if (option.id == undefined) {
            option.id = 'acc_page_btn_';
        }

        let pageTag = `<li class="page-item ${option.active} ${option.id}" style="cursor: pointer;" onclick="${option.onclick}" id="${option.id + option.page}"><span class="page-link">${option.page}</span></li>`;
        return pageTag;
    }

    
</script>