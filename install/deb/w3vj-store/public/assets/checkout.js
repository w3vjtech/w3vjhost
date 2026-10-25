// Opens Razorpay Checkout for the subscription created by checkout.php, then lets the server
// verify the payment (api/confirm.php). The browser result is never trusted on its own.
(() => {
	'use strict';
	const dataElement = document.getElementById('checkout-data');
	const payButton = document.querySelector('.js-pay');
	const statusElement = document.querySelector('.js-pay-status');
	if (!dataElement || !payButton) return;

	const data = JSON.parse(dataElement.textContent);

	function showStatus(message) {
		statusElement.textContent = message;
		statusElement.classList.remove('hidden');
	}

	async function confirmPayment(response) {
		payButton.disabled = true;
		showStatus('Payment received. Setting up your account…');
		const body = new URLSearchParams({
			csrf: data.csrf,
			token: data.token,
			razorpay_payment_id: response.razorpay_payment_id || '',
			razorpay_subscription_id: response.razorpay_subscription_id || '',
			razorpay_signature: response.razorpay_signature || '',
		});
		try {
			const result = await fetch('/api/confirm.php', { method: 'POST', body, credentials: 'same-origin' });
			const json = await result.json();
			if (json.redirect) {
				window.location.assign(json.redirect);
				return;
			}
			showStatus(json.error || 'We could not confirm the payment yet. If money was taken, your account will be created automatically; check your email.');
		} catch {
			showStatus('Connection problem while confirming. If money was taken, your account will be created automatically; check your email.');
		}
		payButton.disabled = false;
	}

	function openCheckout() {
		if (typeof window.Razorpay !== 'function') {
			showStatus('The payment window could not load. Please disable blockers for checkout.razorpay.com and try again.');
			return;
		}
		const checkout = new window.Razorpay({
			key: data.key,
			subscription_id: data.subscription_id,
			name: data.name,
			description: data.description,
			image: '/assets/logo.svg',
			prefill: data.prefill,
			theme: { color: '#2563eb' },
			handler: confirmPayment,
			modal: {
				ondismiss: () => showStatus('Payment window closed. Use the button to try again.'),
			},
		});
		checkout.on('payment.failed', (event) => {
			showStatus('Payment failed: ' + ((event.error && event.error.description) || 'please try another method.'));
		});
		checkout.open();
	}

	payButton.addEventListener('click', openCheckout);
	openCheckout();
})();
