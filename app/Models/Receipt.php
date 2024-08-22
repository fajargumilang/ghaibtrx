<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Receipt extends Model
{
    protected $fillable = [
        'store_name',
        'address',
        'hp',
        'trans',
        'kassa',
        'time_transaction',

        'member',
        'name_of_kassa',
        'name_of_customer',
        'pt_akhir',

        'receipt_number',
        'total_amount',
        'discount',
        'tax',
        'final_amount',
        'payment_method',
        'uang_tunai'
    ];

    public function items()
    {
        return $this->hasMany(ReceiptItem::class, 'receipt_id');
    }
}
