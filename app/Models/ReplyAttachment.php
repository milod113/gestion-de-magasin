<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReplyAttachment extends Model
{
    protected $table = 'reply_attachments';

    protected $fillable = [
        'reply_id', 'user_id', 'disk', 'path', 'original_name', 'mime_type', 'size'
    ];

    public function reply()
    {
        return $this->belongsTo(Reply::class);
    }
}
