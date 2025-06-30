<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UserActionOccurred
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $userId;
    public $actionType;
    public $description;

    public function __construct($userId, $actionType, $description)
    {
        $this->userId = $userId;
        $this->actionType = $actionType;
        $this->description = $description;
    }
}