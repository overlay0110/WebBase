<div class="page-content header-clear-medium container" style=" ">

		<a href="./order" >
            <div class="card card-style mb-3 " style="margin: 0px; margin-bottom:20px;">
                <div class="d-flex">
                    <div class="ps-3 ms-2 align-self-center">
                        <h1 class="pt-4 font-22">OO 주문</h1>
                        <p class="font-11 opacity-50 mt-n2 mb-4"></p>
                    </div>
                    <div class="ms-auto me-4 align-self-center">
                        <i class="fa fa-shopping-bag color-brown-dark fa-3x mt-4 mb-4 me-1"></i>
                    </div>
                </div>
            </div>
        </a>


		<a href="./order_list" >
            <div class="card card-style mb-3" style="margin: 0px; margin-bottom:20px;">
                <div class="d-flex">
                    <div class="ps-3 ms-2 align-self-center">
                        <h1 class="pt-4 font-22">OO 내역</h1>
                        <p class="font-11 opacity-50 mt-n2 mb-4"></p>
                    </div>
                    <div class="ms-auto me-4 align-self-center">
                        <i class="fa fa-file color-magenta-dark fa-3x mt-4 mb-4 me-1"></i>
                    </div>
                </div>
            </div>
        </a>

		<div style="margin-bottom:80px;"></div>

		<h2>OO 정보</h2>

		<div style="margin-bottom:20px;"></div>

		<div>
		

			<? if(count($m_list) == 0): ?>
			<div style="height: 200px;display: flex;justify-content: center;align-items: center;">
				<p>등록된 OO이 없습니다.</p>
			</div>
			<? endif; ?>

			<? for($i=0;$i<count($m_list);$i++): ?>
			<? $data=$m_list[$i];?>

			<div class="card card-style" style="margin: 0px; margin-bottom:20px;">
				<div class="content mb-0">
					<div>
						<h3><?=$data['m_info']['store_name']?> (<?=$data['m_info']['branch_name']?>)</h3>
					</div>
					<div style="margin-bottom:20px;"></div>
					<div>
						<div class="d-flex mb-4">
							<div>
								<img src="<?=$data['m_info']['show_img']?>" class="rounded-m shadow-xl" width="130">
							</div>
							<div class="ms-3">
								<h5 class="font-600"><?=$data['m_info']['phone']?></h5>
							</div>
						</div>
						<div class="row mb-0">

							<div class="col-12">

								<div class=" mb-3 ms-3" style="margin-left: auto !important; padding:20px;">
									<div>
										<h5 class="font-600" style="text-align: right;"><?=$data['m_info']['province']?> <?=$data['m_info']['city']?> <?=$data['m_info']['street_address']?> <?=$data['m_info']['detail_address']?> (<?=$data['m_info']['zip_code']?>)</h5>
									</div>
								</div>

							</div>

						</div>
					</div>
				</div>
			</div>

			<? endfor; ?>
			


		</div>

</div>

<script>
</script>