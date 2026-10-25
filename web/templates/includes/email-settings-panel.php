<div class="panel rounded-lg border border-slate-200 bg-white p-5 shadow-sm">
	<h2 class="u-text-H3 u-mb10 mb-[10px] text-base font-semibold"><?= _("Common Account Settings") ?></h2>
	<p class="u-mb10 mb-[10px]">
		<?= _("Connect to this account using credentials:") ?>
	</p>
	<div class="u-mb10 mb-[10px]">
		<label for="email_settings_username"><?= _("Username") ?></label>
		<div class="clipboard flex">
			<input type="text" class="form-control clipboard-input js-copy-input js-account-output block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-2 focus:outline-blue-200 disabled:bg-slate-100 disabled:text-slate-500" name="email_settings_username" id="email_settings_username" value="<?= htmlentities(trim($v_account, "'")) ?>@<?= htmlentities(trim($v_domain, "'")) ?>" data-postfix="@<?= htmlentities(trim($v_domain, "'")) ?>" readonly>
			<button type="button" class="clipboard-button js-copy-button rounded-r-lg border border-slate-300 bg-slate-100 px-3 py-2 text-slate-600" title="<?= _("Copy to clipboard") ?>">
				<i class="fas fa-copy"></i>
			</button>
		</div>
	</div>
	<div class="u-mb10 mb-[10px]">
		<label for="email_settings_password"><?= _("Password") ?></label>
		<div class="clipboard flex">
			<input type="text" class="form-control clipboard-input js-copy-input js-password-output block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-2 focus:outline-blue-200 disabled:bg-slate-100 disabled:text-slate-500" name="email_settings_password" id="email_settings_password" readonly>
			<button type="button" class="clipboard-button js-copy-button rounded-r-lg border border-slate-300 bg-slate-100 px-3 py-2 text-slate-600" title="<?= _("Copy to clipboard") ?>">
				<i class="fas fa-copy"></i>
			</button>
		</div>
	</div>
	<?php if ($_SESSION["WEBMAIL_SYSTEM"]) { ?>
		<div class="u-mb10 mb-[10px]">
			<label for="email_settings_webmail"><?= _("Webmail") ?></label>
			<div class="clipboard flex">
				<input type="text" class="form-control clipboard-input js-copy-input block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-2 focus:outline-blue-200 disabled:bg-slate-100 disabled:text-slate-500" name="email_settings_webmail" id="email_settings_webmail" value="http://<?= htmlentities($v_webmail_alias) ?>" readonly>
				<button type="button" class="clipboard-button js-copy-button rounded-r-lg border border-slate-300 bg-slate-100 px-3 py-2 text-slate-600" title="<?= _("Copy to clipboard") ?>">
					<i class="fas fa-copy"></i>
				</button>
			</div>
		</div>
	<?php } ?>
	<div class="u-mb20 mb-[20px]">
		<label for="email_settings_hostname"><?= _("Hostname") ?></label>
		<div class="clipboard flex">
			<input type="text" class="form-control clipboard-input js-copy-input block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-2 focus:outline-blue-200 disabled:bg-slate-100 disabled:text-slate-500" name="email_settings_hostname" id="email_settings_hostname" value="mail.<?= htmlentities($v_domain) ?>" readonly>
			<button type="button" class="clipboard-button js-copy-button rounded-r-lg border border-slate-300 bg-slate-100 px-3 py-2 text-slate-600" title="<?= _("Copy to clipboard") ?>">
				<i class="fas fa-copy"></i>
			</button>
		</div>
	</div>
	<h2 class="u-text-H3 u-mb10 mb-[10px] text-base font-semibold"><?= _("IMAP Settings") ?></h2>
	<ul class="values-list u-mb20 mb-[20px]">
		<li class="values-list-item flex flex-wrap gap-2 py-1">
			<span class="values-list-label min-w-32 font-semibold"><?= _("Authentication") ?></span>
			<span class="values-list-value min-w-0 wrap-anywhere"><?= _("Normal password") ?></span>
		</li>
		<li class="values-list-item flex flex-wrap gap-2 py-1">
			<span class="values-list-label min-w-32 font-semibold">SSL/TLS</span>
			<span class="values-list-value min-w-0 wrap-anywhere"><?= _("Port") ?> 993</span>
		</li>
		<li class="values-list-item flex flex-wrap gap-2 py-1">
			<span class="values-list-label min-w-32 font-semibold">STARTTLS</span>
			<span class="values-list-value min-w-0 wrap-anywhere"><?= _("Port") ?> 143</span>
		</li>
		<li class="values-list-item flex flex-wrap gap-2 py-1">
			<span class="values-list-label min-w-32 font-semibold"><?= _("No encryption") ?></span>
			<span class="values-list-value min-w-0 wrap-anywhere"><?= _("Port") ?> 143</span>
		</li>
	</ul>
	<h2 class="u-text-H3 u-mb10 mb-[10px] text-base font-semibold"><?= _("POP3 Settings") ?></h2>
	<ul class="values-list u-mb20 mb-[20px]">
		<li class="values-list-item flex flex-wrap gap-2 py-1">
			<span class="values-list-label min-w-32 font-semibold"><?= _("Authentication") ?></span>
			<span class="values-list-value min-w-0 wrap-anywhere"><?= _("Normal password") ?></span>
		</li>
		<li class="values-list-item flex flex-wrap gap-2 py-1">
			<span class="values-list-label min-w-32 font-semibold">SSL/TLS</span>
			<span class="values-list-value min-w-0 wrap-anywhere"><?= _("Port") ?> 995</span>
		</li>
		<li class="values-list-item flex flex-wrap gap-2 py-1">
			<span class="values-list-label min-w-32 font-semibold">STARTTLS</span>
			<span class="values-list-value min-w-0 wrap-anywhere"><?= _("Port") ?> 110</span>
		</li>
		<li class="values-list-item flex flex-wrap gap-2 py-1">
			<span class="values-list-label min-w-32 font-semibold"><?= _("No encryption") ?></span>
			<span class="values-list-value min-w-0 wrap-anywhere"><?= _("Port") ?> 110</span>
		</li>
	</ul>
	<h2 class="u-text-H3 u-mb10 mb-[10px] text-base font-semibold"><?= _("SMTP Settings") ?></h2>
	<ul class="values-list">
		<li class="values-list-item flex flex-wrap gap-2 py-1">
			<span class="values-list-label min-w-32 font-semibold"><?= _("Authentication") ?></span>
			<span class="values-list-value min-w-0 wrap-anywhere"><?= _("Normal password") ?></span>
		</li>
		<li class="values-list-item flex flex-wrap gap-2 py-1">
			<span class="values-list-label min-w-32 font-semibold">SSL/TLS</span>
			<span class="values-list-value min-w-0 wrap-anywhere"><?= _("Port") ?> 465</span>
		</li>
		<li class="values-list-item flex flex-wrap gap-2 py-1">
			<span class="values-list-label min-w-32 font-semibold">STARTTLS</span>
			<span class="values-list-value min-w-0 wrap-anywhere"><?= _("Port") ?> 587</span>
		</li>
		<li class="values-list-item flex flex-wrap gap-2 py-1">
			<span class="values-list-label min-w-32 font-semibold"><?= _("No encryption") ?></span>
			<span class="values-list-value min-w-0 wrap-anywhere"><?= _("Port") ?> 25</span>
		</li>
	</ul>
</div>
