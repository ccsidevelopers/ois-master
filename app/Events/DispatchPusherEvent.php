<?php

namespace App\Events;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use App\User;
use Illuminate\Support\Facades\Auth;

class DispatchPusherEvent extends Event implements ShouldBroadcast
{
    use SerializesModels;
    public $message;
    public $userID;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($message,$userID)
    {
        $this->message = $message;
        $this->userID = $userID;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return ['privateChannel-'.$this->userID];
    }
}
