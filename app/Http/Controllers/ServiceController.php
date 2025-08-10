<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Service;
use App\Events\UserActionOccurred;

class ServiceController extends Controller
{
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'ServiceName' => 'required|string|max:255',
                'Description' => 'nullable|string',
                'Cost' => 'nullable|numeric|min:0',
                'IsMultiVisit' => 'boolean',
                'IsActive' => 'boolean',
            ]);

            // Ensure user is authenticated
            $user = Auth::user();
            if (!$user) {
                \Log::error('No authenticated user attempting to create service');
                return response()->json(['error' => 'Unauthorized'], 401);
            }

            // Determine user role for logging
            $userRole = $user->userAccount && $user->userAccount->UserType === 'Owner' ? 'Owner' : 'HR Admin';
            $userName = "{$user->FirstName} {$user->LastName}";

            // Set default IsActive to true if not provided
            $validated['IsActive'] = $validated['IsActive'] ?? true;

            $service = Service::create($validated);

            // Dispatch UserActionOccurred event with user name
            event(new UserActionOccurred(
                $user->UserID,
                'Service Created',
                "{$userRole} {$userName} created a new service {$service->ServiceName}"
            ));
            \Log::info('Service created successfully', [
                'service_id' => $service->ServiceID,
                'user_id' => $user->UserID,
                'user_type' => $userRole,
            ]);

            return response()->json($service, 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Validation failed creating service: ' . json_encode($e->errors()));
            return response()->json([
                'error' => 'Validation failed',
                'details' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            \Log::error('Error creating service: ' . $e->getMessage());
            return response()->json([
                'error' => 'Failed to create service',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $service = Service::findOrFail($id);

            // Ensure user is authenticated
            $user = Auth::user();
            if (!$user) {
                \Log::error('No authenticated user attempting to update service');
                return response()->json(['error' => 'Unauthorized'], 401);
            }

            // Determine user role for logging
            $userRole = $user->userAccount && $user->userAccount->UserType === 'Owner' ? 'Owner' : 'HR Admin';
            $userName = "{$user->FirstName} {$user->LastName}";

            $validated = $request->validate([
                'ServiceName' => 'required|string|max:255',
                'Description' => 'nullable|string',
                'Cost' => 'nullable|numeric|min:0',
                'IsMultiVisit' => 'boolean',
                'IsActive' => 'boolean',
            ]);

            // Store original values for comparison
            $originalName = $service->ServiceName;
            $originalCost = $service->Cost;
            $originalIsActive = $service->IsActive;

            // Update the service
            $service->update($validated);

            // Format costs to always show two decimal places
            $formattedOriginalCost = number_format($originalCost, 2, '.', '');
            $formattedNewCost = number_format($validated['Cost'], 2, '.', '');

            // Check for changes and log them
            if ($originalName !== $validated['ServiceName']) {
                event(new UserActionOccurred(
                    $user->UserID,
                    'Service Updated',
                    "{$userRole} {$userName} changed service {$originalName} to {$validated['ServiceName']}"
                ));
                \Log::info('Service name updated', [
                    'service_id' => $service->ServiceID,
                    'original_name' => $originalName,
                    'new_name' => $validated['ServiceName'],
                    'user_id' => $user->UserID,
                    'user_type' => $userRole,
                ]);
            }

            if ($originalCost != $validated['Cost']) {
                event(new UserActionOccurred(
                    $user->UserID,
                    'Service Updated',
                    "{$userRole} {$userName} changed service cost from {$formattedOriginalCost} to {$formattedNewCost}"
                ));
                \Log::info('Service cost updated', [
                    'service_id' => $service->ServiceID,
                    'original_cost' => $originalCost,
                    'new_cost' => $validated['Cost'],
                    'formatted_original_cost' => $formattedOriginalCost,
                    'formatted_new_cost' => $formattedNewCost,
                    'user_id' => $user->UserID,
                    'user_type' => $userRole,
                ]);
            }

            if ($originalIsActive !== $validated['IsActive']) {
                $status = $validated['IsActive'] ? 'enabled' : 'disabled';
                event(new UserActionOccurred(
                    $user->UserID,
                    'Service Updated',
                    "{$userRole} {$userName} {$status} service {$validated['ServiceName']}"
                ));
                \Log::info("Service status updated to {$status}", [
                    'service_id' => $service->ServiceID,
                    'is_active' => $validated['IsActive'],
                    'user_id' => $user->UserID,
                    'user_type' => $userRole,
                ]);
            }

            return response()->json($service);
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Validation failed updating service: ' . json_encode($e->errors()));
            return response()->json([
                'error' => 'Validation failed',
                'details' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            \Log::error('Error updating service: ' . $e->getMessage());
            return response()->json([
                'error' => 'Failed to update service',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function list(Request $request)
    {
        $query = Service::query();

        // If 'active_only' query parameter is true, filter for active services
        if ($request->query('active_only', false)) {
            $query->where('IsActive', true);
        }

        $services = $query->get();
        return response()->json($services);
    }
}
