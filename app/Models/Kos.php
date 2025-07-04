<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kos extends Model
{
    protected $fillable = [
        'nama_kos',
        'alamat',
        'harga_sewa',
        'tipe_kamar',
        'fasilitas',
        'nomor_kontak',
        'status',
        'latitude',
        'longitude',
        'foto',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function favoritOleh()
    {
        return $this->belongsToMany(\App\Models\User::class, 'favorites')->withTimestamps();
    }


}
