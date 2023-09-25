<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;
    protected $fillable = ['toponymic', 'street_name', 'number', 'zip_code', 'city', 'latitude', 'longitude'];

    public function estate()
    {
        return $this->belongsTo(Estate::class);
    }
}
