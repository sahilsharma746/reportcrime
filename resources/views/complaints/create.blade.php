@extends('layouts.app')
@section('title', 'Report a Crime')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <h1 class="mb-4">Report a Crime</h1>
            <form action="{{ route('complaints.store') }}" method="POST" enctype="multipart/form-data"
                id="complaintForm">
                @csrf
                    <input type="hidden" name="anonymous" value="1">
                @guest
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title">Anonymity</h5>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="anonymousCheckbox" name="anonymous"
                                value="0" checked>
                            <label class="form-check-label" for="anonymousCheckbox">File Anonymously</label>
                        </div>
                    </div>
                </div>

                <div id="userInfoFields" style="display: none;">
                    <div class="card mb-4">
                        <div class="card-body">
                            <h5 class="card-title">Personal Information</h5>
                            <div class="mb-3">
                                <label for="first_name" class="form-label">First Name</label>
                                <input type="text" class="form-control @error('first_name') is-invalid @enderror" id="first_name" name="first_name" value="{{ old('first_name') }}">
                                @error('first_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="last_name" class="form-label">Last Name</label>
                                <input type="text" class="form-control @error('last_name') is-invalid @enderror" id="last_name" name="last_name" value="{{ old('last_name') }}">
                                @error('last_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="phone" class="form-label">Phone Number</label>
                                <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone') }}">
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email Address</label>
                                <input type="text" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="text" class="form-control @error('password') is-invalid @enderror" id="password" name="password" value="{{ old('password') }}">
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div id="addressFields" style="display: none;">
                    <div class="card mb-4">
                        <div class="card-body">
                            <h5 class="card-title">Address Information</h5>
                            <div class="mb-3">
                                <label for="address" class="form-label">Address</label>
                                <input type="text" class="form-control @error('address') is-invalid @enderror" id="address" name="address" value="{{ old('address') }}">
                                @error('address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="city" class="form-label">City</label>
                                <input type="text" class="form-control @error('person_city') is-invalid @enderror" id="person_city" name="person_city" value="{{ old('person_city') }}">
                                @error('person_city')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="state" class="form-label">State</label>
                                <input type="text" class="form-control @error('person_state') is-invalid @enderror" id="person_state" name="person_state" value="{{ old('person_state') }}">
                                @error('person_state')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="zip" class="form-label">Zip Code</label>
                                <input type="text" class="form-control @error('zip') is-invalid @enderror" id="zip" name="zip" value="{{ old('zip') }}">
                                @error('zip')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                @endguest
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title">Report Details</h5>
                        <div class="mb-3">
                            <label for="complaint_type" class="form-label">Type of Crime</label>
                            <select class="form-select @error('complaint_type') is-invalid @enderror" id="complaint_type" name="complaint_type" required>
                                <option selected disabled>Select a category</option>
                                <option value="Robbery">Robbery</option>
                                <option value="Theft">Theft</option>
                                <option value="Burglary">Burglary</option>
                                <option value="Murder">Murder</option>
                                <option value="Other">Other</option>
                            </select>
                            @error('complaint_type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3" id="custom_type_div" style="display: none;">
                            <label for="custom_type" class="form-label">if other, please specify</label>
                            <input type="text" class="form-control @error('custom_type') is-invalid @enderror" id="custom_type" name="custom_type" value="{{ old('custom_type') }}">
                            @error('custom_type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="5"
                                required></textarea>
                            @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="incident_date" class="form-label">Incident Date and Time</label>
                            <div style="max-width: 250px; display: inline-block;">
                                <input type="datetime-local" class="form-control @error('incident_date') is-invalid @enderror" id="incident_date" required name="incident_date" value="{{ old('incident_date') }}">
                                @error('incident_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="state" class="form-label">State</label>
                            <select class="form-select @error('state') is-invalid @enderror" id="state" name="state" required>
                                <option selected disabled>Select a state</option>
                                @foreach($states as $state)
                                    <option value="{{ $state->id }}">{{ $state->name }}</option>
                                @endforeach
                            </select>
                            @error('state')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="city" class="form-label">City</label>
                            <input type="text" class="form-control @error('city') is-invalid @enderror" id="city" name="city" value="{{ old('city') }}">
                            @error('city')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <!-- <select class="form-select" id="city" name="city" disabled required>
                                    <option selected disabled>Select a city</option>
                                </select> -->
                        </div>

                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title">Accused Information</h5>
                        <p>If you know the details of the accused, please input it here</p>
                        <div class="mb-3">
                            <label for="officer_name" class="form-label">Accused Name</label>
                            <input type="text" class="form-control @error('officer_name') is-invalid @enderror" id="officer_name" name="officer_name" value="{{ old('officer_name') }}">
                            @error('officer_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <!-- <div class="mb-3">
                            <label for="officer_division" class="form-label">Accused Location</label>
                            <input type="text" class="form-control" id="officer_division" name="officer_division">
                        </div> -->
                        <div class="mb-3">
                            <label for="officer_division" class="form-label">Email</label>
                            <input type="text" class="form-control @error('officer_division') is-invalid @enderror" id="officer_division" name="officer_division" value="{{ old('officer_division') }}">
                            @error('officer_division')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="accused_phone_number" class="form-label">Phone Number</label>
                            <input type="text" class="form-control @error('accused_phone_number') is-invalid @enderror" id="accused_phone_number" name="accused_phone_number" value="{{ old('accused_phone_number') }}">
                            @error('accused_phone_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="accused_address" class="form-label">Address</label>
                            <input type="text" class="form-control @error('accused_address') is-invalid @enderror" id="accused_address" name="accused_address" value="{{ old('accused_address') }}">
                            @error('accused_address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="accused_city" class="form-label">City</label>
                            <input type="text" class="form-control @error('accused_city') is-invalid @enderror" id="accused_city" name="accused_city" value="{{ old('accused_city') }}">
                            @error('accused_city')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="accused_state" class="form-label">State</label>
                            <input type="text" class="form-control @error('accused_state') is-invalid @enderror" id="accused_state" name="accused_state" value="{{ old('accused_state') }}">
                            @error('accused_state')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="accused_zip" class="form-label">Zip Code</label>
                            <input type="text" class="form-control @error('accused_zip') is-invalid @enderror" id="accused_zip" name="accused_zip" value="{{ old('accused_zip') }}">
                            @error('accused_zip')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title">Attachments</h5>
                        <div class="mb-3">
                            <label for="attachments" class="form-label">Upload Files (Images, Videos,
                                Documents)</label>
                            <input type="file" class="form-control @error('attachments') is-invalid @enderror" id="attachments" name="attachments[]" multiple>
                            @error('attachments')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="text-center">
                    <button type="submit" class="btn btn-primary btn-lg">Submit Report</button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
.card {
    border-radius: 10px;
    background-color: #ffffff;
}

.form-check-input {
    width: 16px;
    height: 16px;
}
</style>

<script>
@guest
document.getElementById('anonymousCheckbox').addEventListener('change', function() {
    var userInfoFields = document.getElementById('userInfoFields');
    var addressFields = document.getElementById('addressFields');
    if (this.checked) {
        userInfoFields.style.display = 'none'; // Hide user info fields if anonymous
        addressFields.style.display = 'none'; // Hide address fields if anonymous
        // Clear the values of the user info and address fields
        document.getElementById('first_name').value = '';
        document.getElementById('last_name').value = '';
        document.getElementById('phone').value = '';
        document.getElementById('email').value = '';
        document.getElementById('password').value = '';
        document.getElementById('address').value = '';
        document.getElementById('city').value = '';
        document.getElementById('state').value = '';
        document.getElementById('zip').value = '';
    } else {
        userInfoFields.style.display = 'block'; // Show user info fields if not anonymous
        addressFields.style.display = 'block'; // Show address fields if not anonymous
        // The hidden input will ensure that anonymous is set to 0
    }
});

document.getElementById('complaintForm').addEventListener('submit', function(e) {
    console.log('Form action:', this.action); // Log the form action URL
    console.log('Anonymous value:', document.querySelector('input[name="anonymous"]')
    .value); // Log the anonymous value

    var anonymous = document.getElementById('anonymousCheckbox').checked;
   if (!anonymous) {
        var requiredFields = ['first_name', 'last_name', 'phone', 'email', 'password', 'address', 'city',
            'state', 'zip'
        ];
        for (var i = 0; i < requiredFields.length; i++) {
            var field = document.getElementById(requiredFields[i]);
            if (!field.value) {
                e.preventDefault(); // Prevent form submission only if validation fails
                alert('Please fill in all required fields.'); // Alert user
                return; // Exit the function
            }
        }
    }
    console.log('Form is valid, submitting...'); // Log for debugging
    // Form will submit normally if all validations pass
});
@endguest

document.addEventListener('DOMContentLoaded', function() {
    let statesData = @json($states);

    const stateSelect = document.getElementById('state');
    const citySelect = document.getElementById('city');

    stateSelect.addEventListener('change', function() {
        const stateId = this.value;
        citySelect.innerHTML = '<option selected disabled>Select a city</option>';
        citySelect.disabled = true;

        const selectedState = statesData.find(state => state.id == stateId);
        if (selectedState) {
            selectedState.cities.forEach(city => {
                const option = document.createElement('option');
                option.value = city.id;
                option.textContent = city.name;
                citySelect.appendChild(option);
            });
            citySelect.disabled = false;
        }
    });

    document.getElementById('complaint_type').addEventListener('change', function() {
        var customTypeDiv = document.getElementById('custom_type_div');
        if (this.value === 'Other') {
            customTypeDiv.style.display = 'block';
        } else {
            customTypeDiv.style.display = 'none';
            document.getElementById('custom_type').value = ''; // Clear the custom type input
        }
    });
});
</script>
@endsection

<!-- @if ($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif -->
