<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Create New Patient') }}
            </h2>
            <div class="text-sm text-gray-500">
                <a href="{{ route('doctor.patients.index') }}" class="text-blue-600 hover:text-blue-800">
                    ← Back to Patients
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{ route('doctor.patients.store') }}" method="POST" class="space-y-6">
                        @csrf

                        <!-- Personal Information -->
                        <div class="bg-blue-50 p-4 rounded-lg">
                            <h3 class="text-lg font-semibold text-blue-800 mb-4">Personal Information</h3>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <!-- Name -->
                                <div>
                                    <label for="name" class="block text-sm font-medium text-gray-700">Full Name *</label>
                                    <input type="text" id="name" name="name" value="{{ old('name') }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    @error('name')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Date of Birth -->
                                <div>
                                    <label for="date_of_birth" class="block text-sm font-medium text-gray-700">Date of Birth *</label>
                                    <input type="date" id="date_of_birth" name="date_of_birth" value="{{ old('date_of_birth') }}" required max="{{ date('Y-m-d') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    <div id="age-display" class="mt-1 text-sm text-gray-500"></div>
                                    @error('date_of_birth')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Gender -->
                                <div>
                                    <label for="gender" class="block text-sm font-medium text-gray-700">Gender *</label>
                                    <select id="gender" name="gender" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                        <option value="">Select Gender</option>
                                        <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                                        <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                                    </select>
                                    @error('gender')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Phone -->
                                <div>
                                    <label for="phone" class="block text-sm font-medium text-gray-700">Phone Number *</label>
                                    <input type="text" id="phone" name="phone" value="{{ old('phone') }}" required placeholder="08xxxxxxxxxx" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    @error('phone')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Address -->
                            <div class="mt-4">
                                <label for="address" class="block text-sm font-medium text-gray-700">Address</label>
                                <textarea id="address" name="address" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('address') }}</textarea>
                                @error('address')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Medical Information -->
                        <div class="bg-green-50 p-4 rounded-lg">
                            <h3 class="text-lg font-semibold text-green-800 mb-4">Medical Information</h3>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <!-- Medical Record Number (auto-generated) -->
                                <div class="bg-white p-3 rounded border">
                                    <label class="block text-sm font-medium text-gray-700">Medical Record Number</label>
                                    <div class="mt-1">
                                        <div class="text-lg font-semibold text-gray-900" id="mrn-preview">
                                            Generating...
                                        </div>
                                        <p class="text-xs text-gray-500">This will be automatically generated</p>
                                    </div>
                                </div>

                                <!-- Allergies -->
                                <div>
                                    <label for="allergies" class="block text-sm font-medium text-gray-700">Known Allergies</label>
                                    <input type="text" id="allergies" name="allergies" value="{{ old('allergies') }}" placeholder="e.g., Penicillin, Peanuts" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                                </div>

                                <!-- Chronic Conditions -->
                                <div class="md:col-span-2">
                                    <label for="chronic_conditions" class="block text-sm font-medium text-gray-700">Chronic Conditions</label>
                                    <textarea id="chronic_conditions" name="chronic_conditions" rows="2" placeholder="e.g., Diabetes, Hypertension" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">{{ old('chronic_conditions') }}</textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Emergency Contact -->
                        <div class="bg-yellow-50 p-4 rounded-lg">
                            <h3 class="text-lg font-semibold text-yellow-800 mb-4">Emergency Contact (Optional)</h3>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="emergency_contact_name" class="block text-sm font-medium text-gray-700">Contact Name</label>
                                    <input type="text" id="emergency_contact_name" name="emergency_contact_name" value="{{ old('emergency_contact_name') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-yellow-500 focus:ring-yellow-500">
                                </div>

                                <div>
                                    <label for="emergency_contact_phone" class="block text-sm font-medium text-gray-700">Contact Phone</label>
                                    <input type="text" id="emergency_contact_phone" name="emergency_contact_phone" value="{{ old('emergency_contact_phone') }}" placeholder="08xxxxxxxxxx" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-yellow-500 focus:ring-yellow-500">
                                </div>

                                <div class="md:col-span-2">
                                    <label for="emergency_contact_relation" class="block text-sm font-medium text-gray-700">Relationship</label>
                                    <input type="text" id="emergency_contact_relation" name="emergency_contact_relation" value="{{ old('emergency_contact_relation') }}" placeholder="e.g., Spouse, Parent, Child" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-yellow-500 focus:ring-yellow-500">
                                </div>
                            </div>
                        </div>

                        <!-- Notes -->
                        <div>
                            <label for="notes" class="block text-sm font-medium text-gray-700">Additional Notes</label>
                            <textarea id="notes" name="notes" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('notes') }}</textarea>
                        </div>

                        <div class="flex justify-end space-x-3 pt-6">
                            <a href="{{ route('doctor.patients.index') }}" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                                Cancel
                            </a>
                            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
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

        // Generate MRN preview
        function generateMRNPreview() {
            const year = new Date().getFullYear();
            // In real implementation, you'd fetch the next sequence from server
            const mrnPreview = `MRN-${year}-XXXX`;
            document.getElementById('mrn-preview').textContent = mrnPreview;
        }

        // Validate phone number format
        document.getElementById('phone').addEventListener('blur', function() {
            const phone = this.value;
            const phoneRegex = /^08[0-9]{9,11}$/;

            if (phone && !phoneRegex.test(phone)) {
                this.classList.add('border-red-500');
                // Show error message
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

        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
            generateMRNPreview();

            // If there's an old value for date of birth, calculate age
            const dobInput = document.getElementById('date_of_birth');
            if (dobInput.value) {
                dobInput.dispatchEvent(new Event('change'));
            }
        });
    </script>
    @endpush
</x-app-layout>
