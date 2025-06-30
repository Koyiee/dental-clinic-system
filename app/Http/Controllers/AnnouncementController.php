<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Announcement;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Events\UserActionOccurred;

class AnnouncementController extends Controller
{
    public function index(Request $request)
    {
        $now = Carbon::now()->toDateTimeString();
        // Update status based on StartDate and EndDate
        Announcement::where('StartDate', '>', $now)->update(['Status' => 'pending']);
        Announcement::where('StartDate', '<=', $now)
                    ->where('EndDate', '<', $now)
                    ->update(['Status' => 'expired']);
        Announcement::where('StartDate', '<=', $now)
                    ->where('EndDate', '>=', $now)
                    ->update(['Status' => 'active']);
    
        // Include soft-deleted announcements using withTrashed()
        $query = Announcement::withTrashed();
        $announcements = $query->get();
        $transformedAnnouncements = $announcements->map(function ($announcement) {
            return [
                'AnnouncementId' => $announcement->AnnouncementID, // Use the correct primary key
                'AnnouncementTitle' => $announcement->AnnouncementTitle,
                'AnnouncementDescription' => $announcement->AnnouncementDescription,
                'AnnouncementPicture' => $announcement->AnnouncementPicture ? 'data:image/jpeg;base64,' . base64_encode($announcement->AnnouncementPicture) : null,
                'TargetUser' => $announcement->TargetUser,
                'StartDate' => $announcement->StartDate,
                'EndDate' => $announcement->EndDate,
                'Priority' => $announcement->Priority,
                'Status' => $announcement->Status,
                'CreatedBy' => $announcement->CreatedBy,
                'created_at' => $announcement->created_at,
                'updated_at' => $announcement->updated_at,
                'deleted_at' => $announcement->deleted_at, // Include deleted_at to identify soft-deleted records
            ];
        })->sortBy('Priority');
        Log::info('Fetched all announcements (including soft-deleted):', ['count' => $transformedAnnouncements->count()]);
        return response()->json($transformedAnnouncements->values());

        $query = Announcement::query();
        if ($request->has('createdBy')) {
            $query->where('CreatedBy', $request->createdBy);
        }
        return response()->json($query->get());
    }

    public function store(Request $request)
    {
        Log::info('Incoming request data:', $request->all());
        $request->validate([
            'AnnouncementTitle' => 'required|string',
            'AnnouncementDescription' => 'required|string',
            'AnnouncementPicture' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'TargetUser' => 'required|string',
            'Priority' => 'required|in:1,2,3',
            'StartDate' => 'required|date',
            'EndDate' => 'required|date|after:StartDate',
            'CreatedBy' => 'required|string',
        ]);
        $imageData = null;
        if ($request->hasFile('AnnouncementPicture')) {
            $imageData = file_get_contents($request->file('AnnouncementPicture'));
            if ($imageData === false) {
                Log::error('Failed to read image file');
                return response()->json(['error' => 'Failed to process image'], 400);
            }
        }
        $now = Carbon::now();
        $startDate = Carbon::parse($request->StartDate);
        $endDate = Carbon::parse($request->EndDate);
        $status = $startDate > $now ? 'pending' : ($endDate < $now ? 'expired' : 'active');
        $announcementData = [
            'AnnouncementTitle' => $request->AnnouncementTitle,
            'AnnouncementDescription' => $request->AnnouncementDescription,
            'AnnouncementPicture' => $imageData,
            'TargetUser' => $request->TargetUser,
            'Priority' => $request->Priority,
            'StartDate' => $request->StartDate,
            'EndDate' => $request->EndDate,
            'Status' => $status,
            'CreatedBy' => $request->CreatedBy,
            'created_at' => now(),
            'updated_at' => now(),
        ];
        if ($request->TargetUser === 'All') {
            $audiences = ['patients', 'Dentist'];
            foreach ($audiences as $audience) {
                $announcementData['TargetUser'] = $audience;
                Announcement::create($announcementData);
            }
        } else {
            Announcement::create($announcementData);
        }
        Log::info('Announcement created successfully', ['targetUser' => $request->TargetUser]);
        return response()->json(['message' => 'Announcement added successfully!'], 201);
    }

