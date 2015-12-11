<div id="modal-history">
	<div class="modal-history-inner">
		<a href="#" class="mfp-close"></a>
		<h2>История операций</h2>
		<div class="tab-history">
			<div class="tab-history-heading">
				<ul>
					<li><a href="th_content1">Все операции <span>(<?=count($user->moneyHistoryAll);?>)</span> </a></li>
					<li><a href="th_content2">Пополнение <span>(<?=count($user->moneyHistoryPlus);?>)</span></a></li>
					<li><a href="th_content3">Платежи <span>(<?=count($user->moneyHistoryMinus);?>)</span></a></li>
				</ul>
			</div><!-- end heading -->
			<div class="tab-history-content-wrap">
				<div class="th_content th_content1">
					<div class="operations-table-wrap">
						<table id="miyazaki">
							<thead>
							<tr>
								<th><p>Дата</p></th>
								<th><p>Операции</p></th>
								<th><p>Способ оплаты</p></th>
								<th><p>Сумма</p></th>
								<th><p>Статус</p></th>
							<tbody>
							<?foreach ($user->moneyHistoryAll as $history):?>
								<tr>
									<td>
										<p><?=$history->dateTextDMY?></p>
										<p><?=$history->dateTextHI?></p>
									</td>
									<td><p><?=$history->operationT->name?></p></td>
									<td><p><?if ($history->typeMoney):?><?=$history->typeMoney->rus_name?><?endif?></p></td>
									<td><p class="sum"><?=$history->sumText;?></p></td>
									<td><p class="status-access"><?=$history->statusT->name;?></p></td>
								</tr>	
							<?endforeach;?>
						</table>
					</div><!-- end operatoins-table-wrap -->
				</div><!-- end tab-content -->

				<div class="th_content th_content2">
					<div class="operations-table-wrap">
						<table id="miyazaki">
							<thead>
							<tr>
								<th><p>Дата</p></th>
								<th><p>Операции</p></th>
								<th><p>Способ оплаты</p></th>
								<th><p>Сумма</p></th>
								<th><p>Статус</p></th>
							<tbody>
							<?foreach ($user->moneyHistoryPlus as $history):?>
								<tr>
									<td>
										<p><?=$history->dateTextDMY?></p>
										<p><?=$history->dateTextHI?></p>
									</td>
									<td><p><?=$history->operationT->name?></p></td>
									<td><p><?if ($history->typeMoney):?><?=$history->typeMoney->rus_name?><?endif?></p></td>
									<td><p class="sum"><?=$history->sumText;?></p></td>
									<td><p class="status-access"><?=$history->statusT->name;?></p></td>
								</tr>	
							<?endforeach;?>
						</table>
					</div><!-- end operatoins-table-wrap -->
				</div><!-- end tab-content -->
				<div class="th_content th_content3">
					<div class="operations-table-wrap">
						<table id="miyazaki">
							<thead>
							<tr>
								<th><p>Дата</p></th>
								<th><p>Операции</p></th>
								<th><p>Способ оплаты</p></th>
								<th><p>Сумма</p></th>
								<th><p>Статус</p></th>
							<tbody>
							<?foreach ($user->moneyHistoryMinus as $history):?>
								<tr>
									<td>
										<p><?=$history->dateTextDMY?></p>
										<p><?=$history->dateTextHI?></p>
									</td>
									<td><p><?=$history->operationT->name?></p></td>
									<td><p></p></td>
									<td><p class="sum"><?=$history->sumText;?></p></td>
									<td><p class="status-access"><?=$history->statusT->name;?></p></td>
								</tr>	
							<?endforeach;?>
						</table>
					</div><!-- end operatoins-table-wrap -->
				</div><!-- end tab-content -->
			</div><!-- end content-wrap -->
		</div><!-- end history-tab -->
	</div><!-- end modal history inner -->
	
</div>

<script>
	var tabHistory = function(){
	var $tabContent = $('.th_content');
	$tabContent.not(':first').hide();
	$('.tab-history ul li a').first().addClass('tab-history-active');

	$('.tab-history ul li a').on('click',function(e){
			e.preventDefault();
			var $tabContent = $('.th_content');
			var $this = $(this);
			var $attr = $this.attr('href');
			$this.addClass('tab-history-active').parent().siblings().find('a').removeClass('tab-history-active');
			$("." + $attr).fadeIn(200).siblings().fadeOut(200);
		});
	};
	tabHistory();
</script>