<?php

namespace App\Events;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class SAOdispatchChat extends Event implements ShouldBroadcast
{
    use SerializesModels;
    public $message;
    public $userID;
    public $userName;
    public $pix;
    public $timestampa;
    public $time;


    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($userID,$message,$userName,$pix,$timestampa,$time)
    {
        $this->userID = $userID;
        $this->message = $message;
        $this->userName = $userName;
        $this->pix = $pix;
        $this->timestampa = $timestampa;
        $this->time = $time;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return ['publicChannel'];
    }
}
