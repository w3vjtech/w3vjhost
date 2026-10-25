<!-- Begin toolbar -->
<div class="toolbar sticky top-14 z-20 border-y border-slate-200 bg-white">
	<div class="toolbar-inner mx-auto flex w-full min-w-0 flex-wrap items-center justify-between gap-3 px-4 py-3 md:px-6">
		<div class="toolbar-buttons flex flex-wrap items-center gap-2">
			<a class="button button-secondary button-back js-button-back inline-flex min-h-9 items-center justify-center gap-1.5 rounded-lg border border-blue-600 bg-blue-600 px-4 py-1.5 text-sm font-semibold text-white hover:bg-blue-700 disabled:cursor-not-allowed disabled:opacity-50 border-slate-300! bg-white! text-slate-700! hover:bg-slate-50!" href="/list/user/">
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

	<form
		x-data="{
			loginDisabled: <?= tohtml($v_login_disabled == "yes" ? "true" : "false") ?>
		}"
		id="main-form"
		name="v_add_user"
		method="post"
	>
		<input type="hidden" name="token" value="<?= tohtml($_SESSION["token"]) ?>">
		<input type="hidden" name="ok" value="Add">

		<div class="form-container mx-auto w-full max-w-2xl py-6">
			<h1 class="u-mb20 mb-[20px]"><?= tohtml( _("Add User")) ?></h1>
			<?php show_alert_message($_SESSION); ?>
			<div class="u-mb10 mb-[10px]">
				<label for="v_username" class="form-label mb-1 block text-sm font-semibold text-slate-700"><?= tohtml( _("Username")) ?></label>
				<input type="text" class="form-control block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-2 focus:outline-blue-200 disabled:bg-slate-100 disabled:text-slate-500" name="v_username" id="v_username" value="<?= tohtml(trim($v_username, "'")) ?>" tabindex="1" required>
			</div>
			<div class="u-mb10 mb-[10px]">
				<label for="v_name" class="form-label mb-1 block text-sm font-semibold text-slate-700"><?= tohtml( _("Contact Name")) ?></label>
				<input type="text" class="form-control block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-2 focus:outline-blue-200 disabled:bg-slate-100 disabled:text-slate-500" name="v_name" id="v_name" value="<?= tohtml(trim($v_name, "'")) ?>" tabindex="2" required>
			</div>
			<div class="u-mb10 mb-[10px]">
				<label for="v_email" class="form-label mb-1 block text-sm font-semibold text-slate-700"><?= tohtml( _("Email")) ?></label>
				<input type="email" class="form-control js-sync-email-input block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-2 focus:outline-blue-200 disabled:bg-slate-100 disabled:text-slate-500" name="v_email" id="v_email" value="<?= tohtml(trim($v_email, "'")) ?>" tabindex="3" required>
			</div>
			<div class="u-mb10 mb-[10px]">
				<label for="v_password" class="form-label mb-1 block text-sm font-semibold text-slate-700">
					<?= tohtml( _("Password")) ?>
					<button type="button" title="<?= tohtml( _("Generate")) ?>" class="u-unstyled-button u-ml5 js-generate-password ml-[5px] border-0 bg-transparent p-0">
						<i class="fas fa-arrows-rotate icon-green text-green-700"></i>
					</button>
				</label>
				<div class="u-pos-relative u-mb10 mb-[10px] relative">
					<input type="text" class="form-control js-password-input block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-2 focus:outline-blue-200 disabled:bg-slate-100 disabled:text-slate-500" name="v_password" id="v_password" value="<?= tohtml(trim($v_password, "'")) ?>" tabindex="4" required>
					<div class="password-meter relative">
						<meter max="4" class="password-meter-input js-password-meter pr-10"></meter>
					</div>
				</div>
			</div>
			<?php require $_SERVER["HESTIA"] . "/web/templates/includes/password-requirements.php"; ?>
			<div class="form-check flex items-center gap-2">
				<input x-model="loginDisabled" class="form-check-input accent-blue-600" type="checkbox" name="v_login_disabled" id="v_login_disabled">
				<label for="v_login_disabled">
					<?= tohtml( _("Do not allow user to log in to Control Panel")) ?>
				</label>
			</div>
			<div x-cloak x-show="!loginDisabled" id="send-welcome">
				<div class="form-check u-mb10 flex items-center gap-2 mb-[10px]">
					<input class="form-check-input js-sync-email-checkbox accent-blue-600" type="checkbox" name="v_email_notice" id="v_email_notify" tabindex="5">
					<label for="v_email_notify">
						<?= tohtml( _("Send welcome email")) ?>
					</label>
				</div>
			</div>
			<div class="u-mb10 mb-[10px]">
				<label for="v_language" class="form-label mb-1 block text-sm font-semibold text-slate-700"><?= tohtml( _("Language")) ?></label>
				<select class="form-select block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 disabled:bg-slate-100" name="v_language" id="v_language" tabindex="6" required>
					<?php
						foreach ($languages as $key => $value) {
							echo "\n\t\t\t\t\t\t\t\t\t<option value=\"".htmlentities($key)."\"";
							if (( $key == $_SESSION['LANGUAGE'] ) && (empty($v_language))){
								echo ' selected' ;
							}
							if (isset($v_language)){
								if ( htmlentities($key) == trim($v_language,"'") ){
									echo ' selected' ;
								}
							}
							echo ">".htmlentities($value)."</option>\n";
						}
					?>
				</select>
			</div>
			<div class="u-mb10 mb-[10px]">
				<label for="v_role" class="form-label mb-1 block text-sm font-semibold text-slate-700"><?= tohtml( _("Role")) ?></label>
				<select class="form-select block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 disabled:bg-slate-100" name="v_role" id="v_role" required>
					<option value="user"><?= tohtml( _("User")) ?></option>
					<option value="admin" <?= tohtml($v_role == "admin" ? "selected" : "") ?>><?= tohtml( _("Administrator")) ?></option>
					<option value="dns-cluster" <?= tohtml($v_role == "dns-cluster" ? "selected" : "") ?>><?= tohtml( _("DNS Sync User")) ?></option>
				</select>
			</div>
			<div class="u-mb10 mb-[10px]">
				<label for="v_package" class="form-label mb-1 block text-sm font-semibold text-slate-700"><?= tohtml( _("Package")) ?></label>
				<select class="form-select block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 disabled:bg-slate-100" name="v_package" id="v_package" tabindex="8" required>
					<?php
						foreach ($data as $key => $value) {
							echo "\n\t\t\t\t\t\t\t\t\t\t\t\t\t<option value=\"".htmlentities($key)."\"";
							if ((!empty($v_package)) && ( $key == $_POST['v_package'])){
								echo 'selected' ;
							} else {
								if ( $key == 'default'){
									echo 'selected' ;
								}
							}
							echo ">".htmlentities($key)."</option>\n";
						}
					?>
				</select>
			</div>
			<div class="u-mb10 mb-[10px]">
				<label for="v_notify" class="form-label mb-1 block text-sm font-semibold text-slate-700">
					<?= tohtml( _("Email login credentials to:")) ?>
				</label>
				<input type="email" class="form-control js-sync-email-output block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-2 focus:outline-blue-200 disabled:bg-slate-100 disabled:text-slate-500" name="v_notify" id="v_notify" value="<?= tohtml(trim($v_notify, "'")) ?>" tabindex="8">
			</div>
		</div>

	</form>

</div>
