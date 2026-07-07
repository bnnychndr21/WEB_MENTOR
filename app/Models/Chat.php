<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    protected $table = 'chats';

    protected $fillable = [
        'pengajuan_id',
        'sender_id',
        'message',
    ];

    public function pengajuan()
    {
        return $this->belongsTo(PengajuanMentoring::class, 'pengajuan_id');
    }

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }
}
