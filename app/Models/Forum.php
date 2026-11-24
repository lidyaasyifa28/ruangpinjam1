<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Forum extends Model
{
    /**
     * @var array<int, string>
     */
    protected $fillable = [
        'nama_pengirim',
        'isi_pertanyaan',
        'jawaban_admin',
    ];
}
