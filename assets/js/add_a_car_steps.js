function freight_buttons() {
	const typeButtons = document.querySelectorAll('.freight-type-button');
	const subcategoryWrappers = document.querySelectorAll('.freight-type-subcategories');
	const freightbackbutton = document.querySelectorAll('.freight-back-button');
	const freighttypebuttonrow = document.querySelectorAll('.freight-type-button-row');


	freighttypebuttonrow.forEach((button, index) => {
		freighttypebuttonrow[index].classList.add('notvisible');
	});
	freightbackbutton.forEach((button, index) => {
		button.addEventListener('click', (event) => {
			event.preventDefault();
			typeButtons.forEach((button_1, index_1) => {
				typeButtons.forEach(wrapper => wrapper.classList.remove('notvisible'));
				subcategoryWrappers.forEach(wrapper => wrapper.classList.remove('visible'));
				freighttypebuttonrow.forEach((button, index) => {
					freighttypebuttonrow[index].classList.add('notvisible');
				});
			});

		});
	});
	typeButtons.forEach((button, index) => {
		button.addEventListener('click', (event) => {
			event.preventDefault();
			typeButtons.forEach((button_1, index_1) => {
				if (index != index_1) typeButtons[index_1].classList.add('notvisible');
			});
			subcategoryWrappers.forEach(wrapper => wrapper.classList.remove('visible'));
			subcategoryWrappers[index].classList.add('visible');
			freighttypebuttonrow.forEach(wrapper => wrapper.classList.remove('notvisible'));
		});
	});
}

function calculate() {
	// Get form fields
	const length = document.getElementById("length").value;
	const width = document.getElementById("width").value;
	const height = document.getElementById("height").value;
	const weight = document.getElementById("weight").value;
	const quantity = document.getElementById("quantity").value;

	// Calculate volume
	const volume = (length * width * height) / 1000000;
	const volumeValue = volume.toFixed(3) + " М³";

	// Calculate total volume
	const totalVolume = volume * quantity;
	const totalVolumeValue = totalVolume.toFixed(3) + " М³";

	// Calculate total weight
	const totalWeight = weight * quantity;
	const totalWeightValue = totalWeight.toFixed(2) + " Кг";

	// Update summary fields
	document.getElementById("volume-value").textContent = volumeValue;
	document.getElementById("total-volume-value").textContent = totalVolumeValue;
	document.getElementById("total-weight-value").textContent = totalWeightValue;
}

document.addEventListener('DOMContentLoaded', function () {
	const form = document.querySelector('.my-form');
	const fieldsets = form.querySelectorAll('fieldset');
	const progressItems = form.querySelectorAll('.fl-progress-bar li');
	const continueButtons = form.querySelectorAll('.continue-button');
	const freightcontinueButtons = form.querySelectorAll('.freight-type-subcategory');
	const backButtons = form.querySelectorAll('.back-button');
	const submitButton = form.querySelector('.submit-button');
	const showfinalButton = form.querySelector('.show-final-button');
	const formid = document.getElementById('freight-form');
	const final_freight_info = document.getElementById('final_freight_info');

	let currentStep = 0;

	function validateInput(input) {
		if (input.value.trim() === '') {
			const errorMessage = input.dataset.errorMessage || 'This field is required';
			const errorElement = input.nextElementSibling;
			errorElement.textContent = errorMessage;
			return false;
		}
		return true;
	}

	function validateStep(step) {
		const inputs = step.querySelectorAll('.input-field');
		let isValid = true;
		for (let i = 0; i < inputs.length; i++) {
			const input = inputs[i];
			isValid = validateInput(input) && isValid;
		}
		return isValid;
	}

	function showStep(step) {

		fieldsets[currentStep].classList.remove('current');
		progressItems[currentStep].classList.remove('active');

		fieldsets[step].classList.add('current');
		progressItems[step].classList.add('active');

		currentStep = step;
	}

	function nextStep(event) {
		event.preventDefault();
		if (validateStep(fieldsets[currentStep])) {
			const nextStep = currentStep + 1;
			showStep(nextStep);
		}
	}

	function backStep(event) {
		event.preventDefault();
		const nextStep = currentStep - 1;
		showStep(nextStep);

	}

	function submitForm(event) {
		event.preventDefault();
		const form = document.getElementById('freight-form');

		if (validateStep(fieldsets[currentStep])) {
			const formData = new FormData(form);
			const data = {};
			for (let [key, value] of formData.entries()) {
				data[key] = value;
			}
			alert('Form submitted successfully!\n\n' + JSON.stringify(data, null, 2));
		}
	}

	function showFinalForm(event) {
  event.preventDefault();

  if (validateStep(fieldsets[currentStep])) {
    const formData = new FormData(formid);
    const data = {};
    for (let [key, value] of formData.entries()) {
      data[key] = value;
    }

    const finalFreightInfo = document.getElementById("final_freight_info");
    finalFreightInfo.innerHTML = ""; // clear previous content

    for (let key in data) {
      const label = document.querySelector(`label[for=${key}]`);
      if (label) {
        const inputLabel = label.textContent.trim();
        const inputValue = data[key];
        finalFreightInfo.innerHTML += `<p>${inputLabel}: ${inputValue}</p>`;
      }
    }
	nextStep(event);
  }
}


	for (let i = 0; i < continueButtons.length; i++) {
		continueButtons[i].addEventListener('click', nextStep);
	}

	for (let i = 0; i < freightcontinueButtons.length; i++) {
		freightcontinueButtons[i].addEventListener('click', nextStep);
	}

	for (let i = 0; i < backButtons.length; i++) {
		backButtons[i].addEventListener('click', backStep);
	}

	freight_buttons();
	submitButton.addEventListener('click', submitForm);
	showfinalButton.addEventListener('click', showFinalForm);


});