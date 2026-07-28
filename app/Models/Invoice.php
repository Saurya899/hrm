<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Invoice extends Model
{
    protected $fillable = [
        'patient_id',
        'invoice_number',
        'title',
        'billing_date',
        'due_date',
        'subtotal',
        'discount',
        'gst',
        'total_amount',
        'status',
        'payment_method'
    ];

    protected $casts = [

        'billing_date' => 'date',
        'due_date' => 'date',
        'subtotal' => 'decimal:2',
        'discount' => 'decimal:2',
        'gst' => 'decimal:2',
        'total_amount' => 'decimal:2'
    ];

    public function patient(): BelongsTo
    {

        return $this->belongsTo(Patient::class);
    }

    public function items(): HasMany
    {

        return $this->hasMany(InvoiceItem::class);
    }
}
