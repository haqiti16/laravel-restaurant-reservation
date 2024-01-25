<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $table = 'reservations';
    protected $primaryKey = "id";
    protected $keyType = "int";
    public $timestamps = true;
    public $incrementing = true;

    protected $fillable = [
        'table_id',
        'customer_id',
        'start_time',
        'end_time',
        'guest_count',
        'status',
    ];

    public function saveCustomer($data)
    {
        if (!$this->customer_id) {
            $customer = new Customer();
            $customer->fill($data);
            $customer->save();
            $this->customer()->associate($customer);
        }
    }

    public function table()
    {
        return $this->belongsTo(Table::class, "table_id", "id");
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, "customer_id", "id");
    }
}
