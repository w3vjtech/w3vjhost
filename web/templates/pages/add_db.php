<!-- Begin toolbar -->
<div class="toolbar sticky top-14 z-20 border-y border-slate-200 bg-white">
	<div class="toolbar-inner mx-auto flex w-full min-w-0 flex-wrap items-center justify-between gap-3 px-4 py-3 md:px-6">
		<div class="toolbar-buttons flex flex-wrap items-center gap-2">
			<a class="button button-secondary button-back js-button-back inline-flex min-h-9 items-center justify-center gap-1.5 rounded-lg border border-blue-600 bg-blue-600 px-4 py-1.5 text-sm font-semibold text-white hover:bg-blue-700 disabled:cursor-not-allowed disabled:opacity-50 border-slate-300! bg-white! text-slate-700! hover:bg-slate-50!" href="/list/db/">
				<i class="fas fa-arrow-left icon-blue text-blue-700"></i><?= tohtml( _("Back")) ?>
			</a>
		</div>
		<div class="toolbar-buttons flex flex-wrap items-center gap-2">
			<?php if (($_SESSION["role"] == "admin" && $accept === "true") || $_SESSION["role"] !== "admin") { ?>
				<button type="submit" class="button inline-flex min-h-9 items-center justify-center gap-1.5 rounded-lg border border-blue-600 bg-blue-600 px-4 py-1.5 text-sm font-semibold text-white hover:bg-blue-700 disabled:cursor-not-allowed disabled:opacity-50" form="main-form">
					<i class="fas fa-floppy-disk icon-purple text-purple-700"></i><?= tohtml( _("Save")) ?>
				</button>
			<?php } ?>
		</div>
	</div>
</div>
<!-- End toolbar -->

