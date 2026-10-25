import handleFtpAccountHints from './ftpAccountHints';
import { debounce, randomPassword } from './helpers';

// Add/remove FTP accounts on Edit Web Domain page
export default function handleFtpAccounts() {
	// Listen to FTP user "Password" field changes and insert
	// "Send FTP credentials to email" field if it doesn't exist
	handlePasswordInputChange();

	// Listen to FTP user "Password" generate button clicks and generate a random password
	// Also insert "Send FTP credentials to email" field if it doesn't exist
	handleGeneratePasswordClick();

	// Listen to "Add FTP account" button click and add new FTP account form
	handleAddAccountClick();

	// Listen to FTP account "Delete" button clicks and delete FTP account
	handleDeleteAccountClick();

	// Listen to "Additional FTP account(s)" checkbox and show/hide FTP accounts section
	handleToggleFtpAccountsCheckbox();
}

function handlePasswordInputChange() {
	document.querySelectorAll('.js-ftp-user-psw').forEach((ftpPasswordInput) => {
		ftpPasswordInput.addEventListener(
			'input',
			debounce((evt) => insertEmailField(evt.target)),
		);
	});
}

function handleGeneratePasswordClick(root = document) {
	root.querySelectorAll('.js-ftp-password-generate').forEach((generateButton) => {
		generateButton.addEventListener('click', () => {
			const ftpPasswordInput =
				generateButton.parentElement.parentElement.querySelector('.js-ftp-user-psw');

			ftpPasswordInput.value = randomPassword();
			insertEmailField(ftpPasswordInput);
		});
	});
}

function handleAddAccountClick() {
	const addFtpAccountButton = document.querySelector('.js-add-ftp-account');
	if (addFtpAccountButton) {
		// Never reuse an index: new accounts can be removed from the DOM, so the
		// current account count may equal an index that is still in use
		let nextIndex = document.querySelectorAll('.js-active-ftp-accounts .js-ftp-account').length;
		addFtpAccountButton.addEventListener('click', () => {
			const template = document
				.querySelector('.js-ftp-account-template .js-ftp-account-nrm')
				.cloneNode(true);
			const newIndex = nextIndex++;

			template.querySelectorAll('input').forEach((input) => {
				const name = input.getAttribute('name');
				const id = input.getAttribute('id');
				input.setAttribute('name', name.replace('%INDEX%', newIndex));
				if (id) {
					input.setAttribute('id', id.replace('%INDEX%', newIndex));
				}
			});

			template.querySelectorAll('label[for*="%INDEX%"]').forEach((label) => {
				const forAttr = label.getAttribute('for');
				label.setAttribute('for', forAttr.replace('%INDEX%', newIndex));
			});

			template.querySelector('.js-ftp-user-number').textContent = newIndex;
			document.querySelector('.js-active-ftp-accounts').appendChild(template);

			updateUserNumbers();

			// Attach listeners to the new account only (cloneNode drops them)
			handleFtpAccountHints(template);
			handleGeneratePasswordClick(template);
			handleDeleteAccountClick(template);
		});
	}
}

function handleDeleteAccountClick(root = document) {
	root.querySelectorAll('.js-delete-ftp-account').forEach((deleteButton) => {
		deleteButton.addEventListener('click', () => {
			const ftpAccount = deleteButton.closest('.js-ftp-account');
			ftpAccount.querySelector('.js-ftp-user-deleted').value = '1';
			if (ftpAccount.querySelector('.js-ftp-user-is-new').value == 1) {
				ftpAccount.remove();
			} else {
				ftpAccount.classList.remove('js-ftp-account-nrm');
				ftpAccount.style.display = 'none';
			}

			updateUserNumbers();

			if (document.querySelectorAll('.js-active-ftp-accounts .js-ftp-account-nrm').length === 0) {
				document.querySelector('.js-add-ftp-account').style.display = 'none';
				document.querySelector('input[name="v_ftp"]').checked = false;
			}
		});
	});
}

function updateUserNumbers() {
	// Deleted existing accounts stay in the DOM (hidden) until save; don't count them
	const ftpUserNumbers = document.querySelectorAll(
		'.js-active-ftp-accounts .js-ftp-account-nrm .js-ftp-user-number',
	);
	ftpUserNumbers.forEach((number, index) => {
		number.textContent = index + 1;
	});
}

function handleToggleFtpAccountsCheckbox() {
	const toggleFtpAccountsCheckbox = document.querySelector('.js-toggle-ftp-accounts');

	if (!toggleFtpAccountsCheckbox) {
		return;
	}

	toggleFtpAccountsCheckbox.addEventListener('change', (evt) => {
		const isChecked = evt.target.checked;
		const addFtpAccountButton = document.querySelector('.js-add-ftp-account');
		const ftpAccounts = document.querySelectorAll('.js-ftp-account-nrm');

		addFtpAccountButton.style.display = isChecked ? 'block' : 'none';

		ftpAccounts.forEach((ftpAccount) => {
			const usernameInput = ftpAccount.querySelector('.js-ftp-user');
			const hiddenUserDeletedInput = ftpAccount.querySelector('.js-ftp-user-deleted');

			if (usernameInput.value.trim() !== '') {
				hiddenUserDeletedInput.value = isChecked ? '0' : '1';
			}

			ftpAccount.style.display = isChecked ? 'block' : 'none';
		});
	});
}

// Insert "Send FTP credentials to email" field if not present in FTP account
function insertEmailField(ftpPasswordInput) {
	const accountWrapper = ftpPasswordInput.closest('.js-ftp-account');

	if (accountWrapper.querySelector('.js-email-alert-on-psw')) {
		return;
	}

	const hiddenIsNewInput = accountWrapper.querySelector('.js-ftp-user-is-new');
	const inputName = hiddenIsNewInput.name.replace('is_new', 'v_ftp_email');
	const emailFieldHTML = `
		<div class="u-pl30 u-mb10 pl-[30px] mb-[10px]">
			<label for="${inputName}" class="form-label mb-1 block text-sm font-semibold text-slate-700">
				Send FTP credentials to email
			</label>
			<input type="email" class="form-control js-email-alert-on-psw block min-h-9 w-full min-w-0 rounded-lg border border-slate-400 bg-white px-3 py-2 text-sm text-slate-700 focus:border-blue-600 focus:outline-2 focus:outline-blue-200"
				value="" name="${inputName}" id="${inputName}">
		</div>`;
	accountWrapper.insertAdjacentHTML('beforeend', emailFieldHTML);
}
