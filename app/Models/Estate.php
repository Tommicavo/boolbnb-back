<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Estate extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['title', 'description', 'rooms', 'beds', 'bathrooms', 'mq', 'is_visible', 'price', 'address', 'latitude', 'longitude'];

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

    public function get_cover_path()
    {
        if ($this->images->isNotEmpty()) {
            return asset('storage/' . $this->images[0]->url);
        } else return 'https://www.mrw.it/img/cope/0iwkf4_1609360688.jpg';
    }
}
