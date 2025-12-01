<?php

namespace App\Http\Controllers;

use App\Models\DeliveryMan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DeliveryApplicationController extends Controller
{
    /**
     * Show the delivery man application form.
     */
    public function create()
    {
        return view('delivery.apply');
    }

    /**
     * Store a new delivery man application.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:delivery_men,email',
            'phone' => 'required|string|unique:delivery_men,phone',
            'gender' => 'required|in:male,female,other',
            'date_of_birth' => 'required|date|before:-18 years',

            'address' => 'required|string|max:500',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'zip_code' => 'required|string|max:20',

            'vehicle_type' => 'required|in:motorcycle,car,bicycle,scooter,other',
            'vehicle_make' => 'required|string|max:100',
            'vehicle_model' => 'required|string|max:100',
            'vehicle_year' => 'required|integer|min:1990|max:' . date('Y'),
            'vehicle_color' => 'required|string|max:50',
            'vehicle_plate' => 'required|string|max:20',

            'drivers_license' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'vehicle_insurance' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'vehicle_registration' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'id_document' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',

            'preferred_areas' => 'required|array|min:1',
            'availability' => 'required|in:full_time,part_time,flexible',
            'work_hours' => 'required|string|max:255',

            'bank_name' => 'required|string|max:100',
            'account_number' => 'required|string|size:10|regex:/^[0-9]{10}$/',
            'account_holder_name' => 'required|string|max:255',
            'account_type' => 'required|in:savings,current,domiciliary',

            'terms_agreed' => 'required|accepted',
        ]);

        try {
            $driversLicensePath = $request->file('drivers_license')->store('delivery-documents', 'public');
            $vehicleInsurancePath = $request->file('vehicle_insurance')->store('delivery-documents', 'public');
            $vehicleRegistrationPath = $request->file('vehicle_registration')->store('delivery-documents', 'public');
            $idDocumentPath = $request->file('id_document')->store('delivery-documents', 'public');

            DeliveryMan::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
                'gender' => $validated['gender'],
                'address' => "{$validated['address']}, {$validated['city']}, {$validated['state']} {$validated['zip_code']}",
                'vehicle_type' => $validated['vehicle_type'],
                'vehicle_number' => $validated['vehicle_plate'],
                'driver_license' => $driversLicensePath,
                'vehicle_insurance' => $vehicleInsurancePath,
                'vehicle_registration' => $vehicleRegistrationPath,
                'status' => 'pending',
                'application_notes' => "Preferred Areas: " . implode(', ', $validated['preferred_areas']) .
                                      " | Availability: {$validated['availability']} | Hours: {$validated['work_hours']}",
            ]);

            return redirect()->route('delivery.apply')
                ->with('success', 'Your application has been submitted successfully! We will review it and get back to you within 2-3 business days.');
        } catch (\Exception $e) {
            if (isset($driversLicensePath)) Storage::disk('public')->delete($driversLicensePath);
            if (isset($vehicleInsurancePath)) Storage::disk('public')->delete($vehicleInsurancePath);
            if (isset($vehicleRegistrationPath)) Storage::disk('public')->delete($vehicleRegistrationPath);
            if (isset($idDocumentPath)) Storage::disk('public')->delete($idDocumentPath);

            return back()->with('error', 'There was an error submitting your application. Please try again.');
        }
    }
}