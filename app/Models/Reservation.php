<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $table = 'reservations';

    protected $primaryKey = 'reservation_id';

    protected $fillable = [
        'user_id',
        'name',
        'phone',
        'num_people',
        'date',
        'time',
        'note',
        'status',
    ];

    public function getRouteKeyName() {
        return 'reservation_id';
    }
}
