// Add listeners to .js-toggle-options buttons
export default function handleToggleAdvanced() {
	document.querySelectorAll('.js-toggle-options').forEach((toggleOptionsButton) => {
		toggleOptionsButton.addEventListener('click', toggleAdvancedOptions);
	});
}

// Toggle between basic and advanced options.
// When switching from basic to advanced, the textarea is updated with the values from the inputs
function toggleAdvancedOptions() {
	const advancedOptionsWrapper = document.querySelector('.js-advanced-options');
	const basicOptionsWrapper = document.querySelector('.js-basic-options');

	if (advancedOptionsWrapper.classList.contains('u-hidden')) {
		advancedOptionsWrapper.classList.remove('u-hidden');
		basicOptionsWrapper.classList.add('u-hidden');
		updateAdvancedTextarea();
	} else {
		advancedOptionsWrapper.classList.add('u-hidden');
		basicOptionsWrapper.classList.remove('u-hidden');
	}
}

// Update the "advanced options" textarea with "basic options" input values
export function updateAdvancedTextarea() {
	const advancedTextarea = document.querySelector('.js-advanced-textarea');
	const textInputs = document.querySelectorAll('#main-form input[type=text]');

	textInputs.forEach((textInput) => {
		const search = textInput.dataset.regexp;
		if (!search) {
			return;
		}
		const prevValue = textInput.dataset.prevValue ?? '';
		textInput.setAttribute('data-prev-value', textInput.value);
		// Values are user input: escape them, and use a replacer function so "$" is literal
		const regexp = new RegExp(`(${escapeRegExp(search)})(.+)(${escapeRegExp(prevValue)})`);
		advancedTextarea.value = advancedTextarea.value.replace(
			regexp,
			(_match, key, middle) => `${key}${middle}${textInput.value}`,
		);
	});
}

function escapeRegExp(value) {
	return value.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
}