<div class="container mx-auto w-full max-w-none px-4 md:px-6">

	<form
		x-data="{
			showAdvanced: <?= tohtml(empty($v_adv) ? "false" : "true") ?>
		}"
		id="main-form"
		name="v_add_db"
		method="post"
	>
		<input type="hidden" name="token" value="<?= tohtml($_SESSION["token"]) ?>">
		<input type="hidden" name="ok" value="Add">

		<div class="form-container mx-auto w-full max-w-2xl py-6">
			<h1 class="u-mb20 mb-[20px]"><?= tohtml( _("Add Database")) ?></h1>
			<?php show_alert_message($_SESSION); ?>
			<?php if ($_SESSION["role"] == "admin" && $accept !== "true") { ?>
				<div class="alert alert-danger mb-4 rounded-lg border p-4 text-sm [&_a]:underline [&_i]:mr-2 border-red-200 bg-red-50 text-red-800" role="alert">
					<i class="fas fa-exclamation"></i>
					<p><?= htmlify_trans(sprintf(_("It is strongly advised to {create a standard user account} before adding %s to the server due to the increased privileges the admin account possesses and potential security risks."), _('a database')), '</a>', '<a href="/add/user/">') ?></p>
				</div>
			<?php } ?>
			<?php if ($_SESSION["role"] == "admin" && empty($accept)) { ?>
				<div class="u-side-by-side u-mt20 flex flex-wrap items-center gap-2 mt-[20px]">
					<a href="/add/user/" class="button u-width-full u-mr10 inline-flex min-h-9 items-center justify-center gap-1.5 rounded-lg border border-blue-600 bg-blue-600 px-4 py-1.5 text-sm font-semibold text-white hover:bg-blue-700 disabled:cursor-not-allowed disabled:opacity-50 mr-[10px] w-full"><?= tohtml( _("Add User")) ?></a>
					<a href="/add/db/?<?= tohtml(http_build_query(["accept" => 'true'])) ?>" class="button button-danger u-width-full u-ml10 inline-flex min-h-9 items-center justify-center gap-1.5 rounded-lg border border-blue-600 bg-blue-600 px-4 py-1.5 text-sm font-semibold text-white hover:bg-blue-700 disabled:cursor-not-allowed disabled:opacity-50 border-red-200! bg-white! text-red-700! hover:bg-red-50! ml-[10px] w-full"><?= tohtml( _("Continue")) ?></a>
				</div>
			<?php } ?>
			<?php if (($_SESSION["role"] == "admin" && $accept === "true") || $_SESSION["role"] !== "admin") { ?>
					<p class="hint u-mb20 text-sm leading-6 text-slate-500 mb-[20px]">
						<?php
							$prefix_hint = _("Prefix %s will be automatically added to database name and database user");
							$prefix_hint_html = '<span class="u-text-bold">' . tohtml($user_plain) . '_</span>';
							printf($prefix_hint, $prefix_hint_html);
						?>
					</p>
				<div class="u-mb10 mb-[10px]">
					<label for="v_database" class="form-label mb-1 block text-sm font-semibold text-slate-700"><?= tohtml( _("Database")) ?></label>
					<input type="text" class="form-control js-db-hint-database-name block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-2 focus:outline-blue-200 disabled:bg-slate-100 disabled:text-slate-500" name="v_database" id="v_database" value="<?= tohtml(trim($v_database, "'")) ?>">
					<small class="hint text-sm leading-6 text-slate-500"></small>
				</div>
				<div class="u-mb10 mb-[10px]">
					<label for="v_type" class="form-label mb-1 block text-sm font-semibold text-slate-700"><?= tohtml( _("Type")) ?></label>
					<select class="form-select block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 disabled:bg-slate-100" name="v_type" id="v_type">
						<?php
							foreach ($db_types as $key => $value) {
								echo "\n\t\t\t\t\t\t\t\t\t\t<option value=\"".htmlentities($value)."\"";
								if ((!empty($v_type)) && ( $value == $v_type )) echo ' selected';
								echo ">".htmlentities($value)."</option>";
							}
						?>
					</select>
				</div>
				<div class="u-mb10 mb-[10px]">
					<label for="v_dbuser" class="form-label u-side-by-side mb-1 block text-sm font-semibold text-slate-700 flex flex-wrap items-center gap-2">
						<?= tohtml( _("Username")) ?>
						<em><small>(<?= tohtml(sprintf(_("Maximum %s characters length, including prefix"), 32)) ?>)</small></em>
					</label>
					<input type="text" class="form-control js-db-hint-username block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-2 focus:outline-blue-200 disabled:bg-slate-100 disabled:text-slate-500" name="v_dbuser" id="v_dbuser" value="<?= tohtml(trim($v_dbuser, "'")) ?>">
					<small class="hint text-sm leading-6 text-slate-500"></small>
				</div>
				<div class="u-mb10 mb-[10px]">
					<label for="v_password" class="form-label mb-1 block text-sm font-semibold text-slate-700">
						<?= tohtml( _("Password")) ?>
						<button type="button" title="<?= tohtml( _("Generate")) ?>" class="u-unstyled-button u-ml5 js-generate-password ml-[5px] border-0 bg-transparent p-0">
							<i class="fas fa-arrows-rotate icon-green text-green-700"></i>
						</button>
					</label>
					<div class="u-pos-relative u-mb10 mb-[10px] relative">
						<input type="text" class="form-control js-password-input block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-2 focus:outline-blue-200 disabled:bg-slate-100 disabled:text-slate-500" name="v_password" id="v_password">
						<div class="password-meter relative">
							<meter max="4" class="password-meter-input js-password-meter pr-10"></meter>
						</div>
					</div>
				</div>
				<?php require $_SERVER["HESTIA"] . "/web/templates/includes/password-requirements.php"; ?>
				<div class="u-mb20 mb-[20px]">
					<label for="v_db_email" class="form-label mb-1 block text-sm font-semibold text-slate-700">
						<?= tohtml( _("Email login credentials to:")) ?>
					</label>
					<input type="email" class="form-control block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-2 focus:outline-blue-200 disabled:bg-slate-100 disabled:text-slate-500" name="v_db_email" id="v_db_email" value="<?= tohtml(trim($v_db_email, "'")) ?>">
				</div>
				<div class="u-mb20 mb-[20px]">
					<button x-on:click="showAdvanced = !showAdvanced" type="button" class="button button-secondary inline-flex min-h-9 items-center justify-center gap-1.5 rounded-lg border border-blue-600 bg-blue-600 px-4 py-1.5 text-sm font-semibold text-white hover:bg-blue-700 disabled:cursor-not-allowed disabled:opacity-50 border-slate-300! bg-white! text-slate-700! hover:bg-slate-50!">
						<?= tohtml( _("Advanced Options")) ?>
					</button>
				</div>
				<div x-cloak x-show="showAdvanced">
					<div class="u-mb10 mb-[10px]">
						<label for="v_host" class="form-label mb-1 block text-sm font-semibold text-slate-700"><?= tohtml( _("Host")) ?></label>
						<select class="form-select block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 disabled:bg-slate-100" name="v_host" id="v_host">
							<?php
								foreach ($db_hosts as $value) {
									echo "\n\t\t\t\t\t\t\t\t\t\t<option value=\"".htmlentities($value)."\"";
									if ((!empty($v_host)) && ( $value == $v_host )) echo ' selected';
									echo ">".htmlentities($value)."</option>";
								}
							?>
						</select>
					</div>
					<div class="u-mb10 mb-[10px]">
						<label for="v_charset" class="form-label mb-1 block text-sm font-semibold text-slate-700"><?= tohtml( _("Charset")) ?></label>
						<select class="form-select block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 disabled:bg-slate-100" name="v_charset" id="v_charset">
							<option value=big5 <?php if ((!empty($v_charset)) && ( $v_charset == 'big5')) echo 'selected'; ?>>big5</option>
							<option value=dec8 <?php if ((!empty($v_charset)) && ( $v_charset == 'dec8')) echo 'selected'; ?>>dec8</option>
							<option value=cp850 <?php if ((!empty($v_charset)) && ( $v_charset == 'cp850')) echo 'selected'; ?>>cp850</option>
							<option value=hp8 <?php if ((!empty($v_charset)) && ( $v_charset == 'hp8')) echo 'selected'; ?>>hp8</option>
							<option value=koi8r <?php if ((!empty($v_charset)) && ( $v_charset == 'koi8r')) echo 'selected'; ?>>koi8r</option>
							<option value=latin1 <?php if ((!empty($v_charset)) && ( $v_charset == 'latin1')) echo 'selected'; ?>>latin1</option>
							<option value=latin2 <?php if ((!empty($v_charset)) && ( $v_charset == 'latin2')) echo 'selected'; ?>>latin2</option>
							<option value=swe7 <?php if ((!empty($v_charset)) && ( $v_charset == 'swe7')) echo 'selected'; ?>>swe7</option>
							<option value=ascii <?php if ((!empty($v_charset)) && ( $v_charset == 'ascii')) echo 'selected'; ?>>ascii</option>
							<option value=ujis <?php if ((!empty($v_charset)) && ( $v_charset == 'ujis')) echo 'selected'; ?>>ujis</option>
							<option value=sjis <?php if ((!empty($v_charset)) && ( $v_charset == 'sjis')) echo 'selected'; ?>>sjis</option>
							<option value=hebrew <?php if ((!empty($v_charset)) && ( $v_charset == 'hebrew')) echo 'selected'; ?>>hebrew</option>
							<option value=tis620 <?php if ((!empty($v_charset)) && ( $v_charset == 'tis620')) echo 'selected'; ?>>tis620</option>
							<option value=euckr <?php if ((!empty($v_charset)) && ( $v_charset == 'euckr')) echo 'selected'; ?>>euckr</option>
							<option value=koi8u <?php if ((!empty($v_charset)) && ( $v_charset == 'koi8u')) echo 'selected'; ?>>koi8u</option>
							<option value=gb2312 <?php if ((!empty($v_charset)) && ( $v_charset == 'gb2312')) echo 'selected'; ?>>gb2312</option>
							<option value=greek <?php if ((!empty($v_charset)) && ( $v_charset == 'greek')) echo 'selected'; ?>>greek</option>
							<option value=cp1250 <?php if ((!empty($v_charset)) && ( $v_charset == 'cp1250')) echo 'selected'; ?>>cp1250</option>
							<option value=gbk <?php if ((!empty($v_charset)) && ( $v_charset == 'gbk')) echo 'selected'; ?>>gbk</option>
							<option value=latin5 <?php if ((!empty($v_charset)) && ( $v_charset == 'latin5')) echo 'selected'; ?>>latin5</option>
							<option value=armscii8 <?php if ((!empty($v_charset)) && ( $v_charset == 'armscii8')) echo 'selected'; ?>>armscii8</option>
							<option value=utf8 <?php if ((!empty($v_charset)) && ( $v_charset == 'utf8')) echo 'selected'; ?>>utf8</option>
							<option value=utf8mb4 <?php if ((!empty($v_charset)) && ( $v_charset == 'utf8mb4')) echo 'selected'; ?> <?php if (empty($v_charset)) echo 'selected'; ?>>utf8mb4</option>
							<option value=ucs2 <?php if ((!empty($v_charset)) && ( $v_charset == 'ucs2')) echo 'selected'; ?>>ucs2</option>
							<option value=cp866 <?php if ((!empty($v_charset)) && ( $v_charset == 'cp866')) echo 'selected'; ?>>cp866</option>
							<option value=keybcs2 <?php if ((!empty($v_charset)) && ( $v_charset == 'keybcs2')) echo 'selected'; ?>>keybcs2</option>
							<option value=macce <?php if ((!empty($v_charset)) && ( $v_charset == 'macce')) echo 'selected'; ?>>macce</option>
							<option value=macroman <?php if ((!empty($v_charset)) && ( $v_charset == 'macroman')) echo 'selected'; ?>>macroman</option>
							<option value=cp852 <?php if ((!empty($v_charset)) && ( $v_charset == 'cp852')) echo 'selected'; ?>>cp852</option>
							<option value=latin7 <?php if ((!empty($v_charset)) && ( $v_charset == 'latin7')) echo 'selected'; ?>>latin7</option>
							<option value=cp1251 <?php if ((!empty($v_charset)) && ( $v_charset == 'cp1251')) echo 'selected'; ?>>cp1251</option>
							<option value=cp1256 <?php if ((!empty($v_charset)) && ( $v_charset == 'cp1256')) echo 'selected'; ?>>cp1256</option>
							<option value=cp1257 <?php if ((!empty($v_charset)) && ( $v_charset == 'cp1257')) echo 'selected'; ?>>cp1257</option>
							<option value=binary <?php if ((!empty($v_charset)) && ( $v_charset == 'binary')) echo 'selected'; ?>>binary</option>
							<option value=geostd8 <?php if ((!empty($v_charset)) && ( $v_charset == 'geostd8')) echo 'selected'; ?>>geostd8</option>
							<option value=cp932 <?php if ((!empty($v_charset)) && ( $v_charset == 'cp932')) echo 'selected'; ?>>cp932</option>
							<option value=eucjpms <?php if ((!empty($v_charset)) && ( $v_charset == 'eucjpms')) echo 'selected'; ?>>eucjpms</option>
						</select>
					</div>
				</div>
			<?php } ?>
		</div>

	</form>

</div>
