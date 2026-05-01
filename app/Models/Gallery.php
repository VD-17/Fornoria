<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    protected $table = 'gallerys';

    protected $primaryKey = 'gallery_id';

    protected $fillable = [
        'imageUrl',
        'uploadedAt',
    ];
}
