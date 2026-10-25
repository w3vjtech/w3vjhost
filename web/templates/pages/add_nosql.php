<div class="toolbar sticky top-14 z-20 border-y border-slate-200 bg-white">
	<div class="toolbar-inner mx-auto flex w-full min-w-0 flex-wrap items-center justify-between gap-3 px-4 py-3 md:px-6">
		<div class="toolbar-buttons flex flex-wrap items-center gap-2">
			<a class="button button-secondary button-back js-button-back inline-flex min-h-9 items-center justify-center gap-1.5 rounded-lg border border-blue-600 bg-blue-600 px-4 py-1.5 text-sm font-semibold text-white hover:bg-blue-700 disabled:cursor-not-allowed disabled:opacity-50 border-slate-300! bg-white! text-slate-700! hover:bg-slate-50!" href="/list/db/">
				<i class="fas fa-arrow-left icon-blue text-blue-700"></i><?= tohtml(_("Back")) ?>
			</a>
		</div>
		<div class="toolbar-buttons flex flex-wrap items-center gap-2">
			<?php if ($read_only !== true && ($nosql_data["services"]["mongodb"] || $nosql_data["services"]["redis"])) { ?>
				<button type="submit" class="button inline-flex min-h-9 items-center justify-center gap-1.5 rounded-lg border border-blue-600 bg-blue-600 px-4 py-1.5 text-sm font-semibold text-white hover:bg-blue-700 disabled:cursor-not-allowed disabled:opacity-50" form="nosql-form">
					<i class="fas fa-floppy-disk icon-purple text-purple-700"></i><?= tohtml(_("Create Database")) ?>
				</button>
			<?php } ?>
		</div>
	</div>
</div>

<div class="container mx-auto w-full max-w-none px-4 md:px-6">
	<form id="nosql-form" method="post">
		<input type="hidden" name="token" value="<?= tohtml($_SESSION["token"]) ?>">
		<input type="hidden" name="ok" value="Add">
		<div class="form-container mx-auto w-full max-w-2xl py-6">
			<h1 class="u-mb20 mb-[20px]"><?= tohtml(_("Add NoSQL Database")) ?></h1>
			<?php show_alert_message($_SESSION); ?>
			<p class="hint u-mb20 text-sm leading-6 text-slate-500 mb-[20px]">
				<?= tohtml(_("MongoDB databases receive a dedicated read/write user. Redis entries are isolated key namespaces protected by Redis ACLs, not separate Redis database indexes.")) ?>
			</p>
			<?php if (!empty($nosql_data["redis_acl_setup_required"])) { ?>
				<div class="alert alert-warning mb-4 rounded-lg border p-4 text-sm [&_a]:underline [&_i]:mr-2 border-amber-200 bg-amber-50 text-amber-800" role="alert">
					<p><?= tohtml(_("Redis needs an administrator to enable persistent ACL storage before Redis namespaces can be managed. This restarts Redis.")) ?></p>
				</div>
			<?php } ?>
			<?php if (
				!$nosql_data["services"]["mongodb"] &&
				!$nosql_data["services"]["redis"] &&
				empty($nosql_data["redis_acl_setup_required"])
			) { ?>
				<div class="alert alert-danger mb-4 rounded-lg border p-4 text-sm [&_a]:underline [&_i]:mr-2 border-red-200 bg-red-50 text-red-800" role="alert">
					<p><?= tohtml(_("MongoDB and Redis are not installed or available on this server.")) ?></p>
				</div>
			<?php } elseif ($nosql_data["services"]["mongodb"] || $nosql_data["services"]["redis"]) { ?>
				<div class="u-mb10 mb-[10px]">
					<label for="type" class="form-label mb-1 block text-sm font-semibold text-slate-700"><?= tohtml(_("Service")) ?></label>
					<select class="form-select block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 disabled:bg-slate-100" name="type" id="type" required <?= $read_only ? "disabled" : "" ?>>
						<?php if ($nosql_data["services"]["mongodb"]) { ?>
							<option value="mongodb">MongoDB</option>
						<?php } ?>
						<?php if ($nosql_data["services"]["redis"]) { ?>
							<option value="redis">Redis</option>
						<?php } ?>
					</select>
				</div>
				<div class="u-mb10 mb-[10px]">
					<label for="name" class="form-label mb-1 block text-sm font-semibold text-slate-700"><?= tohtml(_("Name")) ?></label>
					<input
						type="text"
						class="form-control block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-2 focus:outline-blue-200 disabled:bg-slate-100 disabled:text-slate-500"
						name="name"
						id="name"
						pattern="[a-z][a-z0-9_]{0,31}"
						maxlength="32"
						autocomplete="off"
						required
						<?= $read_only ? "disabled" : "" ?>
					>
					<small class="hint text-sm leading-6 text-slate-500"><?= tohtml(_("Use a lowercase letter first, followed by lowercase letters, numbers, or underscores.")) ?></small>
				</div>
				<div class="alert alert-warning mb-4 rounded-lg border p-4 text-sm [&_a]:underline [&_i]:mr-2 border-amber-200 bg-amber-50 text-amber-800" role="alert">
					<p><?= tohtml(_("NoSQL databases are not currently included in W3VJHOST user backups.")) ?></p>
					<p><?= tohtml(_("NoSQL storage is not included in W3VJHOST per-user disk usage or quotas; Redis memory limits are server-wide.")) ?></p>
				</div>
			<?php } ?>
		</div>
	</form>
</div>
