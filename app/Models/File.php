<?php

namespace App\Models;

use Illuminate\Broadcasting\Channel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\BroadcastsEvents;

class File extends Model
{
    use HasFactory, BroadcastsEvents;
	
	protected $casts = [
        'created_at' => 'date:m/d/Y',
    ];

    protected $fillable = ['name', 'content', 'ext', 'owner'];

    /**
     * The 'content' field, which hold the file's actual binary data, will be hidden
     * from JSON serialization, but still accessible directly (eg: for download).
     * This way we don't cause an impact in performance every time a file's metadata is fetched.
     */
    protected $hidden = ['content', 'updated_at'];

    /**
     * Get the user that owns this file.
     *
     * @return BelongsTo
     */
    public function owner() {
        return $this->belongsTo(User::class, 'owner');
    }

    /**
     * Get the channels that model events should broadcast on.
     *
     * @param string $event
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return [new Channel('files')];
    }

    /**
     * Get the data to broadcast for the model.
     *
     * @return array
     */
    public function broadcastWith()
    {
        return ['file' => $this->load('owner:id,name')];
    }

}
