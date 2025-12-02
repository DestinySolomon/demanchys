<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PaymentMethod;
use Illuminate\Support\Facades\Storage;


class PaymentController extends Controller
{
    /**
     * Display a listing of payment methods.
     */
    public function index()
    {
        $paymentMethods = PaymentMethod::orderBy('sort_order')->get();
        return view('admin.payments.index', compact('paymentMethods'));
    }

    /**
     * Toggle payment method status (active/inactive)
     */
    public function toggleStatus(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:payment_methods,id',
            'is_active' => 'required|boolean'
        ]);

        $paymentMethod = PaymentMethod::find($request->id);
        $paymentMethod->update(['is_active' => $request->is_active]);

        return response()->json([
            'success' => true,
            'message' => 'Status updated successfully',
            'is_active' => $paymentMethod->is_active
        ]);
    }

    /**
     * Set a payment method as default
     */
    public function setDefault(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:payment_methods,id'
        ]);

        // First, remove default from all payment methods
        PaymentMethod::where('is_default', true)->update(['is_default' => false]);
        
        // Then set the selected one as default
        $paymentMethod = PaymentMethod::find($request->id);
        $paymentMethod->update(['is_default' => true]);

        return response()->json([
            'success' => true,
            'message' => $paymentMethod->name . ' is now the default payment method',
            'method_name' => $paymentMethod->name
        ]);
    }

    /**
     * Show the form for creating a new payment method.
     */
    public function create()
    {
        $types = PaymentMethod::getPaymentTypes();
        return view('admin.payments.create', compact('types'));
    }

    /**
     * Store a newly created payment method.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|in:' . implode(',', array_keys(PaymentMethod::getPaymentTypes())),
            'is_active' => 'boolean',
            'is_default' => 'boolean'
        ]);

        // If setting as default, remove default from others
        if ($request->is_default) {
            PaymentMethod::where('is_default', true)->update(['is_default' => false]);
        }

        // Prepare credentials based on configuration fields
        $credentials = [];
        $configFields = (new PaymentMethod(['type' => $request->type]))->getConfigurationFields();
        
        foreach ($configFields as $field) {
            $fieldName = $field['name'];
            if ($request->has($fieldName)) {
                $credentials[$fieldName] = $request->$fieldName;
            }
        }

        PaymentMethod::create([
            'name' => $request->name,
            'description' => $request->description,
            'type' => $request->type,
            'icon' => $request->icon,
            'is_active' => $request->is_active ?? true,
            'is_default' => $request->is_default ?? false,
            'sort_order' => $request->sort_order ?? 0,
            'credentials' => $credentials
        ]);

        return redirect()->route('admin.payments.index')
            ->with('success', 'Payment method created successfully.');
    }

    /**
     * Display the specified payment method.
     */
    public function show(string $id)
    {
        $paymentMethod = PaymentMethod::findOrFail($id);
        return view('admin.payments.show', compact('paymentMethod'));
    }

    /**
     * Show the form for editing a payment method.
     */
    public function edit(string $id)
    {
        $paymentMethod = PaymentMethod::findOrFail($id);
        return view('admin.payments.edit', compact('paymentMethod'));
    }

    /**
     * Update the specified payment method.
     */


       public function update(Request $request, string $id)
{
    $paymentMethod = PaymentMethod::findOrFail($id);
    
    $request->validate([
        'name' => 'required|string|max:255',
        'is_active' => 'boolean',
        'is_default' => 'boolean',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    ]);

    // If setting as default, remove default from others
    if ($request->is_default && !$paymentMethod->is_default) {
        PaymentMethod::where('is_default', true)->update(['is_default' => false]);
    }

    // Prepare credentials based on configuration fields
    $credentials = $paymentMethod->credentials ?? [];
    $configFields = $paymentMethod->getConfigurationFields();
    
    foreach ($configFields as $field) {
        $fieldName = $field['name'];
        if ($request->has($fieldName) && $request->$fieldName !== null) {
            $credentials[$fieldName] = $request->$fieldName;
        } elseif (isset($field['default']) && !isset($credentials[$fieldName])) {
            $credentials[$fieldName] = $field['default'];
        }
    }

    // Handle image upload
    $imagePath = $paymentMethod->image;
    if ($request->hasFile('image')) {
        // Delete old image if exists
        if ($imagePath && Storage::disk('public')->exists($imagePath)) {
            Storage::disk('public')->delete($imagePath);
        }
        
        // Store new image
        $imagePath = $request->file('image')->store('payment-methods', 'public');
    }

    // Prepare update data
    $updateData = [
        'name' => $request->name,
        'description' => $request->description,
        'is_active' => $request->is_active ?? true,
        'is_default' => $request->is_default ?? false,
        'sort_order' => $request->sort_order ?? 0,
        'credentials' => !empty($credentials) ? $credentials : null
    ];

    // Only add image if it was uploaded
    if ($imagePath) {
        $updateData['image'] = $imagePath;
    }

    $paymentMethod->update($updateData);

    return redirect()->route('admin.payments.index')
        ->with('success', 'Payment method updated successfully.');
}



    /**
     * Remove the specified payment method.
     */
    public function destroy(string $id)
    {
        $paymentMethod = PaymentMethod::findOrFail($id);
        
        // Prevent deletion of default payment method
        if ($paymentMethod->is_default) {
            return redirect()->route('admin.payments.index')
                ->with('error', 'Cannot delete the default payment method.');
        }

        $paymentMethod->delete();

        return redirect()->route('admin.payments.index')
            ->with('success', 'Payment method deleted successfully.');
    }
}