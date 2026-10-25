<!-- Begin toolbar -->
<div class="toolbar sticky top-14 z-20 border-y border-slate-200 bg-white">
	<div class="toolbar-inner mx-auto flex w-full min-w-0 flex-wrap items-center justify-between gap-3 px-4 py-3 md:px-6">
		<div class="toolbar-buttons flex flex-wrap items-center gap-2">
			<?php if ($read_only !== true) { ?>
				<a href="/add/dns/" class="button button-secondary js-button-create inline-flex min-h-9 items-center justify-center gap-1.5 rounded-lg border border-blue-600 bg-blue-600 px-4 py-1.5 text-sm font-semibold text-white hover:bg-blue-700 disabled:cursor-not-allowed disabled:opacity-50 border-slate-300! bg-white! text-slate-700! hover:bg-slate-50!">
					<i class="fas fa-circle-plus icon-green text-green-700"></i><?= tohtml( _("Add DNS Domain")) ?>
				</a>
			<?php } ?>
		</div>
		<div class="toolbar-right flex min-w-0 max-w-full flex-wrap items-center gap-2 [&_form]:flex [&_form]:min-w-0">
			<div class="toolbar-search min-w-0">
				<form action="/search/" method="get">
					<input type="hidden" name="token" value="<?= tohtml($_SESSION["token"]) ?>" />
					<input type="search" class="form-control js-search-input block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-2 focus:outline-blue-200 disabled:bg-slate-100 disabled:text-slate-500" name="q" value="<?= tohtml($_POST['q'] ?? '') ?>" title="<?= tohtml( _("Search")) ?>">
					<button type="submit" class="toolbar-input-submit flex min-h-9 min-w-9 items-center justify-center rounded-r-lg border border-slate-300 bg-slate-50 px-2 text-blue-700 hover:bg-blue-50" title="<?= tohtml( _("Search")) ?>">
						<i class="fas fa-magnifying-glass"></i>
					</button>
				</form>
			</div>
		</div>
	</div>
</div>
<!-- End toolbar -->

<div class="container mx-auto w-full max-w-none px-4 md:px-6">

	<div class="form-container mx-auto w-full max-w-2xl py-6">
		<h1 class="u-mb20 mb-[20px]"><?= tohtml( _("View Public DNSSEC Key")) ?></h1>
		<div class="u-mb10 mb-[10px]">
			<label class="form-label mb-1 block text-sm font-semibold text-slate-700"><?= tohtml( _("DNSKEY Record")) ?></label>
			<input type="text" class="form-control block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-2 focus:outline-blue-200 disabled:bg-slate-100 disabled:text-slate-500" value="<?= tohtml($data[$domain]["RECORD"]) ?>" readonly>
		</div>
		<div class="u-mb10 mb-[10px]">
			<label class="form-label mb-1 block text-sm font-semibold text-slate-700"><?= tohtml( _("DS Record")) ?></label>
			<input type="text" class="form-control block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-2 focus:outline-blue-200 disabled:bg-slate-100 disabled:text-slate-500" value="<?= tohtml($data[$domain]["DS"]) ?>" readonly>
		</div>
		<div class="u-mb10 mb-[10px]">
			<label class="form-label mb-1 block text-sm font-semibold text-slate-700"><?= tohtml( _("Public Key")) ?></label>
			<input type="text" class="form-control block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-2 focus:outline-blue-200 disabled:bg-slate-100 disabled:text-slate-500" value="<?= tohtml($data[$domain]["KEY"]) ?>" readonly>
		</div>
		<div class="u-mb10 mb-[10px]">
			<label class="form-label mb-1 block text-sm font-semibold text-slate-700"><?= tohtml( _("Key Type / Flag")) ?></label>
			<input type="text" class="form-control block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-2 focus:outline-blue-200 disabled:bg-slate-100 disabled:text-slate-500" value="<?= tohtml($flag) ?>" readonly>
		</div>
		<div class="u-mb10 mb-[10px]">
			<label class="form-label mb-1 block text-sm font-semibold text-slate-700"><?= tohtml( _("Key Tag")) ?></label>
			<input type="text" class="form-control block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-2 focus:outline-blue-200 disabled:bg-slate-100 disabled:text-slate-500" value="<?= tohtml($data[$domain]["KEYTAG"]) ?>" readonly>
		</div>
		<div class="u-mb10 mb-[10px]">
			<label class="form-label mb-1 block text-sm font-semibold text-slate-700"><?= tohtml( _("Flag")) ?></label>
			<input type="text" class="form-control block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-2 focus:outline-blue-200 disabled:bg-slate-100 disabled:text-slate-500" value="<?= tohtml($data[$domain]["FLAG"]) ?>" readonly>
		</div>
		<div class="u-mb10 mb-[10px]">
			<label class="form-label mb-1 block text-sm font-semibold text-slate-700"><?= tohtml( _("Algorithm")) ?></label>
			<input type="text" class="form-control block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-2 focus:outline-blue-200 disabled:bg-slate-100 disabled:text-slate-500" value="<?= tohtml($algorithm) ?>" readonly>
		</div>
	</div>

</div>
