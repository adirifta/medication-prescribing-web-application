<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Create New Examination') }}
            </h2>
            <div class="text-sm text-gray-500">
                <a href="{{ route('doctor.examinations.index') }}" class="text-blue-600 hover:text-blue-800">
                    ← Back to Examinations
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form id="examinationForm" action="{{ route('doctor.examinations.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf

                        <!-- Patient Information -->
                        <div class="bg-blue-50 p-4 rounded-lg">
                            <h3 class="text-lg font-semibold text-blue-800 mb-4">Patient Information</h3>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="patient_id" class="block text-sm font-medium text-gray-700">Select Patient</label>
                                    <select id="patient_id" name="patient_id" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                        <option value="">Select a patient</option>
                                        @foreach($patients as $patient)
                                            <option value="{{ $patient->id }}">
                                                {{ $patient->name }} ({{ $patient->medical_record_number }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Or Create New Patient</label>
                                    <a href="{{ route('doctor.patients.create') }}" class="mt-2 inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                        + New Patient
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Vital Signs -->
                        <div class="bg-green-50 p-4 rounded-lg">
                            <h3 class="text-lg font-semibold text-green-800 mb-4">Vital Signs</h3>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <label for="height" class="block text-sm font-medium text-gray-700">Height (cm)</label>
                                    <input type="number"
                                        step="0.1"
                                        id="height"
                                        name="height"
                                        min="30"
                                        max="250"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500"
                                        oninput="validateHeight(this)">
                                <div>
                                    <label for="weight" class="block text-sm font-medium text-gray-700">Weight (kg)</label>
                                     <input type="number"
                                        step="0.1"
                                        id="weight"
                                        name="weight"
                                        min="1"
                                        max="300"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500"
                                        oninput="validateWeight(this)">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">BMI</label>
                                    <div id="bmi-display" class="mt-2 text-lg font-semibold text-gray-900">-</div>
                                    <input type="hidden" id="bmi" name="bmi">
                                </div>

                                <div>
                                    <label for="systolic" class="block text-sm font-medium text-gray-700">Systolic (mmHg)</label>
                                    <input type="number"
                                        id="systolic"
                                        name="systolic"
                                        min="50"
                                        max="300"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500"
                                        oninput="validateSystolic(this)">
                                    <p class="text-xs text-gray-500 mt-1">Normal: 90-120 mmHg</p>
                                </div>

                                <div>
                                    <label for="diastolic" class="block text-sm font-medium text-gray-700">Diastolic (mmHg)</label>
                                    <input type="number"
                                        id="diastolic"
                                        name="diastolic"
                                        min="30"
                                        max="200"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500"
                                        oninput="validateDiastolic(this)">
                                    <p class="text-xs text-gray-500 mt-1">Normal: 60-80 mmHg</p>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Blood Pressure</label>
                                    <div id="bp-display" class="mt-2 text-sm text-gray-900">-</div>
                                </div>

                                <div>
                                    <label for="heart_rate" class="block text-sm font-medium text-gray-700">Heart Rate (bpm)</label>
                                    <input type="number"
                                        id="heart_rate"
                                        name="heart_rate"
                                        min="30"
                                        max="250"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500"
                                        oninput="validateHeartRate(this)">
                                    <p class="text-xs text-gray-500 mt-1">Normal: 60-100 bpm</p>
                                </div>

                                <div>
                                    <label for="respiration_rate" class="block text-sm font-medium text-gray-700">Respiration Rate (breaths/min)</label>
                                    <input type="number"
                                        id="respiration_rate"
                                        name="respiration_rate"
                                        min="6"
                                        max="60"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500"
                                        oninput="validateRespirationRate(this)">
                                    <p class="text-xs text-gray-500 mt-1">Normal: 12-20 breaths/min</p>
                                </div>

                                <div>
                                    <label for="temperature" class="block text-sm font-medium text-gray-700">Temperature (°C)</label>
                                     <input type="number"
                                        step="0.1"
                                        id="temperature"
                                        name="temperature"
                                        min="30"
                                        max="45"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500"
                                        oninput="validateTemperature(this)">
                                    <p class="text-xs text-gray-500 mt-1">Normal: 36.5-37.5°C</p>
                                </div>
                            </div>
                        </div>

                        <!-- Doctor Notes -->
                        <div>
                            <label for="doctor_notes" class="block text-sm font-medium text-gray-700">Doctor Notes</label>
                            <textarea id="doctor_notes" name="doctor_notes" rows="4" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"></textarea>
                        </div>

                        <!-- File Upload -->
                        <div>
                            <label for="external_file" class="block text-sm font-medium text-gray-700">Upload External File</label>
                            <input type="file" id="external_file" name="external_file" accept=".pdf,.jpg,.jpeg,.png,.doc,.docx" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                            <p class="mt-1 text-xs text-gray-500">PDF, JPG, PNG, DOC up to 10MB</p>
                        </div>

                        <!-- Prescription Section -->
                        <div class="bg-purple-50 p-4 rounded-lg">
                            <h3 class="text-lg font-semibold text-purple-800 mb-4">Prescription</h3>

                            <div class="mb-4">
                                <label for="prescription_notes" class="block text-sm font-medium text-gray-700">Prescription Notes</label>
                                <textarea id="prescription_notes" name="prescription_notes" rows="2" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500"></textarea>
                            </div>

                            <!-- Medicine Selection -->
                            <div class="mb-6">
                                <div class="flex justify-between items-center mb-2">
                                    <label class="block text-sm font-medium text-gray-700">Medicines</label>
                                    <button type="button" onclick="addMedicine()" class="inline-flex items-center px-3 py-1 bg-purple-600 text-white text-xs rounded hover:bg-purple-700">
                                        + Add Medicine
                                    </button>
                                </div>

                                <div id="medicines-container" class="space-y-3">
                                    <!-- Medicines will be added here dynamically -->
                                </div>
                            </div>
                        </div>

                        <!-- Summary -->
                        <div class="bg-yellow-50 p-4 rounded-lg">
                            <h3 class="text-lg font-semibold text-yellow-800 mb-2">Summary</h3>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <p class="text-sm text-gray-600">Number of Medicines:</p>
                                    <p id="medicine-count" class="font-semibold">0</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600">Estimated Total:</p>
                                    <p id="total-price" class="font-semibold text-xl">IDR 0</p>
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-end space-x-3">
                            <a href="{{ route('doctor.examinations.index') }}" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                                Cancel
                            </a>
                            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                Save Examination
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        // Validation functions for vital signs
        function validateHeight(input) {
            const value = parseFloat(input.value);
            if (value < 30 || value > 250) {
                input.classList.add('border-red-500', 'bg-red-50');
                input.classList.remove('border-gray-300');
                showValidationError('height', 'Height must be between 30cm and 250cm');
            } else {
                input.classList.remove('border-red-500', 'bg-red-50');
                input.classList.add('border-gray-300');
                clearValidationError('height');
            }
            calculateBMI();
        }

        function validateWeight(input) {
            const value = parseFloat(input.value);
            if (value < 1 || value > 300) {
                input.classList.add('border-red-500', 'bg-red-50');
                input.classList.remove('border-gray-300');
                showValidationError('weight', 'Weight must be between 1kg and 300kg');
            } else {
                input.classList.remove('border-red-500', 'bg-red-50');
                input.classList.add('border-gray-300');
                clearValidationError('weight');
            }
            calculateBMI();
        }

        function validateSystolic(input) {
            const value = parseInt(input.value);
            if (value < 50 || value > 300) {
                input.classList.add('border-red-500', 'bg-red-50');
                input.classList.remove('border-gray-300');
                showValidationError('systolic', 'Systolic must be between 50 and 300 mmHg');
            } else {
                input.classList.remove('border-red-500', 'bg-red-50');
                input.classList.add('border-gray-300');
                clearValidationError('systolic');
            }
            updateBP();
        }

        function validateDiastolic(input) {
            const value = parseInt(input.value);
            if (value < 30 || value > 200) {
                input.classList.add('border-red-500', 'bg-red-50');
                input.classList.remove('border-gray-300');
                showValidationError('diastolic', 'Diastolic must be between 30 and 200 mmHg');
            } else {
                input.classList.remove('border-red-500', 'bg-red-50');
                input.classList.add('border-gray-300');
                clearValidationError('diastolic');
            }
            updateBP();
        }

        function validateHeartRate(input) {
            const value = parseInt(input.value);
            if (value < 30 || value > 250) {
                input.classList.add('border-red-500', 'bg-red-50');
                input.classList.remove('border-gray-300');
                showValidationError('heart_rate', 'Heart rate must be between 30 and 250 bpm');
            } else {
                input.classList.remove('border-red-500', 'bg-red-50');
                input.classList.add('border-gray-300');
                clearValidationError('heart_rate');
            }
        }

        function validateRespirationRate(input) {
            const value = parseInt(input.value);
            if (value < 6 || value > 60) {
                input.classList.add('border-red-500', 'bg-red-50');
                input.classList.remove('border-gray-300');
                showValidationError('respiration_rate', 'Respiration rate must be between 6 and 60 breaths/min');
            } else {
                input.classList.remove('border-red-500', 'bg-red-50');
                input.classList.add('border-gray-300');
                clearValidationError('respiration_rate');
            }
        }

        function validateTemperature(input) {
            const value = parseFloat(input.value);
            if (value < 30 || value > 45) {
                input.classList.add('border-red-500', 'bg-red-50');
                input.classList.remove('border-gray-300');
                showValidationError('temperature', 'Temperature must be between 30°C and 45°C');
            } else {
                input.classList.remove('border-red-500', 'bg-red-50');
                input.classList.add('border-gray-300');
                clearValidationError('temperature');
            }
        }

        // Helper functions for validation messages
        function showValidationError(fieldId, message) {
            let errorDiv = document.getElementById(`${fieldId}-error`);
            if (!errorDiv) {
                const input = document.getElementById(fieldId);
                errorDiv = document.createElement('div');
                errorDiv.id = `${fieldId}-error`;
                errorDiv.className = 'text-xs text-red-600 mt-1';
                input.parentNode.appendChild(errorDiv);
            }
            errorDiv.textContent = message;
        }

        function clearValidationError(fieldId) {
            const errorDiv = document.getElementById(`${fieldId}-error`);
            if (errorDiv) {
                errorDiv.remove();
            }
        }

        // Validate all vital signs before form submission
        function validateVitalSigns() {
            const inputs = [
                { id: 'height', min: 30, max: 250 },
                { id: 'weight', min: 1, max: 300 },
                { id: 'systolic', min: 50, max: 300 },
                { id: 'diastolic', min: 30, max: 200 },
                { id: 'heart_rate', min: 30, max: 250 },
                { id: 'respiration_rate', min: 6, max: 60 },
                { id: 'temperature', min: 30, max: 45 }
            ];

            let isValid = true;
            const errors = [];

            inputs.forEach(inputConfig => {
                const input = document.getElementById(inputConfig.id);
                if (input && input.value) {
                    const value = parseFloat(input.value);
                    if (value < inputConfig.min || value > inputConfig.max) {
                        isValid = false;
                        errors.push(`${inputConfig.id}: Value must be between ${inputConfig.min} and ${inputConfig.max}`);

                        // Highlight the invalid field
                        input.classList.add('border-red-500', 'bg-red-50');

                        // Show error message
                        const fieldName = inputConfig.id.replace('_', ' ');
                        showValidationError(inputConfig.id, `${fieldName} must be between ${inputConfig.min} and ${inputConfig.max}`);
                    }
                }
            });

            return { isValid, errors };
        }

        const medicines = @json($medicines);
        let medicineCounter = 0;
        let selectedMedicines = [];

        function addMedicine() {
            const container = document.getElementById('medicines-container');
            const id = `medicine-${medicineCounter++}`;

            const medicineHtml = `
                <div id="${id}" class="border border-gray-300 rounded-lg p-4 bg-white">
                    <div class="flex justify-between mb-2">
                        <h4 class="font-medium">Medicine ${medicineCounter}</h4>
                        <button type="button" onclick="removeMedicine('${id}')" class="text-red-600 hover:text-red-800">
                            × Remove
                        </button>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-4 gap-3">
                        <div>
                            <label class="block text-xs font-medium text-gray-700">Medicine</label>
                            <select name="medicines[${medicineCounter}][id]"
                                    data-medicine-index="${medicineCounter}"
                                    onchange="updateMedicinePrice(this)"
                                    class="medicine-select mt-1 block w-full rounded-md border-gray-300 shadow-sm text-sm">
                                <option value="">Select medicine</option>
                                ${medicines.map(med => `
                                    <option value="${med.id}" data-name="${med.name}">${med.name}</option>
                                `).join('')}
                            </select>
                            <!-- Hidden input untuk menyimpan nama obat -->
                            <input type="hidden" name="medicines[${medicineCounter}][name]" id="medicine-name-${medicineCounter}">
                        </div>

                        <div>
                            <label class="block text-xs font-medium text-gray-700">Quantity</label>
                            <input type="number"
                                name="medicines[${medicineCounter}][quantity]"
                                min="1"
                                value="1"
                                data-medicine-index="${medicineCounter}"
                                onchange="updateMedicineSubtotal(${medicineCounter})"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm text-sm">
                        </div>

                        <div>
                            <label class="block text-xs font-medium text-gray-700">Unit Price</label>
                            <div class="mt-1">
                                <input type="number"
                                    id="price-${medicineCounter}"
                                    readonly
                                    class="block w-full rounded-md border-gray-300 bg-gray-50 shadow-sm text-sm">
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-medium text-gray-700">Subtotal</label>
                            <div class="mt-1">
                                <input type="number"
                                    id="subtotal-${medicineCounter}"
                                    readonly
                                    class="block w-full rounded-md border-gray-300 bg-gray-50 shadow-sm text-sm">
                            </div>
                        </div>

                        <div class="md:col-span-4">
                            <label class="block text-xs font-medium text-gray-700">Instructions</label>
                            <textarea name="medicines[${medicineCounter}][instructions]"
                                    rows="2"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm text-sm"
                                    placeholder="Usage instructions..."></textarea>
                        </div>
                    </div>
                </div>
            `;

            container.insertAdjacentHTML('beforeend', medicineHtml);
            updateSummary();
        }

        async function updateMedicinePrice(select) {
            const medicineId = select.value;
            const selectedOption = select.options[select.selectedIndex];
            const medicineName = selectedOption.getAttribute('data-name');
            const index = select.getAttribute('data-medicine-index');

            // Update hidden input untuk nama obat
            const nameInput = document.getElementById(`medicine-name-${index}`);
            if (nameInput) {
                nameInput.value = medicineName;
            }

            // Fetch price dari API
            try {
                const response = await fetch(`/api/medicine-price/${medicineId}`);
                const data = await response.json();

                const priceInput = document.getElementById(`price-${index}`);
                const quantityInput = document.querySelector(`input[name="medicines[${index}][quantity]"]`);

                if (priceInput && data.price) {
                    priceInput.value = data.price;
                    updateMedicineSubtotal(index);
                } else if (priceInput) {
                    priceInput.value = 0;
                    updateMedicineSubtotal(index);
                }
            } catch (error) {
                console.error('Error fetching price:', error);
                const priceInput = document.getElementById(`price-${index}`);
                if (priceInput) {
                    priceInput.value = 0;
                    updateMedicineSubtotal(index);
                }
            }
        }

        function removeMedicine(id) {
            const element = document.getElementById(id);
            if (element) {
                element.remove();
                // Update ulang semua index setelah penghapusan
                reindexMedicines();
                updateSummary();
            }
        }

        function reindexMedicines() {
            const medicineElements = document.querySelectorAll('[id^="medicine-"]');

            medicineElements.forEach((element, newIndex) => {
                // Update id element
                const newId = `medicine-${newIndex}`;
                element.id = newId;

                // Update semua atribut data-medicine-index dan name
                const selects = element.querySelectorAll('.medicine-select');
                const inputs = element.querySelectorAll('input');
                const textareas = element.querySelectorAll('textarea');

                // Update select
                selects.forEach(select => {
                    select.setAttribute('data-medicine-index', newIndex);
                    select.name = `medicines[${newIndex}][id]`;
                    select.onchange = function() { updateMedicinePrice(this); };
                });

                // Update inputs
                inputs.forEach(input => {
                    if (input.name.includes('quantity')) {
                        input.name = `medicines[${newIndex}][quantity]`;
                        input.setAttribute('data-medicine-index', newIndex);
                        input.onchange = function() { updateMedicineSubtotal(newIndex); };
                    } else if (input.name.includes('name')) {
                        input.name = `medicines[${newIndex}][name]`;
                        input.id = `medicine-name-${newIndex}`;
                    }
                });

                // Update price inputs
                const priceInput = element.querySelector(`[id^="price-"]`);
                if (priceInput) {
                    priceInput.id = `price-${newIndex}`;
                }

                const subtotalInput = element.querySelector(`[id^="subtotal-"]`);
                if (subtotalInput) {
                    subtotalInput.id = `subtotal-${newIndex}`;
                }

                // Update textareas
                textareas.forEach(textarea => {
                    if (textarea.name.includes('instructions')) {
                        textarea.name = `medicines[${newIndex}][instructions]`;
                    }
                });

                // Update judul
                const title = element.querySelector('h4');
                if (title) {
                    title.textContent = `Medicine ${newIndex + 1}`;
                }

                // Update remove button onclick
                const removeBtn = element.querySelector('button[onclick*="removeMedicine"]');
                if (removeBtn) {
                    removeBtn.setAttribute('onclick', `removeMedicine('${newId}')`);
                }
            });

            // Update medicineCounter
            medicineCounter = medicineElements.length;
        }

        function updateMedicineSubtotal(index) {
            const priceInput = document.getElementById(`price-${index}`);
            const quantityInput = document.querySelector(`input[name="medicines[${index}][quantity]"]`);
            const subtotalInput = document.getElementById(`subtotal-${index}`);

            if (priceInput && quantityInput && subtotalInput) {
                const price = parseFloat(priceInput.value) || 0;
                const quantity = parseInt(quantityInput.value) || 0;
                const subtotal = price * quantity;

                subtotalInput.value = subtotal.toFixed(2);
                updateSummary();
            }
        }

        function removeMedicine(id) {
            document.getElementById(id).remove();
            updateSummary();
        }

        function updateSummary() {
            const medicines = document.querySelectorAll('[id^="medicine-"]');
            let total = 0;

            medicines.forEach(medicine => {
                const subtotalInput = medicine.querySelector('[id^="subtotal-"]');
                if (subtotalInput && subtotalInput.value) {
                    total += parseFloat(subtotalInput.value);
                }
            });

            document.getElementById('medicine-count').textContent = medicines.length;
            document.getElementById('total-price').textContent = `IDR ${total.toLocaleString('id-ID')}`;
        }

        // Calculate BMI
        document.getElementById('height')?.addEventListener('input', calculateBMI);
        document.getElementById('weight')?.addEventListener('input', calculateBMI);

        function calculateBMI() {
            const height = parseFloat(document.getElementById('height').value) / 100; // convert to meters
            const weight = parseFloat(document.getElementById('weight').value);

            if (height > 0 && weight > 0) {
                const bmi = weight / (height * height);
                document.getElementById('bmi-display').textContent = bmi.toFixed(1);
                document.getElementById('bmi').value = bmi.toFixed(1);

                // Color coding
                const bmiDisplay = document.getElementById('bmi-display');
                if (bmi < 18.5) {
                    bmiDisplay.className = 'mt-2 text-lg font-semibold text-blue-600';
                } else if (bmi < 25) {
                    bmiDisplay.className = 'mt-2 text-lg font-semibold text-green-600';
                } else if (bmi < 30) {
                    bmiDisplay.className = 'mt-2 text-lg font-semibold text-yellow-600';
                } else {
                    bmiDisplay.className = 'mt-2 text-lg font-semibold text-red-600';
                }
            }
        }

        // Calculate Blood Pressure
        document.getElementById('systolic')?.addEventListener('input', updateBP);
        document.getElementById('diastolic')?.addEventListener('input', updateBP);

        function updateBP() {
            const systolic = parseInt(document.getElementById('systolic').value);
            const diastolic = parseInt(document.getElementById('diastolic').value);
            const bpDisplay = document.getElementById('bp-display');

            if (systolic && diastolic) {
                bpDisplay.textContent = `${systolic}/${diastolic} mmHg`;

                // Color coding based on blood pressure
                if (systolic < 120 && diastolic < 80) {
                    bpDisplay.className = 'mt-2 text-sm text-green-600';
                } else if (systolic < 130 && diastolic < 80) {
                    bpDisplay.className = 'mt-2 text-sm text-yellow-600';
                } else if (systolic < 140 || diastolic < 90) {
                    bpDisplay.className = 'mt-2 text-sm text-orange-600';
                } else {
                    bpDisplay.className = 'mt-2 text-sm text-red-600';
                }
            }
        }

        function removeEmptyMedicineFields() {
    const medicineElements = document.querySelectorAll('[id^="medicine-"]');

    medicineElements.forEach((element, index) => {
        const medicineId = element.querySelector(`select[name="medicines[${index}][id]"]`)?.value;
        const medicineName = element.querySelector(`select[name="medicines[${index}][name]"]`)?.value;

        // Jika tidak ada ID dan tidak ada name, hapus element
        if (!medicineId && !medicineName) {
            element.remove();
            console.log(`Removed empty medicine field ${index}`);
        }
    });

    // Update ulang index setelah menghapus
    reindexMedicineFields();
}

// Fungsi untuk mengurutkan ulang index medicine
function reindexMedicineFields() {
    const medicineElements = document.querySelectorAll('[id^="medicine-"]');

    medicineElements.forEach((element, newIndex) => {
        const oldIndex = element.id.split('-')[1];

        // Update semua input names dengan index baru
        const selects = element.querySelectorAll('select');
        const inputs = element.querySelectorAll('input');
        const textareas = element.querySelectorAll('textarea');

        // Update select names
        selects.forEach(select => {
            const name = select.name.replace(/medicines\[\d+\]/, `medicines[${newIndex}]`);
            select.name = name;
        });

        // Update input names
        inputs.forEach(input => {
            const name = input.name.replace(/medicines\[\d+\]/, `medicines[${newIndex}]`);
            input.name = name;
        });

        // Update textarea names
        textareas.forEach(textarea => {
            const name = textarea.name.replace(/medicines\[\d+\]/, `medicines[${newIndex}]`);
            textarea.name = name;
        });

        // Update judul
        const title = element.querySelector('h4');
        if (title) {
            title.textContent = `Medicine ${newIndex + 1}`;
        }
    });
}

        // Form submission handling
    document.getElementById('examinationForm').addEventListener('submit', async function(e) {
        e.preventDefault(); // Mencegah reload halaman

        console.log('Form submission started...');

        // Log data form
        const formData = new FormData(this);
        console.log('FormData entries:');
        for (let [key, value] of formData.entries()) {
            console.log(`${key}: ${value}`);
        }

        // Log selected medicines
        const medicines = document.querySelectorAll('[id^="medicine-"]');
        console.log(`Number of medicines: ${medicines.length}`);

        // Validasi data sebelum submit
        const patientId = document.getElementById('patient_id').value;
        const doctorNotes = document.getElementById('doctor_notes').value;

        if (!patientId) {
            console.error('Validation Error: Patient is required');
            alert('Please select a patient');
            return;
        }

        if (!doctorNotes.trim()) {
            console.error('Validation Error: Doctor notes are required');
            alert('Please fill in doctor notes');
            return;
        }

        console.log('All validations passed');

        try {
            // Kirim form dengan AJAX
            const response = await fetch(this.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                }
            });

            console.log('Response status:', response.status);
            console.log('Response headers:', Object.fromEntries(response.headers.entries()));

            const data = await response.json();
            console.log('Response data:', data);

            if (response.ok) {
                console.log('Success! Redirecting...');
                // Redirect ke halaman success
                window.location.href = '{{ route("doctor.examinations.index") }}';
            } else {
                console.error('Server Error:', data);
                // Tampilkan error dari server
                if (data.errors) {
                    let errorMessages = '';
                    Object.values(data.errors).forEach(error => {
                        errorMessages += error + '\n';
                    });
                    alert('Validation Errors:\n' + errorMessages);
                } else {
                    alert('Error: ' + (data.message || 'Unknown error occurred'));
                }
            }

        } catch (error) {
            console.error('Network Error:', error);
            alert('Network error. Please check your connection and try again.');

            // Fallback: submit form secara tradisional jika AJAX gagal
            console.log('Falling back to traditional form submission...');
            this.submit();
        }
    });

        // Add one medicine by default
        document.addEventListener('DOMContentLoaded', function() {
            addMedicine();
        });
    </script>
    @endpush
</x-app-layout>
