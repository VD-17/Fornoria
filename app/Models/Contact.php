<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $table = 'contacts';

    protected $primaryKey = 'form_id';

    protected $fillable = [
        'user_id',
        'form_name',
        'form_email',
        'subject',
        'message',
    ];
}
