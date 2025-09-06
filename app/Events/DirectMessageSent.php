<?php

namespace App\Events;

use App\Models\Message;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class DirectMessageSent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

     public function __construct(public Message $message) {}

    public function broadcastOn()
    {
        // Each user has their own private channel
        return new PrivateChannel('user.' . $this->message->receiver_id);
    }

    public function broadcastAs() { return 'DirectMessageSent'; }

    public function broadcastWith()
    {
       $a = [];
    foreach (($this->message->attachments ?? []) as $att) {
        $a[] = [
            'url'  => Storage::disk('public')->url($att->path),
            'mime' => $att->mime,
            'name' => $att->original_name,
            'size' => $att->size,
            'width'=> $att->width,
            'height'=>$att->height,
            'duration'=>$att->duration,
        ];
    }

    return [
        'id'         => $this->message->id,
        'body'       => $this->message->body,
        'sender'     => ['id'=>$this->message->sender->id,'name'=>$this->message->sender->name],
        'receiver_id'=> $this->message->receiver_id,
        'created_at' => $this->message->created_at->toISOString(),
        'attachments'=> $a,
    ];
    }
}
