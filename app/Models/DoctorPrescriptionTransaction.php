<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DoctorPrescriptionTransaction extends Model
{
    protected $table = 'doctor_prescription_transactions'; // Nama tabel di DB

    protected $fillable = [

    'prescription_id',
    'doctor_name',
    'patient_name',
    'transaction_date',
    'total_price',
    'user_id',  
    'notes', 
    ];

    protected $dates = ['paid_at'];

    // Resep yang ditransaksikan
    public function prescription()
    {
        return $this->belongsTo(DoctorPrescription::class, 'prescription_id');
    }

    // Kasir yang memproses
    public function cashier()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Detail item yang dibeli (relasi one-to-many)
    // public function details()
    // {
    //     return $this->hasMany(DoctorPrescriptionTransactionDetail::class);
    // }
    public function details()
    {
        return $this->hasMany(DoctorPrescriptionTransactionDetail::class);
    }

}
