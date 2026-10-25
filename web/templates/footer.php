		</main>
		<?php require $_SERVER["HESTIA"] . "/web/templates/includes/app-footer.php"; ?>
	</div> <?php // Closes `<div class="app">` in header.php ?>
<?php if (
	$_SESSION["userContext"] === "admin" &&
	$_SESSION["POLICY_SYSTEM_HIDE_SERVICES"] !== "yes" &&
	$_SESSION["UPDATE_AVAILABLE"] === "yes"
) {
?>
	<p x-data="{ open: true }" x-cloak x-show="open" class="updates-banner fixed inset-x-0 bottom-0 z-40 border-t border-white/25 bg-green-700 p-[10px] text-center text-xs text-white shadow-[0_-2px_4px_rgb(0_0_0/40%)] [&_button]:underline [&_code]:font-mono">
		<span class="u-text-bold font-bold">New updates are available!</span> To upgrade your server now, run
		<code>apt update && apt upgrade</code> from a shell session.
		(<button type="button" class="u-text-bold font-bold" x-on:click="open = false">
			hide
		</button>)
	</p>
<?php } ?>
	<div class="spinner-overlay js-spinner invisible fixed inset-0 z-50 flex items-center justify-center bg-slate-900/40 text-5xl text-white opacity-0 [&.active]:visible [&.active]:opacity-100">
		<i class="fas fa-circle-notch fa-spin"></i>
	</div>

	<div x-data>
		<dialog x-ref="dialog" class="shortcuts m-auto max-h-[calc(100dvh-2rem)] w-[calc(100%-2rem)] max-w-3xl overflow-auto rounded-lg border border-slate-200 bg-white text-slate-700 shadow-xl backdrop:bg-slate-900/40 [&_.key]:font-semibold [&_.key]:text-blue-700 [&_li]:py-2">
			<div class="shortcuts-header flex items-center justify-between border-b border-slate-200 px-5 py-3">
				<div class="shortcuts-title font-semibold text-slate-900"><?= _("Shortcuts") ?></div>
				<div
					x-on:click="$refs.dialog.close()"
					class="shortcuts-close rounded p-2 hover:bg-slate-100"
				>
					<i class="fas fa-xmark"></i>
				</div>
			</div>
			<div class="shortcuts-inner grid md:grid-cols-2">
				<ul class="shortcuts-list p-5">
					<li><span class="key">a</span><?= _("Add new object") ?></li>
					<li><span class="key">Ctrl + Enter</span><?= _("Save form") ?></li>
					<li class="u-mb20 mb-[20px]"><span class="key">Ctrl + Backspace</span><?= _("Unsave form") ?></li>
					<li><span class="key">1</span><?= _("Go to WEB list") ?></li>
					<li><span class="key">2</span><?= _("Go to DNS list") ?></li>
					<li><span class="key">3</span><?= _("Go to MAIL list") ?></li>
					<li><span class="key">4</span><?= _("Go to DB list") ?></li>
					<li><span class="key">5</span><?= _("Go to CRON list") ?></li>
					<li><span class="key">6</span><?= _("Go to BACKUP list") ?></li>
				</ul>
				<ul class="shortcuts-list p-5">
					<li class="u-mb20 mb-[20px]"><span class="key">f</span><?= _("Focus on search") ?></li>
					<li class="u-mb20 mb-[20px]"><span class="key">h</span><?= _("Display / Hide shortcuts") ?></li>
					<li><span class="key bigger">&larr;</span><?= _("Move backward through top menu") ?></li>
					<li><span class="key bigger">&rarr;</span><?= _("Move forward through top menu") ?></li>
					<li class="u-mb20 mb-[20px]"><span class="key">Enter</span><?= _("Enter focused element") ?></li>
					<li><span class="key bigger">&uarr;</span><?= _("Move up through elements list") ?></li>
					<li><span class="key bigger">&darr;</span><?= _("Move down through elements list") ?></li>
				</ul>
			</div>
		</dialog>

		<button
			x-on:click="$refs.dialog.showModal()"
			type="button"
			class="button button-secondary button-circle button-floating button-floating-shortcuts inline-flex min-h-9 items-center justify-center gap-1.5 rounded-lg border border-blue-600 bg-blue-600 px-4 py-1.5 text-sm font-semibold text-white hover:bg-blue-700 disabled:cursor-not-allowed disabled:opacity-50 border-slate-300! bg-white! text-slate-700! hover:bg-slate-50! size-8 min-h-8! rounded-full! p-1! fixed bottom-6 z-20 shadow-sm right-16"
			title="<?= _("Shortcuts") ?>"
		>
			<i class="fas fa-keyboard"></i>
			<span class="u-hidden"><?= _("Shortcuts") ?></span>
		</button>
	</div>

	<?php require $_SERVER["HESTIA"] . "/web/templates/includes/jump-to-top-link.php"; ?>

	<?php if ($_SESSION["DEBUG_MODE"] == "true") {
		require $_SERVER["HESTIA"] . "/web/templates/pages/debug_panel.php";
	} ?>

</body>
</html>
