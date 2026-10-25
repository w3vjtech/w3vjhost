<!doctype html>
<html lang="en">

<head>
	<!-- Load necessary CSS and JavaScript from source -->
	<?php require $_SERVER["HESTIA"] . "/web/templates/includes/title.php"; ?>
	<?php require $_SERVER["HESTIA"] . "/web/templates/includes/css.php"; ?>
	<?php require $_SERVER["HESTIA"] . "/web/templates/includes/js.php"; ?>
</head>

<body class="min-h-screen bg-slate-50 font-sans text-sm leading-6 text-slate-700 [color-scheme:light] [&_svg]:size-5 [&_svg]:shrink-0 [&_svg]:fill-none [&_svg]:stroke-current [&_svg]:[stroke-width:1.75] [&_.u-hidden]:hidden! [&_[x-cloak]]:hidden! [&_[hidden]]:hidden! [&_:focus-visible]:outline-2 [&_:focus-visible]:outline-offset-2 [&_:focus-visible]:outline-blue-600 [&_h1]:text-xl [&_h1]:font-semibold [&_h2]:text-lg [&_h2]:font-semibold [&_h3]:font-semibold [&_a]:transition-colors [&_button]:cursor-pointer [&_input[type=checkbox]]:accent-blue-600 [&_.w3vj-sidebar_.container]:px-2 [--chart-label-color:#475569] [--chart-grid-color:#e2e8f0] [--chart-line-1-color:#2563eb] [--chart-line-2-color:#be185d] [--chart-line-3-color:#15803d] md:[&:has(.w3vj-sidebar)_.app]:pl-60 md:[&:has(.w3vj-sidebar)_.top-bar]:left-60 md:[&.w3vj-sidebar-collapsed_.app]:pl-[68px] md:[&.w3vj-sidebar-collapsed_.top-bar]:left-[68px] md:[&.w3vj-sidebar-collapsed_.w3vj-sidebar]:w-[68px] md:[&.w3vj-sidebar-collapsed_.w3vj-sidebar-heading]:flex-col md:[&.w3vj-sidebar-collapsed_.w3vj-nav-label]:sr-only md:[&.w3vj-sidebar-collapsed_.w3vj-nav-count]:sr-only md:[&.w3vj-sidebar-collapsed_.main-menu-stats]:sr-only max-md:[&.w3vj-sidebar-ready_.w3vj-sidebar]:-translate-x-full max-md:[&.w3vj-sidebar-open_.w3vj-sidebar]:translate-x-0 max-md:[&.w3vj-sidebar-open]:overflow-hidden max-md:[&:not(.w3vj-sidebar-ready)_.w3vj-sidebar]:static max-md:[&:not(.w3vj-sidebar-ready)_.w3vj-sidebar]:w-full page-server-info">

	<div class="app min-h-screen flex flex-col">

		<header class="app-header shrink-0 pt-14">
			<div class="top-bar fixed inset-x-0 top-0 z-30 flex h-14 border-b border-slate-200 bg-white">
				<div class="container top-bar-inner mx-auto w-full max-w-none px-4 md:px-6 flex items-center justify-between gap-3">
					<div class="top-bar-left flex min-w-0 items-center gap-3">
						<a href="/" class="top-bar-logo flex shrink-0 items-center" title="<?= tohtml($_SESSION["APP_NAME"]) ?>">
							<img src="/images/logo-header.svg" alt="<?= tohtml($_SESSION["APP_NAME"]) ?>" width="54" height="29">
						</a>
					</div>
					<div class="top-bar-right flex shrink-0 items-center">
						<nav x-data="{ open: false }" class="top-bar-menu relative flex">
							<button
								type="button"
								class="top-bar-menu-link u-hide-tablet md:hidden! inline-flex min-h-9 min-w-9 items-center justify-center gap-1 rounded-md px-2 text-slate-600 hover:bg-blue-50 hover:text-blue-700 [&.active]:bg-blue-50"
								x-on:click="open = !open">
								<i class="fas fa-bars"></i>
									<span class="u-hidden" x-text="open ? <?= tohtml(json_encode(_("Close menu"), JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_THROW_ON_ERROR)) ?> : <?= tohtml(json_encode(_("Open menu"), JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_THROW_ON_ERROR)) ?>">
										<?= tohtml( _("Open menu")) ?>
									</span>
							</button>
							<div x-cloak x-show="open" x-on:click.outside="open = false" class="top-bar-menu-panel absolute top-full right-0 z-40 w-60 rounded-lg border border-slate-200 bg-white p-2 shadow-lg md:static md:w-auto md:border-0 md:p-0 md:shadow-none md:block!">
								<ul class="top-bar-menu-list md:flex">
									<li class="top-bar-menu-item flex">
										<a class="top-bar-menu-link inline-flex min-h-9 min-w-9 items-center justify-center gap-1 rounded-md px-2 text-slate-600 hover:bg-blue-50 hover:text-blue-700 [&.active]:bg-blue-50" href="/list/rrd/" title="<?= tohtml( _("Back")) ?>">
											<i class="fas fa-circle-left"></i>
											<span class="top-bar-menu-link-label text-xs"><?= tohtml( _("Back")) ?></span>
										</a>
									</li>
									<li class="top-bar-menu-item flex">
										<a class="top-bar-menu-link <?php if (isset($_GET['cpu'])) echo 'active' ?> inline-flex min-h-9 min-w-9 items-center justify-center gap-1 rounded-md px-2 text-slate-600 hover:bg-blue-50 hover:text-blue-700 [&.active]:bg-blue-50" href="/list/server/?cpu">
											<i class="fas fa-microchip"></i>
											<span class="top-bar-menu-link-label text-xs"><?= tohtml( _("CPU")) ?></span>
										</a>
									</li>
									<li class="top-bar-menu-item flex">
										<a class="top-bar-menu-link <?php if (isset($_GET['mem'])) echo 'active' ?> inline-flex min-h-9 min-w-9 items-center justify-center gap-1 rounded-md px-2 text-slate-600 hover:bg-blue-50 hover:text-blue-700 [&.active]:bg-blue-50" href="/list/server/?mem">
											<i class="fas fa-memory"></i>
											<span class="top-bar-menu-link-label text-xs"><?= tohtml( _("RAM")) ?></span>
										</a>
									</li>
									<li class="top-bar-menu-item flex">
										<a class="top-bar-menu-link <?php if (isset($_GET['disk'])) echo 'active' ?> inline-flex min-h-9 min-w-9 items-center justify-center gap-1 rounded-md px-2 text-slate-600 hover:bg-blue-50 hover:text-blue-700 [&.active]:bg-blue-50" href="/list/server/?disk">
											<i class="fas fa-hard-drive"></i>
											<span class="top-bar-menu-link-label text-xs"><?= tohtml( _("Disk")) ?></span>
										</a>
									</li>
									<li class="top-bar-menu-item flex">
										<a class="top-bar-menu-link <?php if (isset($_GET['net'])) echo 'active' ?> inline-flex min-h-9 min-w-9 items-center justify-center gap-1 rounded-md px-2 text-slate-600 hover:bg-blue-50 hover:text-blue-700 [&.active]:bg-blue-50" href="/list/server/?net">
											<i class="fas fa-hard-drive"></i>
											<span class="top-bar-menu-link-label text-xs"><?= tohtml( _("Network")) ?></span>
										</a>
									</li>
									<?php if ((isset($_SESSION['WEB_SYSTEM'])) && (!empty($_SESSION['WEB_SYSTEM']))) { ?>
										<li class="top-bar-menu-item flex">
											<a class="top-bar-menu-link <?php if (isset($_GET['web'])) echo 'active' ?> inline-flex min-h-9 min-w-9 items-center justify-center gap-1 rounded-md px-2 text-slate-600 hover:bg-blue-50 hover:text-blue-700 [&.active]:bg-blue-50" href="/list/server/?web">
												<i class="fas fa-earth-europe"></i>
												<span class="top-bar-menu-link-label text-xs"><?= tohtml( _("Web")) ?></span>
											</a>
										</li>
									<?php } ?>
									<?php if ((isset($_SESSION['DNS_SYSTEM'])) && (!empty($_SESSION['DNS_SYSTEM']))) { ?>
										<li class="top-bar-menu-item flex">
											<a class="top-bar-menu-link <?php if (isset($_GET['dns'])) echo 'active' ?> inline-flex min-h-9 min-w-9 items-center justify-center gap-1 rounded-md px-2 text-slate-600 hover:bg-blue-50 hover:text-blue-700 [&.active]:bg-blue-50" href="/list/server/?dns">
												<i class="fas fa-book-atlas"></i>
												<span class="top-bar-menu-link-label text-xs"><?= tohtml( _("DNS")) ?></span>
											</a>
										</li>
									<?php } ?>
									<?php if ((isset($_SESSION['MAIL_SYSTEM'])) && (!empty($_SESSION['MAIL_SYSTEM']))) { ?>
										<li class="top-bar-menu-item flex">
											<a class="top-bar-menu-link <?php if (isset($_GET['mail'])) echo 'active' ?> inline-flex min-h-9 min-w-9 items-center justify-center gap-1 rounded-md px-2 text-slate-600 hover:bg-blue-50 hover:text-blue-700 [&.active]:bg-blue-50" href="/list/server/?mail">
												<i class="fas fa-envelopes-bulk"></i>
												<span class="top-bar-menu-link-label text-xs"><?= tohtml( _("Mail")) ?></span>
											</a>
										</li>
									<?php } ?>
									<?php if ((isset($_SESSION['DB_SYSTEM'])) && (!empty($_SESSION['DB_SYSTEM']))) { ?>
										<li class="top-bar-menu-item flex">
											<a class="top-bar-menu-link <?php if (isset($_GET['db'])) echo 'active' ?> inline-flex min-h-9 min-w-9 items-center justify-center gap-1 rounded-md px-2 text-slate-600 hover:bg-blue-50 hover:text-blue-700 [&.active]:bg-blue-50" href="/list/server/?db">
												<i class="fas fa-database"></i>
												<span class="top-bar-menu-link-label text-xs"><?= tohtml( _("DB")) ?></span>
											</a>
										</li>
									<?php } ?>
									<li class="top-bar-menu-item flex">
										<a class="top-bar-menu-link inline-flex min-h-9 min-w-9 items-center justify-center gap-1 rounded-md px-2 text-slate-600 hover:bg-blue-50 hover:text-blue-700 [&.active]:bg-blue-50" href="javascript:location.reload();" title="<?= tohtml( _("Refresh")) ?>">
											<i class="fas fa-arrow-rotate-right"></i>
											<span class="u-hidden"><?= tohtml( _("Refresh")) ?></span>
										</a>
									</li>
									<li class="top-bar-menu-item flex">
										<a class="top-bar-menu-link top-bar-menu-link-logout inline-flex min-h-9 min-w-9 items-center justify-center gap-1 rounded-md px-2 text-slate-600 hover:bg-blue-50 hover:text-blue-700 [&.active]:bg-blue-50" href="/logout/?<?= tohtml(http_build_query(["token" => $_SESSION["token"]])) ?>" title="<?= tohtml( _("Log out")) ?>">
											<i class="fas fa-right-from-bracket"></i>
											<span class="u-hidden"><?= tohtml( _("Log out")) ?></span>
										</a>
									</li>
								</ul>
							</div>
						</nav>
					</div>
				</div>
			</div>
		</header>

		<main class="app-content min-w-0 flex-1">

			<div class="logs-container max-h-[calc(100dvh-6rem)] overflow-auto p-4">

				<div class="container mx-auto w-full max-w-none px-4 md:px-6">
					<pre class="console-output u-mt20 font-mono text-sm leading-5 text-slate-800 whitespace-pre-wrap mt-[20px]">