    public function storeOwner(Request $request)
    {
        try {
            $request->validate([
                'AnnouncementTitle' => 'required|string|max:255',
                'AnnouncementDescription' => 'required|string',
                'TargetUser' => 'required|string',
                'Priority' => 'required|in:Urgent,Moderate,Not Urgent',
                'StartDate' => 'required|date',
                'EndDate' => 'required|date|after:StartDate',
                'CreatedBy' => 'required|string',
                'AnnouncementPicture' => 'nullable|image|max:2048',
            ]);

            // Ensure owner is authenticated
            $owner = Auth::user();
            if (!$owner) {
                Log::error('No authenticated user attempting to create owner announcement');
                return response()->json(['error' => 'Unauthorized'], 401);
            }

            $imageData = null;
            if ($request->hasFile('AnnouncementPicture')) {
                $imageData = file_get_contents($request->file('AnnouncementPicture'));
                if ($imageData === false) {
                    Log::error('Failed to read image file');
                    return response()->json(['error' => 'Failed to process image'], 400);
                }
            }

            $now = Carbon::now();
            $startDate = Carbon::parse($request->StartDate);
            $endDate = Carbon::parse($request->EndDate);
            $status = $startDate > $now ? 'pending' : ($endDate < $now ? 'expired' : 'active');
            $announcementData = [
                'AnnouncementTitle' => $request->AnnouncementTitle,
                'AnnouncementDescription' => $request->AnnouncementDescription,
                'AnnouncementPicture' => $imageData,
                'TargetUser' => $request->TargetUser,
                'Priority' => $request->Priority,
                'StartDate' => $request->StartDate,
                'EndDate' => $request->EndDate,
                'Status' => $status,
                'CreatedBy' => $request->CreatedBy,
                'created_at' => now(),
                'updated_at' => now(),
            ];

            // Determine user role for logging
            $userRole = $owner->userAccount && $owner->userAccount->UserType === 'Owner' ? 'Owner' : 'HR Admin';
            $userName = "{$owner->FirstName} {$owner->LastName}";

            if ($request->TargetUser === 'All') {
                $audiences = ['patients', 'Dentist'];
                foreach ($audiences as $audience) {
                    $announcementData['TargetUser'] = $audience;
                    Announcement::create($announcementData);

                    // Log for each audience
                    event(new UserActionOccurred(
                        $owner->UserID,
                        'Announcement Created',
                        "{$userRole} {$userName} has created an announcement titled '{$request->AnnouncementTitle}'"
                    ));
                    Log::info('Owner announcement created for audience', [
                        'targetUser' => $audience,
                        'announcement_title' => $request->AnnouncementTitle,
                        'owner_id' => $owner->UserID,
                    ]);
                }
            } else {
                Announcement::create($announcementData);
                // Log for single audience
                event(new UserActionOccurred(
                    $owner->UserID,
                    'Announcement Created',
                    "{$userRole} {$userName} has created an announcement titled '{$request->AnnouncementTitle}'"
                ));
                Log::info('Owner announcement created successfully', [
                    'targetUser' => $request->TargetUser,
                    'announcement_title' => $request->AnnouncementTitle,
                    'owner_id' => $owner->UserID,
                ]);
            }

            return response()->json(['message' => 'Announcement added successfully by Owner!'], 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation failed creating owner announcement: ' . json_encode($e->errors()));
            return response()->json([
                'error' => 'Validation failed',
                'details' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            Log::error('Error creating owner announcement: ' . $e->getMessage());
            return response()->json([
                'error' => 'Failed to create announcement',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        Log::info('Starting announcement update', ['id' => $id, 'data' => $request->all()]);
    
        $announcement = Announcement::find($id);
        if (!$announcement) {
            Log::error('Announcement not found', ['id' => $id]);
            return response()->json(['message' => 'Announcement not found'], 404);
        }
    
        $user = Auth::user();
        if (!$user) {
            Log::error('No authenticated user');
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    
        try {
            $validated = $request->validate([
                'AnnouncementTitle' => 'required|string|max:255',
                'AnnouncementDescription' => 'required|string',
                'TargetUser' => 'required|string',
                'Priority' => 'required|in:Urgent,Moderate,Not Urgent',
                'StartDate' => 'required|date',
                'EndDate' => 'required|date|after:StartDate',
                'CreatedBy' => 'required|string',
                'AnnouncementPicture' => 'nullable|image|max:2048',
            ]);
            Log::info('Validation passed', $validated);
        } catch (\Exception $e) {
            Log::error('Validation failed', ['error' => $e->getMessage()]);
            throw $e;
        }
    
        $imageData = $announcement->AnnouncementPicture;
        if ($request->hasFile('AnnouncementPicture')) {
            $imageData = file_get_contents($request->file('AnnouncementPicture'));
            if ($imageData === false) {
                Log::error('Failed to read image file');
                return response()->json(['error' => 'Failed to process image'], 400);
            }
        }
    
        $now = Carbon::now();
        $startDate = Carbon::parse($request->StartDate);
        $endDate = Carbon::parse($request->EndDate);
        $status = $startDate > $now ? 'pending' : ($endDate < $now ? 'expired' : 'active');
    
        $originalTitle = $announcement->AnnouncementTitle; // Capture original title
    
        $updateData = [
            'AnnouncementTitle' => $request->AnnouncementTitle,
            'AnnouncementDescription' => $request->AnnouncementDescription,
            'AnnouncementPicture' => $imageData,
            'TargetUser' => $request->TargetUser,
            'Priority' => $request->Priority,
            'StartDate' => $request->StartDate,
            'EndDate' => $request->EndDate,
            'Status' => $status,
            'CreatedBy' => $request->CreatedBy,
            'updated_at' => now(),
        ];
    
        try {
            // Determine user role for logging
            $userRole = $user->userAccount && $user->userAccount->UserType === 'Owner' ? 'Owner' : 'HR Admin';
            $userName = "{$user->FirstName} {$user->LastName}";

            if ($request->TargetUser === 'All') {
                $relatedAnnouncements = Announcement::where('AnnouncementTitle', $announcement->AnnouncementTitle)
                    ->where('created_at', $announcement->created_at)
                    ->where('AnnouncementId', '!=', $id)
                    ->get();
                Log::info('Related announcements found', [
                    'count' => $relatedAnnouncements->count(),
                    'ids' => $relatedAnnouncements->pluck('AnnouncementId')->toArray()
                ]);
    
                $announcement->update($updateData);
                Log::info('Main announcement updated', ['id' => $id]);
    
                $audiences = ['patients', 'Dentist'];
                foreach ($audiences as $audience) {
                    $relatedAnnouncement = $relatedAnnouncements->firstWhere('TargetUser', $audience);
                    if ($relatedAnnouncement) {
                        $relatedAnnouncement->update(array_merge($updateData, ['TargetUser' => $audience]));
                        Log::info('Related announcement updated', ['id' => $relatedAnnouncement->AnnouncementId]);
                    } else {
                        Announcement::create(array_merge($updateData, ['TargetUser' => $audience, 'created_at' => now()]));
                        Log::info('New announcement created for audience', ['audience' => $audience]);
                    }
                }
    
                // Single event for all updates
                event(new UserActionOccurred(
                    $user->UserID,
                    'Announcement Edited',
                    "{$userRole} {$userName} has edited announcement '{$originalTitle}' to '{$request->AnnouncementTitle}'"
                ));
                Log::info('Event triggered for announcement edit', [
                    'user_type' => $userRole,
                    'user_id' => $user->UserID,
                    'original_title' => $originalTitle,
                    'new_title' => $request->AnnouncementTitle
                ]);
            } else {
                $announcement->update($updateData);
                Log::info('Single announcement updated', ['id' => $id]);
                event(new UserActionOccurred(
                    $user->UserID,
                    'Announcement Edited',
                    "{$userRole} {$userName} has edited announcement '{$originalTitle}' to '{$request->AnnouncementTitle}'"
                ));
                Log::info('Event triggered for announcement edit', [
                    'user_type' => $userRole,
                    'user_id' => $user->UserID,
                    'original_title' => $originalTitle,
                    'new_title' => $request->AnnouncementTitle
                ]);
            }
    
            Log::info('Announcement update completed', ['id' => $id]);
            return response()->json(['message' => 'Announcement updated successfully!'], 200);
        } catch (\Exception $e) {
            Log::error('Error updating announcement', ['id' => $id, 'error' => $e->getMessage()]);
            return response()->json(['error' => 'Failed to update announcement: ' . $e->getMessage()], 500);
        }
    }

    public function getPatientAnnouncements(Request $request)
    {
        try {
            $now = Carbon::now()->toDateTimeString();
            Announcement::where('StartDate', '>', $now)->update(['Status' => 'pending']);
            Announcement::where('StartDate', '<=', $now)
                        ->where('EndDate', '<', $now)
                        ->update(['Status' => 'expired']);
            Announcement::where('StartDate', '<=', $now)
                        ->where('EndDate', '>=', $now)
                        ->update(['Status' => 'active']);
            
            $query = Announcement::where('TargetUser', 'patients')
                                 ->where('Status', 'active')
                                 ->where('StartDate', '<=', $now);
            $announcements = $query->get();
            $transformedAnnouncements = $announcements->map(function ($announcement) {
                return [
                    'AnnouncementId' => $announcement->AnnouncementId,
                    'AnnouncementTitle' => $announcement->AnnouncementTitle,
                    'AnnouncementDescription' => $announcement->AnnouncementDescription,
                    'AnnouncementPicture' => $announcement->AnnouncementPicture ? 'data:image/jpeg;base64,' . base64_encode($announcement->AnnouncementPicture) : null,
                    'TargetUser' => $announcement->TargetUser,
                    'StartDate' => $announcement->StartDate,
                    'EndDate' => $announcement->EndDate,
                    'Priority' => $announcement->Priority,
                    'Status' => $announcement->Status,
                    'CreatedBy' => $announcement->CreatedBy,
                    'created_at' => $announcement->created_at,
                    'updated_at' => $announcement->updated_at,
                ];
            })->sortBy('Priority');
            Log::info('Fetched patient announcements:', ['count' => $transformedAnnouncements->count()]);
            return response()->json($transformedAnnouncements->values());
        } catch (\Exception $e) {
            Log::error('Error fetching patient announcements: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to fetch announcements'], 500);
        }
    }

    public function getDentistAnnouncements(Request $request)
    {
        try {
            $now = Carbon::now()->toDateTimeString();
            Announcement::where('StartDate', '>', $now)->update(['Status' => 'pending']);
            Announcement::where('StartDate', '<=', $now)
                        ->where('EndDate', '<', $now)
                        ->update(['Status' => 'expired']);
            Announcement::where('StartDate', '<=', $now)
                        ->where('EndDate', '>=', $now)
                        ->update(['Status' => 'active']);
            
            $query = Announcement::where('TargetUser', 'Dentist')
                                 ->where('Status', 'active')
                                 ->where('StartDate', '<=', $now);
            $announcements = $query->get();
            $transformedAnnouncements = $announcements->map(function ($announcement) {
                return [
                    'AnnouncementId' => $announcement->AnnouncementId,
                    'AnnouncementTitle' => $announcement->AnnouncementTitle,
                    'AnnouncementDescription' => $announcement->AnnouncementDescription,
                    'AnnouncementPicture' => $announcement->AnnouncementPicture ? 'data:image/jpeg;base64,' . base64_encode($announcement->AnnouncementPicture) : null,
                    'TargetUser' => $announcement->TargetUser,
                    'StartDate' => $announcement->StartDate,
                    'EndDate' => $announcement->EndDate,
                    'Priority' => $announcement->Priority,
                    'Status' => $announcement->Status,
                    'CreatedBy' => $announcement->CreatedBy,
                    'created_at' => $announcement->created_at,
                    'updated_at' => $announcement->updated_at,
                ];
            })->sortBy('Priority');
            Log::info('Fetched dentist announcements:', ['count' => $transformedAnnouncements->count()]);
            return response()->json($transformedAnnouncements->values());
        } catch (\Exception $e) {
            Log::error('Error fetching dentist announcements: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to fetch announcements'], 500);
        }
    }

    public function getAnnouncementImage($id)
    {
        $announcement = Announcement::where('AnnouncementId', $id)->first();
        if (!$announcement || !$announcement->AnnouncementPicture) {
            return response()->json(['error' => 'Image not found'], 404);
        }
        return response()->make($announcement->AnnouncementPicture, 200, [
            'Content-Type' => 'image/jpeg'
        ]);
    }

    public function getAnnouncementsByAudience($audience)
    {
        $now = Carbon::now()->toDateTimeString();
        Announcement::where('StartDate', '>', $now)->update(['Status' => 'pending']);
        Announcement::where('StartDate', '<=', $now)
                    ->where('EndDate', '<', $now)
                    ->update(['Status' => 'expired']);
        Announcement::where('StartDate', '<=', $now)
                    ->where('EndDate', '>=', $now)
                    ->update(['Status' => 'active']);
        
        $query = Announcement::where('TargetUser', $audience)
                             ->where('Status', 'active')
                             ->where('StartDate', '<=', $now);
        $announcements = $query->get();
        $transformedAnnouncements = $announcements->map(function ($announcement) {
            return [
                'AnnouncementId' => $announcement->AnnouncementId,
                'AnnouncementTitle' => $announcement->AnnouncementTitle,
                'AnnouncementDescription' => $announcement->AnnouncementDescription,
                'AnnouncementPicture' => $announcement->AnnouncementPicture ? 'data:image/jpeg;base64,' . base64_encode($announcement->AnnouncementPicture) : null,
                'TargetUser' => $announcement->TargetUser,
                'StartDate' => $announcement->StartDate,
                'EndDate' => $announcement->EndDate,
                'Priority' => $announcement->Priority,
                'Status' => $announcement->Status,
                'CreatedBy' => $announcement->CreatedBy,
                'created_at' => $announcement->created_at,
                'updated_at' => $announcement->updated_at,
            ];
        })->sortBy('Priority');
        Log::info("Fetched announcements by audience $audience:", ['count' => $transformedAnnouncements->count()]);
        return response()->json($transformedAnnouncements->values());
    }

    public function storeHr(Request $request)
    {
        Log::info('Incoming HR request data:', $request->all());
        $request->validate([
            'AnnouncementTitle' => 'required|string|max:255',
            'AnnouncementDescription' => 'required|string',
            'TargetUser' => 'required|string',
            'Priority' => 'required|in:Urgent,Moderate,Not Urgent',
            'StartDate' => 'required|date',
            'EndDate' => 'required|date|after:StartDate',
            'CreatedBy' => 'required|string',
            'AnnouncementPicture' => 'nullable|image|max:2048',
        ]);

        $hrAdmin = Auth::user();
        if (!$hrAdmin) {
            Log::error('No authenticated user attempting to create HR announcement');
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $imageData = null;
        if ($request->hasFile('AnnouncementPicture')) {
            $imageData = file_get_contents($request->file('AnnouncementPicture'));
        }
        $now = Carbon::now();
        $startDate = Carbon::parse($request->StartDate);
        $endDate = Carbon::parse($request->EndDate);
        $status = $startDate > $now ? 'pending' : ($endDate < $now ? 'expired' : 'active');
        $announcementData = [
            'AnnouncementTitle' => $request->AnnouncementTitle,
            'AnnouncementDescription' => $request->AnnouncementDescription,
            'AnnouncementPicture' => $imageData,
            'TargetUser' => $request->TargetUser,
            'Priority' => $request->Priority,
            'StartDate' => $request->StartDate,
            'EndDate' => $request->EndDate,
            'Status' => $status,
            'CreatedBy' => $request->CreatedBy,
            'created_at' => now(),
            'updated_at' => now(),
        ];

        // Determine user role for logging
        $userRole = $hrAdmin->userAccount && $hrAdmin->userAccount->UserType === 'Owner' ? 'Owner' : 'HR Admin';
        $userName = "{$hrAdmin->FirstName} {$hrAdmin->LastName}";

        if ($request->TargetUser === 'All') {
            $audiences = ['patients', 'Dentist'];
            foreach ($audiences as $audience) {
                $announcementData['TargetUser'] = $audience;
                Announcement::create($announcementData);

                event(new UserActionOccurred(
                    $hrAdmin->UserID,
                    'Announcement Created',
                    "{$userRole} {$userName} has created an announcement titled '{$request->AnnouncementTitle}'"
                ));
            }
        } else {
            Announcement::create($announcementData);
            event(new UserActionOccurred(
                $hrAdmin->UserID,
                'Announcement Created',
                "{$userRole} {$userName} has created an announcement titled '{$request->AnnouncementTitle}'"
            ));
        }
        Log::info('HR announcement created successfully', ['targetUser' => $request->TargetUser]);
        return response()->json(['message' => 'Announcement added successfully by HR!'], 201);
    }

    public function destroy($id)
    {
        Log::info('Attempting to soft delete announcement:', ['id' => $id]);
    
        if (!$id || $id === 'null') {
            Log::error('Invalid announcement ID provided for soft deletion', ['id' => $id]);
            return response()->json(['message' => 'Invalid announcement ID'], 400);
        }
    
        $announcement = Announcement::withTrashed()->find($id);
    
        if (!$announcement) {
            Log::error('Announcement not found for soft deletion', ['id' => $id]);
            return response()->json(['message' => 'Announcement not found'], 404);
        }

        $user = Auth::user();
        if (!$user) {
            Log::error('No authenticated user attempting to delete announcement');
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $announcement->delete();

        // Determine user role for logging
        $userRole = $user->userAccount && $user->userAccount->UserType === 'Owner' ? 'Owner' : 'HR Admin';
        $userName = "{$user->FirstName} {$user->LastName}";

        event(new UserActionOccurred(
            $user->UserID,
            'Announcement Deleted',
            "{$userRole} {$userName} has deleted an announcement titled '{$announcement->AnnouncementTitle}'"
        ));

        Log::info('Announcement soft deleted successfully', [
            'id' => $id,
            'user_type' => $userRole,
            'user_id' => $user->UserID
        ]);
        return response()->json(['message' => 'Announcement soft deleted successfully'], 200);
    }
}