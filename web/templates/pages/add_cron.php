<!-- Begin toolbar -->
<div class="toolbar sticky top-14 z-20 border-y border-slate-200 bg-white">
	<div class="toolbar-inner mx-auto flex w-full min-w-0 flex-wrap items-center justify-between gap-3 px-4 py-3 md:px-6">
		<div class="toolbar-buttons flex flex-wrap items-center gap-2">
			<a class="button button-secondary button-back js-button-back inline-flex min-h-9 items-center justify-center gap-1.5 rounded-lg border border-blue-600 bg-blue-600 px-4 py-1.5 text-sm font-semibold text-white hover:bg-blue-700 disabled:cursor-not-allowed disabled:opacity-50 border-slate-300! bg-white! text-slate-700! hover:bg-slate-50!" href="/list/cron/">
				<i class="fas fa-arrow-left icon-blue text-blue-700"></i><?= tohtml( _("Back")) ?>
			</a>
		</div>
		<div class="toolbar-buttons flex flex-wrap items-center gap-2">
			<button type="submit" class="button inline-flex min-h-9 items-center justify-center gap-1.5 rounded-lg border border-blue-600 bg-blue-600 px-4 py-1.5 text-sm font-semibold text-white hover:bg-blue-700 disabled:cursor-not-allowed disabled:opacity-50" form="main-form">
				<i class="fas fa-floppy-disk icon-purple text-purple-700"></i><?= tohtml( _("Save")) ?>
			</button>
		</div>
	</div>
</div>
<!-- End toolbar -->

