<?php

//namespace App\Events;
//
//use App\Models\Message;
//use Illuminate\Broadcasting\PrivateChannel;
//use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow; // ⬅️ THIS
//use Illuminate\Foundation\Events\Dispatchable;
//use Illuminate\Broadcasting\InteractsWithSockets;
//use Illuminate\Queue\SerializesModels;
//use Illuminate\Support\Facades\Storage;                  // ⬅️ make sure this is imported
//
//class DirectMessageSent implements ShouldBroadcastNow     // ⬅️ switch here
//{
//    use Dispatchable, InteractsWithSockets, SerializesModels;
//
//    public function __construct(public Message $message)
//    {
//        // ensure relations are loaded for payload
//        $this->message->loadMissing('sender', 'attachments');
//    }
//
//    public function broadcastOn()
//    {
//        return new PrivateChannel('user.' . $this->message->receiver_id);
//    }
//
//    public function broadcastAs() { return 'DirectMessageSent'; }
//
//    public function broadcastWith()
//    {
//        $a = [];
//        foreach (($this->message->attachments ?? []) as $att) {
//            $a[] = [
//                'url'     => Storage::disk('public')->url($att->path),
//                'mime'    => $att->mime,
//                'name'    => $att->original_name,
//                'size'    => $att->size,
//                'width'   => $att->width,
//                'height'  => $att->height,
//                'duration'=> $att->duration,
//            ];
//        }
//
//        return [
//            'id'          => $this->message->id,
//            'body'        => $this->message->body,
//            'sender'      => [
//                'id'   => $this->message->sender->id,
//                'name' => $this->message->sender->name,
//            ],
//            'receiver_id' => $this->message->receiver_id,
//            'created_at'  => $this->message->created_at->toISOString(),
//            'attachments' => $a,
//        ];
//    }
//}


// app/Events/DirectMessageSent.php
namespace App\Events;

use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Queue\SerializesModels;

class DirectMessageSent implements ShouldBroadcastNow
{
    use SerializesModels;

    public $message;

    public function __construct($message) { $this->message = $message; }

    public function broadcastOn()
    {
        // Receiver tab इस private channel पर subscribe होगा
        return new PrivateChannel('user.'.$this->message->receiver_id);
    }

    public function broadcastAs() { return 'DirectMessageSent'; }

    public function broadcastWith()
    {
        $m = $this->message->load('sender:id,name','attachments');
        return [
            'id'         => $m->id,
            'body'       => $m->body,
            'created_at' => $m->created_at,
            'sender'     => ['id'=>$m->sender_id, 'name'=>$m->sender->name],
            'attachments'=> $m->attachments->map(fn($a)=>[
                'url'  => asset('storage/'.$a->path),
                'mime' => $a->mime,
                'name' => $a->original_name,
            ]),
        ];
    }
}
