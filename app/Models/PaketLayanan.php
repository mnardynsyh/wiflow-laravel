<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaketLayanan extends Model
{
    protected $table = 'paket_layanan'; 
    protected $guarded = ['id'];

    public function pendaftaran()
    {
        return $this->hasMany(Pendaftaran::class, 'id_paket');
    }
}
