@extends('layouts.app')

@section('title', 'Page Title')

@section('header')
        <div class="flex justify-between items-center">
            <div>
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
                    Edit Examination
                </h2>
                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                    Update examination details for patient
                </p>
            </div>
            <div class="flex items-center space-x-4">
                <button id="theme-toggle" class="p-2 rounded-lg bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600">
                    <i class="fas fa-moon text-gray-600 dark:text-yellow-400" id="theme-icon"></i>
                </button>
                <a href="{{ route('doctor.examinations.show', $examination->id) }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Back to Examination
                </a>
            </div>
        </div>
    @endsection

@section('content')

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="card">
                <div class="p-6">
                    <form id="examinationForm" action="{{ route('doctor.examinations.update', $examination->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <!-- Patient Information -->
                        <div class="bg-gradient-to-r from-blue-50 to-blue-100 dark:from-blue-900/20 dark:to-blue-800/20 p-6 rounded-lg">
                            <h3 class="text-lg font-semibold text-blue-800 dark:text-blue-300 mb-4 flex items-center">
                                <i class="fas fa-user-injured mr-3"></i>
                                Patient Information
                            </h3>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="patient_id" class="form-label">
                                        <i class="fas fa-user mr-2 text-blue-500"></i>
                                        Select Patient
                                    </label>
                                    <select id="patient_id" name="patient_id" required class="form-input">
                                        <option value="">Select a patient</option>
                                        @foreach($patients as $p)
                                            <option value="{{ $p->id }}" {{ $examination->patient_id == $p->id ? 'selected' : '' }}>
                                                {{ $p->name }} ({{ $p->medical_record_number }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="flex items-center">
                                    <div class="bg-white dark:bg-gray-800 p-4 rounded-lg border border-blue-200 dark:border-blue-700 flex-1">
                                        <div class="text-sm font-medium text-blue-700 dark:text-blue-300 mb-1">Current Patient</div>
                                        <div class="text-lg font-semibold text-gray-900 dark:text-white">
                                            {{ $examination->patient->name }}
                                        </div>
                                        <div class="text-sm text-gray-600 dark:text-gray-400">
                                            MRN: {{ $examination->patient->medical_record_number }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Vital Signs -->
                        <div class="bg-gradient-to-r from-green-50 to-green-100 dark:from-green-900/20 dark:to-green-800/20 p-6 rounded-lg">
                            <h3 class="text-lg font-semibold text-green-800 dark:text-green-300 mb-4 flex items-center">
                                <i class="fas fa-heart-pulse mr-3"></i>
                                Vital Signs
                            </h3>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <!-- Height -->
                                <div>
                                    <label for="height" class="form-label">
                                        <i class="fas fa-ruler-vertical mr-2 text-green-500"></i>
                                        Height (cm)
                                    </label>
                                    <input type="number" step="0.1" id="height" name="height"
                                           value="{{ old('height', $examination->height) }}"
                                           class="form-input"
                                           oninput="calculateBMI()">
                                </div>

                                <!-- Weight -->
                                <div>
                                    <label for="weight" class="form-label">
                                        <i class="fas fa-weight-scale mr-2 text-green-500"></i>
                                        Weight (kg)
                                    </label>
                                    <input type="number" step="0.1" id="weight" name="weight"
                                           value="{{ old('weight', $examination->weight) }}"
                                           class="form-input"
                                           oninput="calculateBMI()">
                                </div>

                                <!-- BMI -->
                                <div>
                                    <label class="form-label">
                                        <i class="fas fa-chart-line mr-2 text-green-500"></i>
                                        BMI
                                    </label>
                                    <div class="flex items-center mt-1">
                                        <div id="bmi-display" class="text-2xl font-bold text-gray-900 dark:text-white mr-3">
                                            {{ $examination->bmi ?: '-' }}
                                        </div>
                                        <div id="bmi-indicator" class="text-xs font-semibold px-2 py-1 rounded-full">
                                            <!-- Will be populated by JavaScript -->
                                        </div>
                                    </div>
                                    <input type="hidden" id="bmi" name="bmi" value="{{ old('bmi', $examination->bmi) }}">
                                </div>

                                <!-- Systolic -->
                                <div>
                                    <label for="systolic" class="form-label">
                                        <i class="fas fa-tachometer-alt mr-2 text-red-500"></i>
                                        Systolic (mmHg)
                                    </label>
                                    <input type="number" id="systolic" name="systolic"
                                           value="{{ old('systolic', $examination->systolic) }}"
                                           class="form-input"
                                           oninput="updateBP()">
                                </div>

                                <!-- Diastolic -->
                                <div>
                                    <label for="diastolic" class="form-label">
                                        <i class="fas fa-tachometer-alt mr-2 text-red-500"></i>
                                        Diastolic (mmHg)
                                    </label>
                                    <input type="number" id="diastolic" name="diastolic"
                                           value="{{ old('diastolic', $examination->diastolic) }}"
                                           class="form-input"
                                           oninput="updateBP()">
                                </div>

                                <!-- Blood Pressure -->
                                <div>
                                    <label class="form-label">
                                        <i class="fas fa-heart mr-2 text-red-500"></i>
                                        Blood Pressure
                                    </label>
                                    <div id="bp-display" class="text-xl font-semibold text-gray-900 dark:text-white mt-1">
                                        {{ $examination->blood_pressure ?: '-' }}
                                    </div>
                                </div>

                                <!-- Heart Rate -->
                                <div>
                                    <label for="heart_rate" class="form-label">
                                        <i class="fas fa-heartbeat mr-2 text-pink-500"></i>
                                        Heart Rate (bpm)
                                    </label>
                                    <input type="number" id="heart_rate" name="heart_rate"
                                           value="{{ old('heart_rate', $examination->heart_rate) }}"
                                           class="form-input">
                                </div>

                                <!-- Respiration Rate -->
                                <div>
                                    <label for="respiration_rate" class="form-label">
                                        <i class="fas fa-lungs mr-2 text-teal-500"></i>
                                        Respiration Rate
                                    </label>
                                    <input type="number" id="respiration_rate" name="respiration_rate"
                                           value="{{ old('respiration_rate', $examination->respiration_rate) }}"
                                           class="form-input">
                                </div>

                                <!-- Temperature -->
                                <div>
                                    <label for="temperature" class="form-label">
                                        <i class="fas fa-thermometer-half mr-2 text-orange-500"></i>
                                        Temperature (°C)
                                    </label>
                                    <input type="number" step="0.1" id="temperature" name="temperature"
                                           value="{{ old('temperature', $examination->temperature) }}"
                                           class="form-input">
                                </div>
                            </div>
                        </div>

                        <!-- Doctor Notes -->
                        <div>
                            <label for="doctor_notes" class="form-label flex items-center">
                                <i class="fas fa-stethoscope mr-2 text-blue-500"></i>
                                Doctor Notes
                            </label>
                            <textarea id="doctor_notes" name="doctor_notes" rows="4" required
                                      class="form-input">{{ old('doctor_notes', $examination->doctor_notes) }}</textarea>
                        </div>

                        <!-- File Upload -->
                        <div>
                            <label class="form-label flex items-center">
                                <i class="fas fa-paperclip mr-2 text-gray-500"></i>
                                External Files
                            </label>
                            @if($examination->external_file_path)
                            <div class="mb-4 p-4 bg-gray-50 dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700">
                                <div class="flex items-center">
                                    <i class="fas fa-file-medical text-gray-400 text-xl mr-3"></i>
                                    <div class="flex-1">
                                        <div class="font-medium text-gray-900 dark:text-white">Current File</div>
                                        <div class="text-sm text-gray-600 dark:text-gray-400">
                                            Uploaded on {{ $examination->created_at->format('d M Y') }}
                                        </div>
                                    </div>
                                    <a href="{{ Storage::url($examination->external_file_path) }}" target="_blank"
                                       class="btn btn-secondary text-sm px-3 py-1">
                                        <i class="fas fa-eye mr-1"></i> View
                                    </a>
                                </div>
                            </div>
                            @endif
                            <input type="file" id="external_file" name="external_file"
                                   accept=".pdf,.jpg,.jpeg,.png,.doc,.docx"
                                   class="form-input file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 dark:file:bg-blue-900 dark:file:text-blue-300">
                            <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                                <i class="fas fa-info-circle mr-1"></i>
                                Supported formats: PDF, JPG, PNG, DOC, DOCX (max 10MB)
                            </p>
                        </div>

                        <!-- Prescription Section -->
                        @php
                            $examination->load(['prescription.items']);
                        @endphp
                        <div class="bg-gradient-to-r from-purple-50 to-purple-100 dark:from-purple-900/20 dark:to-purple-800/20 p-6 rounded-lg">
                            <h3 class="text-lg font-semibold text-purple-800 dark:text-purple-300 mb-4 flex items-center">
                                <i class="fas fa-prescription-bottle-alt mr-3"></i>
                                Prescription
                            </h3>

                            @if($examination->prescription && !$examination->prescription->canBeEdited())
                            <!-- Warning Message -->
                            <div class="mb-6 p-4 bg-yellow-50 dark:bg-yellow-900/30 border border-yellow-200 dark:border-yellow-800 rounded-lg">
                                <div class="flex">
                                    <i class="fas fa-exclamation-triangle text-yellow-500 mt-1 mr-3"></i>
                                    <div>
                                        <h4 class="font-medium text-yellow-800 dark:text-yellow-200">
                                            Prescription Status: {{ ucfirst($examination->prescription->status) }}
                                        </h4>
                                        <p class="mt-1 text-sm text-yellow-700 dark:text-yellow-300">
                                            This prescription has been processed by the pharmacist and cannot be edited.
                                            Contact the pharmacy if changes are needed.
                                        </p>
                                    </div>
                                </div>
                            </div>
                            @endif

                            <!-- Prescription Notes -->
                            <div class="mb-6">
                                <label for="prescription_notes" class="form-label">
                                    <i class="fas fa-notes-medical mr-2 text-purple-500"></i>
                                    Prescription Notes
                                </label>
                                <textarea id="prescription_notes" name="prescription_notes" rows="2"
                                          class="form-input"
                                          {{ $examination->prescription && !$examination->prescription->canBeEdited() ? 'disabled' : '' }}>
                                    {{ old('prescription_notes', $examination->prescription->notes ?? '') }}
                                </textarea>
                            </div>

                            <!-- Medicine Selection -->
                            @if($examination->prescription && $examination->prescription->canBeEdited())
                            <div class="mb-6">
                                <div class="flex justify-between items-center mb-4">
                                    <label class="form-label">
                                        <i class="fas fa-pills mr-2 text-purple-500"></i>
                                        Medicines
                                    </label>
                                    <button type="button" onclick="addMedicine()" class="btn btn-secondary">
                                        <i class="fas fa-plus mr-2"></i>
                                        Add Medicine
                                    </button>
                                </div>

                                <div id="medicines-container" class="space-y-4">
                                    @php
                                        $medicineCounter = 0;
                                        $selectedMedicines = $examination->prescription->items ?? [];
                                    @endphp

                                    @if(count($selectedMedicines) > 0)
                                        @foreach($selectedMedicines as $index => $item)
                                            @php $medicineCounter = $index + 1; @endphp
                                            <div id="medicine-{{ $medicineCounter }}" class="border border-gray-200 dark:border-gray-700 rounded-lg p-4 bg-white dark:bg-gray-800">
                                                <div class="flex justify-between items-center mb-4">
                                                    <h4 class="font-medium text-gray-900 dark:text-white flex items-center">
                                                        <i class="fas fa-medkit mr-2 text-purple-500"></i>
                                                        Medicine {{ $medicineCounter }}
                                                    </h4>
                                                    <button type="button" onclick="removeMedicine('medicine-{{ $medicineCounter }}')"
                                                            class="text-red-600 dark:text-red-400 hover:text-red-800 dark:hover:text-red-300">
                                                        <i class="fas fa-times mr-1"></i> Remove
                                                    </button>
                                                </div>

                                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                                                    <!-- Medicine Select -->
                                                    <div>
                                                        <label class="form-label text-xs">Medicine</label>
                                                        <select name="medicines[{{ $medicineCounter }}][id]"
                                                                onchange="updateMedicinePrice(this, {{ $medicineCounter }})"
                                                                class="form-input text-sm">
                                                            <option value="">Select medicine</option>
                                                            @foreach($medicines as $med)
                                                                <option value="{{ $med['id'] }}"
                                                                        data-name="{{ $med['name'] }}"
                                                                        {{ $item->medicine_id == $med['id'] ? 'selected' : '' }}>
                                                                    {{ $med['name'] }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        <input type="hidden" name="medicines[{{ $medicineCounter }}][name]"
                                                               value="{{ $item->medicine_name }}">
                                                    </div>

                                                    <!-- Quantity -->
                                                    <div>
                                                        <label class="form-label text-xs">Quantity</label>
                                                        <input type="number" name="medicines[{{ $medicineCounter }}][quantity]"
                                                               min="1" value="{{ $item->quantity }}"
                                                               onchange="updateMedicineSubtotal({{ $medicineCounter }})"
                                                               class="form-input text-sm">
                                                    </div>

                                                    <!-- Unit Price -->
                                                    <div>
                                                        <label class="form-label text-xs">Unit Price</label>
                                                        <div class="mt-1">
                                                            <input type="number" id="price-{{ $medicineCounter }}"
                                                                   value="{{ $item->unit_price }}" readonly
                                                                   class="form-input bg-gray-50 dark:bg-gray-700 text-sm">
                                                        </div>
                                                    </div>

                                                    <!-- Subtotal -->
                                                    <div>
                                                        <label class="form-label text-xs">Subtotal</label>
                                                        <div class="mt-1">
                                                            <input type="number" id="subtotal-{{ $medicineCounter }}"
                                                                   value="{{ $item->subtotal }}" readonly
                                                                   class="form-input bg-gray-50 dark:bg-gray-700 text-sm">
                                                        </div>
                                                    </div>

                                                    <!-- Instructions -->
                                                    <div class="md:col-span-4">
                                                        <label class="form-label text-xs">
                                                            <i class="fas fa-info-circle mr-1"></i>
                                                            Instructions
                                                        </label>
                                                        <textarea name="medicines[{{ $medicineCounter }}][instructions]"
                                                                  rows="2"
                                                                  class="form-input text-sm"
                                                                  placeholder="Usage instructions, dosage, frequency...">
                                                            {{ $item->instructions }}
                                                        </textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                            @endif
                        </div>

                        <!-- Summary -->
                        <div class="bg-gradient-to-r from-yellow-50 to-yellow-100 dark:from-yellow-900/20 dark:to-yellow-800/20 p-6 rounded-lg">
                            <h3 class="text-lg font-semibold text-yellow-800 dark:text-yellow-300 mb-4 flex items-center">
                                <i class="fas fa-receipt mr-3"></i>
                                Summary
                            </h3>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <div class="bg-white dark:bg-gray-800 p-4 rounded-lg border border-yellow-200 dark:border-yellow-700">
                                    <div class="text-sm text-yellow-600 dark:text-yellow-400 mb-1">Number of Medicines</div>
                                    <div id="medicine-count" class="text-2xl font-bold text-gray-900 dark:text-white">
                                        {{ $medicineCounter }}
                                    </div>
                                </div>
                                <div class="bg-white dark:bg-gray-800 p-4 rounded-lg border border-yellow-200 dark:border-yellow-700">
                                    <div class="text-sm text-yellow-600 dark:text-yellow-400 mb-1">Estimated Total</div>
                                    <div id="total-price" class="text-2xl font-bold text-gray-900 dark:text-white">
                                        IDR {{ number_format($examination->prescription->total_price ?? 0, 0, ',', '.') }}
                                    </div>
                                </div>
                                <div class="bg-white dark:bg-gray-800 p-4 rounded-lg border border-yellow-200 dark:border-yellow-700">
                                    <div class="text-sm text-yellow-600 dark:text-yellow-400 mb-1">Examination Status</div>
                                    <div class="text-xl font-bold text-gray-900 dark:text-white capitalize">
                                        {{ $examination->status }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex justify-end space-x-4 pt-6 border-t border-gray-200 dark:border-gray-700">
                            <a href="{{ route('doctor.examinations.show', $examination->id) }}"
                               class="btn btn-secondary">
                                <i class="fas fa-times mr-2"></i>
                                Cancel
                            </a>
                            <button type="submit"
                                    class="btn btn-primary"
                                    {{ $examination->prescription && !$examination->prescription->canBeEdited() ? 'disabled' : '' }}>
                                <i class="fas fa-save mr-2"></i>
                                Update Examination
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Theme Toggle
        const themeToggle = document.getElementById('theme-toggle');
        const themeIcon = document.getElementById('theme-icon');

        if (localStorage.getItem('theme') === 'dark' ||
            (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
            if (themeIcon) {
                themeIcon.classList.remove('fa-moon');
                themeIcon.classList.add('fa-sun');
            }
        }

        if (themeToggle) {
            themeToggle.addEventListener('click', () => {
                document.documentElement.classList.toggle('dark');

                if (document.documentElement.classList.contains('dark')) {
                    localStorage.setItem('theme', 'dark');
                    themeIcon.classList.remove('fa-moon');
                    themeIcon.classList.add('fa-sun');
                } else {
                    localStorage.setItem('theme', 'light');
                    themeIcon.classList.remove('fa-sun');
                    themeIcon.classList.add('fa-moon');
                }
            });
        }

        // Medicine Functions (keep from original)
        const medicines = @json($medicines);
        let medicineCounter = {{ $medicineCounter }};
        let selectedMedicines = [];

        function addMedicine() {
            const container = document.getElementById('medicines-container');
            const id = `medicine-${++medicineCounter}`;

            const medicineHtml = `
                <div id="${id}" class="border border-gray-200 dark:border-gray-700 rounded-lg p-4 bg-white dark:bg-gray-800">
                    <div class="flex justify-between items-center mb-4">
                        <h4 class="font-medium text-gray-900 dark:text-white flex items-center">
                            <i class="fas fa-medkit mr-2 text-purple-500"></i>
                            Medicine ${medicineCounter}
                        </h4>
                        <button type="button" onclick="removeMedicine('${id}')"
                                class="text-red-600 dark:text-red-400 hover:text-red-800 dark:hover:text-red-300">
                            <i class="fas fa-times mr-1"></i> Remove
                        </button>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                        <!-- Medicine Select -->
                        <div>
                            <label class="form-label text-xs">Medicine</label>
                            <select name="medicines[${medicineCounter}][id]"
                                    onchange="updateMedicinePrice(this, ${medicineCounter})"
                                    class="form-input text-sm">
                                <option value="">Select medicine</option>
                                ${medicines.map(med => `
                                    <option value="${med.id}" data-name="${med.name}">${med.name}</option>
                                `).join('')}
                            </select>
                        </div>

                        <!-- Quantity -->
                        <div>
                            <label class="form-label text-xs">Quantity</label>
                            <input type="number" name="medicines[${medicineCounter}][quantity]"
                                   min="1" value="1"
                                   onchange="updateMedicineSubtotal(${medicineCounter})"
                                   class="form-input text-sm">
                        </div>

                        <!-- Unit Price -->
                        <div>
                            <label class="form-label text-xs">Unit Price</label>
                            <div class="mt-1">
                                <input type="number" id="price-${medicineCounter}" readonly
                                       class="form-input bg-gray-50 dark:bg-gray-700 text-sm">
                            </div>
                        </div>

                        <!-- Subtotal -->
                        <div>
                            <label class="form-label text-xs">Subtotal</label>
                            <div class="mt-1">
                                <input type="number" id="subtotal-${medicineCounter}" readonly
                                       class="form-input bg-gray-50 dark:bg-gray-700 text-sm">
                            </div>
                        </div>

                        <!-- Instructions -->
                        <div class="md:col-span-4">
                            <label class="form-label text-xs">
                                <i class="fas fa-info-circle mr-1"></i>
                                Instructions
                            </label>
                            <textarea name="medicines[${medicineCounter}][instructions]"
                                      rows="2"
                                      class="form-input text-sm"
                                      placeholder="Usage instructions, dosage, frequency..."></textarea>
                        </div>
                    </div>
                </div>
            `;

            container.insertAdjacentHTML('beforeend', medicineHtml);
            updateSummary();
        }

        async function updateMedicinePrice(select, index) {
            const medicineId = select.value;
            const selectedOption = select.options[select.selectedIndex];
            const medicineName = selectedOption.getAttribute('data-name');

            // Update medicine name
            select.name = `medicines[${index}][name]`;

            try {
                const response = await fetch(`/api/medicine-price/${medicineId}`);
                const data = await response.json();

                const priceInput = document.getElementById(`price-${index}`);
                const quantityInput = document.querySelector(`input[name="medicines[${index}][quantity]"]`);

                if (priceInput && data.price) {
                    priceInput.value = data.price;
                    updateMedicineSubtotal(index);
                }
            } catch (error) {
                console.error('Error fetching price:', error);
            }
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
            medicineCounter--;
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
        function calculateBMI() {
            const height = parseFloat(document.getElementById('height').value) / 100;
            const weight = parseFloat(document.getElementById('weight').value);
            const bmiDisplay = document.getElementById('bmi-display');
            const bmiIndicator = document.getElementById('bmi-indicator');
            const bmiInput = document.getElementById('bmi');

            if (height > 0 && weight > 0) {
                const bmi = weight / (height * height);
                bmiDisplay.textContent = bmi.toFixed(1);
                bmiInput.value = bmi.toFixed(1);

                // Set BMI category and color
                let category = '';
                let color = '';

                if (bmi < 18.5) {
                    category = 'Underweight';
                    color = 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200';
                } else if (bmi < 25) {
                    category = 'Normal';
                    color = 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200';
                } else if (bmi < 30) {
                    category = 'Overweight';
                    color = 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200';
                } else {
                    category = 'Obese';
                    color = 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200';
                }

                bmiIndicator.className = `text-xs font-semibold px-2 py-1 rounded-full ${color}`;
                bmiIndicator.textContent = category;
            } else {
                bmiDisplay.textContent = '-';
                bmiIndicator.textContent = '';
            }
        }

        // Calculate Blood Pressure
        function updateBP() {
            const systolic = parseInt(document.getElementById('systolic').value);
            const diastolic = parseInt(document.getElementById('diastolic').value);
            const bpDisplay = document.getElementById('bp-display');

            if (systolic && diastolic) {
                bpDisplay.textContent = `${systolic}/${diastolic} mmHg`;

                // Set color based on BP category
                if (systolic < 120 && diastolic < 80) {
                    bpDisplay.className = 'text-xl font-semibold text-green-600 dark:text-green-400 mt-1';
                } else if (systolic < 130 && diastolic < 80) {
                    bpDisplay.className = 'text-xl font-semibold text-yellow-600 dark:text-yellow-400 mt-1';
                } else if (systolic < 140 || diastolic < 90) {
                    bpDisplay.className = 'text-xl font-semibold text-orange-600 dark:text-orange-400 mt-1';
                } else {
                    bpDisplay.className = 'text-xl font-semibold text-red-600 dark:text-red-400 mt-1';
                }
            } else {
                bpDisplay.textContent = '-';
                bpDisplay.className = 'text-xl font-semibold text-gray-900 dark:text-white mt-1';
            }
        }

        // Initialize calculations
        document.addEventListener('DOMContentLoaded', function() {
            calculateBMI();
            updateBP();
            updateSummary();
        });
    </script>
    @endpush
@endsection
