<!-- Begin toolbar -->
<div class="toolbar sticky top-14 z-20 border-y border-slate-200 bg-white">
	<div class="toolbar-inner mx-auto flex w-full min-w-0 flex-wrap items-center justify-between gap-3 px-4 py-3 md:px-6">
		<div class="toolbar-buttons flex flex-wrap items-center gap-2">
			<a class="button button-secondary button-back js-button-back inline-flex min-h-9 items-center justify-center gap-1.5 rounded-lg border border-blue-600 bg-blue-600 px-4 py-1.5 text-sm font-semibold text-white hover:bg-blue-700 disabled:cursor-not-allowed disabled:opacity-50 border-slate-300! bg-white! text-slate-700! hover:bg-slate-50!" href="/list/mail/">
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
			hasSmtpRelay: <?= tohtml($v_smtp_relay == "true" ? "true" : "false") ?>,
			dkimEnabled: <?= tohtml(empty($v_dkim) || $v_dkim == "yes" ? "true" : "false") ?>
		}"
		id="main-form"
		name="v_add_mail"
		method="post"
	>
		<input type="hidden" name="token" value="<?= tohtml($_SESSION["token"]) ?>">
		<input type="hidden" name="ok" value="Add">

		<div class="form-container mx-auto w-full max-w-2xl py-6">
			<h1 class="u-mb20 mb-[20px]"><?= tohtml( _("Add Mail Domain")) ?></h1>
			<?php show_alert_message($_SESSION); ?>
			<?php if ($_SESSION["role"] == "admin" && $accept !== "true") { ?>
				<div class="alert alert-danger mb-4 rounded-lg border p-4 text-sm [&_a]:underline [&_i]:mr-2 border-red-200 bg-red-50 text-red-800" role="alert">
					<i class="fas fa-exclamation"></i>
						<p><?= htmlify_trans(
     	sprintf(
     		_("It is strongly advised to {create a standard user account} before adding %s to the server due to the increased privileges the admin account possesses and potential security risks."),
     		_("a mail domain"),
     	),
     	"</a>",
     	'<a href="/add/user/">',
     ) ?></p>
				</div>
			<?php } ?>
			<?php if ($_SESSION["role"] == "admin" && empty($accept)) { ?>
				<div class="u-side-by-side u-mt20 flex flex-wrap items-center gap-2 mt-[20px]">
					<a href="/add/user/" class="button u-width-full u-mr10 inline-flex min-h-9 items-center justify-center gap-1.5 rounded-lg border border-blue-600 bg-blue-600 px-4 py-1.5 text-sm font-semibold text-white hover:bg-blue-700 disabled:cursor-not-allowed disabled:opacity-50 mr-[10px] w-full"><?= tohtml( _("Add User")) ?></a>
					<a href="/add/mail/?<?= tohtml(http_build_query(["accept" => 'true'])) ?>" class="button button-danger u-width-full u-ml10 inline-flex min-h-9 items-center justify-center gap-1.5 rounded-lg border border-blue-600 bg-blue-600 px-4 py-1.5 text-sm font-semibold text-white hover:bg-blue-700 disabled:cursor-not-allowed disabled:opacity-50 border-red-200! bg-white! text-red-700! hover:bg-red-50! ml-[10px] w-full"><?= tohtml( _("Continue")) ?></a>
				</div>
			<?php } ?>
			<?php if (($_SESSION["role"] == "admin" && $accept === "true") || $_SESSION["role"] !== "admin") { ?>
				<div class="u-mb20 mb-[20px]">
					<label for="v_domain" class="form-label mb-1 block text-sm font-semibold text-slate-700"><?= tohtml( _("Domain")) ?></label>
					<input type="text" class="form-control block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-2 focus:outline-blue-200 disabled:bg-slate-100 disabled:text-slate-500" name="v_domain" id="v_domain" value="<?= tohtml(trim($v_domain, "'")) ?>" required>
				</div>
				<?php if ($_SESSION["WEBMAIL_SYSTEM"]) { ?>
					<div class="u-mb20 mb-[20px]">
						<label for="v_webmail" class="form-label mb-1 block text-sm font-semibold text-slate-700"><?= tohtml( _("Webmail Client")) ?></label>
						<select class="form-select block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 disabled:bg-slate-100" name="v_webmail" id="v_webmail" tabindex="6">
							<?php foreach ($webmail_clients as $client) {
       	echo "\t\t\t\t<option value=\"" . htmlentities($client) . "\"";
       	if ($v_webmail == $client) {
       		echo " selected";
       	}
       	echo ">" . htmlentities(ucfirst($client)) . "</option>\n";
       } ?>
							<option value="" <?php if (empty($v_webmail) || $v_webmail == "disabled") {
       	echo "selected";
       } ?>><?= tohtml( _("Disabled")) ?></option>
						</select>
					</div>
				<?php } ?>
				<?php if (!empty($_SESSION["ANTISPAM_SYSTEM"])) { ?>
					<div class="form-check u-mb10 flex items-center gap-2 mb-[10px]">
						<input class="form-check-input accent-blue-600" type="checkbox" name="v_antispam" id="v_antispam" <?php if (empty($v_antispam) || $v_antispam == "yes") {
      	echo "checked";
      } ?>>
						<label for="v_antispam">
							<?= tohtml( _("Spam Filter")) ?>
						</label>
					</div>
					<div class="form-check u-mb10 flex items-center gap-2 mb-[10px]">
						<input class="form-check-input accent-blue-600" type="checkbox" name="v_reject" id="v_reject" <?php if (empty($v_reject) || $v_reject == "yes") {
      	echo "checked";
      } ?>>
						<label for="v_reject">
							<?= tohtml( _("Reject Spam")) ?>
						</label>
					</div>
				<?php } ?>
				<?php if (!empty($_SESSION["ANTIVIRUS_SYSTEM"])) { ?>
					<div class="form-check u-mb10 flex items-center gap-2 mb-[10px]">
						<input class="form-check-input accent-blue-600" type="checkbox" name="v_antivirus" id="v_antivirus" <?php if (empty($v_antivirus) || $v_antivirus == "yes") {
      	echo "checked";
      } ?>>
						<label for="v_antivirus">
							<?= tohtml( _("Anti-Virus")) ?>
						</label>
					</div>
				<?php } ?>
				<div class="form-check u-mb10 flex items-center gap-2 mb-[10px]">
					<input x-model="dkimEnabled" class="form-check-input accent-blue-600" type="checkbox" name="v_dkim" id="v_dkim" <?php if (empty($v_dkim) || $v_dkim == "yes") {
     	echo "checked";
     } ?>>
					<label for="v_dkim">
						<?= tohtml( _("DKIM Support")) ?>
					</label>
				</div>
				<div x-cloak x-show="dkimEnabled" class="u-pl30 u-mb10 pl-[30px] mb-[10px]">
					<label for="v_dkim_selector" class="form-label mb-1 block text-sm font-semibold text-slate-700">
						DKIM Selector <span class="optional text-xs font-normal text-slate-500">(<?= _("Use a-z, 0-9, hyphen; no leading, trailing or consecutive hyphens") ?>)</span>
					</label>
					<input type="text" class="form-control block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-2 focus:outline-blue-200 disabled:bg-slate-100 disabled:text-slate-500" name="v_dkim_selector" id="v_dkim_selector" value="<?= tohtml(empty($v_dkim_selector) ? "mail" : trim($v_dkim_selector, "'")) ?>">
				</div>
				<div class="form-check u-mb10 flex items-center gap-2 mb-[10px]">
					<input x-model="hasSmtpRelay" class="form-check-input accent-blue-600" type="checkbox" name="v_smtp_relay" id="v_smtp_relay">
					<label for="v_smtp_relay">
						<?= tohtml( _("SMTP Relay")) ?>
					</label>
				</div>
				<div x-cloak x-show="hasSmtpRelay" id="smtp_relay_table" class="u-pl30 pl-[30px]">
					<div class="u-mb10 mb-[10px]">
						<label for="v_smtp_relay_host" class="form-label mb-1 block text-sm font-semibold text-slate-700"><?= tohtml( _("Host")) ?></label>
						<input type="text" class="form-control block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-2 focus:outline-blue-200 disabled:bg-slate-100 disabled:text-slate-500" name="v_smtp_relay_host" id="v_smtp_relay_host" value="<?= tohtml(trim($v_smtp_relay_host, "'")) ?>">
					</div>
					<div class="u-mb10 mb-[10px]">
						<label for="v_smtp_relay_port" class="form-label mb-1 block text-sm font-semibold text-slate-700"><?= tohtml( _("Port")) ?></label>
						<input type="text" class="form-control block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-2 focus:outline-blue-200 disabled:bg-slate-100 disabled:text-slate-500" name="v_smtp_relay_port" id="v_smtp_relay_port" value="<?= tohtml(trim($v_smtp_relay_port, "'")) ?>">
					</div>
					<div class="u-mb10 mb-[10px]">
						<label for="v_smtp_relay_user" class="form-label mb-1 block text-sm font-semibold text-slate-700"><?= tohtml( _("Username")) ?></label>
						<input type="text" class="form-control block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-2 focus:outline-blue-200 disabled:bg-slate-100 disabled:text-slate-500" name="v_smtp_relay_user" id="v_smtp_relay_user" value="<?= tohtml(trim($v_smtp_relay_user, "'")) ?>">
					</div>
					<div class="u-mb10 mb-[10px]">
						<label for="v_smtp_relay_pass" class="form-label mb-1 block text-sm font-semibold text-slate-700"><?= tohtml( _("Password")) ?></label>
						<input type="text" class="form-control block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-2 focus:outline-blue-200 disabled:bg-slate-100 disabled:text-slate-500" name="v_smtp_relay_pass" id="v_smtp_relay_pass">
					</div>
				</div>
			<?php } ?>
		</div>

	</form>

</div>
