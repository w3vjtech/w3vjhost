<!-- Begin toolbar -->
<div class="toolbar sticky top-14 z-20 border-y border-slate-200 bg-white">
	<div class="toolbar-inner mx-auto flex w-full min-w-0 flex-wrap items-center justify-between gap-3 px-4 py-3 md:px-6">
		<div class="toolbar-buttons flex flex-wrap items-center gap-2">
			<a class="button button-secondary button-back js-button-back inline-flex min-h-9 items-center justify-center gap-1.5 rounded-lg border border-blue-600 bg-blue-600 px-4 py-1.5 text-sm font-semibold text-white hover:bg-blue-700 disabled:cursor-not-allowed disabled:opacity-50 border-slate-300! bg-white! text-slate-700! hover:bg-slate-50!" href="/list/web/">
				<i class="fas fa-arrow-left icon-blue text-blue-700"></i><?= tohtml( _("Back")) ?>
			</a>
		</div>
		<div class="toolbar-buttons flex flex-wrap items-center gap-2">
			<a href="/delete/web/cache/?<?= tohtml(http_build_query(["domain" => $v_domain, "token" => $_SESSION['token']])) ?>" class="button button-secondary js-clear-cache-button <?php if (!($v_nginx_cache == 'yes' || (($v_proxy_template == 'caching' || is_int(strpos($v_proxy_template, 'caching-'))) && $_SESSION['PROXY_SYSTEM'] == 'nginx'))) { echo "u-hidden"; } ?> inline-flex min-h-9 items-center justify-center gap-1.5 rounded-lg border border-blue-600 bg-blue-600 px-4 py-1.5 text-sm font-semibold text-white hover:bg-blue-700 disabled:cursor-not-allowed disabled:opacity-50 border-slate-300! bg-white! text-slate-700! hover:bg-slate-50!">
				<i class="fas fa-trash icon-red text-red-700"></i><?= tohtml( _("Purge NGINX Cache")) ?>
			</a>
			<?php if ($_SESSION["PLUGIN_APP_INSTALLER"] !== "false") { ?>
				<a href="/add/webapp/?<?= tohtml(http_build_query(["domain" => $v_domain])) ?>" class="button button-secondary inline-flex min-h-9 items-center justify-center gap-1.5 rounded-lg border border-blue-600 bg-blue-600 px-4 py-1.5 text-sm font-semibold text-white hover:bg-blue-700 disabled:cursor-not-allowed disabled:opacity-50 border-slate-300! bg-white! text-slate-700! hover:bg-slate-50!">
					<i class="fas fa-magic icon-blue text-blue-700"></i><?= tohtml( _("Quick Install App")) ?>
				</a>
			<?php } ?>
			<button type="submit" class="button inline-flex min-h-9 items-center justify-center gap-1.5 rounded-lg border border-blue-600 bg-blue-600 px-4 py-1.5 text-sm font-semibold text-white hover:bg-blue-700 disabled:cursor-not-allowed disabled:opacity-50" form="main-form">
				<i class="fas fa-floppy-disk icon-purple text-purple-700"></i><?= tohtml( _("Save")) ?>
			</button>
		</div>
	</div>
</div>
<!-- End toolbar -->

