<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pendaftaran extends Model
{
    protected $table = 'pendaftaran';
    protected $guarded = ['id'];
    
    protected $casts = [
        'tanggal_jadwal' => 'datetime',
    ];


    public function paket()
    {
        return $this->belongsTo(PaketLayanan::class, 'id_paket');
    }

    public function teknisi()
    {
        return $this->belongsTo(User::class, 'id_teknisi');
    }


    public function laporanInstalasi()
    {
        return $this->hasOne(LaporanInstalasi::class, 'id_pendaftaran');
    }
}
