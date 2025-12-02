@extends('admin.layouts.app')

@section('title', 'Settings')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-white border-bottom">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">
                            <i class="bi bi-gear me-2"></i>
                            Settings
                        </h4>
                        <div>
                            <button class="btn btn-primary btn-sm" id="saveAllSettings">
                                <i class="bi bi-save me-1"></i> Save All Changes
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Settings Navigation Tabs -->
                    <div class="row mb-4">
                        <div class="col-md-3">
                            <div class="card">
                                <div class="card-body p-0">
                                    <div class="list-group list-group-flush" id="settingsTabs" role="tablist">
                                        <a class="list-group-item list-group-item-action active" data-bs-toggle="tab" href="#general-tab">
                                            <i class="bi bi-sliders me-2"></i> General Settings
                                        </a>
                                        <a class="list-group-item list-group-item-action" data-bs-toggle="tab" href="#logo-tab">
                                            <i class="bi bi-image me-2"></i> Logo & Favicon
                                        </a>
                                        <a class="list-group-item list-group-item-action" data-bs-toggle="tab" href="#recaptcha-tab">
                                            <i class="bi bi-shield-check me-2"></i> Google reCAPTCHA
                                        </a>
                                        <a class="list-group-item list-group-item-action" data-bs-toggle="tab" href="#whatsapp-tab">
                                            <i class="bi bi-whatsapp me-2"></i> WhatsApp Chat
                                        </a>
                                        <a class="list-group-item list-group-item-action" data-bs-toggle="tab" href="#analytics-tab">
                                            <i class="bi bi-graph-up me-2"></i> Analytics
                                        </a>
                                        <a class="list-group-item list-group-item-action" data-bs-toggle="tab" href="#darkmode-tab">
                                            <i class="bi bi-moon me-2"></i> Dark Mode
                                        </a>
                                        <a class="list-group-item list-group-item-action text-danger" data-bs-toggle="tab" href="#database-tab">
                                            <i class="bi bi-database me-2"></i> Database Clear
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Settings Content -->
                        <div class="col-md-9">
                            <div class="tab-content">
                                <!-- General Settings -->
                                <div class="tab-pane fade show active" id="general-tab">
                                    <div class="card">
                                        <div class="card-header bg-light">
                                            <h5 class="mb-0">
                                                <i class="bi bi-sliders me-2"></i>
                                                General Settings
                                            </h5>
                                        </div>
                                        <div class="card-body">
                                            <form id="generalForm">
                                                @csrf
                                                <div class="row">
                                                    <div class="col-md-6 mb-3">
                                                        <label for="site_name" class="form-label">Site Name *</label>
                                                        <input type="text" class="form-control" id="site_name" name="site_name" 
                                                               value="{{ $settings['general']['site_name']->value ?? 'De Manchys Lounge' }}" required>
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                        <label for="site_email" class="form-label">Site Email *</label>
                                                        <input type="email" class="form-control" id="site_email" name="site_email" 
                                                               value="{{ $settings['general']['site_email']->value ?? '' }}" required>
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                        <label for="site_phone" class="form-label">Site Phone</label>
                                                        <input type="text" class="form-control" id="site_phone" name="site_phone" 
                                                               value="{{ $settings['general']['site_phone']->value ?? '' }}">
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                        <label for="site_address" class="form-label">Site Address</label>
                                                        <input type="text" class="form-control" id="site_address" name="site_address" 
                                                               value="{{ $settings['general']['site_address']->value ?? '' }}">
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                        <label for="currency" class="form-label">Currency</label>
                                                        <select class="form-control" id="currency" name="currency">
                                                            <option value="USD" {{ ($settings['general']['currency']->value ?? 'USD') == 'USD' ? 'selected' : '' }}>USD ($)</option>
                                                            <option value="EUR" {{ ($settings['general']['currency']->value ?? 'USD') == 'EUR' ? 'selected' : '' }}>EUR (€)</option>
                                                            <option value="GBP" {{ ($settings['general']['currency']->value ?? 'USD') == 'GBP' ? 'selected' : '' }}>GBP (£)</option>
                                                            <option value="NGN" {{ ($settings['general']['currency']->value ?? 'USD') == 'NGN' ? 'selected' : '' }}>NGN (₦)</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                        <label for="timezone" class="form-label">Timezone</label>
                                                        <select class="form-control" id="timezone" name="timezone">
                                                            @foreach(timezone_identifiers_list() as $tz)
                                                                <option value="{{ $tz }}" {{ ($settings['general']['timezone']->value ?? 'UTC') == $tz ? 'selected' : '' }}>
                                                                    {{ $tz }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-12 mb-3">
                                                        <label for="site_description" class="form-label">Site Description</label>
                                                        <textarea class="form-control" id="site_description" name="site_description" rows="3">{{ $settings['general']['site_description']->value ?? '' }}</textarea>
                                                    </div>
                                                    <div class="col-md-12 mb-3">
                                                        <label for="site_keywords" class="form-label">Site Keywords (comma separated)</label>
                                                        <input type="text" class="form-control" id="site_keywords" name="site_keywords" 
                                                               value="{{ $settings['general']['site_keywords']->value ?? '' }}">
                                                    </div>
                                                </div>
                                                <div class="d-flex justify-content-end">
                                                    <button type="button" class="btn btn-primary" onclick="saveSettings('general')">
                                                        <i class="bi bi-save me-1"></i> Save General Settings
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <!-- Logo & Favicon -->
                                <div class="tab-pane fade" id="logo-tab">
                                    <div class="card">
                                        <div class="card-header bg-light">
                                            <h5 class="mb-0">
                                                <i class="bi bi-image me-2"></i>
                                                Logo & Favicon
                                            </h5>
                                        </div>
                                        <div class="card-body">
                                            <form id="logoForm" enctype="multipart/form-data">
                                                @csrf
                                                <div class="row">
                                                    <!-- Logo -->
                                                    <div class="col-md-6 mb-4">
                                                        <div class="card">
                                                            <div class="card-body text-center">
                                                                <h6 class="card-title mb-3">Logo</h6>
                                                                <div class="mb-3">
                                                                    @if(isset($settings['appearance']['logo']->value) && $settings['appearance']['logo']->value)
                                                                        <img src="{{ asset('storage/' . $settings['appearance']['logo']->value) }}" 
                                                                             alt="Current Logo" class="img-fluid mb-3" 
                                                                             style="max-height: 150px; max-width: 100%;">
                                                                        <div class="form-check mb-2">
                                                                            <input class="form-check-input" type="checkbox" id="remove_logo" name="remove_logo">
                                                                            <label class="form-check-label text-danger" for="remove_logo">
                                                                                Remove Current Logo
                                                                            </label>
                                                                        </div>
                                                                    @else
                                                                        <div class="bg-light rounded-3 p-4 mb-3">
                                                                            <i class="bi bi-image text-muted display-6"></i>
                                                                            <p class="mt-2 mb-0">No logo uploaded</p>
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="logo" class="form-label">Upload New Logo</label>
                                                                    <input type="file" class="form-control" id="logo" name="logo" accept="image/*">
                                                                    <small class="text-muted">Recommended: PNG, JPG, SVG. Max: 2MB</small>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Favicon -->
                                                    <div class="col-md-6 mb-4">
                                                        <div class="card">
                                                            <div class="card-body text-center">
                                                                <h6 class="card-title mb-3">Favicon</h6>
                                                                <div class="mb-3">
                                                                    @if(isset($settings['appearance']['favicon']->value) && $settings['appearance']['favicon']->value)
                                                                        <img src="{{ asset('storage/' . $settings['appearance']['favicon']->value) }}" 
                                                                             alt="Current Favicon" class="img-fluid mb-3" 
                                                                             style="max-height: 64px; max-width: 64px;">
                                                                        <div class="form-check mb-2">
                                                                            <input class="form-check-input" type="checkbox" id="remove_favicon" name="remove_favicon">
                                                                            <label class="form-check-label text-danger" for="remove_favicon">
                                                                                Remove Current Favicon
                                                                            </label>
                                                                        </div>
                                                                    @else
                                                                        <div class="bg-light rounded-3 p-4 mb-3">
                                                                            <i class="bi bi-image text-muted display-6"></i>
                                                                            <p class="mt-2 mb-0">No favicon uploaded</p>
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="favicon" class="form-label">Upload New Favicon</label>
                                                                    <input type="file" class="form-control" id="favicon" name="favicon" accept="image/*">
                                                                    <small class="text-muted">Recommended: ICO, PNG. Max: 1MB</small>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="d-flex justify-content-end">
                                                    <button type="button" class="btn btn-primary" onclick="saveLogo()">
                                                        <i class="bi bi-save me-1"></i> Save Logo & Favicon
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <!-- Google reCAPTCHA -->
                                <div class="tab-pane fade" id="recaptcha-tab">
                                    <div class="card">
                                        <div class="card-header bg-light">
                                            <h5 class="mb-0">
                                                <i class="bi bi-shield-check me-2"></i>
                                                Google reCAPTCHA
                                            </h5>
                                        </div>
                                        <div class="card-body">
                                            <form id="recaptchaForm">
                                                @csrf
                                                <div class="mb-3">
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" type="checkbox" id="recaptcha_enabled" name="recaptcha_enabled" 
                                                               {{ ($settings['security']['recaptcha_enabled']->value ?? 0) == 1 ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="recaptcha_enabled">
                                                            Enable Google reCAPTCHA
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6 mb-3">
                                                        <label for="recaptcha_site_key" class="form-label">Site Key</label>
                                                        <input type="text" class="form-control" id="recaptcha_site_key" name="recaptcha_site_key" 
                                                               value="{{ $settings['security']['recaptcha_site_key']->value ?? '' }}">
                                                        <small class="text-muted">Get this from Google reCAPTCHA admin console</small>
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                        <label for="recaptcha_secret_key" class="form-label">Secret Key</label>
                                                        <input type="text" class="form-control" id="recaptcha_secret_key" name="recaptcha_secret_key" 
                                                               value="{{ $settings['security']['recaptcha_secret_key']->value ?? '' }}">
                                                        <small class="text-muted">Keep this secret</small>
                                                    </div>
                                                </div>
                                                <div class="alert alert-info">
                                                    <i class="bi bi-info-circle me-2"></i>
                                                    You need to register your site at 
                                                    <a href="https://www.google.com/recaptcha/admin" target="_blank">Google reCAPTCHA Admin</a> 
                                                    to get these keys.
                                                </div>
                                                <div class="d-flex justify-content-end">
                                                    <button type="button" class="btn btn-primary" onclick="saveSettings('recaptcha')">
                                                        <i class="bi bi-save me-1"></i> Save reCAPTCHA Settings
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <!-- WhatsApp Chat -->
                                <div class="tab-pane fade" id="whatsapp-tab">
                                    <div class="card">
                                        <div class="card-header bg-light">
                                            <h5 class="mb-0">
                                                <i class="bi bi-whatsapp me-2"></i>
                                                WhatsApp Chat
                                            </h5>
                                        </div>
                                        <div class="card-body">
                                            <form id="whatsappForm">
                                                @csrf
                                                <div class="mb-3">
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" type="checkbox" id="whatsapp_enabled" name="whatsapp_enabled" 
                                                               {{ ($settings['integration']['whatsapp_enabled']->value ?? 0) == 1 ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="whatsapp_enabled">
                                                            Enable WhatsApp Chat Widget
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6 mb-3">
                                                        <label for="whatsapp_number" class="form-label">WhatsApp Number</label>
                                                        <input type="text" class="form-control" id="whatsapp_number" name="whatsapp_number" 
                                                               value="{{ $settings['integration']['whatsapp_number']->value ?? '' }}"
                                                               placeholder="+1234567890">
                                                        <small class="text-muted">Include country code</small>
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                        <label for="whatsapp_position" class="form-label">Widget Position</label>
                                                        <select class="form-control" id="whatsapp_position" name="whatsapp_position">
                                                            <option value="right" {{ ($settings['integration']['whatsapp_position']->value ?? 'right') == 'right' ? 'selected' : '' }}>Right Side</option>
                                                            <option value="left" {{ ($settings['integration']['whatsapp_position']->value ?? 'right') == 'left' ? 'selected' : '' }}>Left Side</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-12 mb-3">
                                                        <label for="whatsapp_message" class="form-label">Default Message</label>
                                                        <textarea class="form-control" id="whatsapp_message" name="whatsapp_message" rows="3"
                                                                  placeholder="Hello! I have a question about...">{{ $settings['integration']['whatsapp_message']->value ?? '' }}</textarea>
                                                        <small class="text-muted">Pre-filled message when users click the widget</small>
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                        <label for="whatsapp_delay" class="form-label">Popup Delay (seconds)</label>
                                                        <input type="number" class="form-control" id="whatsapp_delay" name="whatsapp_delay" 
                                                               value="{{ $settings['integration']['whatsapp_delay']->value ?? 5 }}" min="0">
                                                        <small class="text-muted">0 = show immediately</small>
                                                    </div>
                                                </div>
                                                <div class="d-flex justify-content-end">
                                                    <button type="button" class="btn btn-primary" onclick="saveSettings('whatsapp')">
                                                        <i class="bi bi-save me-1"></i> Save WhatsApp Settings
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <!-- Analytics -->
                                <div class="tab-pane fade" id="analytics-tab">
                                    <div class="card">
                                        <div class="card-header bg-light">
                                            <h5 class="mb-0">
                                                <i class="bi bi-graph-up me-2"></i>
                                                Analytics & Tracking
                                            </h5>
                                        </div>
                                        <div class="card-body">
                                            <form id="analyticsForm">
                                                @csrf
                                                <!-- Google Analytics -->
                                                <div class="mb-4">
                                                    <h6 class="border-bottom pb-2 mb-3">Google Analytics</h6>
                                                    <div class="mb-3">
                                                        <div class="form-check form-switch">
                                                            <input class="form-check-input" type="checkbox" id="google_analytics_enabled" name="google_analytics_enabled" 
                                                                   {{ ($settings['integration']['google_analytics_enabled']->value ?? 0) == 1 ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="google_analytics_enabled">
                                                                Enable Google Analytics
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="google_analytics_id" class="form-label">Google Analytics ID</label>
                                                        <input type="text" class="form-control" id="google_analytics_id" name="google_analytics_id" 
                                                               value="{{ $settings['integration']['google_analytics_id']->value ?? '' }}"
                                                               placeholder="G-XXXXXXXXXX or UA-XXXXXXXXX-X">
                                                    </div>
                                                </div>

                                                <!-- Facebook Pixel -->
                                                <div class="mb-4">
                                                    <h6 class="border-bottom pb-2 mb-3">Facebook Pixel</h6>
                                                    <div class="mb-3">
                                                        <div class="form-check form-switch">
                                                            <input class="form-check-input" type="checkbox" id="facebook_pixel_enabled" name="facebook_pixel_enabled" 
                                                                   {{ ($settings['integration']['facebook_pixel_enabled']->value ?? 0) == 1 ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="facebook_pixel_enabled">
                                                                Enable Facebook Pixel
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="facebook_pixel_id" class="form-label">Facebook Pixel ID</label>
                                                        <input type="text" class="form-control" id="facebook_pixel_id" name="facebook_pixel_id" 
                                                               value="{{ $settings['integration']['facebook_pixel_id']->value ?? '' }}"
                                                               placeholder="XXXXXXXXXXXXXXX">
                                                    </div>
                                                </div>

                                                <div class="d-flex justify-content-end">
                                                    <button type="button" class="btn btn-primary" onclick="saveSettings('analytics')">
                                                        <i class="bi bi-save me-1"></i> Save Analytics Settings
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <!-- Dark Mode -->
                                <div class="tab-pane fade" id="darkmode-tab">
                                    <div class="card">
                                        <div class="card-header bg-light">
                                            <h5 class="mb-0">
                                                <i class="bi bi-moon me-2"></i>
                                                Dark Mode Settings
                                            </h5>
                                        </div>
                                        <div class="card-body">
                                            <form id="darkmodeForm">
                                                @csrf
                                                <div class="row">
                                                    <div class="col-md-6 mb-3">
                                                        <div class="form-check form-switch">
                                                            <input class="form-check-input" type="checkbox" id="dark_mode_enabled" name="dark_mode_enabled" 
                                                                   {{ ($settings['appearance']['dark_mode_enabled']->value ?? 1) == 1 ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="dark_mode_enabled">
                                                                Enable Dark Mode
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                        <div class="form-check form-switch">
                                                            <input class="form-check-input" type="checkbox" id="dark_mode_default" name="dark_mode_default" 
                                                                   {{ ($settings['appearance']['dark_mode_default']->value ?? 0) == 1 ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="dark_mode_default">
                                                                Default to Dark Mode
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                        <div class="form-check form-switch">
                                                            <input class="form-check-input" type="checkbox" id="dark_mode_toggle" name="dark_mode_toggle" 
                                                                   {{ ($settings['appearance']['dark_mode_toggle']->value ?? 1) == 1 ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="dark_mode_toggle">
                                                                Show Toggle Switch
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="alert alert-info">
                                                    <i class="bi bi-info-circle me-2"></i>
                                                    Dark mode allows users to switch between light and dark themes for better viewing experience.
                                                </div>
                                                <div class="d-flex justify-content-end">
                                                    <button type="button" class="btn btn-primary" onclick="saveSettings('dark-mode')">
                                                        <i class="bi bi-save me-1"></i> Save Dark Mode Settings
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <!-- Database Clear -->
                                <div class="tab-pane fade" id="database-tab">
                                    <div class="card border-danger">
                                        <div class="card-header bg-danger text-white">
                                            <h5 class="mb-0">
                                                <i class="bi bi-exclamation-triangle me-2"></i>
                                                Database Clear & Maintenance
                                            </h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="alert alert-danger">
                                                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                                                <strong>Warning:</strong> These actions can affect your website performance. Some actions cannot be undone.
                                            </div>
                                            
                                            <form id="databaseForm">
                                                @csrf
                                                <div class="row">
                                                    <div class="col-md-6 mb-3">
                                                        <div class="card h-100">
                                                            <div class="card-body">
                                                                <h6 class="card-title">Cache Clear</h6>
                                                                <div class="form-check mb-2">
                                                                    <input class="form-check-input" type="checkbox" id="clear_cache" name="clear_cache">
                                                                    <label class="form-check-label" for="clear_cache">
                                                                        Clear Application Cache
                                                                    </label>
                                                                </div>
                                                                <small class="text-muted">Clears all cached data. This may temporarily slow down the site.</small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                        <div class="card h-100">
                                                            <div class="card-body">
                                                                <h6 class="card-title">Sessions & Logs</h6>
                                                                <div class="form-check mb-2">
                                                                    <input class="form-check-input" type="checkbox" id="clear_sessions" name="clear_sessions">
                                                                    <label class="form-check-label" for="clear_sessions">
                                                                        Clear All Sessions
                                                                    </label>
                                                                </div>
                                                                <div class="form-check mb-2">
                                                                    <input class="form-check-input" type="checkbox" id="clear_logs" name="clear_logs">
                                                                    <label class="form-check-label" for="clear_logs">
                                                                        Clear Log Files
                                                                    </label>
                                                                </div>
                                                                <small class="text-muted">All users will be logged out. Log files will be deleted.</small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="alert alert-warning mt-3">
                                                    <i class="bi bi-shield-exclamation me-2"></i>
                                                    <strong>Important:</strong> Before proceeding, make sure you have backups of important data.
                                                </div>
                                                
                                                <div class="d-flex justify-content-end">
                                                    <button type="button" class="btn btn-danger" onclick="clearDatabase()">
                                                        <i class="bi bi-trash me-1"></i> Clear Selected Items
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .list-group-item.active {
        background-color: #0d6efd;
        border-color: #0d6efd;
        color: white;
    }
    
    .list-group-item:hover:not(.active) {
        background-color: #f8f9fa;
    }
    
    .form-check-input:checked {
        background-color: #0d6efd;
        border-color: #0d6efd;
    }
    
    .card {
        border-radius: 8px;
    }
    
    .card-header.bg-light {
        background-color: #f8f9fa !important;
    }
</style>
@endpush

@push('scripts')
<script>
    // Save all settings button
    document.getElementById('saveAllSettings').addEventListener('click', function() {
        const activeTab = document.querySelector('#settingsTabs .active');
        const tabId = activeTab.getAttribute('href');
        
        switch(tabId) {
            case '#general-tab':
                saveSettings('general');
                break;
            case '#logo-tab':
                saveLogo();
                break;
            case '#recaptcha-tab':
                saveSettings('recaptcha');
                break;
            case '#whatsapp-tab':
                saveSettings('whatsapp');
                break;
            case '#analytics-tab':
                saveSettings('analytics');
                break;
            case '#darkmode-tab':
                saveSettings('dark-mode');
                break;
            default:
                alert('Please save each section individually');
        }
    });

    // Save settings function
    function saveSettings(type) {
        let formId, url, formData;
        
        switch(type) {
            case 'general':
                formId = 'generalForm';
                url = '{{ route("admin.settings.update-general") }}';
                break;
            case 'recaptcha':
                formId = 'recaptchaForm';
                url = '{{ route("admin.settings.update-recaptcha") }}';
                break;
            case 'whatsapp':
                formId = 'whatsappForm';
                url = '{{ route("admin.settings.update-whatsapp") }}';
                break;
            case 'analytics':
                formId = 'analyticsForm';
                url = '{{ route("admin.settings.update-analytics") }}';
                break;
            case 'dark-mode':
                formId = 'darkmodeForm';
                url = '{{ route("admin.settings.update-dark-mode") }}';
                break;
            default:
                alert('Invalid settings type');
                return;
        }
        
        formData = new FormData(document.getElementById(formId));
        
        // Convert form data to JSON for non-file submissions
        const data = {};
        formData.forEach((value, key) => {
            if (key !== '_token') {
                data[key] = value;
            }
        });
        
        // Add CSRF token
        data['_token'] = '{{ csrf_token() }}';
        
        // Send AJAX request
        fetch(url, {
            method: 'POST',
            credentials: 'same-origin',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify(data)
        })
        .then(response => {
            if (!response.ok) {
                return response.text().then(text => { throw new Error(response.status + ' ' + response.statusText + ': ' + (text || '')); });
            }
            const ct = response.headers.get('content-type') || '';
            if (ct.includes('application/json')) return response.json();
            return response.text().then(text => {
                try { return JSON.parse(text); } catch (e) { return { success: false, message: text || response.statusText }; }
            });
        })
        .then(result => {
            if (result.success) {
                showToast('success', result.message);
            } else {
                showToast('error', result.message || 'Error saving settings');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showToast('error', error.message || 'Network error. Please try again.');
        });
    }

    // Save logo and favicon
    function saveLogo() {
        const form = document.getElementById('logoForm');
        const formData = new FormData(form);
        
        fetch('{{ route("admin.settings.update-logo") }}', {
            method: 'POST',
            credentials: 'same-origin',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: formData
        })
        .then(response => {
            if (!response.ok) {
                return response.text().then(text => { throw new Error(response.status + ' ' + response.statusText + ': ' + (text || '')); });
            }
            const ct = response.headers.get('content-type') || '';
            if (ct.includes('application/json')) return response.json();
            return response.text().then(text => {
                try { return JSON.parse(text); } catch (e) { return { success: false, message: text || response.statusText }; }
            });
        })
        .then(result => {
            if (result.success) {
                showToast('success', result.message);
                // Reload after 2 seconds to show new images
                setTimeout(() => {
                    // Force reload (bypass cache)
                    window.location.reload(true);
                }, 1200);
            } else {
                showToast('error', result.message || 'Error saving logo/favicon');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showToast('error', error.message || 'Network error. Please try again.');
        });
    }

    // Clear database
    function clearDatabase() {
        if (!confirm('Are you sure you want to clear the selected items? This action cannot be undone.')) {
            return;
        }
        
        const form = document.getElementById('databaseForm');
        const formData = new FormData(form);
        const data = {};
        
        formData.forEach((value, key) => {
            if (key !== '_token') {
                data[key] = value ? 1 : 0;
            }
        });
        
        data['_token'] = '{{ csrf_token() }}';
        
        fetch('{{ route("admin.settings.clear-database") }}', {
            method: 'POST',
            credentials: 'same-origin',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify(data)
        })
        .then(response => {
            if (!response.ok) {
                return response.text().then(text => { throw new Error(response.status + ' ' + response.statusText + ': ' + (text || '')); });
            }
            const ct = response.headers.get('content-type') || '';
            if (ct.includes('application/json')) return response.json();
            return response.text().then(text => {
                try { return JSON.parse(text); } catch (e) { return { success: false, message: text || response.statusText }; }
            });
        })
        .then(result => {
            if (result.success) {
                showToast('success', result.message);
            } else {
                showToast('error', result.message || 'Error clearing database');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showToast('error', error.message || 'Network error. Please try again.');
        });
    }

    // Toast notification function
    function showToast(type, message) {
        // Create toast container if it doesn't exist
        let toastContainer = document.getElementById('toast-container');
        if (!toastContainer) {
            toastContainer = document.createElement('div');
            toastContainer.id = 'toast-container';
            toastContainer.style.position = 'fixed';
            toastContainer.style.top = '20px';
            toastContainer.style.right = '20px';
            toastContainer.style.zIndex = '9999';
            document.body.appendChild(toastContainer);
        }
        
        // Create toast
        const toast = document.createElement('div');
        toast.className = `alert alert-${type} alert-dismissible fade show`;
        toast.style.minWidth = '300px';
        toast.style.boxShadow = '0 4px 12px rgba(0,0,0,0.15)';
        
        const icon = type === 'success' ? 'bi-check-circle' : 'bi-exclamation-triangle';
        toast.innerHTML = `
            <i class="bi ${icon} me-2"></i>
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;
        
        toastContainer.appendChild(toast);
        
        // Auto remove after 5 seconds
        setTimeout(() => {
            toast.remove();
        }, 5000);
    }

    // Toggle maintenance message based on site status
    document.addEventListener('DOMContentLoaded', function() {
        const maintenanceRadio = document.getElementById('site_status_maintenance');
        const maintenanceMessage = document.getElementById('maintenance_message');
        
        if (maintenanceRadio && maintenanceMessage) {
            maintenanceRadio.addEventListener('change', function() {
                maintenanceMessage.disabled = !this.checked;
            });
            
            // Initial state
            maintenanceMessage.disabled = !maintenanceRadio.checked;
        }
    });
</script>
@endpush