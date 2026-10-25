<!-- Begin toolbar -->
<div class="toolbar sticky top-14 z-20 border-y border-slate-200 bg-white">
	<div class="toolbar-inner mx-auto flex w-full min-w-0 flex-wrap items-center justify-between gap-3 px-4 py-3 md:px-6">
		<div class="toolbar-buttons flex flex-wrap items-center gap-2">
			<a class="button button-secondary button-back js-button-back inline-flex min-h-9 items-center justify-center gap-1.5 rounded-lg border border-blue-600 bg-blue-600 px-4 py-1.5 text-sm font-semibold text-white hover:bg-blue-700 disabled:cursor-not-allowed disabled:opacity-50 border-slate-300! bg-white! text-slate-700! hover:bg-slate-50!" href="/list/firewall/ipset/">
				<i class="fas fa-arrow-left icon-blue text-blue-700"></i><?= tohtml( _("Back")) ?>
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

	<form id="main-form" name="v_add_ipset" method="post">
		<input type="hidden" name="token" value="<?= tohtml($_SESSION["token"]) ?>">
		<input type="hidden" name="ok" value="Add">

		<?php
		$country = [
			"br" => "Brazil",
			"ca" => "Canada",
			"cn" => "China",
			"fr" => "French",
			"de" => "Germany",
			"in" => "India",
			"id" => "Indonesia",
			"nl" => "Netherlands",
			"ro" => "Romania",
			"ru" => "Russia",
			"es" => "Spain",
			"ch" => "Switzerland",
			"tr" => "Turkey",
			"ua" => "Ukraine",
			"gb" => "United Kingdom",
			"us" => "United States",
		];

		function generate_iplist($country, $type) {
			$iplist = [];
			$lowercaseType = strtolower($type);
			foreach ($country as $iso => $name) {
				$iplist[] = [
					"name" => "[$type] " . _("Country") . " - $name",
					"source" => "https://raw.githubusercontent.com/ipverse/rir-ip/master/country/$iso/$lowercaseType-aggregated.txt",
				];
			}
			return $iplist;
		}

		$country_iplists = generate_iplist($country, "IPv4");
		// Uncomment below for IPv6
		// $country_ipv6lists = generate_iplist($country, 'IPv6');

		$blacklist_iplists = [
			["name" => "[IPv4] " . _("Block Malicious IPs"), "source" => "script:/usr/local/hestia/install/common/firewall/ipset/blacklist.sh"],
			// Uncomment below for IPv6
			// array('name' => "[IPv6] " . _("Block Malicious IPs"), 'source' => "script:/usr/local/hestia/install/common/firewall/ipset/blacklist.ipv6.sh"),
		];
		?>

		<div class="form-container mx-auto w-full max-w-2xl py-6">
			<h1 class="u-mb20 mb-[20px]"><?= tohtml( _("Add IPset IP List for Firewall")) ?></h1>
			<?php show_alert_message($_SESSION); ?>
			<div class="u-mb10 mb-[10px]">
				<label for="v_ipname" class="form-label mb-1 block text-sm font-semibold text-slate-700"><?= tohtml( _("IP List Name")) ?></label>
				<input type="text" class="form-control block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-2 focus:outline-blue-200 disabled:bg-slate-100 disabled:text-slate-500" name="v_ipname" id="v_ipname" maxlength="255" value="<?= tohtml(trim($v_ipname, "'")) ?>">
			</div>
			<div class="u-mb10 mb-[10px]">
				<label for="v_datasource" class="form-label mb-1 block text-sm font-semibold text-slate-700">
					<?= tohtml( _("Data Source")) ?> <span class="optional text-xs font-normal text-slate-500">(<?= tohtml( _("URL, script or file")) ?>)</span>
				</label>
				<div class="u-pos-relative relative">
					<select
						class="form-select js-datasource-select block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 disabled:bg-slate-100"
						tabindex="-1"
						onchange="this.nextElementSibling.value=this.value"
						data-country-iplists="<?= tohtml(json_encode($country_iplists)) ?>"
						data-blacklist-iplists="<?= tohtml(json_encode($blacklist_iplists)) ?>"
					>
						<option value=""><?= tohtml( _("Clear")) ?></option>
					</select>
					<input type="text" class="form-control list-editor block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-2 focus:outline-blue-200 disabled:bg-slate-100 disabled:text-slate-500 absolute inset-x-1 top-0.5 w-auto! py-1!" name="v_datasource" id="v_datasource" maxlength="255" value="<?= tohtml(trim($v_datasource, "'")) ?>">
				</div>
			</div>
			<div class="u-mb10 mb-[10px]">
				<label for="v_ipver" class="form-label mb-1 block text-sm font-semibold text-slate-700"><?= tohtml( _("IP Version")) ?></label>
				<select class="form-select block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 disabled:bg-slate-100" name="v_ipver" id="v_ipver">
					<option value="v4" <?php if ((!empty($v_ipver)) && ( $v_ipver == "'v4'" )) echo 'selected'?>>IPv4</option>
					<option value="v6" <?php if ((!empty($v_ipver)) && ( $v_ipver == "'v6'" )) echo 'selected'?>>IPv6</option>
				</select>
			</div>
			<div class="u-mb10 mb-[10px]">
				<label for="v_autoupdate" class="form-label mb-1 block text-sm font-semibold text-slate-700"><?= tohtml( _("Auto Update")) ?></label>
				<select class="form-select block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 disabled:bg-slate-100" name="v_autoupdate" id="v_autoupdate">
					<option value="yes" <?php if ((!empty($v_autoupdate)) && ( $v_autoupdate == "'yes'" )) echo 'selected'?>><?= tohtml( _("Yes")) ?></option>
					<option value="no" <?php if ((!empty($v_autoupdate)) && ( $v_autoupdate == "'no'" )) echo 'selected'?>><?= tohtml( _("No")) ?></option>
				</select>
			</div>
		</div>

	</form>

</div>
