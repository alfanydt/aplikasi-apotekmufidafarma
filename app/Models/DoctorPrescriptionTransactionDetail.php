<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DoctorPrescriptionTransactionDetail extends Model
{
    use HasFactory;

    protected $table = 'doctor_prescription_transaction_details';

    protected $fillable = [
        'doctor_prescription_transaction_id',
        'product_name',
        'product_id',
        'quantity',
        'price',
    ];

    public function transaction()
    {
        return $this->belongsTo(DoctorPrescriptionTransaction::class, 'doctor_prescription_transaction_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
