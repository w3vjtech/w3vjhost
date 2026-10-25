// Attaches listeners to nameserver add and remove links to clone or remove the input
export default function handleNameServerInput() {
	// Add new name server input
	const addNsButton = document.querySelector('.js-add-ns');
	if (addNsButton) {
		addNsButton.addEventListener('click', () => addNsInput(addNsButton));
	}

	// Remove name server input
	document.querySelectorAll('.js-remove-ns').forEach((removeNsElem) => {
		removeNsElem.addEventListener('click', () => removeNsInput(removeNsElem));
	});
}

function addNsInput(addNsButton) {
	const currentNsInputs = document.querySelectorAll('input[name^=v_ns]');
	const inputCount = currentNsInputs.length;

	if (inputCount < 8) {
		const template = currentNsInputs[0].parentElement.cloneNode(true);
		const templateNsInput = template.querySelector('input');

		templateNsInput.removeAttribute('value');
		templateNsInput.removeAttribute('id');
		templateNsInput.name = `v_ns${inputCount + 1}`;

		// The first row has no remove button; give added rows the same layout and
		// remove button as the server-rendered extra rows
		if (!template.querySelector('.js-remove-ns')) {
			template.className = 'u-side-by-side u-mb5 flex flex-wrap items-center gap-2 mb-[5px]';
			const removeButton = document.createElement('button');
			removeButton.type = 'button';
			removeButton.className =
				'u-button-reset u-ml10 js-remove-ns border-0 bg-transparent p-0 ml-[10px] text-red-700';
			removeButton.title = addNsButton.dataset.removeLabel || 'Remove';
			removeButton.innerHTML = '<i class="fas fa-trash"></i>';
			template.append(removeButton);
		}
		template
			.querySelector('.js-remove-ns')
			.addEventListener('click', (evt) => removeNsInput(evt.currentTarget));
		addNsButton.before(template);
	}

	if (inputCount === 7) {
		addNsButton.classList.add('u-hidden');
	}
}

function removeNsInput(removeNsElement) {
	removeNsElement.parentElement.remove();
	const currentNsInputs = document.querySelectorAll('input[name^=v_ns]');
	currentNsInputs.forEach((input, index) => {
		input.name = `v_ns${index + 1}`;
	});
	document.querySelector('.js-add-ns').classList.remove('u-hidden');
}
