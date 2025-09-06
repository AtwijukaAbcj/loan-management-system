<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PesapalSetting extends Model
{
    protected $fillable = [
        'consumer_key',
        'consumer_secret',
        'is_active',
    ];
}
