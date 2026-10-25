<!-- Begin toolbar -->
<div class="toolbar sticky top-14 z-20 border-y border-slate-200 bg-white">
	<div class="toolbar-inner mx-auto flex w-full min-w-0 flex-wrap items-center justify-between gap-3 px-4 py-3 md:px-6">
		<div class="toolbar-buttons flex flex-wrap items-center gap-2">
			<a class="button button-secondary button-back js-button-back inline-flex min-h-9 items-center justify-center gap-1.5 rounded-lg border border-blue-600 bg-blue-600 px-4 py-1.5 text-sm font-semibold text-white hover:bg-blue-700 disabled:cursor-not-allowed disabled:opacity-50 border-slate-300! bg-white! text-slate-700! hover:bg-slate-50!" href="/list/server/">
				<i class="fas fa-arrow-left icon-blue text-blue-700"></i><?= tohtml( _("Back")) ?>
			</a>
			<a href="/list/server/?cpu" class="button button-secondary inline-flex min-h-9 items-center justify-center gap-1.5 rounded-lg border border-blue-600 bg-blue-600 px-4 py-1.5 text-sm font-semibold text-white hover:bg-blue-700 disabled:cursor-not-allowed disabled:opacity-50 border-slate-300! bg-white! text-slate-700! hover:bg-slate-50!">
				<i class="fas fa-chart-pie icon-green text-green-700"></i><?= tohtml( _("Advanced Details")) ?>
			</a>
		</div>
		<div class="toolbar-right flex min-w-0 max-w-full flex-wrap items-center gap-2 [&_form]:flex [&_form]:min-w-0">
			<a class="toolbar-link<?php if ((empty($period)) || ($period == 'daily')) echo " selected" ?>" href="?<?= tohtml(http_build_query(["period" => 'daily'])) ?>"><?= tohtml( _("Daily")) ?></a>
			<a class="toolbar-link<?php if ((!empty($period)) && ($period == 'weekly')) echo " selected" ?>" href="?<?= tohtml(http_build_query(["period" => 'weekly'])) ?>"><?= tohtml( _("Weekly")) ?></a>
			<a class="toolbar-link<?php if ((!empty($period)) && ($period == 'monthly')) echo " selected" ?>" href="?<?= tohtml(http_build_query(["period" => 'monthly'])) ?>"><?= tohtml( _("Monthly")) ?></a>
			<a class="toolbar-link<?php if ((!empty($period)) && ($period == 'yearly')) echo " selected" ?>" href="?<?= tohtml(http_build_query(["period" => 'yearly'])) ?>"><?= tohtml( _("Yearly")) ?></a>
                        <a class="toolbar-link<?php if ((!empty($period)) && ($period == 'biennially')) echo " selected" ?>" href="?<?= tohtml(http_build_query(["period" => 'biennially'])) ?>"><?= tohtml( _("Biennially")) ?></a>
                        <a class="toolbar-link<?php if ((!empty($period)) && ($period == 'triennially')) echo " selected" ?>" href="?<?= tohtml(http_build_query(["period" => 'triennially'])) ?>"><?= tohtml( _("Triennially")) ?></a>
		</div>
	</div>
</div>
<!-- End toolbar -->

<div class="container mx-auto w-full max-w-none px-4 md:px-6">
	<div class="form-container form-container-wide mx-auto w-full max-w-2xl py-6 max-w-5xl">
		<!-- Begin graph list item loop -->
		<?php foreach ($data as $key => $value) { ?>
			<div class="u-mb40 mb-[40px]">
				<h2 class="u-mb20 mb-[20px]"><?= tohtml($data[$key]["TITLE"]) ?></h2>
				<canvas
					class="u-max-height300 js-rrd-chart max-h-[300px]"
					data-service="<?= tohtml($data[$key]["TYPE"] !== "net" ? $data[$key]["RRD"] : "net_" . $data[$key]["RRD"]) ?>"
					data-period="<?= tohtml($period) ?>"
				></canvas>
			</div>
		<?php } ?>
	</div>
</div>
