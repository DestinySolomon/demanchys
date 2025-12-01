<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Become a Delivery Partner - Demanchys Lounge</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
</head>
<body>
    <div class="container py-5">
        <div class="card">
            <div class="card-body">
                <h2 class="fw-bold mb-3">Become a Delivery Partner</h2>
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                <form action="{{ route('delivery.apply.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Full Name *</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email *</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Phone *</label>
                        <input type="tel" name="phone" class="form-control" value="{{ old('phone') }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Vehicle Type *</label>
                        <select name="vehicle_type" class="form-select" required>
                            <option value="motorcycle">Motorcycle</option>
                            <option value="car">Car</option>
                            <option value="bicycle">Bicycle</option>
                        </select>
                    </div>
                    <div class="mb-3 text-end">
                        <button class="btn btn-warning" type="submit">Submit Application</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Become a Delivery Partner - Demanchys Lounge</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        body {
            background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .application-container {
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
            margin: 2rem auto;
            max-width: 1000px;
        }
        .application-header {
            background: linear-gradient(135deg, #ffc107 0%, #ffb300 100%);
            border-radius: 15px 15px 0 0;
            padding: 2rem;
            text-align: center;
        }
        .form-section {
            border-bottom: 1px solid #e9ecef;
            padding: 2rem;
        }
        .form-section:last-child {
            border-bottom: none;
        }
        .section-title {
            color: #ffc107;
            border-bottom: 2px solid #ffc107;
            padding-bottom: 0.5rem;
            margin-bottom: 1.5rem;
        }
        .btn-apply {
            background: linear-gradient(135deg, #ffc107 0%, #ffb300 100%);
            border: none;
            color: #000;
            font-weight: 600;
            padding: 0.75rem 2rem;
        }
        .btn-apply:hover {
            background: linear-gradient(135deg, #ffb300 0%, #ff8f00 100%);
            color: #000;
        }
    </style>
</head>
<body>
    <div class="container py-5">
        <div class="application-container">
            <!-- Header -->
            <div class="application-header">
                <h1 class="text-dark fw-bold mb-2">Become a Delivery Partner</h1>
                <p class="text-dark mb-0">Join Demanchys Lounge and earn great money delivering amazing food!</p>
            </div>

            <!-- Success Message -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show m-3" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <!-- Error Message -->
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show m-3" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <form action="{{ route('delivery.apply.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Personal Information -->
                <div class="form-section">
                    <h3 class="section-title"><i class="bi bi-person me-2"></i>Personal Information</h3>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="name" class="form-label">Full Name *</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   id="name" name="name" value="{{ old('name') }}" required>
                            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label">Email Address *</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                   id="email" name="email" value="{{ old('email') }}" required>
                            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="phone" class="form-label">Phone Number *</label>
                            <input type="tel" class="form-control @error('phone') is-invalid @enderror" 
                                   id="phone" name="phone" value="{{ old('phone') }}" required>
                            @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="gender" class="form-label">Gender *</label>
                            <select class="form-select @error('gender') is-invalid @enderror" id="gender" name="gender" required>
                                <option value="">Select</option>
                                <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                                <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                                <option value="other" {{ old('gender') == 'other' ? 'selected' : '' }}>Other</option>
                            </select>
                            @error('gender') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="date_of_birth" class="form-label">Date of Birth *</label>
                            <input type="date" class="form-control @error('date_of_birth') is-invalid @enderror" 
                                   id="date_of_birth" name="date_of_birth" value="{{ old('date_of_birth') }}" required>
                            @error('date_of_birth') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            <div class="form-text">Must be 18 years or older</div>
                        </div>
                    </div>
                </div>

                <!-- Address Information -->
                <div class="form-section">
                    <h3 class="section-title"><i class="bi bi-geo-alt me-2"></i>Address Information</h3>
                    <div class="row">
                        <div class="col-12 mb-3">
                            <label for="address" class="form-label">Street Address *</label>
                            <input type="text" class="form-control @error('address') is-invalid @enderror" 
                                   id="address" name="address" value="{{ old('address') }}" required>
                            @error('address') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="city" class="form-label">City *</label>
                            <input type="text" class="form-control @error('city') is-invalid @enderror" 
                                   id="city" name="city" value="{{ old('city') }}" required>
                            @error('city') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="state" class="form-label">State *</label>
                            <input type="text" class="form-control @error('state') is-invalid @enderror" 
                                   id="state" name="state" value="{{ old('state') }}" required>
                            @error('state') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="zip_code" class="form-label">ZIP Code *</label>
                            <input type="text" class="form-control @error('zip_code') is-invalid @enderror" 
                                   id="zip_code" name="zip_code" value="{{ old('zip_code') }}" required>
                            @error('zip_code') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                </div>

                <!-- Vehicle Information -->
                <div class="form-section">
                    <h3 class="section-title"><i class="bi bi-truck me-2"></i>Vehicle Information</h3>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="vehicle_type" class="form-label">Vehicle Type *</label>
                            <select class="form-select @error('vehicle_type') is-invalid @enderror" id="vehicle_type" name="vehicle_type" required>
                                <option value="">Select Vehicle Type</option>
                                <option value="motorcycle" {{ old('vehicle_type') == 'motorcycle' ? 'selected' : '' }}>Motorcycle</option>
                                <option value="car" {{ old('vehicle_type') == 'car' ? 'selected' : '' }}>Car</option>
                                <option value="bicycle" {{ old('vehicle_type') == 'bicycle' ? 'selected' : '' }}>Bicycle</option>
                                <option value="scooter" {{ old('vehicle_type') == 'scooter' ? 'selected' : '' }}>Scooter</option>
                                <option value="other" {{ old('vehicle_type') == 'other' ? 'selected' : '' }}>Other</option>
                            </select>
                            @error('vehicle_type') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="vehicle_plate" class="form-label">License Plate Number *</label>
                            <input type="text" class="form-control @error('vehicle_plate') is-invalid @enderror" 
                                   id="vehicle_plate" name="vehicle_plate" value="{{ old('vehicle_plate') }}" required>
                            @error('vehicle_plate') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="vehicle_make" class="form-label">Vehicle Make *</label>
                            <input type="text" class="form-control @error('vehicle_make') is-invalid @enderror" 
                                   id="vehicle_make" name="vehicle_make" value="{{ old('vehicle_make') }}" required>
                            @error('vehicle_make') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="vehicle_model" class="form-label">Vehicle Model *</label>
                            <input type="text" class="form-control @error('vehicle_model') is-invalid @enderror" 
                                   id="vehicle_model" name="vehicle_model" value="{{ old('vehicle_model') }}" required>
                            @error('vehicle_model') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="vehicle_year" class="form-label">Vehicle Year *</label>
                            <input type="number" class="form-control @error('vehicle_year') is-invalid @enderror" 
                                   id="vehicle_year" name="vehicle_year" value="{{ old('vehicle_year') }}" 
                                   min="1990" max="{{ date('Y') }}" required>
                            @error('vehicle_year') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="vehicle_color" class="form-label">Vehicle Color *</label>
                            <input type="text" class="form-control @error('vehicle_color') is-invalid @enderror" 
                                   id="vehicle_color" name="vehicle_color" value="{{ old('vehicle_color') }}" required>
                            @error('vehicle_color') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                </div>

                <!-- Document Uploads -->
                <div class="form-section">
                    <h3 class="section-title"><i class="bi bi-file-earmark me-2"></i>Required Documents</h3>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="drivers_license" class="form-label">Driver's License *</label>
                            <input type="file" class="form-control @error('drivers_license') is-invalid @enderror" 
                                   id="drivers_license" name="drivers_license" accept=".jpg,.jpeg,.png,.pdf" required>
                            @error('drivers_license') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            <div class="form-text">JPG, PNG, or PDF (Max: 2MB)</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="vehicle_insurance" class="form-label">Vehicle Insurance *</label>
                            <input type="file" class="form-control @error('vehicle_insurance') is-invalid @enderror" 
                                   id="vehicle_insurance" name="vehicle_insurance" accept=".jpg,.jpeg,.png,.pdf" required>
                            @error('vehicle_insurance') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            <div class="form-text">JPG, PNG, or PDF (Max: 2MB)</div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="vehicle_registration" class="form-label">Vehicle Registration *</label>
                            <input type="file" class="form-control @error('vehicle_registration') is-invalid @enderror" 
                                   id="vehicle_registration" name="vehicle_registration" accept=".jpg,.jpeg,.png,.pdf" required>
                            @error('vehicle_registration') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            <div class="form-text">JPG, PNG, or PDF (Max: 2MB)</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="id_document" class="form-label">ID Document *</label>
                            <input type="file" class="form-control @error('id_document') is-invalid @enderror" 
                                   id="id_document" name="id_document" accept=".jpg,.jpeg,.png,.pdf" required>
                            @error('id_document') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            <div class="form-text">Passport, National ID, or Driver's License (Max: 2MB)</div>
                        </div>
                    </div>
                </div>

                <!-- Delivery Preferences -->
                <div class="form-section">
                    <h3 class="section-title"><i class="bi bi-clock me-2"></i>Delivery Preferences</h3>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Preferred Delivery Areas *</label>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="preferred_areas[]" value="Downtown" id="area_downtown">
                                <label class="form-check-label" for="area_downtown">Downtown</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="preferred_areas[]" value="Business District" id="area_business">
                                <label class="form-check-label" for="area_business">Business District</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="preferred_areas[]" value="Residential Areas" id="area_residential">
                                <label class="form-check-label" for="area_residential">Residential Areas</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="preferred_areas[]" value="Suburbs" id="area_suburbs">
                                <label class="form-check-label" for="area_suburbs">Suburbs</label>
                            </div>
                            @error('preferred_areas') <div class="text-danger small">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="availability" class="form-label">Availability *</label>
                            <select class="form-select @error('availability') is-invalid @enderror" id="availability" name="availability" required>
                                <option value="">Select Availability</option>
                                <option value="full_time" {{ old('availability') == 'full_time' ? 'selected' : '' }}>Full Time</option>
                                <option value="part_time" {{ old('availability') == 'part_time' ? 'selected' : '' }}>Part Time</option>
                                <option value="flexible" {{ old('availability') == 'flexible' ? 'selected' : '' }}>Flexible</option>
                            </select>
                            @error('availability') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 mb-3">
                            <label for="work_hours" class="form-label">Preferred Working Hours *</label>
                            <input type="text" class="form-control @error('work_hours') is-invalid @enderror" 
                                   id="work_hours" name="work_hours" value="{{ old('work_hours') }}" 
                                   placeholder="e.g., 9 AM - 5 PM, Evenings only, Weekends" required>
                            @error('work_hours') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                </div>

               <!-- Bank Information -->
<div class="form-section">
    <h3 class="section-title"><i class="bi bi-bank me-2"></i>Bank Information (For Payments)</h3>
    <div class="row">
        <div class="col-md-6 mb-3">
            <label for="bank_name" class="form-label">Bank Name *</label>
            <select class="form-select @error('bank_name') is-invalid @enderror" id="bank_name" name="bank_name" required>
                <option value="">Select Your Bank</option>
                <option value="access_bank" {{ old('bank_name') == 'access_bank' ? 'selected' : '' }}>Access Bank</option>
                <option value="fidelity_bank" {{ old('bank_name') == 'fidelity_bank' ? 'selected' : '' }}>Fidelity Bank</option>
                <option value="first_bank" {{ old('bank_name') == 'first_bank' ? 'selected' : '' }}>First Bank</option>
                <option value="gtb" {{ old('bank_name') == 'gtb' ? 'selected' : '' }}>Guaranty Trust Bank (GTB)</option>
                <option value="uba" {{ old('bank_name') == 'uba' ? 'selected' : '' }}>United Bank for Africa (UBA)</option>
                <option value="union_bank" {{ old('bank_name') == 'union_bank' ? 'selected' : '' }}>Union Bank</option>
                <option value="zenith_bank" {{ old('bank_name') == 'zenith_bank' ? 'selected' : '' }}>Zenith Bank</option>
                <option value="ecobank" {{ old('bank_name') == 'ecobank' ? 'selected' : '' }}>Ecobank</option>
                <option value="polaris_bank" {{ old('bank_name') == 'polaris_bank' ? 'selected' : '' }}>Polaris Bank</option>
                <option value="stanbic_ibtc" {{ old('bank_name') == 'stanbic_ibtc' ? 'selected' : '' }}>Stanbic IBTC Bank</option>
                <option value="sterling_bank" {{ old('bank_name') == 'sterling_bank' ? 'selected' : '' }}>Sterling Bank</option>
                <option value="wema_bank" {{ old('bank_name') == 'wema_bank' ? 'selected' : '' }}>Wema Bank</option>
                <option value="other" {{ old('bank_name') == 'other' ? 'selected' : '' }}>Other Bank</option>
            </select>
            @error('bank_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
        <div class="col-md-6 mb-3">
            <label for="account_holder_name" class="form-label">Account Holder Name *</label>
            <input type="text" class="form-control @error('account_holder_name') is-invalid @enderror" 
                   id="account_holder_name" name="account_holder_name" value="{{ old('account_holder_name') }}" required>
            @error('account_holder_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
            <div class="form-text">Must match exactly with your bank account name</div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 mb-3">
            <label for="account_number" class="form-label">Account Number *</label>
            <input type="text" class="form-control @error('account_number') is-invalid @enderror" 
                   id="account_number" name="account_number" value="{{ old('account_number') }}" 
                   pattern="[0-9]{10}" title="10-digit account number" required>
            @error('account_number') <div class="invalid-feedback">{{ $message }}</div> @enderror
            <div class="form-text">10-digit account number</div>
        </div>
        <div class="col-md-6 mb-3">
            <label for="account_type" class="form-label">Account Type *</label>
            <select class="form-select @error('account_type') is-invalid @enderror" id="account_type" name="account_type" required>
                <option value="">Select Account Type</option>
                <option value="savings" {{ old('account_type') == 'savings' ? 'selected' : '' }}>Savings Account</option>
                <option value="current" {{ old('account_type') == 'current' ? 'selected' : '' }}>Current Account</option>
                <option value="domiciliary" {{ old('account_type') == 'domiciliary' ? 'selected' : '' }}>Domiciliary Account</option>
            </select>
            @error('account_type') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
    </div>
    <div class="alert alert-info">
        <i class="bi bi-info-circle me-2"></i>
        <strong>Important:</strong> Payments will be made weekly to the bank account provided above. 
        Please ensure all information is accurate to avoid payment delays.
    </div>
</div>

                <!-- Terms and Submit -->
                <div class="form-section">
                    <div class="form-check mb-4">
                        <input class="form-check-input @error('terms_agreed') is-invalid @enderror" 
                               type="checkbox" id="terms_agreed" name="terms_agreed" required>
                        <label class="form-check-label" for="terms_agreed">
                            I agree to the <a href="#" class="text-warning">Terms and Conditions</a> and 
                            <a href="#" class="text-warning">Privacy Policy</a> *
                        </label>
                        @error('terms_agreed') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="text-center">
                        <button type="submit" class="btn btn-apply btn-lg">
                            <i class="bi bi-send me-2"></i>Submit Application
                        </button>
                    </div>

                    <div class="text-center mt-3">
                        <p class="text-muted small">
                            <i class="bi bi-info-circle me-1"></i>
                            We will review your application and get back to you within 2-3 business days.
                        </p>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>