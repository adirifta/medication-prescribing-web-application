<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Edit Patient') }}
            </h2>
            <div class="text-sm text-gray-500">
                <a href="{{ route('doctor.patients.show', $patient->id) }}" class="text-blue-600 hover:text-blue-800">
                    ← Back to Patient
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{ route('doctor.patients.update', $patient->id) }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <!-- Patient Information -->
                        <div class="bg-blue-50 p-4 rounded-lg">
                            <h3 class="text-lg font-semibold text-blue-800 mb-4">Patient Information</h3>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <!-- Name -->
                                <div>
                                    <label for="name" class="block text-sm font-medium text-gray-700">Full Name *</label>
                                    <input type="text" id="name" name="name" value="{{ old('name', $patient->name) }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    @error('name')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Medical Record Number (readonly) -->
                                <div>
                                    <label for="medical_record_number" class="block text-sm font-medium text-gray-700">MRN</label>
                                    <input type="text" id="medical_record_number" value="{{ $patient->medical_record_number }}" readonly class="mt-1 block w-full rounded-md border-gray-300 bg-gray-50 shadow-sm">
                                </div>

                                <!-- Date of Birth -->
                                <div>
                                    <label for="date_of_birth" class="block text-sm font-medium text-gray-700">Date of Birth *</label>
                                    <input type="date" id="date_of_birth" name="date_of_birth" value="{{ old('date_of_birth', $patient->date_of_birth->format('Y-m-d')) }}" required max="{{ date('Y-m-d') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    <div id="age-display" class="mt-1 text-sm text-gray-500">
                                        {{ $patient->age }} years old
                                    </div>
                                    @error('date_of_birth')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Gender -->
                                <div>
                                    <label for="gender" class="block text-sm font-medium text-gray-700">Gender *</label>
                                    <select id="gender" name="gender" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                        <option value="male" {{ old('gender', $patient->gender) == 'male' ? 'selected' : '' }}>Male</option>
                                        <option value="female" {{ old('gender', $patient->gender) == 'female' ? 'selected' : '' }}>Female</option>
                                    </select>
                                    @error('gender')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Phone -->
                                <div>
                                    <label for="phone" class="block text-sm font-medium text-gray-700">Phone Number *</label>
                                    <input type="text" id="phone" name="phone" value="{{ old('phone', $patient->phone) }}" required placeholder="08xxxxxxxxxx" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    @error('phone')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Email (optional) -->
                                <div>
                                    <label for="email" class="block text-sm font-medium text-gray-700">Email (Optional)</label>
                                    <input type="email" id="email" name="email" value="{{ old('email', $patient->email) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    @error('email')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Address -->
                            <div class="mt-4">
                                <label for="address" class="block text-sm font-medium text-gray-700">Address</label>
                                <textarea id="address" name="address" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('address', $patient->address) }}</textarea>
                                @error('address')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Medical Information -->
                        <div class="bg-green-50 p-4 rounded-lg">
                            <h3 class="text-lg font-semibold text-green-800 mb-4">Medical Information</h3>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <!-- Blood Type -->
                                <div>
                                    <label for="blood_type" class="block text-sm font-medium text-gray-700">Blood Type</label>
                                    <select id="blood_type" name="blood_type" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                                        <option value="">Unknown</option>
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
                                    <label for="allergies" class="block text-sm font-medium text-gray-700">Known Allergies</label>
                                    <input type="text" id="allergies" name="allergies" value="{{ old('allergies', $patient->allergies) }}" placeholder="e.g., Penicillin, Peanuts" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                                </div>

                                <!-- Chronic Conditions -->
                                <div class="md:col-span-2">
                                    <label for="chronic_conditions" class="block text-sm font-medium text-gray-700">Chronic Conditions</label>
                                    <textarea id="chronic_conditions" name="chronic_conditions" rows="2" placeholder="e.g., Diabetes, Hypertension" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">{{ old('chronic_conditions', $patient->chronic_conditions) }}</textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Emergency Contact -->
                        <div class="bg-yellow-50 p-4 rounded-lg">
                            <h3 class="text-lg font-semibold text-yellow-800 mb-4">Emergency Contact</h3>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="emergency_contact_name" class="block text-sm font-medium text-gray-700">Contact Name</label>
                                    <input type="text" id="emergency_contact_name" name="emergency_contact_name" value="{{ old('emergency_contact_name', $patient->emergency_contact_name) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-yellow-500 focus:ring-yellow-500">
                                </div>

                                <div>
                                    <label for="emergency_contact_phone" class="block text-sm font-medium text-gray-700">Contact Phone</label>
                                    <input type="text" id="emergency_contact_phone" name="emergency_contact_phone" value="{{ old('emergency_contact_phone', $patient->emergency_contact_phone) }}" placeholder="08xxxxxxxxxx" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-yellow-500 focus:ring-yellow-500">
                                </div>

                                <div class="md:col-span-2">
                                    <label for="emergency_contact_relation" class="block text-sm font-medium text-gray-700">Relationship</label>
                                    <input type="text" id="emergency_contact_relation" name="emergency_contact_relation" value="{{ old('emergency_contact_relation', $patient->emergency_contact_relation) }}" placeholder="e.g., Spouse, Parent, Child" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-yellow-500 focus:ring-yellow-500">
                                </div>
                            </div>
                        </div>

                        <!-- Additional Information -->
                        <div>
                            <label for="notes" class="block text-sm font-medium text-gray-700">Additional Notes</label>
                            <textarea id="notes" name="notes" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('notes', $patient->notes) }}</textarea>
                        </div>

                        <div class="flex justify-end space-x-3 pt-6">
                            <a href="{{ route('doctor.patients.show', $patient->id) }}" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                                Cancel
                            </a>
                            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
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
        // Calculate age from date of birth
        document.getElementById('date_of_birth').addEventListener('change', function() {
            const dob = new Date(this.value);
            const today = new Date();
            let age = today.getFullYear() - dob.getFullYear();
            const monthDiff = today.getMonth() - dob.getMonth();

            if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < dob.getDate())) {
                age--;
            }

            const ageDisplay = document.getElementById('age-display');
            ageDisplay.textContent = age > 0 ? `${age} years old` : 'Invalid date';
            ageDisplay.className = age > 0 ? 'mt-1 text-sm text-green-600' : 'mt-1 text-sm text-red-600';
        });

        // Validate phone number format
        document.getElementById('phone').addEventListener('blur', function() {
            const phone = this.value;
            const phoneRegex = /^08[0-9]{9,11}$/;

            if (phone && !phoneRegex.test(phone)) {
                this.classList.add('border-red-500');
                if (!this.nextElementSibling?.classList.contains('text-red-600')) {
                    const errorDiv = document.createElement('p');
                    errorDiv.className = 'mt-1 text-sm text-red-600';
                    errorDiv.textContent = 'Phone number must start with 08 and be 11-13 digits';
                    this.parentNode.appendChild(errorDiv);
                }
            } else {
                this.classList.remove('border-red-500');
                const errorDiv = this.parentNode.querySelector('.text-red-600');
                if (errorDiv) {
                    errorDiv.remove();
                }
            }
        });
    </script>
    @endpush
</x-app-layout>
