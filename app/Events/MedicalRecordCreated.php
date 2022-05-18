<?php

namespace App\Events;

use App\Models\MedicalRecord;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MedicalRecordCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $record;
    public $tests;
    public $ctscan;
    public $mri;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(MedicalRecord $medicalRecord, array $tests, string $ctscan, string $mri)
    {
        $this->record = $medicalRecord;
        $this->tests = $tests;
        $this->ctscan = $ctscan;
        $this->mri = $mri;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
