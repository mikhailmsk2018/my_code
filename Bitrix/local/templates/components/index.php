<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("title", "Обращения");
$user_id=$USER->GetID();
?>
<div class="col-md-9 col-sm-8">
	<div class="section">
		<h3>Обращения</h3>
		<div class="section">
			Здесь Вы можете задать любые вопросы.
		</div>
		<div class="row">
			<div class="col-md-5">
				<?if(TRUE):?>
				<div class="section">
					<a href="p-obr" class="main-btn vam pop-link">Создать обращение</a>
					<!--<a href="/faq/19/" class="bg-btn black-btn vam">Помощь</a>-->
				</div>
				<?endif?>
			</div>
			<div class="col-md-7">
				<div class="section">
					<div class="info-text">Обратите внимание: в списке показаны все Ваши обращения</div>
				</div>
			</div>
		</div>
		<div class="section">
			<div class="box ovh">
				<div class="tabs">
					<div class="top-tabs gray-tabs">
						<div class="tab active">
							<div class="title">Обращения <img src="<?=SITE_TEMPLATE_PATH?>/images/icon-arw-right.png" alt="" style="margin-left: 8px;"></div>
						</div>
						<div class="tab">
							<div class="title">Архив <img src="<?=SITE_TEMPLATE_PATH?>/images/icon-del.png" alt="" style="margin-left: 8px;"></div>
						</div>
					</div>
					<div class="inner">
						<div class="mb-sm">
							<div class="dib vam mr"><b>Показать письма за период</b></div>
							<div class="dib vam">
								<form action="">
									<div class="dib vam mr">
										<div class="date-inp">
											<span class="calend"><img src="<?=SITE_TEMPLATE_PATH?>/images/icon-calendar-2.png" alt=""></span>
											<input type="text" name="date_from" class="inp" value="<?=$_GET['date_from']?>" onclick="BX.calendar({node: this, field: this, bTime: false});">
										</div>
										<div class="date-inp">
											<span class="calend"><img src="<?=SITE_TEMPLATE_PATH?>/images/icon-calendar-2.png" alt=""></span>
											<input type="text" name="date_to" class="inp" value="<?=$_GET['date_to']?>" onclick="BX.calendar({node: this, field: this, bTime: false});">
										</div>
									</div>
									<div class="dib vam">
										<label class="search-dates" for="find-btn">
											<input id="find-btn" type="submit" name="find" class="dn" value="">
											<img src="<?=SITE_TEMPLATE_PATH?>/images/icon-search.png" alt="">
										</label>
									</div>
								</form>
							</div>
						</div>
						<div class="bottom-tabs mb">
							<div class="tab active">
								<?
								$tikets = get_user_tikets(array(9,12,13,14), $_GET['date_from'], $_GET['date_to']);// активные
								show_tikets($tikets);
								?>
							</div>
							<div class="tab">
								<?
								$tikets = get_user_tikets(10, $_GET['date_from'], $_GET['date_to']);// архив
								show_tikets($tikets);
								?>
							</div>
						</div>
						<?if(TRUE):?>
						<div>
							<a href="p-obr" class="main-btn vam pop-link">Создать обращение</a>
							<!--<a href="/faq/19/" class="bg-btn black-btn vam">Помощь</a>-->
						</div>
						<?else:?>
							<p>Создание обращений временно недоступно</p>
						<?endif?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div><!-- col-sm-9 -->




<? require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>