<div class="container mx-auto w-full max-w-none px-4 md:px-6">
	<?php
		$web_x_data = [
			"statsAuthEnabled" => !empty($v_stats_user),
			"redirectEnabled" => !empty($v_redirect),
			"sslEnabled" => $v_ssl == "yes",
			"letsEncryptEnabled" => $v_letsencrypt == "yes" || $v_letsencrypt == "on",
			"showCertificates" => !($v_letsencrypt == "yes" || $v_letsencrypt == "on"),
			"showAdvanced" => false,
			"nginxCacheEnabled" => $v_nginx_cache == "yes",
			"proxySupportEnabled" => !empty($v_proxy),
			"customDocumentRootEnabled" => !empty($v_custom_doc_root),
		];
	?>

	<form
		x-data="<?= tohtml(json_encode($web_x_data, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_THROW_ON_ERROR)) ?>"
		id="main-form"
		name="v_edit_web"
		method="post"
		class="<?= tohtml($v_status) ?> js-enable-inputs-on-submit"
	>
		<input type="hidden" name="token" value="<?= tohtml($_SESSION["token"]) ?>">
		<input type="hidden" name="save" value="save">

		<div class="form-container mx-auto w-full max-w-2xl py-6">
			<h1 class="u-mb20 mb-[20px]"><?= tohtml( _("Edit Web Domain")) ?></h1>
			<?php show_alert_message($_SESSION); ?>
			<div class="u-mb10 mb-[10px]">
				<label for="v_domain" class="form-label mb-1 block text-sm font-semibold text-slate-700"><?= tohtml( _("Domain")) ?></label>
				<input type="text" class="form-control block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-2 focus:outline-blue-200 disabled:bg-slate-100 disabled:text-slate-500" name="v_domain" id="v_domain" value="<?= tohtml(trim($v_domain, "'")) ?>" disabled required>
				<input type="hidden" name="v_domain" value="<?= tohtml(trim($v_domain, "'")) ?>">
			</div>
			<div class="u-mb10 mb-[10px]">
				<label for="v_aliases" class="form-label mb-1 block text-sm font-semibold text-slate-700"><?= tohtml( _("Aliases")) ?></label>
				<textarea class="form-control block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-2 focus:outline-blue-200 disabled:bg-slate-100 disabled:text-slate-500" name="v_aliases" id="v_aliases"><?= tohtml(trim($v_aliases, "'")) ?></textarea>
			</div>
			<?php if ($v_letsencrypt == "yes" || $v_letsencrypt == "on") { ?>
				<div class="alert alert-info u-mb10 mb-4 rounded-lg border p-4 text-sm [&_a]:underline [&_i]:mr-2 border-blue-200 bg-blue-50 text-blue-800 mb-[10px]" role="alert">
					<i class="fas fa-exclamation"></i>
					<p><?= tohtml( _("If the aliases changes, Let's Encrypt will obtain a new SSL certificate.")) ?></p>
				</div>
			<?php } ?>
			<div class="u-mb20 mb-[20px]">
				<label for="v_ip" class="form-label mb-1 block text-sm font-semibold text-slate-700"><?= tohtml( _("IP Address")) ?></label>
				<select class="form-select block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 disabled:bg-slate-100" name="v_ip" id="v_ip">
					<?php
						foreach ($ips as $ip => $value) {
							$display_ip = htmlentities(empty($value['NAT']) ? $ip : "{$value['NAT']}");
							$ip_selected = ((!empty($v_ip) && $ip == $v_ip) || $v_ip == "'{$ip}'")	? 'selected' : '';
							echo "\n\t\t\t\t\t\t\t\t\t\t\t\t<option value=\"{$ip}\" {$ip_selected}>{$display_ip}</option>\n";
						}
					?>
				</select>
			</div>
			<div class="u-mb10 mb-[10px]">
				<label for="v_stats" class="form-label mb-1 block text-sm font-semibold text-slate-700"><?= tohtml( _("Web Statistics")) ?></label>
				<select class="form-select js-stats-select block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 disabled:bg-slate-100" name="v_stats" id="v_stats">
					<?php
						foreach ($stats as $key => $value) {
							$svalue = "'".$value."'";
							echo "\t\t\t\t<option value=\"".htmlentities($value)."\"";
							if (empty($v_stats)) $v_stats = 'none';
							if (( $value == $v_stats ) || ($svalue == $v_stats )){
								echo ' selected' ;
							}
						echo ">". htmlentities(_($value)) ."</option>\n";
						}
					?>
				</select>
			</div>
			<div class="u-mb10 js-stats-auth mb-[10px]" style="<?php if ($v_stats == "none") { ?>display:none<?php } ?>">
				<div class="form-check flex items-center gap-2">
					<input x-model="statsAuthEnabled" class="form-check-input accent-blue-600" type="checkbox" name="v_stats_auth" id="v_stats_auth">
					<label for="v_stats_auth">
						<?= tohtml( _("Statistics Authorization")) ?>
					</label>
				</div>
			</div>
			<div class="u-pl30 js-stats-auth pl-[30px]">
				<div x-cloak x-show="statsAuthEnabled" name="v-add-web-domain-stats-user">
					<div class="u-mb10 mb-[10px]">
						<label for="v_stats_user" class="form-label mb-1 block text-sm font-semibold text-slate-700"><?= tohtml( _("Username")) ?></label>
						<input type="text" class="form-control block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-2 focus:outline-blue-200 disabled:bg-slate-100 disabled:text-slate-500" name="v_stats_user" id="v_stats_user" value="<?= tohtml(trim($v_stats_user, "'")) ?>">
					</div>
					<div class="u-mb20 mb-[20px]">
						<label for="v_password" class="form-label mb-1 block text-sm font-semibold text-slate-700">
							<?= tohtml( _("Password")) ?>
							<button type="button" title="<?= tohtml( _("Generate")) ?>" class="u-unstyled-button u-ml5 js-generate-password ml-[5px] border-0 bg-transparent p-0">
								<i class="fas fa-arrows-rotate icon-green text-green-700"></i>
							</button>
						</label>
						<div class="u-pos-relative relative">
							<input type="text" class="form-control js-password-input block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-2 focus:outline-blue-200 disabled:bg-slate-100 disabled:text-slate-500" name="v_stats_password" id="v_password" value="<?= tohtml(trim($v_stats_password, "'")) ?>">
						</div>
					</div>
				</div>
			</div>
			<div class="form-check u-mb10 flex items-center gap-2 mb-[10px]">
				<input x-model="redirectEnabled" class="form-check-input accent-blue-600" type="checkbox" name="v-redirect-checkbox" id="v-redirect-checkbox">
				<label for="v-redirect-checkbox">
					<?= tohtml( _("Enable domain redirection")) ?>
				</label>
			</div>
			<div x-cloak x-show="redirectEnabled" id="v_redirect" class="u-pl30 u-mb10 pl-[30px] mb-[10px]">
				<div class="form-check flex items-center gap-2">
					<input class="form-check-input js-redirect-custom-value accent-blue-600" type="radio" name="v-redirect" id="v-redirect-radio-1" value="<?= tohtml('www.'.$v_domain) ?>" <?php if ($v_redirect == "www.".$v_domain) echo 'checked'; ?>>
					<label for="v-redirect-radio-1">
						<?= tohtml(sprintf(_("Redirect visitors to %s"), "www." . $v_domain)) ?>
					</label>
				</div>
				<div class="form-check flex items-center gap-2">
					<input class="form-check-input js-redirect-custom-value accent-blue-600" type="radio" name="v-redirect" id="v-redirect-radio-2" value="<?= tohtml($v_domain) ?>" <?php if ( $v_redirect == $v_domain) echo 'checked'; ?>>
					<label for="v-redirect-radio-2">
						<?= tohtml(sprintf(_("Redirect visitors to %s"), $v_domain)) ?>
					</label>
				</div>
				<div class="form-check flex items-center gap-2">
					<input class="form-check-input js-redirect-custom-value accent-blue-600" type="radio" name="v-redirect" id="v-redirect-radio-3" value="custom" <?php if ( !empty($v_redirect_custom)) echo 'checked'; ?>>
					<label for="v-redirect-radio-3">
						<?= tohtml( _("Redirect visitors to a custom domain or web address")) ?>
					</label>
				</div>
				<div class="u-pl30 js-custom-redirect-fields <?php if (empty($v_redirect_custom)) { echo 'u-hidden'; } ?> pl-[30px]">
					<div class="u-mt15 u-mb10 mt-[15px] mb-[10px]">
						<label for="v-redirect-custom" class="form-label mb-1 block text-sm font-semibold text-slate-700"><?= tohtml( _("Target domain or URL")) ?></label>
						<input type="text" class="form-control block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-2 focus:outline-blue-200 disabled:bg-slate-100 disabled:text-slate-500" name="v-redirect-custom" id="v-redirect-custom" value="<?= tohtml($v_redirect_custom) ?>">
					</div>
					<div class="u-mb20 mb-[20px]">
						<label for="v-redirect-code" class="form-label mb-1 block text-sm font-semibold text-slate-700"><?= tohtml( _("Status code")) ?>:</label>
						<select class="form-select block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 disabled:bg-slate-100" name="v-redirect-code" id="v-redirect-code">
							<?php foreach ($redirect_code_options as $status_code): ?>
								<option value="<?= tohtml($status_code) ?>" <?php if ((int) $v_redirect_code === (int) $status_code) echo 'selected="selected"'; ?>>
								<?= tohtml($status_code) ?>
							</option>
							<?php endforeach; ?>
						</select>
					</div>
				</div>
			</div>
			<div class="form-check u-mb10 flex items-center gap-2 mb-[10px]">
				<input x-model="sslEnabled" class="form-check-input accent-blue-600" type="checkbox" name="v_ssl" id="v_ssl">
				<label for="v_ssl">
					<?= tohtml( _("Enable SSL for this domain")) ?>
				</label>
			</div>
			<div x-cloak x-show="sslEnabled" class="u-pl30 pl-[30px]">
				<div class="form-check u-mb10 flex items-center gap-2 mb-[10px]">
					<input x-model="letsEncryptEnabled" class="form-check-input js-toggle-lets-encrypt accent-blue-600" type="checkbox" name="v_letsencrypt" id="v_letsencrypt">
					<label for="v_letsencrypt">
						<?= tohtml( _("Use Let's Encrypt to obtain SSL certificate")) ?>
					</label>
				</div>
				<div x-cloak x-show="letsEncryptEnabled" id="v_ssl_key_algo_wrapper" class="u-pl30 u-mb10 pl-[30px] mb-[10px]">
					<label for="v_ssl_key_algo" class="form-label mb-1 block text-sm font-semibold text-slate-700"><?= tohtml( _("Key Type")) ?></label>
					<select class="form-select block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 disabled:bg-slate-100" name="v_ssl_key_algo" id="v_ssl_key_algo">
						<option value="ecdsa-256" <?php if ($v_ssl_key_algo == "ecdsa-256" || $v_ssl_key_algo == "ecdsa") echo 'selected'; ?>>
							ECDSA P-256 (<?= tohtml( _("recommended")) ?>)
						</option>
						<option value="ecdsa-384" <?php if ($v_ssl_key_algo == "ecdsa-384") echo 'selected'; ?>>
							ECDSA P-384
						</option>
						<option value="rsa" <?php if ($v_ssl_key_algo == "rsa") echo 'selected'; ?>>
							RSA 4096
						</option>
					</select>
				</div>
				<div class="form-check u-mb10 flex items-center gap-2 mb-[10px]">
					<input class="form-check-input accent-blue-600" type="checkbox" name="v_ssl_forcessl" id="v_ssl_forcessl" <?php if ($v_ssl_forcessl == 'yes') echo 'checked' ?>>
					<label for="v_ssl_forcessl">
						<?= tohtml( _("Enable automatic HTTPS redirection")) ?>
					</label>
				</div>
				<div class="form-check u-mb20 flex items-center gap-2 mb-[20px]">
					<input class="form-check-input accent-blue-600" type="checkbox" name="v_ssl_hsts" id="ssl_hsts" <?php if ($v_ssl_hsts == 'yes') echo 'checked' ?>>
					<label for="ssl_hsts">
						<?= tohtml( _("Enable HTTP Strict Transport Security (HSTS)")) ?>
						<a href="https://en.wikipedia.org/wiki/HTTP_Strict_Transport_Security" target="_blank">
							<i class="fas fa-question-circle"></i>
						</a>
					</label>
				</div>
				<div x-cloak x-show="showCertificates" class="js-ssl-details">
					<div class="u-mb10 mb-[10px]">
						<label for="ssl_crt" class="form-label mb-1 block text-sm font-semibold text-slate-700">
							<?= tohtml( _("SSL Certificate")) ?>
							<span id="generate-csr"> / <a class="form-link inline-flex items-center gap-1 rounded px-2 py-1 text-blue-700 hover:bg-blue-50" target="_blank" href="/generate/ssl/?<?= tohtml(http_build_query(["domain" => $v_domain])) ?>"><?= tohtml( _("Generate Self-Signed SSL Certificate")) ?></a></span>
						</label>
						<textarea class="form-control u-min-height100 u-console block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-2 focus:outline-blue-200 disabled:bg-slate-100 disabled:text-slate-500 min-h-[100px] font-mono whitespace-pre leading-tight" name="v_ssl_crt" id="ssl_crt"><?= tohtml(trim($v_ssl_crt, "'")) ?></textarea>
					</div>
					<div class="u-mb10 mb-[10px]">
						<label for="v_ssl_key" class="form-label mb-1 block text-sm font-semibold text-slate-700"><?= tohtml( _("SSL Private Key")) ?></label>
						<textarea class="form-control u-min-height100 u-console block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-2 focus:outline-blue-200 disabled:bg-slate-100 disabled:text-slate-500 min-h-[100px] font-mono whitespace-pre leading-tight" name="v_ssl_key" id="v_ssl_key"><?= tohtml(trim($v_ssl_key, "'")) ?></textarea>
					</div>
					<div class="u-mb20 mb-[20px]">
						<label for="v_ssl_ca" class="form-label mb-1 block text-sm font-semibold text-slate-700">
							<?= tohtml( _("SSL Certificate Authority / Intermediate")) ?> <span class="optional text-xs font-normal text-slate-500">(<?= tohtml( _("Optional")) ?>)</span>
						</label>
						<textarea class="form-control u-min-height100 u-console block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-2 focus:outline-blue-200 disabled:bg-slate-100 disabled:text-slate-500 min-h-[100px] font-mono whitespace-pre leading-tight" name="v_ssl_ca" id="v_ssl_ca"><?= tohtml(trim($v_ssl_ca, "'")) ?></textarea>
					</div>
				</div>
				<?php if ($v_ssl != "no") { ?>
					<ul class="values-list">
						<li class="values-list-item flex flex-wrap gap-2 py-1">
							<span class="values-list-label min-w-32 font-semibold"><?= tohtml( _("Issued To")) ?></span>
							<span class="values-list-value min-w-0 wrap-anywhere"><?= tohtml($v_ssl_subject) ?></span>
						</li>
						<?php if ($v_ssl_aliases) {
							$v_ssl_aliases = str_replace(",", ", ", $v_ssl_aliases); ?>
							<li class="values-list-item flex flex-wrap gap-2 py-1">
								<span class="values-list-label min-w-32 font-semibold"><?= tohtml( _("Alternate")) ?></span>
								<span class="values-list-value min-w-0 wrap-anywhere"><?= tohtml($v_ssl_aliases) ?></span>
							</li>
						<?php } ?>
						<li class="values-list-item flex flex-wrap gap-2 py-1">
							<span class="values-list-label min-w-32 font-semibold"><?= tohtml( _("Not Before")) ?></span>
							<span class="values-list-value min-w-0 wrap-anywhere"><?= tohtml($v_ssl_not_before) ?></span>
						</li>
						<li class="values-list-item flex flex-wrap gap-2 py-1">
							<span class="values-list-label min-w-32 font-semibold"><?= tohtml( _("Not After")) ?></span>
							<span class="values-list-value min-w-0 wrap-anywhere"><?= tohtml($v_ssl_not_after) ?></span>
						</li>
						<li class="values-list-item flex flex-wrap gap-2 py-1">
							<span class="values-list-label min-w-32 font-semibold"><?= tohtml( _("Signature")) ?></span>
							<span class="values-list-value min-w-0 wrap-anywhere"><?= tohtml($v_ssl_signature) ?></span>
						</li>
						<li class="values-list-item flex flex-wrap gap-2 py-1">
							<span class="values-list-label min-w-32 font-semibold"><?= tohtml( _("Key Size")) ?></span>
							<span class="values-list-value min-w-0 wrap-anywhere"><?= tohtml($v_ssl_pub_key) ?></span>
						</li>
						<li class="values-list-item flex flex-wrap gap-2 py-1">
							<span class="values-list-label min-w-32 font-semibold"><?= tohtml( _("Issued By")) ?></span>
							<span class="values-list-value min-w-0 wrap-anywhere"><?= tohtml($v_ssl_issuer) ?></span>
						</li>
						<p x-cloak x-show="letsEncryptEnabled" id="letsinfo">
							<button
								type="button"
								class="form-link inline-flex items-center gap-1 rounded px-2 py-1 text-blue-700 hover:bg-blue-50"
								x-on:click="showCertificates = !showCertificates"
								x-text='showCertificates ? <?= json_encode(_("Hide Certificate"), JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_THROW_ON_ERROR) ?> : <?= json_encode(_("Show Certificate"), JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_THROW_ON_ERROR) ?>'>
								<?= tohtml( _("Show Certificate")) ?>
							</button>
						</p>
					</ul>
				<?php } ?>
			</div>
			<div class="u-mt15 u-mb20 mt-[15px] mb-[20px]">
				<button x-on:click="showAdvanced = !showAdvanced" type="button" class="button button-secondary inline-flex min-h-9 items-center justify-center gap-1.5 rounded-lg border border-blue-600 bg-blue-600 px-4 py-1.5 text-sm font-semibold text-white hover:bg-blue-700 disabled:cursor-not-allowed disabled:opacity-50 border-slate-300! bg-white! text-slate-700! hover:bg-slate-50!">
					<?= tohtml( _("Advanced Options")) ?>
				</button>
			</div>
			<div x-cloak x-show="showAdvanced">
				<?php if ($_SESSION["userContext"] === "admin" || ($_SESSION["userContext"] === "user" && $_SESSION["POLICY_USER_EDIT_WEB_TEMPLATES"] === "yes")) { ?>
					<div class="u-mb10 mb-[10px]">
						<label for="v_template" class="form-label mb-1 block text-sm font-semibold text-slate-700">
							<?= tohtml( _("Web Template")) ?> <span class="optional text-xs font-normal text-slate-500"><?= tohtml(strtoupper($_SESSION["WEB_SYSTEM"])) ?></span>
						</label>
						<select class="form-select block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 disabled:bg-slate-100" name="v_template" id="v_template">
							<?php
								foreach ($templates as $key => $value) {
									echo "\t\t\t\t<option value=\"".htmlentities($value)."\"";
									$svalue = "'".$value."'";
									if ((!empty($v_template)) && ( $value == $v_template ) || ($svalue == $v_template)){
										echo ' selected' ;
									}
									echo ">".htmlentities($value)."</option>\n";
								}
							?>
						</select>
					</div>
					<?php if ($_SESSION["WEB_SYSTEM"] == "nginx") { ?>
						<div class="form-check u-mb10 flex items-center gap-2 mb-[10px]">
							<input x-model="nginxCacheEnabled" class="form-check-input accent-blue-600" type="checkbox" name="v_nginx_cache_check" id="v_nginx_cache_check">
							<label for="v_nginx_cache_check">
								<?= tohtml( _("Enable FastCGI cache")) ?>
								<a href="https://hestiacp.com/docs/server-administration/web-templates.html#nginx-fastcgi-cache" target="_blank" class="u-ml5 ml-[5px]">
									<i class="fas fa-circle-question"></i>
								</a>
							</label>
						</div>
						<div x-cloak x-show="nginxCacheEnabled" id="v_nginx_duration" class="u-pl30 pl-[30px]">
							<div class="u-mb10 mb-[10px]">
								<label for="v_nginx_cache_duration" class="form-label mb-1 block text-sm font-semibold text-slate-700">
									<?= tohtml( _("Cache Duration")) ?> <span class="optional text-xs font-normal text-slate-500">(<?= tohtml( _("For example")) ?>: 30s, 10m or 1d)</span>
								</label>
								<input type="text" class="form-control block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-2 focus:outline-blue-200 disabled:bg-slate-100 disabled:text-slate-500" name="v_nginx_cache_duration" id="v_nginx_cache_duration" value="<?= tohtml(trim($v_nginx_cache_duration, "'")) ?>">
							</div>
						</div>
					<?php } ?>
					<?php if (!empty($_SESSION["WEB_BACKEND"])) { ?>
						<div class="u-mb10 mb-[10px]">
								<label for="v_backend_template" class="form-label mb-1 block text-sm font-semibold text-slate-700">
									<?= tohtml( _("Backend Template")) ?> <span class="optional text-xs font-normal text-slate-500"><?= tohtml(strtoupper($_SESSION["WEB_BACKEND"])) ?></span>
								</label>
							<select class="form-select block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 disabled:bg-slate-100" name="v_backend_template" id="v_backend_template">
								<?php
									foreach ($backend_templates as $key => $value) {
										echo "\t\t\t\t<option value=\"".tohtml($value)."\"";
										$svalue = "'".$value."'";
										if ((!empty($v_backend_template)) && (($value == $v_backend_template) || ($svalue == $v_backend_template))) {
											echo ' selected' ;
										}
										if ((empty($v_backend_template)) && ($value == 'default')){
											echo ' selected' ;
										}
										echo ">".tohtml($value)."</option>\n";
									}
								?>
							</select>
						</div>
					<?php } ?>
					<?php if (!empty($_SESSION["PROXY_SYSTEM"])) { ?>
						<div class="hidden">
							<div class="form-check u-mb10 flex items-center gap-2 mb-[10px]">
								<input x-model="proxySupportEnabled" class="form-check-input accent-blue-600" type="checkbox" name="v_proxy" id="v_proxy">
									<label for="v_proxy">
										<?= tohtml( _("Proxy Support")) ?> <span class="optional text-xs font-normal text-slate-500"><?= tohtml(strtoupper($_SESSION["PROXY_SYSTEM"])) ?></span>
									</label>
							</div>
						</div>
						<div x-cloak x-show="proxySupportEnabled" id="proxytable">
							<div class="u-mb10 mb-[10px]">
								<label for="v_proxy_template" class="form-label mb-1 block text-sm font-semibold text-slate-700"><?= tohtml( _("Proxy Template")) ?></label>
								<select class="form-select js-proxy-template-select block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 disabled:bg-slate-100" name="v_proxy_template" id="v_proxy_template">
									<?php
										foreach ($proxy_templates as $key => $value) {
											echo "\t\t\t\t<option value=\"".tohtml($value)."\"";
											$svalue = "'".$value."'";
											if ((!empty($v_proxy_template)) && (($value == $v_proxy_template) || ($svalue == $v_proxy_template))) {
												echo ' selected' ;
											}
											if ((empty($v_proxy_template)) && ($value == 'default')){
												echo ' selected' ;
											}
											echo ">".tohtml($value)."</option>\n";
										}
									?>
								</select>
							</div>
							<div class="u-mb10 mb-[10px]">
								<label for="v_proxy_ext" class="form-label mb-1 block text-sm font-semibold text-slate-700"><?= tohtml( _("Proxy Extensions")) ?></label>
								<textarea class="form-control u-min-height100 block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-2 focus:outline-blue-200 disabled:bg-slate-100 disabled:text-slate-500 min-h-[100px]" name="v_proxy_ext" id="v_proxy_ext"><?php if (!empty($v_proxy_ext)) { echo tohtml(trim($v_proxy_ext, "'"));} else { echo 'jpg, jpeg, gif, png, ico, svg, css, zip, tgz, gz, rar, bz2, exe, pdf, doc, xls, ppt, txt, odt, ods, odp, odf, tar, bmp, rtf, js, mp3, avi, mpeg, flv, html, htm'; } ?></textarea>
							</div>
						</div>
					<?php } ?>
				<?php } ?>
				<div class="form-check u-mb10 flex items-center gap-2 mb-[10px]">
					<input x-model="customDocumentRootEnabled" class="form-check-input accent-blue-600" type="checkbox" name="v_custom_doc_root_check" id="v_custom_doc_root_check">
					<label for="v_custom_doc_root_check">
						<?= tohtml( _("Custom document root")) ?>
					</label>
				</div>
				<div x-cloak x-show="customDocumentRootEnabled" id="v_custom_doc_root" class="u-pl30 pl-[30px]">
					<div class="u-mb10 mb-[10px]">
						<label for="v-custom-doc-domain" class="form-label mb-1 block text-sm font-semibold text-slate-700"><?= tohtml( _("Point to")) ?></label>
						<input type="hidden" class="js-custom-docroot-prepath" name="v-custom-doc-root_prepath" value="<?= tohtml($v_custom_doc_root_prepath) ?>">
						<select class="form-select js-custom-docroot-domain block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 disabled:bg-slate-100" name="v-custom-doc-domain" id="v-custom-doc-domain">
							<?php foreach ($user_domains as $domain): ?>
							<option value="<?= tohtml($domain) ?>"
								<?php if ($v_custom_doc_domain === $domain || (empty($v_custom_doc_domain) && $domain === $v_domain)) echo 'selected="selected"'; ?>>
								<?= tohtml($domain) ?>
							</option>
							<?php endforeach; ?>
						</select>
					</div>
					<div class="u-mb10 mb-[10px]">
						<label for="v-custom-doc-folder" class="form-label mb-1 block text-sm font-semibold text-slate-700">
							<?= tohtml( _("Directory")) ?> <span class="optional text-xs font-normal text-slate-500">(<?= tohtml( _("Optional")) ?>)</span>
						</label>
						<input type="text" class="form-control js-custom-docroot-dir block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-2 focus:outline-blue-200 disabled:bg-slate-100 disabled:text-slate-500" name="v-custom-doc-folder" id="v-custom-doc-folder" value="<?= tohtml(trim($v_custom_doc_folder, "'")) ?>">
						<small class="js-custom-docroot-hint"></small>
					</div>
				</div>
				<?php if (in_array($_SESSION["FTP_SYSTEM"], ["vsftpd", "proftpd"])) { ?>
					<div class="form-check u-mb10 flex items-center gap-2 mb-[10px]">
						<input class="form-check-input js-toggle-ftp-accounts accent-blue-600" type="checkbox" name="v_ftp" id="v_ftp" <?php if (!empty($v_ftp_user)) echo 'checked' ?>>
						<label for="v_ftp">
							<?= tohtml( _("Additional FTP account(s)")) ?>
						</label>
					</div>
					<div class="js-active-ftp-accounts">
						<?php foreach ($v_ftp_users as $i => $ftp_user): ?>
						<?php
							$v_ftp_user     = $ftp_user['v_ftp_user'];
							$v_ftp_password = $ftp_user['v_ftp_password'];
							$v_ftp_path     = $ftp_user['v_ftp_path'];
							$v_ftp_email    = $ftp_user['v_ftp_email'];
							$v_ftp_pre_path = $ftp_user['v_ftp_pre_path'];
						?>
						<div class="js-ftp-account js-ftp-account-nrm" name="v_add_domain_ftp" style="<?php if (empty($v_ftp_user)) { echo 'display: none;'; } ?>">
							<div class="u-mb10 mb-[10px]">
								<?= tohtml( _("FTP")) ?> #<span class="js-ftp-user-number"><?= tohtml($i + 1) ?></span>
								<button type="button" class="form-link form-link-danger u-ml5 js-delete-ftp-account inline-flex items-center gap-1 rounded px-2 py-1 text-blue-700 hover:bg-blue-50 text-red-700! ml-[5px]"><?= tohtml( _("Delete")) ?></button>
								<input type="hidden" class="js-ftp-user-deleted" name="v_ftp_user[<?= tohtml($i) ?>][delete]" value="0">
								<input type="hidden" class="js-ftp-user-is-new" name="v_ftp_user[<?= tohtml($i) ?>][is_new]" value="<?= tohtml($ftp_user['is_new']) ?>">
							</div>
							<div class="u-pl30 u-mb10 pl-[30px] mb-[10px]">
								<label for="v_ftp_user[<?= tohtml($i) ?>][v_ftp_user]" class="form-label mb-1 block text-sm font-semibold text-slate-700">
									<?= tohtml( _("Username")) ?><br>
									<span class="text-slate-500"><?= tohtml(sprintf(_('Prefix %s will be added to username automatically'),$user_plain."_")) ?></span>
								</label>
								<input type="text" class="form-control js-ftp-user block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-2 focus:outline-blue-200 disabled:bg-slate-100 disabled:text-slate-500"<?= $ftp_user['is_new'] != 1 ? ' disabled="disabled"' : '' ?>
								name="v_ftp_user[<?= tohtml($i) ?>][v_ftp_user]" id="v_ftp_user[<?= tohtml($i) ?>][v_ftp_user]" value="<?= tohtml(trim($v_ftp_user, "'")) ?>">
								<small class="hint js-ftp-user-hint text-sm leading-6 text-slate-500"></small>
							</div>
							<div class="u-pl30 u-mb10 pl-[30px] mb-[10px]">
								<label for="v_ftp_user[<?= tohtml($i) ?>][v_ftp_password]" class="form-label mb-1 block text-sm font-semibold text-slate-700">
									<?= tohtml( _("Password")) ?>
									<button type="button" title="<?= tohtml( _("Generate")) ?>" class="u-unstyled-button u-ml5 js-ftp-password-generate ml-[5px] border-0 bg-transparent p-0">
										<i class="fas fa-arrows-rotate icon-green text-green-700"></i>
									</button>
								</label>
								<input type="text" class="form-control js-ftp-user-psw block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-2 focus:outline-blue-200 disabled:bg-slate-100 disabled:text-slate-500" name="v_ftp_user[<?= tohtml($i) ?>][v_ftp_password]" id="v_ftp_user[<?= tohtml($i) ?>][v_ftp_password]" value="<?= tohtml(trim($v_ftp_password, "'")) ?>">
							</div>
							<div class="u-pl30 u-mb10 pl-[30px] mb-[10px]">
								<label for="v_ftp_user[<?= tohtml($i) ?>][v_ftp_path]" class="form-label mb-1 block text-sm font-semibold text-slate-700"><?= tohtml( _("Path")) ?></label>
								<input type="hidden" name="v_ftp_pre_path" value="<?= tohtml(!empty($v_ftp_pre_path) ? trim($v_ftp_pre_path, "'") : '/') ?>">
								<input type="hidden" name="v_ftp_user[<?= tohtml($i) ?>][v_ftp_path_prev]" value="<?php if (!empty($v_ftp_path)) echo tohtml(($v_ftp_path[0] != '/' ? '/' : '') . trim($v_ftp_path, "'")); ?>">
								<input type="text" class="form-control js-ftp-path block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-2 focus:outline-blue-200 disabled:bg-slate-100 disabled:text-slate-500" name="v_ftp_user[<?= tohtml($i) ?>][v_ftp_path]" id="v_ftp_user[<?= tohtml($i) ?>][v_ftp_path]" value="<?php if (!empty($v_ftp_path)) echo tohtml(($v_ftp_path[0] != '/' ? '/' : '') . trim($v_ftp_path, "'")); ?>">
								<span class="hint-prefix"><?= tohtml(trim($v_ftp_pre_path, "'")) ?></span><span class="hint js-ftp-path-hint text-sm leading-6 text-slate-500"></span>
							</div>
							<?php if ($ftp_user['is_new'] == 1): ?>
								<div class="u-pl30 u-mb10 pl-[30px] mb-[10px]">
									<label for="v_ftp_user[<?= tohtml($i) ?>][v_ftp_email]" class="form-label mb-1 block text-sm font-semibold text-slate-700"><?= tohtml( _("Send FTP credentials to email")) ?></label>
									<input type="email" class="form-control js-email-alert-on-psw block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-2 focus:outline-blue-200 disabled:bg-slate-100 disabled:text-slate-500" name="v_ftp_user[<?= tohtml($i) ?>][v_ftp_email]" id="v_ftp_user[<?= tohtml($i) ?>][v_ftp_email]" value="<?= tohtml(trim($v_ftp_email, "'")) ?>">
								</div>
							<?php endif; ?>
						</div>
						<?php endforeach; ?>
					</div>

					<button type="button" class="form-link u-mt20 js-add-ftp-account inline-flex items-center gap-1 rounded px-2 py-1 text-blue-700 hover:bg-blue-50 mt-[20px]" style="<?php if (empty($v_ftp_user)) echo 'display: none;' ?>">
						<?= tohtml( _("Add FTP account")) ?>
					</button>
				<?php } ?>
			</div>
		</div>

	</form>

