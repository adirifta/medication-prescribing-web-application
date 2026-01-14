<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Edit Examination') }}
            </h2>
            <div class="text-sm text-gray-500">
                <a href="{{ route('doctor.examinations.show', $examination->id) }}" class="text-blue-600 hover:text-blue-800">
                    ← Back to Examination
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form id="examinationForm" action="{{ route('doctor.examinations.update', $examination->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <!-- Patient Information -->
                        <div class="bg-blue-50 p-4 rounded-lg">
                            <h3 class="text-lg font-semibold text-blue-800 mb-4">Patient Information</h3>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="patient_id" class="block text-sm font-medium text-gray-700">Patient</label>
                                    <select id="patient_id" name="patient_id" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                        <option value="">Select a patient</option>
                                        @foreach($patients as $p)
                                            <option value="{{ $p->id }}" {{ $examination->patient_id == $p->id ? 'selected' : '' }}>
                                                {{ $p->name }} ({{ $p->medical_record_number }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="flex items-end">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Current Patient</label>
                                        <div class="mt-2 text-sm font-medium text-gray-900">
                                            {{ $examination->patient->name }}
                                            <span class="text-gray-500 ml-2">(MRN: {{ $examination->patient->medical_record_number }})</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Vital Signs -->
                        <div class="bg-green-50 p-4 rounded-lg">
                            <h3 class="text-lg font-semibold text-green-800 mb-4">Vital Signs</h3>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <label for="height" class="block text-sm font-medium text-gray-700">Height (cm)</label>
                                    <input type="number" step="0.1" id="height" name="height" value="{{ old('height', $examination->height) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                                </div>

                                <div>
                                    <label for="weight" class="block text-sm font-medium text-gray-700">Weight (kg)</label>
                                    <input type="number" step="0.1" id="weight" name="weight" value="{{ old('weight', $examination->weight) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">BMI</label>
                                    <div id="bmi-display" class="mt-2 text-lg font-semibold text-gray-900">{{ $examination->bmi ?: '-' }}</div>
                                    <input type="hidden" id="bmi" name="bmi" value="{{ old('bmi', $examination->bmi) }}">
                                </div>

                                <div>
                                    <label for="systolic" class="block text-sm font-medium text-gray-700">Systolic (mmHg)</label>
                                    <input type="number" id="systolic" name="systolic" value="{{ old('systolic', $examination->systolic) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                                </div>

                                <div>
                                    <label for="diastolic" class="block text-sm font-medium text-gray-700">Diastolic (mmHg)</label>
                                    <input type="number" id="diastolic" name="diastolic" value="{{ old('diastolic', $examination->diastolic) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Blood Pressure</label>
                                    <div id="bp-display" class="mt-2 text-sm text-gray-900">{{ $examination->blood_pressure ?: '-' }}</div>
                                </div>

                                <div>
                                    <label for="heart_rate" class="block text-sm font-medium text-gray-700">Heart Rate (bpm)</label>
                                    <input type="number" id="heart_rate" name="heart_rate" value="{{ old('heart_rate', $examination->heart_rate) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                                </div>

                                <div>
                                    <label for="respiration_rate" class="block text-sm font-medium text-gray-700">Respiration Rate</label>
                                    <input type="number" id="respiration_rate" name="respiration_rate" value="{{ old('respiration_rate', $examination->respiration_rate) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                                </div>

                                <div>
                                    <label for="temperature" class="block text-sm font-medium text-gray-700">Temperature (°C)</label>
                                    <input type="number" step="0.1" id="temperature" name="temperature" value="{{ old('temperature', $examination->temperature) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                                </div>
                            </div>
                        </div>

                        <!-- Doctor Notes -->
                        <div>
                            <label for="doctor_notes" class="block text-sm font-medium text-gray-700">Doctor Notes</label>
                            <textarea id="doctor_notes" name="doctor_notes" rows="4" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('doctor_notes', $examination->doctor_notes) }}</textarea>
                        </div>

                        <!-- File Upload -->
                        <div>
                            <label for="external_file" class="block text-sm font-medium text-gray-700">Upload External File</label>
                            @if($examination->external_file_path)
                            <div class="mb-2 p-3 bg-gray-50 rounded-lg">
                                <div class="flex items-center">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    <div class="ml-3">
                                        <div class="text-sm font-medium text-gray-900">Current File</div>
                                        <a href="{{ Storage::url($examination->external_file_path) }}" target="_blank" class="text-sm text-blue-600 hover:text-blue-800">
                                            View File
                                        </a>
                                    </div>
                                </div>
                            </div>
                            @endif
                            <input type="file" id="external_file" name="external_file" accept=".pdf,.jpg,.jpeg,.png,.doc,.docx" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                            <p class="mt-1 text-xs text-gray-500">PDF, JPG, PNG, DOC up to 10MB</p>
                        </div>

                        <!-- Prescription Section -->
                        @php
                            $examination->load(['prescription.items']);
                        @endphp
                        <div class="bg-purple-50 p-4 rounded-lg">
                            <h3 class="text-lg font-semibold text-purple-800 mb-4">Prescription</h3>

                            @if($examination->prescription && !$examination->prescription->canBeEdited())
                            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-4">
                                <div class="flex">
                                    <svg class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                    </svg>
                                    <div class="ml-3">
                                        <h3 class="text-sm font-medium text-yellow-800">Prescription Status: {{ ucfirst($examination->prescription->status) }}</h3>
                                        <div class="mt-2 text-sm text-yellow-700">
                                            <p>This prescription has been processed by the pharmacist and cannot be edited.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif

                            <div class="mb-4">
                                <label for="prescription_notes" class="block text-sm font-medium text-gray-700">Prescription Notes</label>
                                <textarea id="prescription_notes" name="prescription_notes" rows="2" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500" {{ $examination->prescription && !$examination->prescription->canBeEdited() ? 'disabled' : '' }}>{{ old('prescription_notes', $examination->prescription->notes ?? '') }}</textarea>
                            </div>

                            <!-- Medicine Selection -->
                            @if($examination->prescription && $examination->prescription->canBeEdited())
                            <div class="mb-6">
                                <div class="flex justify-between items-center mb-2">
                                    <label class="block text-sm font-medium text-gray-700">Medicines</label>
                                    <button type="button" onclick="addMedicine()" class="inline-flex items-center px-3 py-1 bg-purple-600 text-white text-xs rounded hover:bg-purple-700">
                                        + Add Medicine
                                    </button>
                                </div>

                                <div id="medicines-container" class="space-y-3">
                                    @php
                                        $medicineCounter = 0;
                                        $selectedMedicines = $examination->prescription->items ?? [];
                                    @endphp

                                    @if(count($selectedMedicines) > 0)
                                        @foreach($selectedMedicines as $index => $item)
                                            @php $medicineCounter = $index + 1; @endphp
                                            <div id="medicine-{{ $medicineCounter }}" class="border border-gray-300 rounded-lg p-4 bg-white">
                                                <div class="flex justify-between mb-2">
                                                    <h4 class="font-medium">Medicine {{ $medicineCounter }}</h4>
                                                    <button type="button" onclick="removeMedicine('medicine-{{ $medicineCounter }}')" class="text-red-600 hover:text-red-800">
                                                        × Remove
                                                    </button>
                                                </div>

                                                <div class="grid grid-cols-1 md:grid-cols-4 gap-3">
                                                    <div>
                                                        <label class="block text-xs font-medium text-gray-700">Medicine</label>
                                                        <select name="medicines[{{ $medicineCounter }}][id]" onchange="updateMedicinePrice(this, {{ $medicineCounter }})" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm text-sm">
                                                            <option value="">Select medicine</option>
                                                            @foreach($medicines as $med)
                                                                <option value="{{ $med['id'] }}" data-name="{{ $med['name'] }}" {{ $item->medicine_id == $med['id'] ? 'selected' : '' }}>
                                                                    {{ $med['name'] }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        <input type="hidden" name="medicines[{{ $medicineCounter }}][name]" value="{{ $item->medicine_name }}">
                                                    </div>

                                                    <div>
                                                        <label class="block text-xs font-medium text-gray-700">Quantity</label>
                                                        <input type="number" name="medicines[{{ $medicineCounter }}][quantity]" min="1" value="{{ $item->quantity }}" onchange="updateMedicineSubtotal({{ $medicineCounter }})" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm text-sm">
                                                    </div>

                                                    <div>
                                                        <label class="block text-xs font-medium text-gray-700">Unit Price</label>
                                                        <div class="mt-1">
                                                            <input type="number" id="price-{{ $medicineCounter }}" value="{{ $item->unit_price }}" readonly class="block w-full rounded-md border-gray-300 bg-gray-50 shadow-sm text-sm">
                                                        </div>
                                                    </div>

                                                    <div>
                                                        <label class="block text-xs font-medium text-gray-700">Subtotal</label>
                                                        <div class="mt-1">
                                                            <input type="number" id="subtotal-{{ $medicineCounter }}" value="{{ $item->subtotal }}" readonly class="block w-full rounded-md border-gray-300 bg-gray-50 shadow-sm text-sm">
                                                        </div>
                                                    </div>

                                                    <div class="md:col-span-4">
                                                        <label class="block text-xs font-medium text-gray-700">Instructions</label>
                                                        <textarea name="medicines[{{ $medicineCounter }}][instructions]" rows="2" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm text-sm" placeholder="Usage instructions...">{{ $item->instructions }}</textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                    <!-- Medicines will be added here dynamically -->
                                    @endif
                                </div>
                            </div>
                            @endif
                        </div>

                        <!-- Summary -->
                        <div class="bg-yellow-50 p-4 rounded-lg">
                            <h3 class="text-lg font-semibold text-yellow-800 mb-2">Summary</h3>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <p class="text-sm text-gray-600">Number of Medicines:</p>
                                    <p id="medicine-count" class="font-semibold">{{ $medicineCounter }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600">Estimated Total:</p>
                                    <p id="total-price" class="font-semibold text-xl">IDR {{ number_format($examination->prescription->total_price ?? 0, 0, ',', '.') }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-end space-x-3">
                            <a href="{{ route('doctor.examinations.show', $examination->id) }}" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                                Cancel
                            </a>
                            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2" {{ $examination->prescription && !$examination->prescription->canBeEdited() ? 'disabled' : '' }}>
                                Update Examination
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        const medicines = @json($medicines);
        let medicineCounter = {{ $medicineCounter }};
        let selectedMedicines = [];

        function addMedicine() {
            const container = document.getElementById('medicines-container');
            const id = `medicine-${++medicineCounter}`;

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
                            <select name="medicines[${medicineCounter}][id]" onchange="updateMedicinePrice(this, ${medicineCounter})" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm text-sm">
                                <option value="">Select medicine</option>
                                ${medicines.map(med => `
                                    <option value="${med.id}" data-name="${med.name}">${med.name}</option>
                                `).join('')}
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-medium text-gray-700">Quantity</label>
                            <input type="number" name="medicines[${medicineCounter}][quantity]" min="1" value="1" onchange="updateMedicineSubtotal(${medicineCounter})" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm text-sm">
                        </div>

                        <div>
                            <label class="block text-xs font-medium text-gray-700">Unit Price</label>
                            <div class="mt-1">
                                <input type="number" id="price-${medicineCounter}" readonly class="block w-full rounded-md border-gray-300 bg-gray-50 shadow-sm text-sm">
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-medium text-gray-700">Subtotal</label>
                            <div class="mt-1">
                                <input type="number" id="subtotal-${medicineCounter}" readonly class="block w-full rounded-md border-gray-300 bg-gray-50 shadow-sm text-sm">
                            </div>
                        </div>

                        <div class="md:col-span-4">
                            <label class="block text-xs font-medium text-gray-700">Instructions</label>
                            <textarea name="medicines[${medicineCounter}][instructions]" rows="2" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm text-sm" placeholder="Usage instructions..."></textarea>
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

            // Fetch price from API
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
            } else {
                document.getElementById('bmi-display').textContent = '-';
                document.getElementById('bmi-display').className = 'mt-2 text-lg font-semibold text-gray-900';
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
            } else {
                bpDisplay.textContent = '-';
                bpDisplay.className = 'mt-2 text-sm text-gray-900';
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
</x-app-layout>
