<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rapat extends Model
{
    use HasFactory;

    protected $fillable = [
        'created_by',
        'judul',
        'waktu',
        'lokasi',
        'agenda',
        'status',
        'passcode',
        'qr',
        'notulensi',
    ];

    protected $casts = [
        'waktu' => 'datetime',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    // // Rapat dibuat oleh User (Admin)
    // public function creator()
    // {
    //     return $this->belongsTo(User::class, 'created_by');
    // }

    // // Dokumen yang terhubung ke rapat
    // public function documents()
    // {
    //     return $this->hasMany(Document::class, 'rapat_id');
    // }

    // // Notulensi chat
    // public function chats()
    // {
    //     return $this->hasMany(NotulensiChat::class, 'rapat_id');
    // }

    // // Record voice
    // public function records()
    // {
    //     return $this->hasMany(Record::class, 'rapat_id');
    // }

    // // Absensi rapat
    // public function absensis()
    // {
    //     return $this->hasMany(AbsensiRapat::class, 'rapat_id');
    // }

    // // Undangan rapat
    // public function undangans()
    // {
    //     return $this->hasMany(Undangan::class, 'rapat_id');
    // }
}
