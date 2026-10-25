<div class="login m-auto w-[calc(100%-2rem)] max-w-md rounded-xl border border-slate-200 bg-white p-6 shadow-sm [&_form]:w-full">
	<a href="/" class="u-block u-mb40 block! mb-[40px]">
		<img src="/images/logo.svg" alt="<?= tohtml($_SESSION["APP_NAME"]) ?>" width="100" height="120">
	</a>
	<form id="login-form" method="post" action="/login/">
		<input type="hidden" name="token" value="<?= tohtml($_SESSION["token"]) ?>">
		<h1 class="login-title mb-5 text-lg font-semibold">
			<?= tohtml(sprintf(_("Welcome to %s"), $_SESSION["APP_NAME"])) ?>
		</h1>
		<?php if (!empty($error)) { ?>
			<p class="error text-red-700"><?= tohtml($error) ?></p>
		<?php } ?>
		<div class="u-mb10 mb-[10px]">
			<label for="username" class="form-label mb-1 block text-sm font-semibold text-slate-700"><?= tohtml( _("Username")) ?></label>
			<input type="text" class="form-control block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-2 focus:outline-blue-200 disabled:bg-slate-100 disabled:text-slate-500" name="user" id="username" autocomplete="username" required autofocus>
		</div>
		<div class="u-mb20 mb-[20px]">
			<label for="password" class="form-label u-side-by-side mb-1 block text-sm font-semibold text-slate-700 flex flex-wrap items-center gap-2">
				<?= tohtml( _("Password")) ?>
				<?php if ($_SESSION["POLICY_SYSTEM_PASSWORD_RESET"] !== "no") { ?>
					<a class="login-form-link text-blue-700 hover:underline" href="/reset/">
						<?= tohtml( _("Forgot Password")) ?>
					</a>
				<?php } ?>
			</label>
			<input type="password" class="form-control block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-2 focus:outline-blue-200 disabled:bg-slate-100 disabled:text-slate-500" name="password" id="password" autocomplete="current-password" required>
		</div>
		<button type="submit" class="button inline-flex min-h-9 items-center justify-center gap-1.5 rounded-lg border border-blue-600 bg-blue-600 px-4 py-1.5 text-sm font-semibold text-white hover:bg-blue-700 disabled:cursor-not-allowed disabled:opacity-50">
			<i class="fas fa-right-to-bracket"></i><?= tohtml( _("Next")) ?>
		</button>
	</form>
</div>
