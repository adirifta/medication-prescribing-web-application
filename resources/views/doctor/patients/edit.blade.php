<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
                    {{ __('Edit Patient') }}
                </h2>
                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                    Update patient information
                </p>
            </div>
            <a href="{{ route('doctor.patients.show', $patient->id) }}" class="btn btn-secondary flex items-center gap-2">
                <i class="fas fa-arrow-left"></i>
                Back to Patient
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="card">
                <div class="p-8">
                    <form action="{{ route('doctor.patients.update', $patient->id) }}" method="POST" class="space-y-8">
                        @csrf
                        @method('PUT')

                        <!-- Patient Information -->
                        <div class="border border-gray-200 dark:border-gray-700 rounded-xl p-6">
                            <div class="flex items-center mb-6">
                                <div class="w-10 h-10 bg-blue-100 dark:bg-blue-900/30 rounded-lg flex items-center justify-center mr-3">
                                    <i class="fas fa-user-edit text-blue-600 dark:text-blue-400"></i>
                                </div>
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Patient Information</h3>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Name -->
                                <div>
                                    <label for="name" class="form-label flex items-center">
                                        <i class="fas fa-user-circle mr-2 text-gray-500"></i>
                                        Full Name *
                                    </label>
                                    <input type="text" id="name" name="name"
                                           value="{{ old('name', $patient->name) }}" required
                                           class="form-input @error('name') border-red-500 @enderror">
                                    @error('name')
                                        <p class="mt-2 text-sm text-red-600 dark:text-red-400 flex items-center">
                                            <i class="fas fa-exclamation-circle mr-2"></i>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <!-- MRN -->
                                <div>
                                    <label class="form-label flex items-center">
                                        <i class="fas fa-id-card mr-2 text-gray-500"></i>
                                        Medical Record Number
                                    </label>
                                    <div class="p-3 bg-gray-50 dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700">
                                        <div class="text-lg font-bold text-gray-900 dark:text-white">
                                            {{ $patient->medical_record_number }}
                                        </div>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                            Unique patient identifier
                                        </p>
                                    </div>
                                </div>

                                <!-- Date of Birth -->
                                <div>
                                    <label for="date_of_birth" class="form-label flex items-center">
                                        <i class="fas fa-birthday-cake mr-2 text-gray-500"></i>
                                        Date of Birth *
                                    </label>
                                    <input type="date" id="date_of_birth" name="date_of_birth"
                                           value="{{ old('date_of_birth', $patient->date_of_birth->format('Y-m-d')) }}" required
                                           max="{{ date('Y-m-d') }}"
                                           class="form-input @error('date_of_birth') border-red-500 @enderror">
                                    <div class="mt-2 text-sm">
                                        <span class="text-gray-500">Age: </span>
                                        <span class="font-medium text-green-600 dark:text-green-400">
                                            {{ $patient->age }} years
                                        </span>
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
                                        <option value="male" {{ old('gender', $patient->gender) == 'male' ? 'selected' : '' }}>
                                            <i class="fas fa-mars mr-2"></i>Male
                                        </option>
                                        <option value="female" {{ old('gender', $patient->gender) == 'female' ? 'selected' : '' }}>
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
                                    <input type="text" id="phone" name="phone"
                                           value="{{ old('phone', $patient->phone) }}" required
                                           class="form-input @error('phone') border-red-500 @enderror">
                                    @error('phone')
                                        <p class="mt-2 text-sm text-red-600 dark:text-red-400 flex items-center">
                                            <i class="fas fa-exclamation-circle mr-2"></i>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <!-- Email -->
                                <div>
                                    <label for="email" class="form-label flex items-center">
                                        <i class="fas fa-envelope mr-2 text-gray-500"></i>
                                        Email
                                    </label>
                                    <input type="email" id="email" name="email"
                                           value="{{ old('email', $patient->email) }}"
                                           class="form-input @error('email') border-red-500 @enderror">
                                    @error('email')
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
                                          class="form-input @error('address') border-red-500 @enderror">{{ old('address', $patient->address) }}</textarea>
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
                                <!-- Blood Type -->
                                <div>
                                    <label for="blood_type" class="form-label flex items-center">
                                        <i class="fas fa-tint mr-2 text-gray-500"></i>
                                        Blood Type
                                    </label>
                                    <select id="blood_type" name="blood_type" class="form-input">
                                        <option value="">Select Blood Type</option>
                                        <option value="A+" {{ old('blood_type', $patient->blood_type) == 'A+' ? 'selected' : '' }}>A+</option>
                                        <option value="A-" {{ old('blood_type', $patient->blood_type) == 'A-' ? 'selected' : '' }}>A-</option>
                                        <option value="B+" {{ old('blood_type', $patient->blood_type) == 'B+' ? 'selected' : '' }}>B+</option>
                                        <option value="B-" {{ old('blood_type', $patient->blood_type) == 'B-' ? 'selected' : '' }}>B-</option>
                                        <option value="AB+" {{ old('blood_type', $patient->blood_type) == 'AB+' ? 'selected' : '' }}>AB+</option>
                                        <option value="AB-" {{ old('blood_type', $patient->blood_type) == 'AB-' ? 'selected' : '' }}>AB-</option>
                                        <option value="O+" {{ old('blood_type', $patient->blood_type) == 'O+' ? 'selected' : '' }}>O+</option>
                                        <option value="O-" {{ old('blood_type', $patient->blood_type) == 'O-' ? 'selected' : '' }}>O-</option>
                                    </select>
                                </div>

                                <!-- Allergies -->
                                <div>
                                    <label for="allergies" class="form-label flex items-center">
                                        <i class="fas fa-allergies mr-2 text-gray-500"></i>
                                        Known Allergies
                                    </label>
                                    <input type="text" id="allergies" name="allergies"
                                           value="{{ old('allergies', $patient->allergies) }}"
                                           placeholder="e.g., Penicillin, Peanuts"
                                           class="form-input">
                                </div>

                                <!-- Chronic Conditions -->
                                <div class="md:col-span-2">
                                    <label for="chronic_conditions" class="form-label flex items-center">
                                        <i class="fas fa-stethoscope mr-2 text-gray-500"></i>
                                        Chronic Conditions
                                    </label>
                                    <textarea id="chronic_conditions" name="chronic_conditions" rows="2"
                                              placeholder="e.g., Diabetes, Hypertension"
                                              class="form-input">{{ old('chronic_conditions', $patient->chronic_conditions) }}</textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Emergency Contact -->
                        <div class="border border-gray-200 dark:border-gray-700 rounded-xl p-6">
                            <div class="flex items-center mb-6">
                                <div class="w-10 h-10 bg-yellow-100 dark:bg-yellow-900/30 rounded-lg flex items-center justify-center mr-3">
                                    <i class="fas fa-phone-alt text-yellow-600 dark:text-yellow-400"></i>
                                </div>
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Emergency Contact</h3>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="emergency_contact_name" class="form-label flex items-center">
                                        <i class="fas fa-user-friends mr-2 text-gray-500"></i>
                                        Contact Name
                                    </label>
                                    <input type="text" id="emergency_contact_name" name="emergency_contact_name"
                                           value="{{ old('emergency_contact_name', $patient->emergency_contact_name) }}"
                                           class="form-input">
                                </div>

                                <div>
                                    <label for="emergency_contact_phone" class="form-label flex items-center">
                                        <i class="fas fa-phone mr-2 text-gray-500"></i>
                                        Contact Phone
                                    </label>
                                    <input type="text" id="emergency_contact_phone" name="emergency_contact_phone"
                                           value="{{ old('emergency_contact_phone', $patient->emergency_contact_phone) }}"
                                           class="form-input">
                                </div>

                                <div class="md:col-span-2">
                                    <label for="emergency_contact_relation" class="form-label flex items-center">
                                        <i class="fas fa-handshake mr-2 text-gray-500"></i>
                                        Relationship
                                    </label>
                                    <input type="text" id="emergency_contact_relation" name="emergency_contact_relation"
                                           value="{{ old('emergency_contact_relation', $patient->emergency_contact_relation) }}"
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
                                    Notes
                                </label>
                                <textarea id="notes" name="notes" rows="4"
                                          class="form-input">{{ old('notes', $patient->notes) }}</textarea>
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div class="flex justify-end space-x-4 pt-6 border-t border-gray-200 dark:border-gray-700">
                            <a href="{{ route('doctor.patients.show', $patient->id) }}" class="btn btn-secondary px-8">
                                Cancel
                            </a>
                            <button type="submit" class="btn btn-primary px-8">
                                <i class="fas fa-save mr-2"></i>
                                Update Patient
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
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

        document.addEventListener('DOMContentLoaded', function() {
            const phoneInput = document.getElementById('phone');
            phoneInput.addEventListener('blur', function() {
                validatePhone(this);
            });
        });
    </script>
    @endpush
</x-app-layout>
