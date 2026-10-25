<div class="login m-auto w-[calc(100%-2rem)] max-w-md rounded-xl border border-slate-200 bg-white p-6 shadow-sm [&_form]:w-full">
	<a href="/" class="u-block u-mb40 block! mb-[40px]">
		<img src="/images/logo.svg" alt="<?= tohtml($_SESSION["APP_NAME"]) ?>" width="100" height="120">
	</a>
	<form method="post">
		<h1 class="login-title mb-5 text-lg font-semibold">
			<?= tohtml( _("Forgot Password")) ?>
		</h1>
		<?php if (!empty($error)) { ?>
			<p class="error text-red-700"><?= tohtml($error) ?></p>
		<?php } ?>
		<div class="u-mb10 mb-[10px]">
			<input type="hidden" name="action" value="confirm">
			<input type="hidden" name="token" value="<?= tohtml($_SESSION["token"]) ?>">
			<input type="hidden" name="user" value="<?= tohtml($_GET["user"]) ?>">
			<input type="hidden" name="code" value="<?= tohtml($_GET["code"]) ?>">
			<label for="password" class="form-label mb-1 block text-sm font-semibold text-slate-700"><?= tohtml( _("New Password")) ?></label>
			<input type="password" class="form-control block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-2 focus:outline-blue-200 disabled:bg-slate-100 disabled:text-slate-500" name="password" id="password" autocomplete="new-password" required autofocus>
		</div>
		<div class="u-mb20 mb-[20px]">
			<label for="password_confirm" class="form-label mb-1 block text-sm font-semibold text-slate-700"><?= tohtml( _("Confirm Password")) ?></label>
			<input type="password" class="form-control block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-2 focus:outline-blue-200 disabled:bg-slate-100 disabled:text-slate-500" name="password_confirm" id="password_confirm" autocomplete="new-password" required>
		</div>
		<div class="u-side-by-side flex flex-wrap items-center gap-2">
			<button type="submit" class="button inline-flex min-h-9 items-center justify-center gap-1.5 rounded-lg border border-blue-600 bg-blue-600 px-4 py-1.5 text-sm font-semibold text-white hover:bg-blue-700 disabled:cursor-not-allowed disabled:opacity-50">
				<?= tohtml( _("Reset")) ?>
			</button>
			<a href="/login/" class="button button-secondary inline-flex min-h-9 items-center justify-center gap-1.5 rounded-lg border border-blue-600 bg-blue-600 px-4 py-1.5 text-sm font-semibold text-white hover:bg-blue-700 disabled:cursor-not-allowed disabled:opacity-50 border-slate-300! bg-white! text-slate-700! hover:bg-slate-50!">
				<?= tohtml( _("Back")) ?>
			</a>
		</div>
	</form>
</div>
