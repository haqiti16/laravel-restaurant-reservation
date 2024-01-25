<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Table extends Model
{
    protected $table = 'tables';
    protected $primaryKey = "id";
    protected $keyType = "int";
    public $timestamps = true;
    public $incrementing = true;

    protected $fillable = [
        'name',
        'capacity',
    ];

    public function isAvailable($start_time, $end_time, $guest_count = null)
    {
        // Get all reservations for the given table
        $reservations = Reservation::where('table_id', $this->id)
            ->where('start_time', '<=', $end_time)
            ->where('end_time', '>=', $start_time)
            ->get();

        // If no reservations exist, the table is available
        if (count($reservations) === 0) {
            return true;
        }

        // If the table is already reserved, check the capacity
        foreach ($reservations as $reservation) {
            if ($reservation->guest_count + $guest_count > $this->capacity) {
                return false;
            }
        }

        // The table is available
        return true;
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class, "table_id", "id");
    }
}
