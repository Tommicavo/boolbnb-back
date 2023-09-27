<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Estate extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['title', 'description', 'rooms', 'beds', 'bathrooms', 'mq', 'is_visible', 'price'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function images()
    {
        return $this->hasMany(Image::class);
    }

    public function services()
    {
        return $this->belongsToMany(Service::class);
    }

    public function sponsorships()
    {
        return $this->belongsToMany(Sponsorship::class);
    }

    public function address()
    {
        return $this->hasOne(Address::class);
    }

    public function get_cover_path()
    {
        if ($this->images->isNotEmpty()) {
            return asset('storage/' . $this->images[0]->url);
        } else return 'https://www.areafit.it/wp-content/uploads/2022/08/placeholder.png';
    }

    public function get_address()
    {
        $estate_address = $this->address->toponymic . ' ' .
            $this->address->street_name . ' ' .
            $this->address->number . ' ' .
            $this->address->zip_code . ' ' .
            $this->address->city;
        return $estate_address;
    }
}
