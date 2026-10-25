<!-- Begin toolbar -->
<div class="toolbar sticky top-14 z-20 border-y border-slate-200 bg-white">
	<div class="toolbar-inner mx-auto flex w-full min-w-0 flex-wrap items-center justify-between gap-3 px-4 py-3 md:px-6">
		<div class="toolbar-buttons flex flex-wrap items-center gap-2">
			<a class="button button-secondary button-back js-button-back inline-flex min-h-9 items-center justify-center gap-1.5 rounded-lg border border-blue-600 bg-blue-600 px-4 py-1.5 text-sm font-semibold text-white hover:bg-blue-700 disabled:cursor-not-allowed disabled:opacity-50 border-slate-300! bg-white! text-slate-700! hover:bg-slate-50!" href="/list/server/">
				<i class="fas fa-arrow-left icon-blue text-blue-700"></i><?= tohtml( _("Back")) ?>
			</a>
			<a href="/edit/server/php/" class="button button-secondary inline-flex min-h-9 items-center justify-center gap-1.5 rounded-lg border border-blue-600 bg-blue-600 px-4 py-1.5 text-sm font-semibold text-white hover:bg-blue-700 disabled:cursor-not-allowed disabled:opacity-50 border-slate-300! bg-white! text-slate-700! hover:bg-slate-50!">
				<i class="fas fa-pencil icon-orange text-amber-700"></i><?= tohtml( _("Configure")) ?> PHP
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

	<form id="main-form" name="v_configure_server" method="post">
		<input type="hidden" name="token" value="<?= tohtml($_SESSION["token"]) ?>">
		<input type="hidden" name="save" value="save">

		<div class="form-container mx-auto w-full max-w-2xl py-6">
			<h1 class="u-mb20 mb-[20px]"><?= tohtml( _("Configure Server")) ?>: <?= tohtml($v_service_name) ?></h1>
			<?php show_alert_message($_SESSION); ?>
			<div class="js-basic-options">
				<div class="u-mb10 mb-[10px]">
					<label for="v_worker_processes" class="form-label mb-1 block text-sm font-semibold text-slate-700">worker_processes</label>
					<input type="text" class="form-control block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-2 focus:outline-blue-200 disabled:bg-slate-100 disabled:text-slate-500" data-regexp="worker_processes" data-prev-value="<?= tohtml($v_worker_processes) ?>" name="v_worker_processes" id="v_worker_processes" value="<?= tohtml($v_worker_processes) ?>">
				</div>
				<div class="u-mb10 mb-[10px]">
					<label for="v_worker_connections" class="form-label mb-1 block text-sm font-semibold text-slate-700">worker_connections</label>
					<input type="text" class="form-control block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-2 focus:outline-blue-200 disabled:bg-slate-100 disabled:text-slate-500" data-regexp="worker_connections" data-prev-value="<?= tohtml($v_worker_connections) ?>" name="v_worker_connections" id="v_worker_connections" value="<?= tohtml($v_worker_connections) ?>">
				</div>
				<div class="u-mb10 mb-[10px]">
					<label for="v_client_max_body_size" class="form-label mb-1 block text-sm font-semibold text-slate-700">client_max_body_size</label>
					<input type="text" class="form-control block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-2 focus:outline-blue-200 disabled:bg-slate-100 disabled:text-slate-500" data-regexp="client_max_body_size" data-prev-value="<?= tohtml($v_client_max_body_size) ?>" name="v_client_max_body_size" id="v_client_max_body_size" value="<?= tohtml($v_client_max_body_size) ?>">
				</div>
				<div class="u-mb10 mb-[10px]">
					<label for="v_send_timeout" class="form-label mb-1 block text-sm font-semibold text-slate-700">send_timeout</label>
					<input type="text" class="form-control block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-2 focus:outline-blue-200 disabled:bg-slate-100 disabled:text-slate-500" data-regexp="send_timeout" data-prev-value="<?= tohtml($v_send_timeout) ?>" name="v_send_timeout" id="v_send_timeout" value="<?= tohtml($v_send_timeout) ?>">
				</div>
				<div class="u-mb10 mb-[10px]">
					<label for="v_proxy_connect_timeout" class="form-label mb-1 block text-sm font-semibold text-slate-700">proxy_connect_timeout</label>
					<input type="text" class="form-control block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-2 focus:outline-blue-200 disabled:bg-slate-100 disabled:text-slate-500" data-regexp="proxy_connect_timeout" data-prev-value="<?= tohtml($v_proxy_connect_timeout) ?>" name="v_proxy_connect_timeout" id="v_proxy_connect_timeout" value="<?= tohtml($v_proxy_connect_timeout) ?>">
				</div>
				<div class="u-mb10 mb-[10px]">
					<label for="v_proxy_send_timeout" class="form-label mb-1 block text-sm font-semibold text-slate-700">proxy_send_timeout</label>
					<input type="text" class="form-control block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-2 focus:outline-blue-200 disabled:bg-slate-100 disabled:text-slate-500" data-regexp="proxy_send_timeout" data-prev-value="<?= tohtml($v_proxy_send_timeout) ?>" name="v_proxy_send_timeout" id="v_proxy_send_timeout" value="<?= tohtml($v_proxy_send_timeout) ?>">
				</div>
				<div class="u-mb10 mb-[10px]">
					<label for="v_proxy_read_timeout" class="form-label mb-1 block text-sm font-semibold text-slate-700">proxy_read_timeout</label>
					<input type="text" class="form-control block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-2 focus:outline-blue-200 disabled:bg-slate-100 disabled:text-slate-500" data-regexp="proxy_read_timeout" data-prev-value="<?= tohtml($v_proxy_read_timeout) ?>" name="v_proxy_read_timeout" id="v_proxy_read_timeout" value="<?= tohtml($v_proxy_read_timeout) ?>">
				</div>
				<div class="u-mb10 mb-[10px]">
					<label for="v_gzip" class="form-label mb-1 block text-sm font-semibold text-slate-700">gzip</label>
					<input type="text" class="form-control block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-2 focus:outline-blue-200 disabled:bg-slate-100 disabled:text-slate-500" data-regexp="gzip" data-prev-value="<?= tohtml($v_gzip) ?>" name="v_gzip" id="v_gzip" value="<?= tohtml($v_gzip) ?>">
				</div>
				<div class="u-mb10 mb-[10px]">
					<label for="v_gzip_comp_level" class="form-label mb-1 block text-sm font-semibold text-slate-700">gzip_comp_level</label>
					<input type="text" class="form-control block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-2 focus:outline-blue-200 disabled:bg-slate-100 disabled:text-slate-500" data-regexp="gzip_comp_level" data-prev-value="<?= tohtml($v_gzip_comp_level) ?>" name="v_gzip_comp_level" id="v_gzip_comp_level" value="<?= tohtml($v_gzip_comp_level) ?>">
				</div>
				<div class="u-mb20 mb-[20px]">
					<label for="v_charset" class="form-label mb-1 block text-sm font-semibold text-slate-700">charset</label>
					<input type="text" class="form-control block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-2 focus:outline-blue-200 disabled:bg-slate-100 disabled:text-slate-500" data-regexp="charset" data-prev-value="<?= tohtml($v_charset) ?>" name="v_charset" id="v_charset" value="<?= tohtml($v_charset) ?>">
				</div>
				<div class="u-mb20 mb-[20px]">
					<button type="button" class="button button-secondary js-toggle-options inline-flex min-h-9 items-center justify-center gap-1.5 rounded-lg border border-blue-600 bg-blue-600 px-4 py-1.5 text-sm font-semibold text-white hover:bg-blue-700 disabled:cursor-not-allowed disabled:opacity-50 border-slate-300! bg-white! text-slate-700! hover:bg-slate-50!">
						<?= tohtml( _("Advanced Options")) ?>
					</button>
				</div>
			</div>
			<div class="js-advanced-options <?php if (empty($v_adv)) echo 'u-hidden'; ?>">
				<div class="u-mb20 mb-[20px]">
					<button type="button" class="button button-secondary js-toggle-options inline-flex min-h-9 items-center justify-center gap-1.5 rounded-lg border border-blue-600 bg-blue-600 px-4 py-1.5 text-sm font-semibold text-white hover:bg-blue-700 disabled:cursor-not-allowed disabled:opacity-50 border-slate-300! bg-white! text-slate-700! hover:bg-slate-50!">
						<?= tohtml( _("Basic Options")) ?>
					</button>
				</div>
				<div class="u-mb20 mb-[20px]">
					<label for="v_config" class="form-label mb-1 block text-sm font-semibold text-slate-700"><?= tohtml($v_config_path) ?></label>
					<textarea class="form-control u-min-height600 u-allow-resize u-console js-advanced-textarea block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-2 focus:outline-blue-200 disabled:bg-slate-100 disabled:text-slate-500 min-h-[600px] min-w-full resize font-mono whitespace-pre leading-tight" name="v_config" id="v_config"><?= tohtml($v_config) ?></textarea>
				</div>
				<div class="form-check flex items-center gap-2">
					<input class="form-check-input accent-blue-600" type="checkbox" name="v_restart" id="v_restart" checked>
					<label for="v_restart">
						<?= tohtml( _("Restart")) ?>
					</label>
				</div>
			</div>
		</div>

	</form>

</div>