<div class="container mx-auto w-full max-w-none px-4 md:px-6">

	<form id="main-form" name="v_add_cron" method="post">
		<input type="hidden" name="token" value="<?= tohtml($_SESSION["token"]) ?>">
		<input type="hidden" name="ok" value="Add">

		<div class="form-container form-container-wide mx-auto w-full max-w-2xl py-6 max-w-5xl">
			<div class="u-side-by-side-tablet u-mb20 mb-[20px] sm:flex sm:items-center sm:justify-between">
				<h1><?= tohtml( _("Add Cron Job")) ?></h1>
				<p>
					<?= tohtml( _("System time")) ?>:
					<time datetime="<?= tohtml(date("c", $current_timestamp)) ?>" class="u-text-bold font-bold">
						<?= tohtml(date("d M Y, H:i", $current_timestamp)) ?>
					</time>
				</p>
			</div>
			<?php show_alert_message($_SESSION); ?>
			<div class="u-mb20 mb-[20px]">
				<label for="v_cmd" class="form-label mb-1 block text-sm font-semibold text-slate-700"><?= tohtml( _("Command")) ?></label>
				<input type="text" class="form-control block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-2 focus:outline-blue-200 disabled:bg-slate-100 disabled:text-slate-500" name="v_cmd" id="v_cmd" value="<?= tohtml(trim($v_cmd, "'")) ?>">
			</div>
			<div class="sidebar-left-grid grid gap-6 lg:grid-cols-[240px_minmax(0,1fr)]">
				<div class="sidebar-left-grid-sidebar">
					<div class="u-mb10 mb-[10px]">
						<label for="v_min" class="form-label mb-1 block text-sm font-semibold text-slate-700"><?= tohtml( _("Minute")) ?></label>
						<input type="text" class="form-control block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-2 focus:outline-blue-200 disabled:bg-slate-100 disabled:text-slate-500 transition-colors duration-700 [&.highlighted]:bg-yellow-100" name="v_min" id="v_min" value="<?= tohtml(trim($v_min, "'")) ?>">
					</div>
					<div class="u-mb10 mb-[10px]">
						<label for="v_hour" class="form-label mb-1 block text-sm font-semibold text-slate-700"><?= tohtml( _("Hour")) ?></label>
						<input type="text" class="form-control block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-2 focus:outline-blue-200 disabled:bg-slate-100 disabled:text-slate-500 transition-colors duration-700 [&.highlighted]:bg-yellow-100" name="v_hour" id="v_hour" value="<?= tohtml(trim($v_hour, "'")) ?>">
					</div>
					<div class="u-mb10 mb-[10px]">
						<label for="v_day" class="form-label mb-1 block text-sm font-semibold text-slate-700"><?= tohtml( _("Day")) ?></label>
						<input type="text" class="form-control block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-2 focus:outline-blue-200 disabled:bg-slate-100 disabled:text-slate-500 transition-colors duration-700 [&.highlighted]:bg-yellow-100" name="v_day" id="v_day" value="<?= tohtml(trim($v_day, "'")) ?>">
					</div>
					<div class="u-mb10 mb-[10px]">
						<label for="v_month" class="form-label mb-1 block text-sm font-semibold text-slate-700"><?= tohtml( _("Month")) ?></label>
						<input type="text" class="form-control block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-2 focus:outline-blue-200 disabled:bg-slate-100 disabled:text-slate-500 transition-colors duration-700 [&.highlighted]:bg-yellow-100" name="v_month" id="v_month" value="<?= tohtml(trim($v_month, "'")) ?>">
					</div>
					<div class="u-mb10 mb-[10px]">
						<label for="v_wday" class="form-label mb-1 block text-sm font-semibold text-slate-700"><?= tohtml( _("Day of Week")) ?></label>
						<input type="text" class="form-control block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-2 focus:outline-blue-200 disabled:bg-slate-100 disabled:text-slate-500 transition-colors duration-700 [&.highlighted]:bg-yellow-100" name="v_wday" id="v_wday" value="<?= tohtml(trim($v_wday, "'")) ?>">
					</div>
				</div>
				<div class="sidebar-left-grid-content">
					<div class="tabs cron-tabs js-tabs rounded-lg border border-slate-200 bg-white p-3 mt-5">
						<div class="tabs-items flex flex-wrap gap-2" role="tablist">
							<button type="button" class="tabs-item rounded-md px-3 py-2 font-semibold text-slate-600 hover:bg-blue-50 aria-selected:bg-blue-50 aria-selected:text-blue-700" id="tab-one" role="tab" tabindex="0" aria-selected="true"><?= tohtml( _("Minutes")) ?></button>
							<button type="button" class="tabs-item rounded-md px-3 py-2 font-semibold text-slate-600 hover:bg-blue-50 aria-selected:bg-blue-50 aria-selected:text-blue-700" id="tab-two" role="tab" tabindex="-1"><?= tohtml( _("Hourly")) ?></button>
							<button type="button" class="tabs-item rounded-md px-3 py-2 font-semibold text-slate-600 hover:bg-blue-50 aria-selected:bg-blue-50 aria-selected:text-blue-700" id="tab-three" role="tab" tabindex="-1"><?= tohtml( _("Daily")) ?></button>
							<button type="button" class="tabs-item rounded-md px-3 py-2 font-semibold text-slate-600 hover:bg-blue-50 aria-selected:bg-blue-50 aria-selected:text-blue-700" id="tab-four" role="tab" tabindex="-1"><?= tohtml( _("Weekly")) ?></button>
							<button type="button" class="tabs-item rounded-md px-3 py-2 font-semibold text-slate-600 hover:bg-blue-50 aria-selected:bg-blue-50 aria-selected:text-blue-700" id="tab-five" role="tab" tabindex="-1"><?= tohtml( _("Monthly")) ?></button>
						</div>
						<div class="tabs-panel p-3" role="tabpanel" aria-labelledby="tab-one" tabindex="0">
							<fieldset>
								<input type="hidden" name="h_hour" value="*" form="">
								<input type="hidden" name="h_day" value="*" form="">
								<input type="hidden" name="h_month" value="*" form="">
								<input type="hidden" name="h_wday" value="*" form="">
								<div class="u-mt10 u-mb20 mt-[10px] mb-[20px]">
									<label for="h_min_1" class="form-label first mb-1 block text-sm font-semibold text-slate-700"><?= tohtml( _("Run Command")) ?>:</label>
									<select class="form-select block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 disabled:bg-slate-100" name="h_min" id="h_min_1" form="">
										<option value="*" selected="selected"><?= tohtml( _("Every minute")) ?></option>
										<option value="*/2"><?= tohtml(sprintf(_("Every %s minutes"), 2)) ?></option>
										<option value="*/5"><?= tohtml(sprintf(_("Every %s minutes"), 5)) ?></option>
										<option value="*/10"><?= tohtml(sprintf(_("Every %s minutes"), 10)) ?></option>
										<option value="*/15"><?= tohtml(sprintf(_("Every %s minutes"), 15)) ?></option>
										<option value="*/30"><?= tohtml(sprintf(_("Every %s minutes"), 30)) ?></option>
									</select>
								</div>
								<div class="u-pt10 pt-[10px]">
									<button type="button" class="button button-secondary js-generate-cron inline-flex min-h-9 items-center justify-center gap-1.5 rounded-lg border border-blue-600 bg-blue-600 px-4 py-1.5 text-sm font-semibold text-white hover:bg-blue-700 disabled:cursor-not-allowed disabled:opacity-50 border-slate-300! bg-white! text-slate-700! hover:bg-slate-50!">
										<?= tohtml( _("Generate")) ?>
									</button>
								</div>
							</fieldset>
						</div>
						<div class="tabs-panel p-3" role="tabpanel" aria-labelledby="tab-two" tabindex="0" hidden>
							<fieldset>
								<input type="hidden" name="h_day" value="*" form="">
								<input type="hidden" name="h_month" value="*" form="">
								<input type="hidden" name="h_wday" value="*" form="">
								<div class="u-mt10 u-mb10 mt-[10px] mb-[10px]">
									<label for="h_hour_2" class="form-label first mb-1 block text-sm font-semibold text-slate-700"><?= tohtml( _("Run Command")) ?>:</label>
									<select class="form-select block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 disabled:bg-slate-100" name="h_hour" id="h_hour_2" form="">
										<option value="*" selected="selected"><?= tohtml( _("Every hour")) ?></option>
										<option value="*/2"><?= tohtml(sprintf(_("Every %s hours"), 2)) ?></option>
										<option value="*/6"><?= tohtml(sprintf(_("Every %s hours"), 6)) ?></option>
										<option value="*/12"><?= tohtml(sprintf(_("Every %s hours"), 12)) ?></option>
									</select>
								</div>
								<div class="u-mb20 mb-[20px]">
									<label for="h_min_2" class="form-label first mb-1 block text-sm font-semibold text-slate-700"><?= tohtml( _("Minute")) ?>:</label>
									<select class="form-select block min-h-9 w-[70px] min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 disabled:bg-slate-100" name="h_min" id="h_min_2" form="">
										<option value="0" selected="selected">00</option>
										<option value="15">15</option>
										<option value="30">30</option>
										<option value="45">45</option>
									</select>
								</div>
								<div class="u-pt10 pt-[10px]">
									<button type="button" class="button button-secondary js-generate-cron inline-flex min-h-9 items-center justify-center gap-1.5 rounded-lg border border-blue-600 bg-blue-600 px-4 py-1.5 text-sm font-semibold text-white hover:bg-blue-700 disabled:cursor-not-allowed disabled:opacity-50 border-slate-300! bg-white! text-slate-700! hover:bg-slate-50!">
										<?= tohtml( _("Generate")) ?>
									</button>
								</div>
							</fieldset>
						</div>
						<div class="tabs-panel p-3" role="tabpanel" aria-labelledby="tab-three" tabindex="0" hidden>
							<fieldset>
								<input type="hidden" name="h_month" value="*" form="">
								<input type="hidden" name="h_wday" value="*" form="">
								<div class="u-mt10 u-mb10 mt-[10px] mb-[10px]">
									<label for="h_day_3" class="form-label first mb-1 block text-sm font-semibold text-slate-700"><?= tohtml( _("Run Command")) ?>:</label>
									<select class="form-select block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 disabled:bg-slate-100" name="h_day" id="h_day_3" form="">
										<option value="*" selected="selected"><?= tohtml( _("Every day")) ?></option>
										<option value="1-31/2"><?= tohtml( _("Every odd day")) ?></option>
										<option value="*/2"><?= tohtml( _("Every even day")) ?></option>
										<option value="*/3"><?= tohtml(sprintf(_("Every %s days"), 2)) ?></option>
										<option value="*/5"><?= tohtml(sprintf(_("Every %s days"), 5)) ?></option>
										<option value="*/10"><?= tohtml(sprintf(_("Every %s days"), 10)) ?></option>
										<option value="*/15"><?= tohtml(sprintf(_("Every %s days"), 15)) ?></option>
									</select>
								</div>
								<div class="u-mb20 mb-[20px]">
									<label for="h_hour_3" class="form-label first mb-1 block text-sm font-semibold text-slate-700"><?= tohtml( _("Hour")) ?>:</label>
									<select class="form-select block min-h-9 w-[70px] min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 disabled:bg-slate-100" name="h_hour" id="h_hour_3" form="">
										<option value="0">00</option>
										<option value="1">01</option>
										<option value="2">02</option>
										<option value="3">03</option>
										<option value="4">04</option>
										<option value="5">05</option>
										<option value="6">06</option>
										<option value="7">07</option>
										<option value="8">08</option>
										<option value="9">09</option>
										<option value="10">10</option>
										<option value="11">11</option>
										<option value="12" selected="selected">12</option>
										<option value="13">13</option>
										<option value="14">14</option>
										<option value="15">15</option>
										<option value="16">16</option>
										<option value="17">17</option>
										<option value="18">18</option>
										<option value="19">19</option>
										<option value="20">20</option>
										<option value="21">21</option>
										<option value="22">22</option>
										<option value="23">23</option>
									</select>
									<label for="h_min_3" class="form-label mb-1 block text-sm font-semibold text-slate-700"><?= tohtml( _("Minute")) ?>:</label>
									<select class="form-select block min-h-9 w-[70px] min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 disabled:bg-slate-100" name="h_min" id="h_min_3" form="">
										<option value="0" selected="selected">00</option>
										<option value="1">01</option>
										<option value="2">02</option>
										<option value="5">05</option>
										<option value="10">10</option>
										<option value="15">15</option>
										<option value="20">20</option>
										<option value="25">25</option>
										<option value="30">30</option>
										<option value="35">35</option>
										<option value="40">40</option>
										<option value="45">45</option>
										<option value="50">50</option>
										<option value="55">55</option>
									</select>
								</div>
								<div class="u-pt10 pt-[10px]">
									<button type="button" class="button button-secondary js-generate-cron inline-flex min-h-9 items-center justify-center gap-1.5 rounded-lg border border-blue-600 bg-blue-600 px-4 py-1.5 text-sm font-semibold text-white hover:bg-blue-700 disabled:cursor-not-allowed disabled:opacity-50 border-slate-300! bg-white! text-slate-700! hover:bg-slate-50!">
										<?= tohtml( _("Generate")) ?>
									</button>
								</div>
							</fieldset>
						</div>
						<div class="tabs-panel p-3" role="tabpanel" aria-labelledby="tab-four" tabindex="0" hidden>
							<fieldset>
								<input type="hidden" name="h_month" value="*" form="">
								<input type="hidden" name="h_day" value="*" form="">
								<div class="u-mt10 u-mb10 mt-[10px] mb-[10px]">
									<label for="h_wday_4" class="form-label first mb-1 block text-sm font-semibold text-slate-700"><?= tohtml( _("Run Command")) ?>:</label>
									<select class="form-select block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 disabled:bg-slate-100" name="h_wday" id="h_wday_4" form="">
										<option value="*" selected="selected"><?= tohtml( _("Every day")) ?></option>
										<option value="1,2,3,4,5"><?= tohtml( _("Weekdays (5 days)")) ?></option>
										<option value="0,6"><?= tohtml( _("Weekend (2 days)")) ?></option>
										<option value="1"><?= tohtml( _("Monday")) ?></option>
										<option value="2"><?= tohtml( _("Tuesday")) ?></option>
										<option value="3"><?= tohtml( _("Wednesday")) ?></option>
										<option value="4"><?= tohtml( _("Thursday")) ?></option>
										<option value="5"><?= tohtml( _("Friday")) ?></option>
										<option value="6"><?= tohtml( _("Saturday")) ?></option>
										<option value="0"><?= tohtml( _("Sunday")) ?></option>
									</select>
								</div>
								<div class="u-mb20 mb-[20px]">
									<label for="h_hour_4" class="form-label first mb-1 block text-sm font-semibold text-slate-700"><?= tohtml( _("Hour")) ?>:</label>
									<select class="form-select block min-h-9 w-[70px] min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 disabled:bg-slate-100" name="h_hour" id="h_hour_4" form="">
										<option value="0">00</option>
										<option value="1">01</option>
										<option value="2">02</option>
										<option value="3">03</option>
										<option value="4">04</option>
										<option value="5">05</option>
										<option value="6">06</option>
										<option value="7">07</option>
										<option value="8">08</option>
										<option value="9">09</option>
										<option value="10">10</option>
										<option value="11">11</option>
										<option value="12" selected="selected">12</option>
										<option value="13">13</option>
										<option value="14">14</option>
										<option value="15">15</option>
										<option value="16">16</option>
										<option value="17">17</option>
										<option value="18">18</option>
										<option value="19">19</option>
										<option value="20">20</option>
										<option value="21">21</option>
										<option value="22">22</option>
										<option value="23">23</option>
									</select>
									<label for="h_min_4" class="form-label mb-1 block text-sm font-semibold text-slate-700"><?= tohtml( _("Minute")) ?>:</label>
									<select class="form-select block min-h-9 w-[70px] min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 disabled:bg-slate-100" name="h_min" id="h_min_4" form="">
										<option value="0" selected="selected">00</option>
										<option value="1">01</option>
										<option value="2">02</option>
										<option value="5">05</option>
										<option value="10">10</option>
										<option value="15">15</option>
										<option value="20">20</option>
										<option value="25">25</option>
										<option value="30">30</option>
										<option value="35">35</option>
										<option value="40">40</option>
										<option value="45">45</option>
										<option value="50">50</option>
										<option value="55">55</option>
									</select>
								</div>
								<div class="u-pt10 pt-[10px]">
									<button type="button" class="button button-secondary js-generate-cron inline-flex min-h-9 items-center justify-center gap-1.5 rounded-lg border border-blue-600 bg-blue-600 px-4 py-1.5 text-sm font-semibold text-white hover:bg-blue-700 disabled:cursor-not-allowed disabled:opacity-50 border-slate-300! bg-white! text-slate-700! hover:bg-slate-50!">
										<?= tohtml( _("Generate")) ?>
									</button>
								</div>
							</fieldset>
						</div>
						<div class="tabs-panel p-3" role="tabpanel" aria-labelledby="tab-five" tabindex="0" hidden>
							<fieldset>
								<input type="hidden" name="h_wday" value="*" form="">
								<div class="u-mt10 u-mb10 mt-[10px] mb-[10px]">
									<label for="h_month_5" class="form-label first mb-1 block text-sm font-semibold text-slate-700"><?= tohtml( _("Run Command")) ?>:</label>
									<select class="form-select block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 disabled:bg-slate-100" name="h_month" id="h_month_5" form="">
										<option value="*" selected="selected"><?= tohtml( _("Every month")) ?></option>
										<option value="1-11/2"><?= tohtml( _("Every odd month")) ?></option>
										<option value="*/2"><?= tohtml( _("Every even month")) ?></option>
										<option value="*/3"><?= tohtml(sprintf(_("Every %s months"), 3)) ?></option>
										<option value="*/6"><?= tohtml(sprintf(_("Every %s months"), 6)) ?></option>
										<option value="1"><?= tohtml( _("Jan")) ?></option>
										<option value="2"><?= tohtml( _("Feb")) ?></option>
										<option value="3"><?= tohtml( _("Mar")) ?></option>
										<option value="4"><?= tohtml( _("Apr")) ?></option>
										<option value="5"><?= tohtml( _("May")) ?></option>
										<option value="6"><?= tohtml( _("Jun")) ?></option>
										<option value="7"><?= tohtml( _("Jul")) ?></option>
										<option value="8"><?= tohtml( _("Aug")) ?></option>
										<option value="9"><?= tohtml( _("Sep")) ?></option>
										<option value="10"><?= tohtml( _("Oct")) ?></option>
										<option value="11"><?= tohtml( _("Nov")) ?></option>
										<option value="12"><?= tohtml( _("Dec")) ?></option>
									</select>
								</div>
								<div class="u-mb20 mb-[20px]">
									<label for="h_day_5" class="form-label first mb-1 block text-sm font-semibold text-slate-700"><?= tohtml( _("Day")) ?>:</label>
									<select class="form-select block min-h-9 w-[70px] min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 disabled:bg-slate-100" name="h_day" id="h_day_5" form="">
										<option value="1" selected="selected">01</option>
										<option value="2">02</option>
										<option value="3">03</option>
										<option value="4">04</option>
										<option value="5">05</option>
										<option value="6">06</option>
										<option value="7">07</option>
										<option value="8">08</option>
										<option value="9">09</option>
										<option value="10">10</option>
										<option value="11">11</option>
										<option value="12">12</option>
										<option value="13">13</option>
										<option value="14">14</option>
										<option value="15">15</option>
										<option value="16">16</option>
										<option value="17">17</option>
										<option value="18">18</option>
										<option value="19">19</option>
										<option value="20">20</option>
										<option value="21">21</option>
										<option value="22">22</option>
										<option value="23">23</option>
										<option value="24">24</option>
										<option value="25">25</option>
										<option value="26">26</option>
										<option value="27">27</option>
										<option value="28">28</option>
										<option value="29">29</option>
										<option value="30">30</option>
										<option value="31">31</option>
									</select>
									<label for="h_hour_5" class="form-label mb-1 block text-sm font-semibold text-slate-700"><?= tohtml( _("Hour")) ?>:</label>
									<select class="form-select block min-h-9 w-[70px] min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 disabled:bg-slate-100" name="h_hour" id="h_hour_5" form="">
										<option value="0">00</option>
										<option value="1">01</option>
										<option value="2">02</option>
										<option value="3">03</option>
										<option value="4">04</option>
										<option value="5">05</option>
										<option value="6">06</option>
										<option value="7">07</option>
										<option value="8">08</option>
										<option value="9">09</option>
										<option value="10">10</option>
										<option value="11">11</option>
										<option value="12" selected="selected">12</option>
										<option value="13">13</option>
										<option value="14">14</option>
										<option value="15">15</option>
										<option value="16">16</option>
										<option value="17">17</option>
										<option value="18">18</option>
										<option value="19">19</option>
										<option value="20">20</option>
										<option value="21">21</option>
										<option value="22">22</option>
										<option value="23">23</option>
									</select>
									<label for="h_min_5" class="form-label mb-1 block text-sm font-semibold text-slate-700"><?= tohtml( _("Minute")) ?>:</label>
									<select class="form-select block min-h-9 w-[70px] min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 disabled:bg-slate-100" name="h_min" id="h_min_5" form="">
										<option value="0" selected="selected">00</option>
										<option value="1">01</option>
										<option value="2">02</option>
										<option value="5">05</option>
										<option value="10">10</option>
										<option value="15">15</option>
										<option value="20">20</option>
										<option value="25">25</option>
										<option value="30">30</option>
										<option value="35">35</option>
										<option value="40">40</option>
										<option value="45">45</option>
										<option value="50">50</option>
										<option value="55">55</option>
									</select>
								</div>
								<div class="u-pt10 pt-[10px]">
									<button type="button" class="button button-secondary js-generate-cron inline-flex min-h-9 items-center justify-center gap-1.5 rounded-lg border border-blue-600 bg-blue-600 px-4 py-1.5 text-sm font-semibold text-white hover:bg-blue-700 disabled:cursor-not-allowed disabled:opacity-50 border-slate-300! bg-white! text-slate-700! hover:bg-slate-50!">
										<?= tohtml( _("Generate")) ?>
									</button>
								</div>
							</fieldset>
						</div>
					</div>
				</div>
			</div>
		</div>

	</form>

</div>
