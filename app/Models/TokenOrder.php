<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TokenOrder extends Model
{
    use HasFactory;

    protected $table = 'token_orders';

    protected $fillable = [
        'user_id',
        'tokens_purchased',
        'usd_paid',
        'peachpayment_order_id',
        'status',
    ];

    const STATUS_PENDING = 'pending';
    const STATUS_PAID = 'paid';

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function isPending()
    {
        return $this->status === 'pending';
    }

    public function isPaid()
    {
        return $this->status === 'paid';
    }

    public function isFailed()
    {
        return $this->status === 'failed';
    }

    public function markAsPaid()
    {
        $this->status = 'paid';
        $this->save();
    }
}
