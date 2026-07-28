<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InvoiceItem extends Model
{
    protected $table = 'invoice_itmes';
    protected $fillable = [
        'invoice_id',
        'description',
        'rate',
        'qty',
        'total'
    ];
    protected $casts = [
        'rate' => 'decimal:2',
        'total' => 'decimal:2'
    ];

    public function invoice(): BelongsTo
    {
        return $this->belongsTo(Invoice::class);
    }
}
