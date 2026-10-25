<?php
// Starter texts for the policy pages Razorpay requires before activating a live account.
// They are placeholders: review them (ideally with a lawyer) and edit to match your business.

declare(strict_types=1);

namespace W3vj\Store;

final class Policies {
	public static function terms(): string {
		$site = h(config()->get("site_name", "W3VJHOST"));
		$business = h(config()->get("business_name", $site));
		return <<<HTML
		<h2>Service</h2>
		<p>$business provides web hosting services under the $site brand. By ordering a plan you agree to these terms.</p>
		<h2>Accounts</h2>
		<p>You are responsible for keeping your login details safe and for all content hosted in your account.</p>
		<h2>Acceptable use</h2>
		<ul>
			<li>No illegal content, malware, phishing, spam or abuse of other networks.</li>
			<li>No activity that degrades the service for other customers.</li>
		</ul>
		<p>We may suspend accounts that break these rules.</p>
		<h2>Billing</h2>
		<p>Plans are billed in advance and renew automatically each month or year until cancelled. If a renewal payment fails, the account may be suspended until payment succeeds.</p>
		<h2>Changes</h2>
		<p>We may update these terms; the date above shows the latest version.</p>
		HTML;
	}

	public static function privacy(): string {
		$business = h(config()->get("business_name", config()->get("site_name", "W3VJHOST")));
		return <<<HTML
		<h2>What we collect</h2>
		<p>Your name, email address, chosen username, IP address and order details. Payments are processed by Razorpay; we never see or store your card or bank details.</p>
		<h2>Why</h2>
		<p>To create and run your hosting account, bill your subscription, contact you about the service and meet legal obligations.</p>
		<h2>Sharing</h2>
		<p>$business shares data only with Razorpay for payments and as required by law. We do not sell personal data.</p>
		<h2>Your rights</h2>
		<p>You can ask us to access, correct or delete your data through the contact page.</p>
		HTML;
	}

	public static function refund(): string {
		return <<<HTML
		<h2>Cancellation</h2>
		<p>You can cancel your subscription at any time using the link in Razorpay's subscription emails or by contacting us. The account stays active until the end of the paid period.</p>
		<h2>Refunds</h2>
		<p>[Fill in your refund policy, for example: new orders can be refunded in full within 7 days of the first payment. Renewals are not refunded.]</p>
		<p>Approved refunds are returned to the original payment method within 5-7 working days.</p>
		HTML;
	}

	public static function contact(): string {
		$email = h(config()->get("contact_email", config()->get("admin_email", "")));
		$phone = h(config()->get("contact_phone", "[Fill in phone]"));
		$address = nl2br(h(config()->get("contact_address", "[Fill in registered business address]")));
		$business = h(config()->get("business_name", config()->get("site_name", "W3VJHOST")));
		return <<<HTML
		<p><strong>$business</strong></p>
		<p>Email: <a href="mailto:$email" class="text-blue-700 underline">$email</a><br>Phone: $phone</p>
		<p>$address</p>
		HTML;
	}
}
