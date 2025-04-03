<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;
    use HasUuids;

    protected $fillable = [
        'number',
        'buyer_tin',
        'seller_tin',
        'product_code',
        'net_amount',
        'issue_date',
        'edit_date',
    ];
}
