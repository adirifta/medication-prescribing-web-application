<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
                    {{ __('Create New Patient') }}
                </h2>
                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                    Add a new patient to your records
                </p>
            </div>
            <a href="{{ route('doctor.patients.index') }}" class="btn btn-secondary flex items-center gap-2">
                <i class="fas fa-arrow-left"></i>
                Back to Patients
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="card">
                <div class="p-8">
                    <form action="{{ route('doctor.patients.store') }}" method="POST" class="space-y-8">
                        @csrf

                        <!-- Personal Information -->
                        <div class="border border-gray-200 dark:border-gray-700 rounded-xl p-6">
                            <div class="flex items-center mb-6">
                                <div class="w-10 h-10 bg-blue-100 dark:bg-blue-900/30 rounded-lg flex items-center justify-center mr-3">
                                    <i class="fas fa-user text-blue-600 dark:text-blue-400"></i>
                                </div>
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Personal Information</h3>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Name -->
                                <div>
                                    <label for="name" class="form-label flex items-center">
                                        <i class="fas fa-user-circle mr-2 text-gray-500"></i>
                                        Full Name *
                                    </label>
                                    <input type="text" id="name" name="name" value="{{ old('name') }}" required
                                           class="form-input @error('name') border-red-500 @enderror"
                                           placeholder="Enter full name">
                                    @error('name')
                                        <p class="mt-2 text-sm text-red-600 dark:text-red-400 flex items-center">
                                            <i class="fas fa-exclamation-circle mr-2"></i>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <!-- Date of Birth -->
                                <div>
                                    <label for="date_of_birth" class="form-label flex items-center">
                                        <i class="fas fa-birthday-cake mr-2 text-gray-500"></i>
                                        Date of Birth *
                                    </label>
                                    <input type="date" id="date_of_birth" name="date_of_birth"
                                           value="{{ old('date_of_birth') }}" required
                                           max="{{ date('Y-m-d') }}"
                                           class="form-input @error('date_of_birth') border-red-500 @enderror">
                                    <div id="age-display" class="mt-2 text-sm">
                                        <span class="text-gray-500">Age: </span>
                                        <span id="age-value" class="font-medium text-gray-700 dark:text-gray-300">-</span>
                                    </div>
                                    @error('date_of_birth')
                                        <p class="mt-2 text-sm text-red-600 dark:text-red-400 flex items-center">
                                            <i class="fas fa-exclamation-circle mr-2"></i>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <!-- Gender -->
                                <div>
                                    <label for="gender" class="form-label flex items-center">
                                        <i class="fas fa-venus-mars mr-2 text-gray-500"></i>
                                        Gender *
                                    </label>
                                    <select id="gender" name="gender" required
                                            class="form-input @error('gender') border-red-500 @enderror">
                                        <option value="">Select Gender</option>
                                        <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>
                                            <i class="fas fa-mars mr-2"></i>Male
                                        </option>
                                        <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>
                                            <i class="fas fa-venus mr-2"></i>Female
                                        </option>
                                    </select>
                                    @error('gender')
                                        <p class="mt-2 text-sm text-red-600 dark:text-red-400 flex items-center">
                                            <i class="fas fa-exclamation-circle mr-2"></i>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <!-- Phone -->
                                <div>
                                    <label for="phone" class="form-label flex items-center">
                                        <i class="fas fa-phone mr-2 text-gray-500"></i>
                                        Phone Number *
                                    </label>
                                    <input type="text" id="phone" name="phone" value="{{ old('phone') }}" required
                                           placeholder="08xxxxxxxxxx"
                                           class="form-input @error('phone') border-red-500 @enderror">
                                    @error('phone')
                                        <p class="mt-2 text-sm text-red-600 dark:text-red-400 flex items-center">
                                            <i class="fas fa-exclamation-circle mr-2"></i>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Address -->
                            <div class="mt-6">
                                <label for="address" class="form-label flex items-center">
                                    <i class="fas fa-home mr-2 text-gray-500"></i>
                                    Address
                                </label>
                                <textarea id="address" name="address" rows="3"
                                          class="form-input @error('address') border-red-500 @enderror"
                                          placeholder="Enter patient's address">{{ old('address') }}</textarea>
                                @error('address')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-400 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-2"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>

                        <!-- Medical Information -->
                        <div class="border border-gray-200 dark:border-gray-700 rounded-xl p-6">
                            <div class="flex items-center mb-6">
                                <div class="w-10 h-10 bg-green-100 dark:bg-green-900/30 rounded-lg flex items-center justify-center mr-3">
                                    <i class="fas fa-heartbeat text-green-600 dark:text-green-400"></i>
                                </div>
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Medical Information</h3>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- MRN Preview -->
                                <div class="md:col-span-2">
                                    <label class="form-label flex items-center">
                                        <i class="fas fa-id-card mr-2 text-gray-500"></i>
                                        Medical Record Number
                                    </label>
                                    <div class="p-4 bg-gray-50 dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700">
                                        <div class="flex justify-between items-center">
                                            <div>
                                                <div class="text-lg font-bold text-gray-900 dark:text-white" id="mrn-preview">
                                                    Generating...
                                                </div>
                                                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                                    Automatically generated
                                                </p>
                                            </div>
                                            <button type="button" onclick="generateMRN()" class="btn btn-outline text-sm">
                                                <i class="fas fa-sync-alt mr-2"></i>
                                                Regenerate
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <!-- Allergies -->
                                <div>
                                    <label for="allergies" class="form-label flex items-center">
                                        <i class="fas fa-allergies mr-2 text-gray-500"></i>
                                        Known Allergies
                                    </label>
                                    <input type="text" id="allergies" name="allergies"
                                           value="{{ old('allergies') }}"
                                           placeholder="e.g., Penicillin, Peanuts"
                                           class="form-input">
                                </div>

                                <!-- Blood Type -->
                                <div>
                                    <label for="blood_type" class="form-label flex items-center">
                                        <i class="fas fa-tint mr-2 text-gray-500"></i>
                                        Blood Type
                                    </label>
                                    <select id="blood_type" name="blood_type" class="form-input">
                                        <option value="">Select Blood Type</option>
                                        <option value="A+" {{ old('blood_type') == 'A+' ? 'selected' : '' }}>A+</option>
                                        <option value="A-" {{ old('blood_type') == 'A-' ? 'selected' : '' }}>A-</option>
                                        <option value="B+" {{ old('blood_type') == 'B+' ? 'selected' : '' }}>B+</option>
                                        <option value="B-" {{ old('blood_type') == 'B-' ? 'selected' : '' }}>B-</option>
                                        <option value="AB+" {{ old('blood_type') == 'AB+' ? 'selected' : '' }}>AB+</option>
                                        <option value="AB-" {{ old('blood_type') == 'AB-' ? 'selected' : '' }}>AB-</option>
                                        <option value="O+" {{ old('blood_type') == 'O+' ? 'selected' : '' }}>O+</option>
                                        <option value="O-" {{ old('blood_type') == 'O-' ? 'selected' : '' }}>O-</option>
                                    </select>
                                </div>

                                <!-- Chronic Conditions -->
                                <div class="md:col-span-2">
                                    <label for="chronic_conditions" class="form-label flex items-center">
                                        <i class="fas fa-stethoscope mr-2 text-gray-500"></i>
                                        Chronic Conditions
                                    </label>
                                    <textarea id="chronic_conditions" name="chronic_conditions" rows="2"
                                              placeholder="e.g., Diabetes, Hypertension"
                                              class="form-input">{{ old('chronic_conditions') }}</textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Emergency Contact -->
                        <div class="border border-gray-200 dark:border-gray-700 rounded-xl p-6">
                            <div class="flex items-center mb-6">
                                <div class="w-10 h-10 bg-yellow-100 dark:bg-yellow-900/30 rounded-lg flex items-center justify-center mr-3">
                                    <i class="fas fa-phone-alt text-yellow-600 dark:text-yellow-400"></i>
                                </div>
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Emergency Contact (Optional)</h3>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="emergency_contact_name" class="form-label flex items-center">
                                        <i class="fas fa-user-friends mr-2 text-gray-500"></i>
                                        Contact Name
                                    </label>
                                    <input type="text" id="emergency_contact_name" name="emergency_contact_name"
                                           value="{{ old('emergency_contact_name') }}"
                                           placeholder="Full name"
                                           class="form-input">
                                </div>

                                <div>
                                    <label for="emergency_contact_phone" class="form-label flex items-center">
                                        <i class="fas fa-phone mr-2 text-gray-500"></i>
                                        Contact Phone
                                    </label>
                                    <input type="text" id="emergency_contact_phone" name="emergency_contact_phone"
                                           value="{{ old('emergency_contact_phone') }}"
                                           placeholder="08xxxxxxxxxx"
                                           class="form-input">
                                </div>

                                <div class="md:col-span-2">
                                    <label for="emergency_contact_relation" class="form-label flex items-center">
                                        <i class="fas fa-handshake mr-2 text-gray-500"></i>
                                        Relationship
                                    </label>
                                    <input type="text" id="emergency_contact_relation" name="emergency_contact_relation"
                                           value="{{ old('emergency_contact_relation') }}"
                                           placeholder="e.g., Spouse, Parent, Child"
                                           class="form-input">
                                </div>
                            </div>
                        </div>

                        <!-- Additional Notes -->
                        <div class="border border-gray-200 dark:border-gray-700 rounded-xl p-6">
                            <div class="flex items-center mb-6">
                                <div class="w-10 h-10 bg-gray-100 dark:bg-gray-800 rounded-lg flex items-center justify-center mr-3">
                                    <i class="fas fa-notes-medical text-gray-600 dark:text-gray-400"></i>
                                </div>
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Additional Notes</h3>
                            </div>

                            <div>
                                <label for="notes" class="form-label flex items-center">
                                    <i class="fas fa-sticky-note mr-2 text-gray-500"></i>
                                    Notes (Optional)
                                </label>
                                <textarea id="notes" name="notes" rows="4"
                                          placeholder="Additional information about the patient..."
                                          class="form-input">{{ old('notes') }}</textarea>
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div class="flex justify-end space-x-4 pt-6 border-t border-gray-200 dark:border-gray-700">
                            <a href="{{ route('doctor.patients.index') }}" class="btn btn-secondary px-8">
                                Cancel
                            </a>
                            <button type="submit" class="btn btn-primary px-8">
                                <i class="fas fa-save mr-2"></i>
                                Create Patient
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        // Calculate age from date of birth
        function calculateAge() {
            const dobInput = document.getElementById('date_of_birth');
            const ageDisplay = document.getElementById('age-value');

            if (dobInput.value) {
                const dob = new Date(dobInput.value);
                const today = new Date();
                let age = today.getFullYear() - dob.getFullYear();
                const monthDiff = today.getMonth() - dob.getMonth();

                if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < dob.getDate())) {
                    age--;
                }

                ageDisplay.textContent = age > 0 ? `${age} years` : 'Invalid date';
                ageDisplay.className = age > 0 ?
                    'font-medium text-green-600 dark:text-green-400' :
                    'font-medium text-red-600 dark:text-red-400';
            } else {
                ageDisplay.textContent = '-';
                ageDisplay.className = 'font-medium text-gray-700 dark:text-gray-300';
            }
        }

        // Generate MRN
        function generateMRN() {
            const year = new Date().getFullYear().toString().slice(-2);
            const randomNum = Math.floor(1000 + Math.random() * 9000);
            const mrn = `MRN${year}${randomNum}`;
            document.getElementById('mrn-preview').textContent = mrn;
        }

        // Phone number validation
        function validatePhone(input) {
            const phone = input.value;
            const phoneRegex = /^08[0-9]{9,11}$/;

            if (phone && !phoneRegex.test(phone)) {
                input.classList.add('border-red-500');
                return false;
            } else {
                input.classList.remove('border-red-500');
                return true;
            }
        }

        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
            generateMRN();

            const dobInput = document.getElementById('date_of_birth');
            const phoneInput = document.getElementById('phone');

            if (dobInput.value) {
                calculateAge();
            }

            dobInput.addEventListener('change', calculateAge);
            phoneInput.addEventListener('blur', function() {
                validatePhone(this);
            });

            // Pre-fill form with old values
            @if(old('date_of_birth'))
                calculateAge();
            @endif
        });
    </script>
    @endpush
</x-app-layout>
