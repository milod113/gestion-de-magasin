<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = ['user_id', 'sujet', 'contenu'];

    public function attachments()
    {
        return $this->hasMany(Attachment::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

