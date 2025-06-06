<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Installment extends Model
{
    use HasFactory;

    protected $fillable = ['sale_id', 'due_date', 'amount', 'status'];

    public function sale()
    {
        return $this->belongsTo(Sale::class);
    }
}

