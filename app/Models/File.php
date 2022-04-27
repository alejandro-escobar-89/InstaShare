<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class File extends Model
{
    use HasFactory;
	
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
}