</div>

<div class="u-hidden js-ftp-account-template">
	<div class="js-ftp-account js-ftp-account-nrm" name="v_add_domain_ftp">
		<div class="u-mb10 mb-[10px]">
			<?= tohtml( _("FTP")) ?> #<span class="js-ftp-user-number"></span>
			<button type="button" class="form-link form-link-danger u-ml5 js-delete-ftp-account inline-flex items-center gap-1 rounded px-2 py-1 text-blue-700 hover:bg-blue-50 text-red-700! ml-[5px]"><?= tohtml( _("Delete")) ?></button>
			<input type="hidden" class="js-ftp-user-deleted" name="v_ftp_user[%INDEX%][delete]" value="0">
			<input type="hidden" class="js-ftp-user-is-new" name="v_ftp_user[%INDEX%][is_new]" value="1">
		</div>
		<div class="u-pl30 u-mb10 pl-[30px] mb-[10px]">
			<label for="v_ftp_user[%INDEX%][v_ftp_user]" class="form-label mb-1 block text-sm font-semibold text-slate-700">
				<?= tohtml( _("Username")) ?><br>
				<span class="text-slate-500"><?= tohtml(sprintf(_("Prefix %s will be added to username automatically"), $user_plain . "_")) ?></span>
			</label>
			<input type="text" class="form-control js-ftp-user block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-2 focus:outline-blue-200 disabled:bg-slate-100 disabled:text-slate-500" name="v_ftp_user[%INDEX%][v_ftp_user]" id="v_ftp_user[%INDEX%][v_ftp_user]" value="">
			<small class="hint js-ftp-user-hint text-sm leading-6 text-slate-500"></small>
		</div>
		<div class="u-pl30 u-mb10 pl-[30px] mb-[10px]">
			<label for="v_ftp_user[%INDEX%][v_ftp_password]" class="form-label mb-1 block text-sm font-semibold text-slate-700">
				<?= tohtml( _("Password")) ?>
				<button type="button" title="<?= tohtml( _("Generate")) ?>" class="u-unstyled-button u-ml5 js-ftp-password-generate ml-[5px] border-0 bg-transparent p-0">
					<i class="fas fa-arrows-rotate icon-green text-green-700"></i>
				</button>
			</label>
			<input type="text" class="form-control js-ftp-user-psw block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-2 focus:outline-blue-200 disabled:bg-slate-100 disabled:text-slate-500" name="v_ftp_user[%INDEX%][v_ftp_password]" id="v_ftp_user[%INDEX%][v_ftp_password]">
		</div>
		<div class="u-pl30 u-mb10 pl-[30px] mb-[10px]">
			<label for="v_ftp_user[%INDEX%][v_ftp_path]" class="form-label mb-1 block text-sm font-semibold text-slate-700"><?= tohtml( _("Path")) ?></label>
			<input type="hidden" name="v_ftp_pre_path" value="">
			<input type="text" class="form-control js-ftp-path block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-2 focus:outline-blue-200 disabled:bg-slate-100 disabled:text-slate-500" name="v_ftp_user[%INDEX%][v_ftp_path]" id="v_ftp_user[%INDEX%][v_ftp_path]" value="">
			<span class="hint-prefix"><?= tohtml(trim($v_ftp_pre_path_new_user, "'")) ?></span><span class="hint js-ftp-path-hint text-sm leading-6 text-slate-500"></span>
		</div>
		<div class="u-pl30 u-mb10 pl-[30px] mb-[10px]">
			<label for="v_ftp_user[%INDEX%][v_ftp_email]" class="form-label mb-1 block text-sm font-semibold text-slate-700"><?= tohtml( _("Send FTP credentials to email")) ?></label>
			<input type="email" class="form-control js-email-alert-on-psw block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-2 focus:outline-blue-200 disabled:bg-slate-100 disabled:text-slate-500" name="v_ftp_user[%INDEX%][v_ftp_email]" id="v_ftp_user[%INDEX%][v_ftp_email]" value="">
		</div>
	</div>
</div>
