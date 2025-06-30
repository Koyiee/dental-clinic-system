<?php

namespace App\Listeners;

use App\Events\UserActionOccurred;
use App\Http\Controllers\OwnerLoginTracerController;
use Illuminate\Support\Facades\Log;

class LogUserAction
{
    private static $processedEvents = [];

    public function handle(UserActionOccurred $event)
    {
        $instanceId = spl_object_hash($this); // Unique ID for this listener instance
        \Log::info('LogUserAction instance', ['instance_id' => $instanceId]);

        $eventKey = md5("{$event->userId}-{$event->actionType}-{$event->description}");
        if (in_array($eventKey, self::$processedEvents)) {
            \Log::info('Duplicate event detected and skipped', [
                'event_key' => $eventKey,
                'user_id' => $event->userId,
                'action_type' => $event->actionType,
                'description' => $event->description,
            ]);
            return;
        }

        self::$processedEvents[] = $eventKey;

        \Log::info('LogUserAction triggered', [
            'user_id' => $event->userId,
            'action_type' => $event->actionType,
            'description' => $event->description,
        ]);

        OwnerLoginTracerController::logAction(
            $event->userId,
            $event->actionType,
            $event->description
        );
    }
}