<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    protected $fillable = [
        'ticket_number',
        'item_id',
        'student_name',
        'student_class',
        'organization',
        'whatsapp',
        'quantity',
        'borrow_date',
        'return_date',
        'purpose',
        'status',
        'rejection_reason',
    ];

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    protected function casts(): array
    {
        return [
            'borrow_date' => 'date',
            'return_date' => 'date',
        ];
    }
}
