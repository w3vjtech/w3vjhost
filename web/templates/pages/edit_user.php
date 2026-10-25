<!-- Begin toolbar -->
<div class="toolbar sticky top-14 z-20 border-y border-slate-200 bg-white">
	<div class="toolbar-inner mx-auto flex w-full min-w-0 flex-wrap items-center justify-between gap-3 px-4 py-3 md:px-6">
		<div class="toolbar-buttons flex flex-wrap items-center gap-2">
			<a class="button button-secondary button-back js-button-back inline-flex min-h-9 items-center justify-center gap-1.5 rounded-lg border border-blue-600 bg-blue-600 px-4 py-1.5 text-sm font-semibold text-white hover:bg-blue-700 disabled:cursor-not-allowed disabled:opacity-50 border-slate-300! bg-white! text-slate-700! hover:bg-slate-50!" href="/list/user/">
				<i class="fas fa-arrow-left icon-blue text-blue-700"></i><?= tohtml( _("Back")) ?>
			</a>
			<?php
				if (($_SESSION['userContext'] === 'admin') && ($_SESSION['look'] === '' ) && ($_SESSION['user'] !== $v_username)) {
					$ssh_key_url = "/list/key/?user=".htmlentities($_GET['user'])."&token=".$_SESSION['token']."";
					$log_url = "/list/log/?user=".htmlentities($_GET['user'])."&token=".$_SESSION['token']."";
					$keys_url = "/list/access-key/?user=".htmlentities($_GET['user'])."&token=".$_SESSION['token']."";
				}else{
					$ssh_key_url = "/list/key/";
					$log_url = "/list/log/";
					$keys_url = "/list/access-key/";
				}
			?>
			<a href="<?= tohtml($ssh_key_url) ?>" class="button button-secondary js-button-create inline-flex min-h-9 items-center justify-center gap-1.5 rounded-lg border border-blue-600 bg-blue-600 px-4 py-1.5 text-sm font-semibold text-white hover:bg-blue-700 disabled:cursor-not-allowed disabled:opacity-50 border-slate-300! bg-white! text-slate-700! hover:bg-slate-50!" title="<?= tohtml( _("Manage SSH Keys")) ?>">
				<i class="fas fa-key icon-orange text-amber-700"></i><?= tohtml( _("Manage SSH Keys")) ?>
			</a>
			<?php if ($_SESSION["userContext"] == "admin" || ($_SESSION["userContext"] !== "admin" && $_SESSION["POLICY_USER_VIEW_LOGS"] !== "no")) { ?>
				<a href="<?= tohtml($log_url) ?>" class="button button-secondary js-button-create inline-flex min-h-9 items-center justify-center gap-1.5 rounded-lg border border-blue-600 bg-blue-600 px-4 py-1.5 text-sm font-semibold text-white hover:bg-blue-700 disabled:cursor-not-allowed disabled:opacity-50 border-slate-300! bg-white! text-slate-700! hover:bg-slate-50!" title="<?= tohtml( _("Logs")) ?>">
					<i class="fas fa-clock-rotate-left icon-maroon text-pink-700"></i><?= tohtml( _("Logs")) ?>
				</a>
			<?php } ?>
			<?php
				$api_status = (!empty($_SESSION['API_SYSTEM']) && is_numeric($_SESSION['API_SYSTEM'])) ? $_SESSION['API_SYSTEM'] : 0;
				if (($v_username == $_SESSION['ROOT_USER'] && $api_status > 0) || ($v_username != $_SESSION['ROOT_USER'] && $api_status > 1)) { ?>
				<a href="<?= tohtml($keys_url) ?>" class="button button-secondary js-button-create inline-flex min-h-9 items-center justify-center gap-1.5 rounded-lg border border-blue-600 bg-blue-600 px-4 py-1.5 text-sm font-semibold text-white hover:bg-blue-700 disabled:cursor-not-allowed disabled:opacity-50 border-slate-300! bg-white! text-slate-700! hover:bg-slate-50!" title="<?= tohtml( _("Access Keys")) ?>">
					<i class="fas fa-key icon-purple text-purple-700"></i><?= tohtml( _("Access Keys")) ?>
				</a>
			<?php } ?>
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
			loginDisabled: <?= tohtml($v_login_disabled === "yes" ? "true" : "false") ?>,
			useIpAllowList: <?= tohtml($v_login_use_iplist === "yes" ? "true" : "false") ?>,
			showAdvanced: false,
		}"
		id="main-form"
		method="post"
		name="v_edit_user"
		class="<?= tohtml($v_status) ?>"
	>
		<input type="hidden" name="token" value="<?= tohtml($_SESSION["token"]) ?>">
		<input type="hidden" name="save" value="save">

		<div class="form-container mx-auto w-full max-w-2xl py-6">
			<h1 class="u-mb20 mb-[20px]"><?= tohtml( _("Edit User")) ?></h1>
			<?php show_alert_message($_SESSION); ?>
			<div class="u-mb10 mb-[10px]">
				<label for="v_user" class="form-label mb-1 block text-sm font-semibold text-slate-700"><?= tohtml( _("Username")) ?></label>
				<input type="text" class="form-control block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-2 focus:outline-blue-200 disabled:bg-slate-100 disabled:text-slate-500" name="v_user" id="v_user" value="<?= tohtml(trim($v_username, "'")) ?>" disabled required>
				<input type="hidden" name="v_username" value="<?= tohtml(trim($v_username, "'")) ?>">
			</div>
			<div class="u-mb10 mb-[10px]">
				<label for="v_name" class="form-label mb-1 block text-sm font-semibold text-slate-700"><?= tohtml( _("Contact Name")) ?></label>
				<input type="text" class="form-control block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-2 focus:outline-blue-200 disabled:bg-slate-100 disabled:text-slate-500" name="v_name" id="v_name" value="<?= tohtml(trim($v_name, "'")) ?>" <?php if (($_SESSION['userContext'] !=='admin' ) && ($_SESSION['POLICY_USER_EDIT_DETAILS'] !=='yes' )) { echo 'disabled' ; }?> required>
				<?php if (($_SESSION['userContext'] !== 'admin') && ($_SESSION['POLICY_USER_EDIT_DETAILS'] !== 'yes')) { ?>
					<input type="hidden" name="v_name" value="<?= tohtml(trim($v_name, "'")) ?>">
				<?php } ?>
			</div>
			<div class="u-mb10 mb-[10px]">
				<label for="v_email" class="form-label mb-1 block text-sm font-semibold text-slate-700"><?= tohtml( _("Email")) ?></label>
				<input type="email" class="form-control block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-2 focus:outline-blue-200 disabled:bg-slate-100 disabled:text-slate-500" name="v_email" id="v_email" value="<?= tohtml(trim($v_email, "'")) ?>" <?php if (($_SESSION['userContext'] !=='admin' ) && ($_SESSION['POLICY_USER_EDIT_DETAILS'] !=='yes' )) { echo 'disabled' ; }?> required>
				<?php if (($_SESSION['userContext'] !== 'admin') && ($_SESSION['POLICY_USER_EDIT_DETAILS'] !== 'yes')) { ?>
					<input type="hidden" name="v_email" value="<?= tohtml(trim($v_email, "'")) ?>">
				<?php } ?>
			</div>
			<div class="u-mb10 mb-[10px]">
				<label for="v_password" class="form-label mb-1 block text-sm font-semibold text-slate-700">
					<?= tohtml( _("Password")) ?>
					<button type="button" title="<?= tohtml( _("Generate")) ?>" class="u-unstyled-button u-ml5 js-generate-password ml-[5px] border-0 bg-transparent p-0">
						<i class="fas fa-arrows-rotate icon-green text-green-700"></i>
					</button>
				</label>
				<div class="u-pos-relative u-mb10 mb-[10px] relative">
					<input type="text" class="form-control js-password-input block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-2 focus:outline-blue-200 disabled:bg-slate-100 disabled:text-slate-500" name="v_password" id="v_password" value="<?= tohtml(trim($v_password, "'")) ?>">
					<div class="password-meter relative">
						<meter max="4" class="password-meter-input js-password-meter pr-10"></meter>
					</div>
				</div>
			</div>
			<div id="password-details" class="u-mb20 mb-[20px]">
				<?php require $_SERVER["HESTIA"] . "/web/templates/includes/password-requirements.php"; ?>
				<?php if ($_SESSION["userContext"] === "admin") { ?>
					<div class="form-check flex items-center gap-2">
						<input x-model="loginDisabled" class="form-check-input accent-blue-600" type="checkbox" name="v_login_disabled" id="v_login_disabled">
						<label for="v_login_disabled">
							<?= tohtml( _("Do not allow user to log in to Control Panel")) ?>
						</label>
					</div>
				<?php } ?>
				<div x-cloak x-show="!loginDisabled" id="password-options">
					<div class="form-check flex items-center gap-2">
						<input class="form-check-input accent-blue-600" type="checkbox" name="v_twofa" id="v_twofa" <?php if (!empty($v_twofa)) echo 'checked' ?>>
						<label for="v_twofa">
							<?= tohtml( _("Enable two-factor authentication")) ?>
						</label>
					</div>
					<?php if (!empty($v_twofa)) { ?>
						<p class="u-mb10 mb-[10px]"><?= tohtml( _("Account Recovery Code") . ": " . $v_twofa) ?></p>
						<p class="u-mb10 mb-[10px]"><?= tohtml( _("Please scan the code below in your 2FA application")) ?>:</p>
						<div class="u-mb10 mb-[10px]">
							<img class="qr-code rounded-lg border border-slate-200" src="<?= tohtml($v_qrcode) ?>" alt="<?= tohtml( _("2FA QR Code")) ?>">
						</div>
					<?php } ?>
				</div>
				<div x-cloak x-show="!loginDisabled" id="password-options-ip">
					<div class="form-check flex items-center gap-2">
						<input x-model="useIpAllowList" class="form-check-input accent-blue-600" type="checkbox" name="v_login_use_iplist" id="v_login_use_iplist">
						<label for="v_login_use_iplist">
							<?= tohtml( _("Use IP address allow list for login attempts")) ?>
						</label>
					</div>
				</div>
				<div x-cloak x-show="useIpAllowList" id="ip-allowlist" class="u-mt10 mt-[10px]">
					<input type="text" class="form-control block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-2 focus:outline-blue-200 disabled:bg-slate-100 disabled:text-slate-500" name="v_login_allowed_ips" value="<?= tohtml(trim($v_login_allowed_ips, "'")) ?>" placeholder="<?= tohtml( _("For example")) ?>: 127.0.0.1,192.168.1.100">
				</div>
			</div>
			<div class="u-mb10 mb-[10px]">
				<label for="v_language" class="form-label mb-1 block text-sm font-semibold text-slate-700"><?= tohtml( _("Language")) ?></label>
				<select class="form-select block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 disabled:bg-slate-100" name="v_language" id="v_language" required>
					<?php
						foreach ($languages as $key => $value) {
							echo "\n\t\t\t\t\t\t\t\t\t<option value=\"".$key."\"";
							$skey = "'".$key."'";
							if (( $key == $v_language ) || ( $skey == $v_language)){
								echo 'selected' ;
							}
							if (( $key == detect_user_language() ) && (empty($v_language))){
								echo 'selected' ;
							}
							echo ">".htmlentities($value)."</option>\n";
						}
					?>
				</select>
			</div>
			<?php if ($v_username != $_SESSION["ROOT_USER"] && $_SESSION["userContext"] === "admin" && $_SESSION["user"] != $v_username): ?>
				<div class="u-mb10 mb-[10px]">
					<label for="v_role" class="form-label mb-1 block text-sm font-semibold text-slate-700"><?= tohtml( _("Role")) ?></label>
					<select class="form-select block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 disabled:bg-slate-100" name="v_role" id="v_role" required>
						<option value="user"><?= tohtml( _("User")) ?></option>
						<option value="admin" <?= tohtml($v_role == "admin" ? "selected" : "") ?>><?= tohtml( _("Administrator")) ?></option>
						<option value="dns-cluster" <?= tohtml($v_role == "dns-cluster" ? "selected" : "") ?>><?= tohtml( _("DNS Sync User")) ?></option>
					</select>
				</div>
			<?php endif; ?>
			<?php if ($_SESSION["POLICY_USER_CHANGE_THEME"] !== "no") { ?>
			<div class="u-mb10 mb-[10px]">
				<label for="v_user_theme" class="form-label mb-1 block text-sm font-semibold text-slate-700"><?= tohtml( _("Theme")) ?></label>
				<select class="form-select block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 disabled:bg-slate-100" name="v_user_theme" id="v_user_theme">
					<?php
						foreach ($themes as $key => $value) {
							echo "\t\t\t\t<option value=\"".$value."\"";
							if ((!empty($_SESSION['userTheme'])) && ( $value == $v_user_theme )) {
								echo ' selected' ;
							}
							if ((empty($v_user_theme) && (!empty($_SESSION['THEME']))) && ( $value == $_SESSION['THEME'] )) {
								echo ' selected' ;
							}
							echo ">".$value."</option>\n";
						}
					?>
				</select>
			</div>
			<?php } ?>
				<div class="u-mb10 mb-[10px]">
					<label for="v_sort_order" class="form-label mb-1 block text-sm font-semibold text-slate-700"><?= tohtml( _("Default List Sort Order")) ?></label>
					<select class="form-select block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 disabled:bg-slate-100" name="v_sort_order" id="v_sort_order">
						<option value='date' <?php if ($v_sort_order === 'date') echo 'selected' ?>><?= tohtml( _("Date")) ?></option>
						<option value='name' <?php if ($v_sort_order === 'name') echo 'selected' ?>><?= tohtml( _("Name")) ?></option>
					</select>
				</div>
			<?php if ($_SESSION['userContext'] === 'admin') { ?>
				<div class="u-mb20 mb-[20px]">
					<label for="v_package" class="form-label mb-1 block text-sm font-semibold text-slate-700"><?= tohtml( _("Package")) ?></label>
					<select class="form-select block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 disabled:bg-slate-100" name="v_package" id="v_package" required>
						<?php
							foreach ($packages as $key => $value) {
								echo "\n\t\t\t\t\t\t\t\t\t<option value=\"".htmlentities($key)."\"";
								$skey = "'".$key."'";
								if (( $key == $v_package ) || ( $skey == $v_package)){
									echo 'selected' ;
								}
								echo ">".htmlentities($key)."</option>\n";
							}
						?>
					</select>
				</div>
				<div class="u-mb20 mb-[20px]">
					<button x-on:click="showAdvanced = !showAdvanced" type="button" class="button button-secondary inline-flex min-h-9 items-center justify-center gap-1.5 rounded-lg border border-blue-600 bg-blue-600 px-4 py-1.5 text-sm font-semibold text-white hover:bg-blue-700 disabled:cursor-not-allowed disabled:opacity-50 border-slate-300! bg-white! text-slate-700! hover:bg-slate-50!">
						<?= tohtml( _("Advanced Options")) ?>
					</button>
				</div>
				<div x-cloak x-show="showAdvanced">
					<div class="u-mb10 mb-[10px]">
						<label for="v_shell" class="form-label mb-1 block text-sm font-semibold text-slate-700"><?= tohtml( _("SSH Access")) ?></label>
						<select class="form-select block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 disabled:bg-slate-100" name="v_shell" id="v_shell">
							<?php
								foreach ($shells as $key => $value) {
									echo "\t\t\t\t<option value=\"".htmlentities($value)."\"";
									$svalue = "'".$value."'";
									if (( $value == $v_shell ) || ($svalue == $v_shell )){
										echo 'selected' ;
									}
									echo ">".htmlentities($value)."</option>\n";
								}
							?>
						</select>
					</div>
					<div class="u-mb10 mb-[10px]">
						<label for="v_phpcli" class="form-label mb-1 block text-sm font-semibold text-slate-700"><?= tohtml( _("PHP CLI Version")) ?></label>
						<select class="form-select block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 disabled:bg-slate-100" name="v_phpcli" id="v_phpcli">
							<?php
								foreach ($php_versions as $key => $value) {
									$php = explode('-',$value);
									echo "\t\t\t\t<option value=\"".$value."\"";
									$svalue = "'".$value."'";
									if ((!empty($v_phpcli)) && ( $value == $v_phpcli ) || ($svalue == $v_phpcli)){
										echo ' selected' ;
									}
									if ((empty($v_phpcli)) && ($value == DEFAULT_PHP_VERSION)){
										echo ' selected' ;
									}
									echo ">".htmlentities($value)."</option>\n";
								}
							?>
						</select>
					</div>
					<?php if ((isset($_SESSION['DNS_SYSTEM'])) && (!empty($_SESSION['DNS_SYSTEM']))) { ?>
						<p class="form-label u-mb10 mb-1 block text-sm font-semibold text-slate-700 mb-[10px]"><?= tohtml( _("Default Name Servers")) ?></p>
						<div class="u-mb5 mb-[5px]">
							<input type="text" class="form-control block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-2 focus:outline-blue-200 disabled:bg-slate-100 disabled:text-slate-500" name="v_ns1" value="<?= tohtml(trim($v_ns1, "'")) ?>">
						</div>
						<div class="u-mb5 mb-[5px]">
							<input type="text" class="form-control block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-2 focus:outline-blue-200 disabled:bg-slate-100 disabled:text-slate-500" name="v_ns2" value="<?= tohtml(trim($v_ns2, "'")) ?>">
						</div>
						<?php require $_SERVER["HESTIA"] . "/web/templates/includes/extra-ns-fields.php"; ?>
						<button type="button" data-remove-label="<?= tohtml(_("Remove")) ?>" class="form-link u-mt20 js-add-ns inline-flex items-center gap-1 rounded px-2 py-1 text-blue-700 hover:bg-blue-50 mt-[20px]" <?php if ($v_ns8) echo 'style="display:none;"'; ?>>
							<?= tohtml( _("Add Name Server")) ?>
						</button>
					<?php } ?>
				</div>
			<?php } ?>
		</div>

	</form>

</div>
