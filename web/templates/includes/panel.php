<div id="token" token="<?= $_SESSION["token"] ?>"></div>

<header class="app-header shrink-0 pt-14" x-data="w3vjSidebar" x-on:keydown.window="keydown($event)">

	<div class="top-bar fixed inset-x-0 top-0 z-30 flex h-14 border-b border-slate-200 bg-white">
		<div class="container top-bar-inner mx-auto w-full max-w-none px-4 md:px-6 flex items-center justify-between gap-3">

			<!-- Logo / Usage Statistics wrapper -->
			<div class="top-bar-left flex min-w-0 items-center gap-3">

				<!-- Logo / Home Button -->
				<button type="button" class="w3vj-drawer-toggle inline-flex size-8 shrink-0 items-center justify-center rounded-md border border-slate-200 md:hidden" x-on:click="openDrawer" aria-controls="w3vj-sidebar" aria-expanded="false" aria-label="<?= _("Expand main menu") ?>"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M4 6h16M4 12h16M4 18h16"/></svg></button>

				<!-- Usage Statistics -->
				<div class="top-bar-usage flex min-w-0">
					<?php if ($_SESSION["look"] !== "") {
     	$user_icon = "fa-binoculars";
     } elseif ($_SESSION["userContext"] === "admin") {
     	$user_icon = "fa-user-tie";
     } else {
     	$user_icon = "fa-user";
     } ?>
					<div class="top-bar-usage-inner flex flex-wrap gap-x-3 text-xs text-slate-600">
						<span class="top-bar-usage-item inline-flex items-center gap-1">
							<i class="fas <?= $user_icon ?>" title="<?= _("Logged in as") ?>: <?= htmlspecialchars($panel[$user]["NAME"]) ?>"></i>
							<span class="u-text-bold font-bold">
								<?= htmlspecialchars($user) ?>
							</span>
						</span>
						<span class="top-bar-usage-item inline-flex items-center gap-1">
							<i class="fas fa-hard-drive" title="<?= _("Disk") ?>: <?= humanize_usage_size($panel[$user]["U_DISK"]) ?> <?= humanize_usage_measure($panel[$user]["U_DISK"]) ?>"></i>
							<span class="u-text-bold font-bold">
								<?= humanize_usage_size($panel[$user]["U_DISK"]) ?>
							</span>
							<?= humanize_usage_measure($panel[$user]["U_DISK"]) ?>
							/
							<span class="u-text-bold font-bold">
							<?= humanize_usage_size($panel[$user]["DISK_QUOTA"]) ?>
							</span>
							<?= humanize_usage_measure($panel[$user]["DISK_QUOTA"]) ?>
						</span>
						<span class="top-bar-usage-item inline-flex items-center gap-1">
							<i class="fas fa-right-left" title="<?= _("Bandwidth") ?>: <?= humanize_usage_size($panel[$user]["U_BANDWIDTH"]) ?> <?= humanize_usage_measure($panel[$user]["U_BANDWIDTH"]) ?>"></i>
							<span class="u-text-bold font-bold">
								<?= humanize_usage_size($panel[$user]["U_BANDWIDTH"]) ?>
							</span>
							<?= humanize_usage_measure($panel[$user]["U_BANDWIDTH"]) ?>
							/
							<span class="u-text-bold font-bold">
								<?= humanize_usage_size($panel[$user]["BANDWIDTH"]) ?>
							</span>
							<?= humanize_usage_measure($panel[$user]["BANDWIDTH"]) ?>
						</span>
					</div>
				</div>

			</div>

			<!-- Notifications / Menu wrapper -->
			<div class="top-bar-right flex shrink-0 items-center">

				<!-- Notifications -->
				<?php
    $impersonatingAdmin = $_SESSION["userContext"] === "admin" && ($_SESSION["look"] !== "" && $user == $_SESSION["ROOT_USER"]) && $_SESSION["POLICY_SYSTEM_PROTECTED_ADMIN"] === "yes";
    // Do not show notifications panel when impersonating 'admin' user
    if (!$impersonatingAdmin) { ?>
					<div x-data="notifications" class="top-bar-notifications relative flex">
						<button
							x-on:click="toggle()"
							x-bind:class="open && 'active'"
							class="top-bar-menu-link inline-flex min-h-9 min-w-9 items-center justify-center gap-1 rounded-md px-2 text-slate-600 hover:bg-blue-50 hover:text-blue-700 [&.active]:bg-blue-50"
							type="button"
							title="<?= _("Notifications") ?>"
						>
							<i
								x-bind:class="{
									'icon-orange text-amber-600 motion-safe:animate-pulse': (!initialized && <?= $panel[$user]["NOTIFICATIONS"] == "yes" ? "true" : "false" ?>) || notifications.length != 0,
									'fas fa-bell': true
								}"
							></i>
							<span class="u-hidden"><?= _("Notifications") ?></span>
						</button>
						<div
							x-cloak
							x-show="open"
							x-on:click.outside="open = false"
							class="top-bar-notifications-panel absolute top-full right-0 z-40 max-h-[70dvh] w-[min(350px,90vw)] overflow-y-auto rounded-lg border border-slate-200 bg-white shadow-lg"
						>
							<template x-if="!initialized">
								<div class="top-bar-notifications-empty p-5 text-center text-slate-500">
									<i class="fas fa-circle-notch fa-spin icon-dim text-slate-400"></i>
									<p><?= _("Loading...") ?></p>
								</div>
							</template>
							<template x-if="initialized && notifications.length == 0">
								<div class="top-bar-notifications-empty p-5 text-center text-slate-500">
									<i class="fas fa-bell-slash icon-dim text-slate-400"></i>
									<p><?= _("No notifications") ?></p>
								</div>
							</template>
							<template x-if="initialized && notifications.length > 0">
								<ul>
									<template x-for="notification in notifications" :key="notification.ID">
										<li
											x-bind:id="`notification-${notification.ID}`"
											x-bind:class="notification.ACK && 'unseen'"
											class="top-bar-notification-item border-b border-slate-200 text-sm"
											x-data="{ open: true }"
											x-show="open"
											x-collapse
										>
											<div class="top-bar-notification-inner p-4">
												<div class="top-bar-notification-header mb-2 flex items-center justify-between gap-2">
													<p x-text="notification.TOPIC" class="top-bar-notification-title font-semibold"></p>
													<button
														x-on:click="open = false; setTimeout(() => remove(notification.ID), 300);"
														type="button"
														class="top-bar-notification-delete rounded p-2 text-red-700 hover:bg-red-50"
														title="<?= _("Delete notification") ?>"
													>
														<i class="fas fa-xmark"></i>
														<span class="u-hidden-visually sr-only"><?= _("Delete notification") ?></span>
													</button>
												</div>
												<div class="top-bar-notification-content" x-html="notification.NOTICE"></div>
												<p class="top-bar-notification-timestamp mt-2 text-right text-xs text-slate-500">
													<time
														:datetime="`${notification.TIMESTAMP_ISO}`"
														x-bind:title="`${notification.TIMESTAMP_TITLE}`"
														x-text="`${notification.TIMESTAMP_TEXT}`"
													></time>
												</p>
											</div>
										</li>
									</template>
								</ul>
							</template>
							<template x-if="initialized && notifications.length > 2">
								<button
									x-on:click="removeAll()"
									type="button"
									class="top-bar-notifications-delete-all w-full p-3 text-blue-700 hover:bg-blue-50"
								>
									<i class="fas fa-check"></i>
									<?= _("Delete all notifications") ?>
								</button>
							</template>
						</div>
					</div>
				<?php }
    ?>

				<!-- Menu -->
				<nav x-data="{ open: false }" class="top-bar-menu relative flex">

					<button
						type="button"
						class="top-bar-menu-link u-hide-tablet md:hidden! inline-flex min-h-9 min-w-9 items-center justify-center gap-1 rounded-md px-2 text-slate-600 hover:bg-blue-50 hover:text-blue-700 [&.active]:bg-blue-50"
						x-on:click="open = !open">
						<i class="fas fa-bars"></i>
						<span class="u-hidden" x-text="open ? '<?= _("Close menu") ?>' : '<?= _("Open menu") ?>'">
							<?= _("Open menu") ?>
						</span>
					</button>

					<div x-cloak x-show="open" x-on:click.outside="open = false" class="top-bar-menu-panel absolute top-full right-0 z-40 w-60 rounded-lg border border-slate-200 bg-white p-2 shadow-lg md:static md:w-auto md:border-0 md:p-0 md:shadow-none md:block!">
						<ul class="top-bar-menu-list md:flex">

							<!-- File Manager -->
							<?php if (isset($_SESSION["FILE_MANAGER"]) && !empty($_SESSION["FILE_MANAGER"]) && $_SESSION["FILE_MANAGER"] == "true") { ?>
								<?php if ($_SESSION["userContext"] === "admin" && $_SESSION["look"] === $_SESSION["ROOT_USER"] && $_SESSION["POLICY_SYSTEM_PROTECTED_ADMIN"] == "yes") { ?>
									<!-- Hide file manager when impersonating admin-->
								<?php } else { ?>
									<li class="top-bar-menu-item flex">
										<a title="<?= _("File manager") ?>" class="top-bar-menu-link <?php if ($TAB == "FM") {
	echo "active";
} ?> inline-flex min-h-9 min-w-9 items-center justify-center gap-1 rounded-md px-2 text-slate-600 hover:bg-blue-50 hover:text-blue-700 [&.active]:bg-blue-50" href="/fm/">
											<i class="fas fa-folder-open"></i>
											<span class="top-bar-menu-link-label u-hide-desktop xl:hidden! text-xs"><?= _("File manager") ?></span>
										</a>
									</li>
								<?php } ?>
							<?php } ?>

							<!-- Web Terminal -->
							<?php if (isset($_SESSION["WEB_TERMINAL"]) && !empty($_SESSION["WEB_TERMINAL"]) && $_SESSION["WEB_TERMINAL"] == "true") { ?>
								<?php if ($_SESSION["userContext"] === "admin" && $_SESSION["look"] === $_SESSION["ROOT_USER"] && $_SESSION["POLICY_SYSTEM_PROTECTED_ADMIN"] == "yes") { ?>
									<!-- Hide web terminal when impersonating admin -->
								<?php } elseif ($_SESSION["login_shell"] != "nologin") { ?>
									<li class="top-bar-menu-item flex">
										<a title="<?= _("Web terminal") ?>" class="top-bar-menu-link <?php if ($TAB == "TERMINAL") {
	echo "active";
} ?> inline-flex min-h-9 min-w-9 items-center justify-center gap-1 rounded-md px-2 text-slate-600 hover:bg-blue-50 hover:text-blue-700 [&.active]:bg-blue-50" href="/list/terminal/">
											<i class="fas fa-terminal"></i>
											<span class="top-bar-menu-link-label u-hide-desktop xl:hidden! text-xs"><?= _("Web terminal") ?></span>
										</a>
									</li>
								<?php } ?>
							<?php } ?>

							<!-- Server Settings -->
							<?php if (($_SESSION["userContext"] === "admin" && $_SESSION["POLICY_SYSTEM_HIDE_SERVICES"] !== "yes") || $_SESSION["user"] === $_SESSION['ROOT_USER']) { ?>
								<?php if ($_SESSION["userContext"] === "admin" && $_SESSION["look"] !== "") { ?>
									<!-- Hide 'Server Settings' button when impersonating 'admin' or other users -->
								<?php } else { ?>
									<li class="top-bar-menu-item flex">
										<a title="<?= _("Server settings") ?>" class="top-bar-menu-link <?php if (in_array($TAB, ["SERVER", "IP", "RRD", "FIREWALL"])) {
	echo "active";
} ?> inline-flex min-h-9 min-w-9 items-center justify-center gap-1 rounded-md px-2 text-slate-600 hover:bg-blue-50 hover:text-blue-700 [&.active]:bg-blue-50" href="/list/server/">
											<i class="fas fa-gear"></i>
											<span class="top-bar-menu-link-label u-hide-desktop xl:hidden! text-xs"><?= _("Server settings") ?></span>
										</a>
									</li>
								<?php } ?>
							<?php } ?>

							<!-- Edit User -->
							<?php if ($_SESSION["userContext"] === "admin" && ($_SESSION["look"] !== "" && $user == $_SESSION["ROOT_USER"]) && $_SESSION["POLICY_SYSTEM_PROTECTED_ADMIN"] === "yes") { ?>
								<!-- Hide 'edit user' entry point from other administrators for default 'admin' account-->
								<li class="top-bar-menu-item flex">
									<a title="<?= _("Logs") ?>" class="top-bar-menu-link <?php if ($TAB == "LOG") {
	echo "active";
} ?> inline-flex min-h-9 min-w-9 items-center justify-center gap-1 rounded-md px-2 text-slate-600 hover:bg-blue-50 hover:text-blue-700 [&.active]:bg-blue-50" href="/list/log/">
										<i class="fas fa-clock-rotate-left"></i>
										<span class="top-bar-menu-link-label u-hide-desktop xl:hidden! text-xs"><?= _("Logs") ?></span>
									</a>
								</li>
							<?php } else { ?>
								<?php if ($panel[$user]["SUSPENDED"] === "no") { ?>
									<li class="top-bar-menu-item flex">
										<a title="<?= htmlspecialchars($user) ?> (<?= htmlspecialchars($panel[$user]["NAME"]) ?>)" class="top-bar-menu-link inline-flex min-h-9 min-w-9 items-center justify-center gap-1 rounded-md px-2 text-slate-600 hover:bg-blue-50 hover:text-blue-700 [&.active]:bg-blue-50" href="/edit/user/?user=<?= $user ?>&token=<?= $_SESSION["token"] ?>">
											<i class="fas fa-circle-user"></i>
											<span class="top-bar-menu-link-label u-hide-desktop xl:hidden! text-xs"><?= htmlspecialchars($user) ?> (<?= htmlspecialchars($panel[$user]["NAME"]) ?>)</span>
										</a>
									</li>
								<?php } ?>
							<?php } ?>

							<!-- Statistics -->
							<li class="top-bar-menu-item flex">
								<a title="<?= _("Statistics") ?>" class="top-bar-menu-link <?php if ($TAB == "STATS") {
	echo "active";
} ?> inline-flex min-h-9 min-w-9 items-center justify-center gap-1 rounded-md px-2 text-slate-600 hover:bg-blue-50 hover:text-blue-700 [&.active]:bg-blue-50" href="/list/stats/">
									<i class="fas fa-chart-line"></i>
									<span class="top-bar-menu-link-label u-hide-desktop xl:hidden! text-xs"><?= _("Statistics") ?></span>
								</a>
							</li>
							<?php if ($_SESSION["HIDE_DOCS"] !== "yes") { ?>
								<!-- Help / Documentation -->
								<li class="top-bar-menu-item flex">
									<a title="<?= _("Help") ?>" class="top-bar-menu-link inline-flex min-h-9 min-w-9 items-center justify-center gap-1 rounded-md px-2 text-slate-600 hover:bg-blue-50 hover:text-blue-700 [&.active]:bg-blue-50" href="https://w3vjtech.com/" target="_blank" rel="noopener">
										<i class="fas fa-circle-question"></i>
										<span class="top-bar-menu-link-label u-hide-desktop xl:hidden! text-xs"><?= _("Help") ?></span>
									</a>
								</li>
							<?php } ?>
							<!-- Logout -->
							<?php if (isset($_SESSION["look"]) && !empty($_SESSION["look"])) { ?>
								<li class="top-bar-menu-item flex">
									<a title="<?= _("Log out") ?> (<?= $user ?>)" class="top-bar-menu-link top-bar-menu-link-logout inline-flex min-h-9 min-w-9 items-center justify-center gap-1 rounded-md px-2 text-slate-600 hover:bg-blue-50 hover:text-blue-700 [&.active]:bg-blue-50" href="/logout/?token=<?= $_SESSION["token"] ?>">
										<i class="fas fa-circle-up"></i>
										<span class="top-bar-menu-link-label u-hide-desktop xl:hidden! text-xs"><?= _("Log out") ?> (<?= $user ?>)</span>
									</a>
								</li>
							<?php } else { ?>
								<li class="top-bar-menu-item flex">
									<a title="<?= _("Log out") ?>" class="top-bar-menu-link top-bar-menu-link-logout inline-flex min-h-9 min-w-9 items-center justify-center gap-1 rounded-md px-2 text-slate-600 hover:bg-blue-50 hover:text-blue-700 [&.active]:bg-blue-50" href="/logout/?token=<?= $_SESSION["token"] ?>">
										<i class="fas fa-right-from-bracket"></i>
										<span class="top-bar-menu-link-label u-hide-desktop xl:hidden! text-xs"><?= _("Log out") ?></span>
									</a>
								</li>
							<?php } ?>

						</ul>
					</div>
				</nav>

			</div>

		</div>
	</div>

	<nav id="w3vj-sidebar" class="main-menu w3vj-sidebar fixed inset-y-0 left-0 z-40 w-60 overflow-y-auto border-r border-slate-200 bg-white transition-[width,transform] duration-150 motion-reduce:transition-none" aria-label="<?= _("Main menu") ?>">
        <div class="w3vj-sidebar-heading flex min-h-14 items-center justify-between gap-2 border-b border-slate-200 p-3"><a href="/" class="top-bar-logo flex shrink-0 items-center" title="<?= htmlentities($_SESSION["APP_NAME"]) ?>">
					<img src="/images/logo-header.svg" alt="<?= htmlentities($_SESSION["APP_NAME"]) ?>" width="54" height="29">
				</a><button type="button" class="w3vj-sidebar-toggle inline-flex size-8 shrink-0 items-center justify-center rounded-md border border-slate-200 text-slate-600 hover:bg-blue-50" x-on:click="toggleSidebar" aria-controls="w3vj-sidebar" aria-expanded="true" aria-label="<?= _("Collapse main menu") ?>" data-expand="<?= _("Expand main menu") ?>" data-collapse="<?= _("Collapse main menu") ?>"><svg viewBox="0 0 24 24" aria-hidden="true"><rect x="3" y="3" width="18" height="18" rx="3"/><path d="M9 3v18m7-13-4 4 4 4"/></svg></button></div>
        <div class="container mx-auto w-full max-w-none px-4 md:px-6">
            <ul class="main-menu-list flex flex-col gap-1 py-3">

				<!-- Users tab -->
				<?php if ($_SESSION["userContext"] == "admin" && $_SESSION["look"] === "") { ?>
					<?php if ($_SESSION["user"] !== $_SESSION["ROOT_USER"] && $_SESSION["POLICY_SYSTEM_HIDE_ADMIN"] === "yes") {
     	$user_count = $panel[$user]["U_USERS"] - 1;
     } else {
     	$user_count = $panel[$user]["U_USERS"];
     } ?>
					<li class="main-menu-item min-w-0 [&.focus]:rounded-lg [&.focus]:outline-2 [&.focus]:outline-blue-500">
						<a class="main-menu-item-link <?php if (in_array($TAB, ["USER", "LOG"])) {
      	echo "active";
      } ?> block rounded-lg border-l-2 border-transparent px-3 py-2 text-slate-600 hover:bg-slate-100 [&.active]:border-blue-600 [&.active]:bg-blue-50 [&.active]:text-blue-700 [&.focus]:ring-2 [&.focus]:ring-blue-500" href="/list/user/" title="<?= _("Users") ?>: <?= $user_count ?>&#13;<?= _("Suspended") ?>: <?= $panel[$user]["SUSPENDED_USERS"] ?>">
							<p class="main-menu-item-label flex items-center gap-2 text-sm font-medium"><svg data-lucide="users" class="w3vj-nav-icon size-5 shrink-0 fill-none stroke-current [stroke-width:1.75]" viewBox="0 0 24 24" aria-hidden="true"><circle cx="9" cy="8" r="3"/><path d="M3 21v-3a6 6 0 0 1 12 0v3m2-16a3 3 0 0 1 0 6m4 10v-3a6 6 0 0 0-3-5"/></svg><span class="w3vj-nav-label"><?= _("USER") ?></span><span class="w3vj-nav-count ml-auto rounded bg-slate-100 px-2 py-0.5 text-xs tabular-nums"><?= htmlspecialchars((string) $user_count) ?></span></p>
							<ul class="main-menu-stats mt-1 pl-7 text-xs leading-5 text-slate-500">
								<li>
									<?= _("Users") ?>: <?= htmlspecialchars($user_count) ?>
								</li>
								<li>
									<?= _("Suspended") ?>: <?= $panel[$user]["SUSPENDED_USERS"] ?>
								</li>
							</ul>
						</a>
					</li>
				<?php } ?>

				<!-- Web tab -->
				<?php if (isset($_SESSION["WEB_SYSTEM"]) && !empty($_SESSION["WEB_SYSTEM"])) { ?>
					<?php if ($panel[$user]["WEB_DOMAINS"] != "0") { ?>
						<li class="main-menu-item min-w-0 [&.focus]:rounded-lg [&.focus]:outline-2 [&.focus]:outline-blue-500">
							<a class="main-menu-item-link <?php if ($TAB == "WEB") {
       	echo "active";
       } ?> block rounded-lg border-l-2 border-transparent px-3 py-2 text-slate-600 hover:bg-slate-100 [&.active]:border-blue-600 [&.active]:bg-blue-50 [&.active]:text-blue-700 [&.focus]:ring-2 [&.focus]:ring-blue-500" href="/list/web/" title="<?= _("Domains") ?>: <?= $panel[$user]["U_WEB_DOMAINS"] ?>&#13;<?= _("Aliases") ?>: <?= $panel[$user]["U_WEB_ALIASES"] ?>&#13;<?= _("Limit") ?>: <?= $panel[
	$user
]["WEB_DOMAINS"] == "unlimited"
	? "∞"
	: $panel[$user]["WEB_DOMAINS"] ?>&#13;<?= _("Suspended") ?>: <?= $panel[$user]["SUSPENDED_WEB"] ?>">
								<p class="main-menu-item-label flex items-center gap-2 text-sm font-medium"><svg data-lucide="globe" class="w3vj-nav-icon size-5 shrink-0 fill-none stroke-current [stroke-width:1.75]" viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="12" r="9"/><ellipse cx="12" cy="12" rx="4" ry="9"/><path d="M3 12h18"/></svg><span class="w3vj-nav-label"><?= _("WEB") ?></span><span class="w3vj-nav-count ml-auto rounded bg-slate-100 px-2 py-0.5 text-xs tabular-nums"><?= htmlspecialchars((string) $panel[$user]["U_WEB_DOMAINS"]) ?></span></p>
								<ul class="main-menu-stats mt-1 pl-7 text-xs leading-5 text-slate-500">
									<li>
										<?= _("Domains") ?>: <?= $panel[$user]["U_WEB_DOMAINS"] ?> / <?= $panel[$user]["WEB_DOMAINS"] == "unlimited" ? "<span class=\"u-text-bold font-bold\">∞</span>" : $panel[$user]["WEB_DOMAINS"] ?> (<?= $panel[
 	$user
 ]["SUSPENDED_WEB"] ?>)
									</li>
									<li>
										<?= _("Aliases") ?>: <?= $panel[$user]["U_WEB_ALIASES"] ?> / <?= $panel[$user]["WEB_ALIASES"] == "unlimited" || $panel[$user]["WEB_DOMAINS"] == "unlimited"
 	? "<span class=\"u-text-bold font-bold\">∞</span>"
 	: $panel[$user]["WEB_ALIASES"] * $panel[$user]["WEB_DOMAINS"] ?>
									</li>
								</ul>
							</a>
						</li>
					<?php } ?>
				<?php } ?>

				<!-- DNS tab -->
				<?php if (isset($_SESSION["DNS_SYSTEM"]) && !empty($_SESSION["DNS_SYSTEM"])) { ?>
					<?php if ($panel[$user]["DNS_DOMAINS"] != "0") { ?>
						<li class="main-menu-item min-w-0 [&.focus]:rounded-lg [&.focus]:outline-2 [&.focus]:outline-blue-500">
							<a class="main-menu-item-link <?php if ($TAB == "DNS") {
       	echo "active";
       } ?> block rounded-lg border-l-2 border-transparent px-3 py-2 text-slate-600 hover:bg-slate-100 [&.active]:border-blue-600 [&.active]:bg-blue-50 [&.active]:text-blue-700 [&.focus]:ring-2 [&.focus]:ring-blue-500" href="/list/dns/" title="<?= _("Domains") ?>: <?= $panel[$user]["U_DNS_DOMAINS"] ?>&#13;<?= _("Limit") ?>: <?= $panel[$user]["DNS_DOMAINS"] == "unlimited"
	? "∞"
	: $panel[$user]["DNS_DOMAINS"] ?>&#13;<?= _("Suspended") ?>: <?= $panel[$user]["SUSPENDED_DNS"] ?>">
								<p class="main-menu-item-label flex items-center gap-2 text-sm font-medium"><svg data-lucide="server" class="w3vj-nav-icon size-5 shrink-0 fill-none stroke-current [stroke-width:1.75]" viewBox="0 0 24 24" aria-hidden="true"><rect x="3" y="3" width="18" height="7" rx="2"/><rect x="3" y="14" width="18" height="7" rx="2"/><path d="M7 6.5h.01M7 17.5h.01M11 6.5h6M11 17.5h6"/></svg><span class="w3vj-nav-label"><?= _("DNS") ?></span><span class="w3vj-nav-count ml-auto rounded bg-slate-100 px-2 py-0.5 text-xs tabular-nums"><?= htmlspecialchars((string) $panel[$user]["U_DNS_DOMAINS"]) ?></span></p>
								<ul class="main-menu-stats mt-1 pl-7 text-xs leading-5 text-slate-500">
									<li>
										<?= _("Zones") ?>: <?= $panel[$user]["U_DNS_DOMAINS"] ?> / <?= $panel[$user]["DNS_DOMAINS"] == "unlimited" ? "<span class=\"u-text-bold font-bold\">∞</span>" : $panel[$user]["DNS_DOMAINS"] ?> (<?= $panel[
 	$user
 ]["SUSPENDED_DNS"] ?>)
									</li>
									<li>
										<?= _("Records") ?>: <?= $panel[$user]["U_DNS_RECORDS"] ?> / <?= $panel[$user]["DNS_RECORDS"] == "unlimited" || $panel[$user]["DNS_DOMAINS"] == "unlimited"
 	? "<span class=\"u-text-bold font-bold\">∞</span>"
 	: $panel[$user]["DNS_RECORDS"] * $panel[$user]["DNS_DOMAINS"] ?>
									</li>
								</ul>
							</a>
						</li>
					<?php } ?>
				<?php } ?>

				<!-- Mail tab -->
				<?php if (isset($_SESSION["MAIL_SYSTEM"]) && !empty($_SESSION["MAIL_SYSTEM"])) { ?>
					<?php if ($panel[$user]["MAIL_DOMAINS"] != "0") { ?>
						<li class="main-menu-item min-w-0 [&.focus]:rounded-lg [&.focus]:outline-2 [&.focus]:outline-blue-500">
							<a class="main-menu-item-link <?php if ($TAB == "MAIL") {
       	echo "active";
       } ?> block rounded-lg border-l-2 border-transparent px-3 py-2 text-slate-600 hover:bg-slate-100 [&.active]:border-blue-600 [&.active]:bg-blue-50 [&.active]:text-blue-700 [&.focus]:ring-2 [&.focus]:ring-blue-500" href="/list/mail/" title="<?= _("Domains") ?>: <?= $panel[$user]["U_MAIL_DOMAINS"] ?>&#13;<?= _("Limit") ?>: <?= $panel[$user]["MAIL_DOMAINS"] == "unlimited"
	? "∞"
	: $panel[$user]["MAIL_DOMAINS"] ?>&#13;<?= _("Suspended") ?>: <?= $panel[$user]["SUSPENDED_MAIL"] ?>">
								<p class="main-menu-item-label flex items-center gap-2 text-sm font-medium"><svg data-lucide="mail" class="w3vj-nav-icon size-5 shrink-0 fill-none stroke-current [stroke-width:1.75]" viewBox="0 0 24 24" aria-hidden="true"><rect x="3" y="5" width="18" height="14" rx="2"/><path d="m3 6 9 7 9-7"/></svg><span class="w3vj-nav-label"><?= _("MAIL") ?></span><span class="w3vj-nav-count ml-auto rounded bg-slate-100 px-2 py-0.5 text-xs tabular-nums"><?= htmlspecialchars((string) $panel[$user]["U_MAIL_DOMAINS"]) ?></span></p>
								<ul class="main-menu-stats mt-1 pl-7 text-xs leading-5 text-slate-500">
									<li>
										<?= _("Domains") ?>: <?= $panel[$user]["U_MAIL_DOMAINS"] ?> / <?= $panel[$user]["MAIL_DOMAINS"] == "unlimited" ? "<span class=\"u-text-bold font-bold\">∞</span>" : $panel[$user]["MAIL_DOMAINS"] ?> (<?= $panel[
 	$user
 ]["SUSPENDED_MAIL"] ?>)
									</li>
									<li>
										<?= _("Accounts") ?>: <?= $panel[$user]["U_MAIL_ACCOUNTS"] ?> / <?= $panel[$user]["MAIL_ACCOUNTS"] == "unlimited" || $panel[$user]["MAIL_DOMAINS"] == "unlimited"
 	? "<span class=\"u-text-bold font-bold\">∞</span>"
 	: $panel[$user]["MAIL_ACCOUNTS"] * $panel[$user]["MAIL_DOMAINS"] ?>
									</li>
								</ul>
							</a>
						</li>
					<?php } ?>
				<?php } ?>

				<!-- Databases tab -->
				<?php if (isset($_SESSION["DB_SYSTEM"]) && !empty($_SESSION["DB_SYSTEM"])) { ?>
					<?php if ($panel[$user]["DATABASES"] != "0") { ?>
						<li class="main-menu-item min-w-0 [&.focus]:rounded-lg [&.focus]:outline-2 [&.focus]:outline-blue-500">
							<a class="main-menu-item-link <?php if ($TAB == "DB") {
       	echo "active";
       } ?> block rounded-lg border-l-2 border-transparent px-3 py-2 text-slate-600 hover:bg-slate-100 [&.active]:border-blue-600 [&.active]:bg-blue-50 [&.active]:text-blue-700 [&.focus]:ring-2 [&.focus]:ring-blue-500" href="/list/db/" title="<?= _("Databases") ?>: <?= $panel[$user]["U_DATABASES"] ?>&#13;<?= _("Limit") ?>: <?= $panel[$user]["DATABASES"] == "unlimited"
	? "∞"
	: $panel[$user]["DATABASES"] ?>&#13;<?= _("Suspended") ?>: <?= $panel[$user]["SUSPENDED_DB"] ?>">
								<p class="main-menu-item-label flex items-center gap-2 text-sm font-medium"><svg data-lucide="database" class="w3vj-nav-icon size-5 shrink-0 fill-none stroke-current [stroke-width:1.75]" viewBox="0 0 24 24" aria-hidden="true"><ellipse cx="12" cy="5" rx="9" ry="3"/><path d="M3 5v14c0 4 18 4 18 0V5M3 12c0 4 18 4 18 0"/></svg><span class="w3vj-nav-label"><?= _("DB") ?></span><span class="w3vj-nav-count ml-auto rounded bg-slate-100 px-2 py-0.5 text-xs tabular-nums"><?= htmlspecialchars((string) $panel[$user]["U_DATABASES"]) ?></span></p>
								<ul class="main-menu-stats mt-1 pl-7 text-xs leading-5 text-slate-500">
									<li>
										<?= _("Databases") ?>: <?= $panel[$user]["U_DATABASES"] ?> / <?= $panel[$user]["DATABASES"] == "unlimited" ? "<span class=\"u-text-bold font-bold\">∞</span>" : $panel[$user]["DATABASES"] ?> (<?= $panel[$user][
 	"SUSPENDED_DB"
 ] ?>)
									</li>
								</ul>
							</a>
                            <ul class="w3vj-db-submenu pb-2 pl-6 [&_a]:flex [&_a]:items-center [&_a]:gap-2 [&_a]:rounded [&_a]:p-2 [&_a]:text-xs [&_a.active]:bg-blue-50 [&_a.active]:text-blue-700">
                                <li><a href="/list/db/#nosql" title="MongoDB / Redis"><svg viewBox="0 0 24 24" aria-hidden="true"><ellipse cx="12" cy="5" rx="9" ry="3"/><path d="M3 5v14c0 4 18 4 18 0V5M3 12c0 4 18 4 18 0"/></svg><span class="w3vj-nav-label">MongoDB / Redis</span></a></li>
                            </ul>
						</li>
					<?php } ?>
				<?php } ?>

				<!-- Cron tab -->
				<?php if (isset($_SESSION["CRON_SYSTEM"]) && !empty($_SESSION["CRON_SYSTEM"])) { ?>
					<?php if ($panel[$user]["CRON_JOBS"] != "0") { ?>
						<li class="main-menu-item min-w-0 [&.focus]:rounded-lg [&.focus]:outline-2 [&.focus]:outline-blue-500">
							<a class="main-menu-item-link <?php if ($TAB == "CRON") {
       	echo "active";
       } ?> block rounded-lg border-l-2 border-transparent px-3 py-2 text-slate-600 hover:bg-slate-100 [&.active]:border-blue-600 [&.active]:bg-blue-50 [&.active]:text-blue-700 [&.focus]:ring-2 [&.focus]:ring-blue-500" href="/list/cron/" title="<?= _("Jobs") ?>: <?= $panel[$user]["U_WEB_DOMAINS"] ?>&#13;<?= _("Limit") ?>: <?= $panel[$user]["CRON_JOBS"] == "unlimited"
	? "∞"
	: $panel[$user]["CRON_JOBS"] ?>&#13;<?= _("Suspended") ?>: <?= $panel[$user]["SUSPENDED_CRON"] ?>">
								<p class="main-menu-item-label flex items-center gap-2 text-sm font-medium"><svg data-lucide="clock" class="w3vj-nav-icon size-5 shrink-0 fill-none stroke-current [stroke-width:1.75]" viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/></svg><span class="w3vj-nav-label"><?= _("CRON") ?></span><span class="w3vj-nav-count ml-auto rounded bg-slate-100 px-2 py-0.5 text-xs tabular-nums"><?= htmlspecialchars((string) $panel[$user]["U_CRON_JOBS"]) ?></span></p>
								<ul class="main-menu-stats mt-1 pl-7 text-xs leading-5 text-slate-500">
									<li>
										<?= _("Jobs") ?>: <?= $panel[$user]["U_CRON_JOBS"] ?> / <?= $panel[$user]["CRON_JOBS"] == "unlimited" ? "<span class=\"u-text-bold font-bold\">∞</span>" : $panel[$user]["CRON_JOBS"] ?> (<?= $panel[$user][
 	"SUSPENDED_CRON"
 ] ?>)
									</li>
								</ul>
							</a>
						</li>
					<?php } ?>
				<?php } ?>

				<!-- Backups tab -->
				<?php if (isset($_SESSION["BACKUP_SYSTEM"]) && !empty($_SESSION["BACKUP_SYSTEM"])) { ?>
					<?php if ($panel[$user]["BACKUPS"] != "0" || $panel[$user]["U_BACKUPS"] != "0" || $panel[$user]["BACKUPS_INCREMENTAL"] == "yes") { ?>
						<li class="main-menu-item min-w-0 [&.focus]:rounded-lg [&.focus]:outline-2 [&.focus]:outline-blue-500">
							<a class="main-menu-item-link <?php if ($TAB == "BACKUP") {
       	echo "active";
       } ?> block rounded-lg border-l-2 border-transparent px-3 py-2 text-slate-600 hover:bg-slate-100 [&.active]:border-blue-600 [&.active]:bg-blue-50 [&.active]:text-blue-700 [&.focus]:ring-2 [&.focus]:ring-blue-500" href="/list/backup/" title="<?= _("Backups") ?>: <?= $panel[$user]["U_BACKUPS"] ?>&#13;<?= _("Limit") ?>: <?= $panel[$user]["BACKUPS"] == "unlimited" ? "∞" : $panel[$user]["BACKUPS"] ?>">
								<p class="main-menu-item-label flex items-center gap-2 text-sm font-medium"><svg data-lucide="archive" class="w3vj-nav-icon size-5 shrink-0 fill-none stroke-current [stroke-width:1.75]" viewBox="0 0 24 24" aria-hidden="true"><path d="M5 8v12h14V8M9 12h6"/><rect x="3" y="3" width="18" height="5" rx="1"/></svg><span class="w3vj-nav-label"><?= _("BACKUP") ?></span><span class="w3vj-nav-count ml-auto rounded bg-slate-100 px-2 py-0.5 text-xs tabular-nums"><?= htmlspecialchars((string) $panel[$user]["U_BACKUPS"]) ?></span></p>
								<ul class="main-menu-stats mt-1 pl-7 text-xs leading-5 text-slate-500">
									<li>
										<?= _("Backups") ?>: <?= $panel[$user]["U_BACKUPS"] ?> / <?= $panel[$user]["BACKUPS"] == "unlimited" ? "<span class=\"u-text-bold font-bold\">∞</span>" : $panel[$user]["BACKUPS"] ?>
									</li>
								</ul>
							</a>
						</li>
					<?php } ?>
				<?php } ?>

			</ul>
		</div>
	</nav>

<button type="button" class="w3vj-sidebar-backdrop fixed inset-0 z-30 bg-slate-900/20 md:hidden" x-on:click="closeDrawer" tabindex="-1" aria-label="<?= _("Close menu") ?>" hidden></button>
</header>

<main class="app-content min-w-0 flex-1">
