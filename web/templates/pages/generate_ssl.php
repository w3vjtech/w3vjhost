<div class="container mx-auto w-full max-w-none px-4 md:px-6">

	<form id="main-form" name="v_generate_csr" method="post">
		<input type="hidden" name="token" value="<?= tohtml($_SESSION["token"]) ?>">
		<input type="hidden" name="generate" value="generate">

		<div class="form-container mx-auto w-full max-w-2xl py-6">
			<h1 class="u-mb20 mb-[20px]"><?= tohtml( _("Generate Self-Signed SSL Certificate")) ?></h1>
			<?php show_alert_message($_SESSION); ?>
			<div class="u-mb10 mb-[10px]">
				<label for="v_domain" class="form-label mb-1 block text-sm font-semibold text-slate-700"><?= tohtml( _("Domain")) ?></label>
				<input type="text" class="form-control block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-2 focus:outline-blue-200 disabled:bg-slate-100 disabled:text-slate-500" name="v_domain" id="v_domain" value="<?= tohtml(trim($v_domain, "'")) ?>">
			</div>
			<div class="u-mb10 mb-[10px]">
				<label for="v_aliases" class="form-label mb-1 block text-sm font-semibold text-slate-700"><?= tohtml( _("Aliases")) ?></label>
				<textarea class="form-control block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-2 focus:outline-blue-200 disabled:bg-slate-100 disabled:text-slate-500" name="v_aliases" id="v_aliases"><?= tohtml(trim($v_aliases, "'")) ?></textarea>
			</div>
			<div class="u-mb10 mb-[10px]">
				<label for="v_email" class="form-label mb-1 block text-sm font-semibold text-slate-700">
					<?= tohtml( _("Email")) ?>
					<span class="optional text-xs font-normal text-slate-500">(<?php print _("Optional"); ?>)</span>
				</label>
				<input type="email" class="form-control block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-2 focus:outline-blue-200 disabled:bg-slate-100 disabled:text-slate-500" name="v_email" id="v_email" value="<?= tohtml(trim($v_email, "'")) ?>">
			</div>
			<div class="u-mb10 mb-[10px]">
				<label for="v_country" class="form-label mb-1 block text-sm font-semibold text-slate-700">
					<?= tohtml( _("Country")) ?>
					<span class="optional text-xs font-normal text-slate-500">(<?= tohtml( _("ISO 3166-1 alpha-2 two-letter code")) ?>)</span>
				</label>
				<input type="text" class="form-control block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-2 focus:outline-blue-200 disabled:bg-slate-100 disabled:text-slate-500" name="v_country" id="v_country" value="<?= tohtml(trim($v_country, "'")) ?>">
			</div>
			<div class="u-mb10 mb-[10px]">
				<label for="v_state" class="form-label mb-1 block text-sm font-semibold text-slate-700">
					<?= tohtml( _("State / Province")) ?>
				</label>
				<input type="text" class="form-control block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-2 focus:outline-blue-200 disabled:bg-slate-100 disabled:text-slate-500" name="v_state" id="v_state" value="<?= tohtml(trim($v_state, "'")) ?>">
			</div>
			<div class="u-mb10 mb-[10px]">
				<label for="v_locality" class="form-label mb-1 block text-sm font-semibold text-slate-700">
					<?= tohtml( _("City / Locality")) ?>
				</label>
				<input type="text" class="form-control block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-2 focus:outline-blue-200 disabled:bg-slate-100 disabled:text-slate-500" name="v_locality" id="v_locality" value="<?= tohtml(trim($v_locality, "'")) ?>">
			</div>
			<div class="u-mb20 mb-[20px]">
				<label for="v_org" class="form-label mb-1 block text-sm font-semibold text-slate-700">
					<?= tohtml( _("Organization")) ?>
				</label>
				<input type="text" class="form-control block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-2 focus:outline-blue-200 disabled:bg-slate-100 disabled:text-slate-500" name="v_org" id="v_org" value="<?= tohtml(trim($v_org, "'")) ?>">
			</div>
			<div class="u-mb20 mb-[20px]">
				<label for="v_key_algo" class="form-label mb-1 block text-sm font-semibold text-slate-700"><?= tohtml( _("Key Type")) ?></label>
				<select class="form-select block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 disabled:bg-slate-100" name="v_key_algo" id="v_key_algo">
					<option value="ecdsa-256" <?php if ($v_key_algo === "ecdsa-256") echo 'selected'; ?>>ECDSA P-256 (<?= tohtml(_("recommended")) ?>)</option>
					<option value="ecdsa-384" <?php if ($v_key_algo === "ecdsa-384") echo 'selected'; ?>>ECDSA P-384</option>
					<option value="rsa" <?php if ($v_key_algo === "rsa") echo 'selected'; ?>>RSA 4096</option>
				</select>
			</div>
			<div>
				<button type="submit" class="button inline-flex min-h-9 items-center justify-center gap-1.5 rounded-lg border border-blue-600 bg-blue-600 px-4 py-1.5 text-sm font-semibold text-white hover:bg-blue-700 disabled:cursor-not-allowed disabled:opacity-50" name="generate">
					<?= tohtml( _("Generate")) ?>
				</button>
			</div>
		</div>

	</form>

</div>
