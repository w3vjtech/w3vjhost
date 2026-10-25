<!-- Begin form -->
<div class="container mx-auto w-full max-w-none px-4 md:px-6">
	<form id="main-form" name="v_generate_csr" method="post">
		<input type="hidden" name="token" value="<?= tohtml($_SESSION["token"]) ?>">

		<div class="form-container mx-auto w-full max-w-2xl py-6">
			<h1 class="u-mb20 mb-[20px]"><?= tohtml( _("Generate Self-Signed SSL Certificate")) ?></h1>
			<?php show_alert_message($_SESSION); ?>
			<div
				x-data="{
					text: '<?= tohtml(base64_encode($v_crt)) ?>',
					blob() {
						return window.URL.createObjectURL(new Blob([atob(this.text)], { type: 'text/plain' }))
					}
				}"
				class="u-mb20 mb-[20px]"
			>
				<label for="v_crt" class="form-label u-side-by-side mb-1 block text-sm font-semibold text-slate-700 flex flex-wrap items-center gap-2">
					<?= tohtml( _("SSL Certificate")) ?>
					<a
						x-bind:href="blob()"
						download="<?= tohtml($v_domain) ?>.crt"
						title="<?= tohtml( _("Download")) ?>"
					>
						<i class="fas fa-download"></i>
						<span class="u-hidden"><?= tohtml( _("Download")) ?></span>
					</a>
				</label>
				<textarea
					x-model="atob(text)"
					class="form-control u-min-height100 block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-2 focus:outline-blue-200 disabled:bg-slate-100 disabled:text-slate-500 min-h-[100px]"
					name="v_crt"
					id="v_crt"
				></textarea>
			</div>
			<div
				x-data="{
					text: '<?= tohtml(base64_encode($v_key)) ?>',
					blob() {
						return window.URL.createObjectURL(new Blob([atob(this.text)], { type: 'text/plain' }))
					}
				}"
				class="u-mb20 mb-[20px]"
			>
				<label for="v_key" class="form-label u-side-by-side mb-1 block text-sm font-semibold text-slate-700 flex flex-wrap items-center gap-2">
					<?= tohtml( _("SSL Private Key")) ?>
					<a
						x-bind:href="blob()"
						download="<?= tohtml($v_domain) ?>.key"
						title="<?= tohtml( _("Download")) ?>"
					>
						<i class="fas fa-download"></i>
						<span class="u-hidden"><?= tohtml( _("Download")) ?></span>
					</a>
				</label>
				<textarea
					x-model="atob(text)"
					class="form-control u-min-height100 block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-2 focus:outline-blue-200 disabled:bg-slate-100 disabled:text-slate-500 min-h-[100px]"
					name="v_key"
					id="v_key"
				></textarea>
			</div>
			<div
				x-data="{
					text: '<?= tohtml(base64_encode($v_csr)) ?>',
					blob() {
						return window.URL.createObjectURL(new Blob([atob(this.text)], { type: 'text/plain' }))
					}
				}"
				class="u-mb20 mb-[20px]"
			>
				<label for="v_csr" class="form-label u-side-by-side mb-1 block text-sm font-semibold text-slate-700 flex flex-wrap items-center gap-2">
					<?= tohtml( _("SSL CSR")) ?>
					<a
						x-bind:href="blob()"
						download="<?= tohtml($v_domain) ?>.csr"
						title="<?= tohtml( _("Download")) ?>"
					>
						<i class="fas fa-download"></i>
						<span class="u-hidden"><?= tohtml( _("Download")) ?></span>
					</a>
				</label>
				<textarea
					x-model="atob(text)"
					class="form-control u-min-height100 block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-2 focus:outline-blue-200 disabled:bg-slate-100 disabled:text-slate-500 min-h-[100px]"
					name="v_csr"
					id="v_csr"
				></textarea>
			</div>
		</div>
	</form>
</div>
<!-- End form -->
