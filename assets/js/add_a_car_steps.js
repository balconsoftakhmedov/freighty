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

function displayImage(event) {
	const file = event.target.files[0];
	const reader = new FileReader();
	reader.onload = function (event) {
		const img = document.getElementById("image-preview");
		img.src = event.target.result;
	};
	reader.readAsDataURL(file);
}
function get_add_freight_function(event, loadsubmit = false) {
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
	const freight_info = document.getElementById("freight_info");

	const typeButtons = document.querySelectorAll('.freight-type-button');
	const subcategoryWrappers = document.querySelectorAll('.freight-type-subcategories');
	const freightbackbutton = document.querySelectorAll('.freight-back-button');
	const freighttypebuttonrow = document.querySelectorAll('.freight-type-button-row');
	const categoryIdInput = document.getElementById('category_id');
	const categoryNameInput = document.getElementById('category_name');

	let currentStep = 0;

	function freight_buttons() {

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

				console.log(button.dataset.category_id); // get category_id attribute
				console.log(button.textContent.trim()); // get text content
				// Get the category ID and name from the clicked button
				const categoryId = button.getAttribute('data-category_id');
				const categoryName = button.textContent.trim();

				// Assign the values to the hidden input fields
				categoryIdInput.value = categoryId;
				categoryNameInput.value = categoryName;
				subcategoryWrappers[index].classList.add('visible');
				freighttypebuttonrow.forEach(wrapper => wrapper.classList.remove('notvisible'));
			});
		});
	}


	function validateInput(input) {
		if (input.value.trim() === '') {
			const errorMessage = input.dataset.errorMessage || 'This field is required';
			let errorElement = input.nextElementSibling;
			if (errorElement && errorElement.classList.contains('stm-error')) {
				errorElement.textContent = errorMessage;
			} else {
				errorElement = document.createElement('span');
				errorElement.classList.add('stm-error');
				errorElement.textContent = errorMessage;
				input.insertAdjacentElement('afterend', errorElement);
			}
			return false;
		} else {
			const errorElement = input.nextElementSibling;
			if (errorElement && errorElement.classList.contains('stm-error')) {
				errorElement.remove();
			}
			return true;
		}
	}


	function validateStep(step) {
		const inputs = step.querySelectorAll('.input-req');
		const inputsreq = step.querySelectorAll('.input-req');
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
			data['freight_info'] = freight_info.value;
			data['action'] = 'create_or_update_freight';
			data['_ajax_nonce-freight_nonce'] = freight_ajax_object.freight_nonce;
data['image'] = '';
console.log(data);
			jQuery.ajax({
				type: 'POST',
				url: freight_ajax_object.ajax_url,
				data: data,
				success: function (response) {
					console.log(response);
				},
				error: function (xhr, status, error) {

				}
			});

		}
	}

	function showFinalForm(event) {
		event.preventDefault();

		const to_address_value = document.getElementById('to_address_value');
		const from_address_value = document.getElementById('from_address_value');
		const freight_desc_value = document.getElementById('freight_desc_value');
		const finalFreightInfo = document.getElementById("final_freight_info");
		const category_value = document.getElementById('category_tag_value');
		const subcategory_value = document.getElementById('subcategory_tag_value');

		if (validateStep(fieldsets[currentStep])) {
			const formData = new FormData(formid);
			const data = {};
			for (let [key, value] of formData.entries()) {
				data[key] = value;
			}


			finalFreightInfo.innerHTML = ""; // clear previous content

			for (let key in data) {
				const label = document.querySelector(`label[for=${key}]`);
				if (label) {
					let inputLabel = label.textContent.trim();
					let inputValue = data[key];
					if (inputLabel == 'Upload image:') {
						const img_url = URL.createObjectURL(inputValue);
						inputValue = `<img class="stm-image-preview" src="${img_url}">`;
					}
					finalFreightInfo.innerHTML += `<p>${inputLabel} ${inputValue}</p>`;
				} else {
					const inputLabel = key.trim();
					const inputValue = data[key];
					//finalFreightInfo.innerHTML += `<p>${inputLabel}: ${inputValue}</p>`;
					if (key == 'from_address') from_address_value.innerHTML = `${inputValue}`;
					if (key == 'to_address') to_address_value.innerHTML = `${inputValue}`;

					if (key == 'category_name') category_value.innerHTML = `${inputValue}`;
					if (key == 'subcategory_name') subcategory_value.innerHTML = `${inputValue}`;
				}
			}
			freight_desc_value.innerHTML = freight_info.value;
			nextStep(event);
		}
	}


	for (let i = 0; i < continueButtons.length; i++) {
		continueButtons[i].addEventListener('click', nextStep);
	}

	for (let i = 0; i < freightcontinueButtons.length; i++) {
		freightcontinueButtons[i].addEventListener('click', function (event) {
			event.preventDefault();
			const subcategoryId = this.dataset.subcategory_id;
			const subcategoryName = this.textContent.trim();
			document.querySelector('#subcategory_id').value = subcategoryId;
			document.querySelector('#subcategory_name').value = subcategoryName;
			console.log(subcategoryName, subcategoryId);
			nextStep(event);
		});
	}

	for (let i = 0; i < backButtons.length; i++) {
		backButtons[i].addEventListener('click', backStep);
	}


	freight_buttons();
	submitButton.addEventListener('click', submitForm);
	showfinalButton.addEventListener('click', showFinalForm);

	if (loadsubmit === true) {
			submitForm(event);
	}

}
document.addEventListener('DOMContentLoaded',  get_add_freight_function(event) );