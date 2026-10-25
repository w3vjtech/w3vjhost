import { createConfirmationDialog, decodeHtmlEntities } from './helpers';

// Displays page error message/notice in a confirmation dialog
export default function handleErrorMessage() {
	const errorMessage = Alpine.store('globals').ERROR_MESSAGE;

	if (errorMessage) {
		// ERROR_MESSAGE is htmlentities()-escaped by js.php
		createConfirmationDialog({ message: decodeHtmlEntities(errorMessage) });
	}
}
