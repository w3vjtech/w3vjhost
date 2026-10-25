<!-- Begin toolbar -->
<div class="toolbar sticky top-14 z-20 border-y border-slate-200 bg-white">
	<div class="toolbar-inner mx-auto flex w-full min-w-0 flex-wrap items-center justify-between gap-3 px-4 py-3 md:px-6">
		<div class="toolbar-buttons flex flex-wrap items-center gap-2">
			<a class="button button-secondary button-back js-button-back inline-flex min-h-9 items-center justify-center gap-1.5 rounded-lg border border-blue-600 bg-blue-600 px-4 py-1.5 text-sm font-semibold text-white hover:bg-blue-700 disabled:cursor-not-allowed disabled:opacity-50 border-slate-300! bg-white! text-slate-700! hover:bg-slate-50!" href="/add/webapp/?<?= tohtml(http_build_query(["domain" => $v_domain])) ?>">
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

<!-- Begin form -->
<div class="container mx-auto w-full max-w-none px-4 md:px-6">

	<?php if (!empty($WebappInstaller->getOptions())) { ?>
		<form id="main-form" method="POST" name="v_setup_webapp">
			<input type="hidden" name="token" value="<?= tohtml($_SESSION["token"]) ?>">
			<input type="hidden" name="ok" value="true">

			<div class="form-container mx-auto w-full max-w-2xl py-6">
				<h1 class="u-mb20 mb-[20px]"><?= tohtml(sprintf(_("Install %s"), $WebappInstaller->applicationName())) ?></h1>
				<?php show_alert_message($_SESSION); ?>
				<?php if (!$WebappInstaller->isDomainRootClean()) { ?>
					<div class="alert alert-info u-mb10 mb-4 rounded-lg border p-4 text-sm [&_a]:underline [&_i]:mr-2 border-blue-200 bg-blue-50 text-blue-800 mb-[10px]" role="alert">
						<i class="fas fa-info"></i>
						<div>
							<p class="u-mb10 mb-[10px]"><?= tohtml( _("Data Loss Warning!")) ?></p>
							<p class="u-mb10 mb-[10px]"><?= tohtml( _("Your web folder already has files uploaded to it. The installer will overwrite your files and/or the installation might fail.")) ?></p>
							<p><?php echo sprintf(_("Please make sure ~/web/%s/public_html is empty!"), $v_domain); ?></p>
						</div>
					</div>
				<?php } ?>
				<?php foreach ($WebappInstaller->getOptions() as $form_name => $form_control) {
					$field_name = $WebappInstaller->formNamespace() . $form_name;
					$field_type = $form_control;
					$field_value = "";
					$field_label =
						isset($form_control["label"])
							? htmlentities($form_control["label"])
							: ucwords(str_replace([".","_"], " ", $form_name));
					$field_placeholder = "";
					if (is_array($form_control)) {
						$field_type = !empty($form_control["type"]) ? $form_control["type"] : "text";
						$field_value = !empty($form_control["value"]) ? $form_control["value"] : "";
						$field_placeholder = !empty($form_control["placeholder"]) ? $form_control["placeholder"] : "";
					}
					$field_value = htmlentities($field_value);
					$field_label = htmlentities($field_label);
					$field_name = htmlentities($field_name);
					$field_placeholder = htmlentities($field_placeholder);
				?>
					<div class="u-mb10 mb-[10px]">
						<?php if ($field_type != "boolean"): ?>
							<label for="<?= tohtml($field_name) ?>" class="form-label mb-1 block text-sm font-semibold text-slate-700">
								<?= tohtml($field_label) ?>
								<?php if ($field_type == "password"): ?>
									<button type="button" title="<?= tohtml( _("Generate")) ?>" class="u-unstyled-button u-ml5 js-generate-password ml-[5px] border-0 bg-transparent p-0">
										<i class="fas fa-arrows-rotate icon-green text-green-700"></i>
									</button>
								<?php endif; ?>
							</label>
						<?php endif; ?>

						<?php if ($field_type == "select" && count($form_control["options"])): ?>
							<select class="form-select block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 disabled:bg-slate-100" name="<?= tohtml($field_name) ?>" id="<?= tohtml($field_name) ?>">
								<?php foreach ($form_control["options"] as $key => $option):
									$key = !is_numeric($key) ? $key : $option;
									$selected = (!empty($form_control["value"]) && $key == $form_control["value"]) ? "selected" : ""; ?>
									<option value="<?= tohtml($key) ?>" <?= tohtml($selected) ?>>
										<?= tohtml($option) ?>
									</option>
								<?php endforeach; ?>
							</select>
						<?php elseif ($field_type == "boolean"):
							$checked = !empty($field_value) ? "checked" : ""; ?>
							<div class="form-check flex items-center gap-2">
								<input
									class="form-check-input accent-blue-600"
									type="checkbox"
									name="<?= tohtml($field_name) ?>"
									id="<?= tohtml($field_name) ?>"
									value="true"
									<?= tohtml($checked) ?>
								>
								<label for="<?= tohtml($field_name) ?>">
									<?= tohtml($field_label) ?>
								</label>
							</div>
						<?php else: ?>
							<?php if ($field_type == "password"): ?>
								<div class="u-pos-relative relative">
									<input
										type="text"
										class="form-control js-password-input block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-2 focus:outline-blue-200 disabled:bg-slate-100 disabled:text-slate-500"
										name="<?= tohtml($field_name) ?>"
										id="<?= tohtml($field_name) ?>"
										placeholder="<?= tohtml($field_placeholder) ?>"
									>
									<div class="password-meter relative">
										<meter max="4" class="password-meter-input js-password-meter pr-10"></meter>
									</div>
								</div>
							<?php else: ?>
								<input
									type="text"
									class="form-control block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-2 focus:outline-blue-200 disabled:bg-slate-100 disabled:text-slate-500"
									name="<?= tohtml($field_name) ?>"
									id="<?= tohtml($field_name) ?>"
									placeholder="<?= tohtml($field_placeholder) ?>"
									value="<?= tohtml($field_value) ?>"
								>
							<?php endif; ?>
						<?php endif; ?>
					</div>
				<?php } ?>
			</div>
		</form>
	<?php } ?>
</div>
<!-- End form -->
