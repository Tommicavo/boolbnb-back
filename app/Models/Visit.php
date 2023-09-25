<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visit extends Model
{
    use HasFactory;

    protected $fillable = ['date', 'ip_address'];

    public function estate()
    {
        return $this->belognsTo(Estate::class);
    }
}
