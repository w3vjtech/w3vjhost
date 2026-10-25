<!-- Begin toolbar -->
<div class="toolbar sticky top-14 z-20 border-y border-slate-200 bg-white">
	<div class="toolbar-inner mx-auto flex w-full min-w-0 flex-wrap items-center justify-between gap-3 px-4 py-3 md:px-6">
		<div class="toolbar-buttons flex flex-wrap items-center gap-2">
			<a class="button button-secondary button-back js-button-back inline-flex min-h-9 items-center justify-center gap-1.5 rounded-lg border border-blue-600 bg-blue-600 px-4 py-1.5 text-sm font-semibold text-white hover:bg-blue-700 disabled:cursor-not-allowed disabled:opacity-50 border-slate-300! bg-white! text-slate-700! hover:bg-slate-50!" href="/list/mail/?<?= tohtml(http_build_query(["domain" => trim($v_domain, "'"), "token" => $_SESSION["token"]])) ?>">
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
			hasAutoReply: <?= tohtml($v_autoreply == "yes" ? "true" : "false") ?>
		}"
		id="main-form"
		name="v_edit_mail_acc"
		method="post"
		class="<?= tohtml($v_status) ?>"
	>
		<input type="hidden" name="token" value="<?= tohtml($_SESSION["token"]) ?>">
		<input type="hidden" name="save" value="save">

		<div class="form-container form-container-wide mx-auto w-full max-w-2xl py-6 max-w-5xl">
			<h1 class="u-mb20 mb-[20px]"><?= tohtml( _("Edit Mail Account")) ?></h1>
			<?php show_alert_message($_SESSION); ?>
			<div class="sidebar-right-grid grid gap-6 lg:grid-cols-[minmax(0,1fr)_280px]">
				<div class="sidebar-right-grid-content">
					<div class="u-mb10 mb-[10px]">
						<label for="v_email" class="form-label mb-1 block text-sm font-semibold text-slate-700"><?= tohtml( _("Account")) ?></label>
						<input type="text" class="form-control block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-2 focus:outline-blue-200 disabled:bg-slate-100 disabled:text-slate-500" name="v_email" id="v_email" value="<?= tohtml($_GET["account"] . "@" . $_GET["domain"]) ?>" disabled>
						<input type="hidden" name="v_domain" value="<?= tohtml(trim($v_domain, "'")) ?>">
						<input type="hidden" name="v_account" value="<?= tohtml(trim($v_account, "'")) ?>" class="js-account-input">
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
					<p class="u-mb10 mb-[10px]"><?= tohtml( _("Your password must have at least")) ?>:</p>
					<ul class="u-list-bulleted u-mb20 mb-[20px] list-disc pl-8">
						<li><?= tohtml( _("8 characters long")) ?></li>
						<li><?= tohtml( _("1 uppercase & 1 lowercase character")) ?></li>
						<li><?= tohtml( _("1 number")) ?></li>
					</ul>
					<div class="u-mb10 mb-[10px]">
						<label for="v_send_email" class="form-label mb-1 block text-sm font-semibold text-slate-700">
							<?= tohtml( _("Email login credentials to:")) ?>
						</label>
						<input type="email" class="form-control block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-2 focus:outline-blue-200 disabled:bg-slate-100 disabled:text-slate-500" name="v_send_email" id="v_send_email" value="<?= tohtml(trim($v_send_email, "'")) ?>">
					</div>
					<div class="u-mb10 mb-[10px]">
						<label for="v_quota" class="form-label mb-1 block text-sm font-semibold text-slate-700">
							<?= tohtml( _("Quota")) ?> <span class="optional text-xs font-normal text-slate-500">(<?= tohtml( _("in MB")) ?>)</span>
						</label>
						<div class="u-pos-relative relative">
							<input type="text" class="form-control block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-2 focus:outline-blue-200 disabled:bg-slate-100 disabled:text-slate-500" name="v_quota" id="v_quota" value="<?php if (!empty($v_quota)) {echo htmlentities(trim($v_quota, "'"));} else { echo "0"; } ?>">
							<button type="button" class="unlimited-toggle js-unlimited-toggle absolute top-2 right-3 cursor-pointer text-slate-600" title="<?= tohtml( _("Unlimited")) ?>">
								<i class="fas fa-infinity"></i>
							</button>
						</div>
					</div>
					<div class="u-mb10 mb-[10px]">
						<label for="v_aliases" class="form-label mb-1 block text-sm font-semibold text-slate-700">
							<?= tohtml( _("Aliases")) ?> <span class="optional text-xs font-normal text-slate-500">(<?= tohtml( _("Use local-part without domain name")) ?>)</span>
						</label>
						<textarea class="form-control block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-2 focus:outline-blue-200 disabled:bg-slate-100 disabled:text-slate-500" name="v_aliases" id="v_aliases"><?= tohtml(trim($v_aliases, "'")) ?></textarea>
					</div>
					<div class="form-check flex items-center gap-2">
						<input class="form-check-input js-discard-all-mail accent-blue-600" type="checkbox" name="v_blackhole" id="v_blackhole" <?php if ($v_blackhole == 'yes') echo 'checked' ?>>
						<label for="v_blackhole">
							<?= tohtml( _("Discard all mail")) ?>
						</label>
					</div>
					<div class="form-check <?php if ($v_blackhole == 'yes') { echo 'u-hidden'; } ?> flex items-center gap-2">
						<input class="form-check-input js-do-not-store-checkbox accent-blue-600" type="checkbox" name="v_fwd_only" id="v_fwd_for" <?php if ($v_fwd_only == 'yes') echo 'checked' ?>>
						<label for="v_fwd_for">
							<?= tohtml( _("Do not store forwarded mail")) ?>
						</label>
					</div>
					<div class="u-mb10 mb-[10px]">
						<label for="v_fwd" class="form-label mb-1 block text-sm font-semibold text-slate-700">
							<?= tohtml( _("Forward to")) ?> <span class="optional text-xs font-normal text-slate-500">(<?= tohtml( _("one or more email addresses")) ?>)</span>
						</label>
						<textarea class="form-control js-forward-to-textarea block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-2 focus:outline-blue-200 disabled:bg-slate-100 disabled:text-slate-500" name="v_fwd" id="v_fwd" <?php if ($v_blackhole == 'yes') echo "disabled"; ?>><?= tohtml(trim($v_fwd, "'")) ?></textarea>
					</div>
					<div class="form-check u-mb10 flex items-center gap-2 mb-[10px]">
						<input x-model="hasAutoReply" class="form-check-input accent-blue-600" type="checkbox" name="v_autoreply" id="v_autoreply">
						<label for="v_autoreply">
							<?= tohtml( _("Auto Reply")) ?>
						</label>
					</div>
					<div x-cloak x-show="hasAutoReply" id="autoreplytable">
						<div class="u-mb10 mb-[10px]">
							<label for="v_autoreply_message" class="form-label mb-1 block text-sm font-semibold text-slate-700"><?= tohtml( _("Message")) ?></label>
							<textarea class="form-control block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-2 focus:outline-blue-200 disabled:bg-slate-100 disabled:text-slate-500" name="v_autoreply_message" id="v_autoreply_message"><?= tohtml(trim($v_autoreply_message, "'")) ?></textarea>
						</div>
					</div>
					<div class="u-mb20 mb-[20px]">
						<label for="v_rate" class="form-label mb-1 block text-sm font-semibold text-slate-700">
							<?= tohtml( _("Rate Limit")) ?> <span class="optional text-xs font-normal text-slate-500">(<?= tohtml( _("email / hour")) ?>)</span>
						</label>
						<input type="text" class="form-control block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-2 focus:outline-blue-200 disabled:bg-slate-100 disabled:text-slate-500" name="v_rate" id="v_rate" value="<?= tohtml(trim($v_rate, "'")) ?>" <?php if ($_SESSION['userContext'] != "admin"){ echo "disabled"; }?>>
					</div>
				</div>
				<div class="sidebar-right-grid-sidebar">
					<?php require $_SERVER["HESTIA"] . "/web/templates/includes/email-settings-panel.php"; ?>
				</div>
			</div>
		</div>

	</form>

</div>
