<footer class="app-footer border-t border-slate-200 bg-white py-4 text-xs text-slate-500">
	<div class="container mx-auto w-full max-w-none px-4 md:px-6">
		<p>
			<?= tohtml($_SESSION["APP_NAME"]) ?> - Based on
			<a class="underline hover:text-slate-700" href="https://hestiacp.com/" target="_blank" rel="noopener noreferrer">Hestia Control Panel</a>,
			licensed under <a class="underline hover:text-slate-700" href="https://www.gnu.org/licenses/gpl-3.0.html" target="_blank" rel="noopener noreferrer">GNU GPLv3</a>.
			v<?= tohtml($_SESSION["VERSION"]) ?>
		</p>
	</div>
</footer>
