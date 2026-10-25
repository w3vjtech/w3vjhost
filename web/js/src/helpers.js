import { customAlphabet } from 'nanoid';

// Generates a random password that always passes password requirements
export function randomPassword(length = 16) {
	const uppercase = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
	const lowercase = 'abcdefghijklmnopqrstuvwxyz';
	const numbers = '0123456789';
	const symbols = '!@#$%^&*()_+-=[]{}|;:/?';
	const allCharacters = uppercase + lowercase + numbers + symbols;
	const generate = customAlphabet(allCharacters, length);

	let password;
	do {
		password = generate();
		// Must contain at least one uppercase letter, one lowercase letter, and one number
	} while (!(/[a-z]/.test(password) && /[A-Z]/.test(password) && /\d/.test(password)));

	return password;
}

// Debounces a function to avoid excessive calls
export function debounce(func, wait = 100) {
	let timeout;
	return function (...args) {
		clearTimeout(timeout);
		timeout = setTimeout(() => func.apply(this, args), wait);
	};
}

// Returns the value of a CSS variable (the theme defines them on <body>)
export function getCssVariable(variableName) {
	return getComputedStyle(document.body).getPropertyValue(variableName).trim();
}

// Decodes HTML entities in server-escaped text, for use with textContent
export function decodeHtmlEntities(text) {
	return new DOMParser().parseFromString(text, 'text/html').documentElement.textContent;
}

// Shows the loading spinner overlay
export function showSpinner() {
	document.querySelector('.js-spinner').classList.add('active');
}

// Parses and sorts IP lists from HTML
export function parseAndSortIpLists(ipListsData) {
	const ipLists = JSON.parse(ipListsData || '[]');
	return ipLists.sort((a, b) => a.name.localeCompare(b.name));
}

// Determines if the current browser is Desktop Safari
export function isDesktopSafari() {
	const userAgent = window.navigator.userAgent;
	const isSafari = /^((?!chrome|android).)*safari/i.test(userAgent);
	const isMac = /Macintosh|MacIntel/i.test(window.navigator.platform);
	return isSafari && isMac;
}

// Waits for the given number of milliseconds
export function delay(milliseconds) {
	return new Promise((resolve) => setTimeout(resolve, milliseconds));
}

// Posts data to the given URL and returns the response
export async function post(url, data, headers = {}) {
	const requestOptions = {
		method: 'POST',
		headers: {
			'Content-Type': 'application/json',
			...headers,
		},
		body: JSON.stringify(data),
	};

	const response = await fetch(url, requestOptions);
	if (!response.ok) {
		throw new Error(`HTTP error ${response.status}: ${response.statusText}`);
	}

	return response.json();
}

// Creates a confirmation <dialog> on the fly
export function createConfirmationDialog({
	title,
	message = 'Are you sure?',
	targetUrl,
	spinner = false,
}) {
	// Create the dialog
	const dialog = document.createElement('dialog');
	dialog.classList.add('modal', 'm-auto', 'w-[calc(100%-2rem)]', 'max-w-lg', 'rounded-lg', 'border', 'border-slate-200', 'bg-white', 'p-5', 'text-slate-700', 'shadow-xl', 'backdrop:bg-slate-900/40');

	// Create and insert the title
	if (title) {
		const titleElement = document.createElement('h2');
		titleElement.textContent = title;
		titleElement.classList.add('modal-title', 'mb-3', 'text-lg', 'font-semibold', 'text-slate-900');
		dialog.append(titleElement);
	}

	// Create and insert the message
	const messageElement = document.createElement('p');
	// Text only: data-confirm-* attributes are entity-decoded by the browser, so innerHTML
	// would turn an escaped object name back into markup
	messageElement.textContent = message;
	messageElement.classList.add('modal-message', 'mb-4', 'wrap-anywhere', 'text-sm');
	dialog.append(messageElement);

	// Create and insert the options
	const optionsElement = document.createElement('div');
	optionsElement.classList.add('modal-options', 'flex', 'justify-end', 'gap-2', 'border-t', 'border-slate-200', 'pt-4');

	const confirmButton = document.createElement('button');
	confirmButton.type = 'submit';
	confirmButton.classList.add('button', 'inline-flex', 'min-h-9', 'items-center', 'justify-center', 'gap-1.5', 'rounded-lg', 'border', 'border-blue-600', 'bg-blue-600', 'px-4', 'py-1.5', 'text-sm', 'font-semibold', 'text-white', 'hover:bg-blue-700', 'disabled:cursor-not-allowed', 'disabled:opacity-50');
	confirmButton.textContent = 'OK';
	optionsElement.append(confirmButton);

	const cancelButton = document.createElement('button');
	cancelButton.type = 'button';
	cancelButton.classList.add('button', 'button-secondary', 'u-ml5', 'inline-flex', 'min-h-9', 'items-center', 'justify-center', 'gap-1.5', 'rounded-lg', 'border', 'border-blue-600', 'bg-blue-600', 'px-4', 'py-1.5', 'text-sm', 'font-semibold', 'text-white', 'hover:bg-blue-700', 'disabled:cursor-not-allowed', 'disabled:opacity-50', 'border-slate-300!', 'bg-white!', 'text-slate-700!', 'hover:bg-slate-50!', 'ml-[5px]');
	cancelButton.textContent = 'Cancel';
	if (targetUrl) {
		optionsElement.append(cancelButton);
	}

	dialog.append(optionsElement);

	// Define named functions to handle the event listeners
	const handleConfirm = () => {
		if (targetUrl) {
			if (spinner) {
				showSpinner();
			}
			window.location.href = targetUrl;
		}

		handleClose();
	};

	const handleCancel = () => handleClose();
	const handleClose = () => {
		confirmButton.removeEventListener('click', handleConfirm);
		cancelButton.removeEventListener('click', handleCancel);
		dialog.removeEventListener('close', handleClose);
		dialog.remove();
	};

	// Add event listeners
	confirmButton.addEventListener('click', handleConfirm);
	cancelButton.addEventListener('click', handleCancel);
	dialog.addEventListener('close', handleClose);

	// Add to DOM and show
	document.body.append(dialog);
	dialog.showModal();
}
