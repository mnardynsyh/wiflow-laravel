<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LaporanInstalasi extends Model
{
    protected $table = 'laporan_instalasi';
    protected $guarded = ['id'];

    public function pendaftaran()
    {
        return $this->belongsTo(Pendaftaran::class, 'id_pendaftaran');
    }

    public function teknisi()
    {
        return $this->belongsTo(User::class, 'id_teknisi');
    }
}
