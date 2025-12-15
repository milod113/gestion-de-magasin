<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = [ 'is_read', 'read_at','user_id','recipient_id', 'sujet', 'contenu'];

protected $casts = [
    'is_read' => 'boolean',
    'read_at' => 'datetime',
];

    public function attachments()
    {
        return $this->hasMany(Attachment::class);
    }

 public function sender()
{
    return $this->belongsTo(User::class, 'user_id');
}

public function recipient()
{
    return $this->belongsTo(User::class, 'recipient_id');
}

}

