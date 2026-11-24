<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable = ['name', 'category', 'stock_total', 'stock_available'];

    public function loans()
    {
        return $this->hasMany(Loan::class);
    }
}
