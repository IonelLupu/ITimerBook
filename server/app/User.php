<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    public $timestamps = false;

    protected $appends = ['level'];

    protected $with = ['categories'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'firstName', 'lastName', 'email', 'password', 'gender','address','minutesForReading',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'users_categories');
    }

    public function books()
    {
        return $this->hasMany(Book::class);
    }

    public function notFinishedBooks()
    {
        return $this->books()->where('finished', 0)->get();
    }


    public function getLevelAttribute()
    {
        if ($this->points <= 2500)
            return 'Incepator';

        if ($this->points > 2500 && $this->points <= 6000)
            return 'Mediu';

        if ($this->points > 6000 && $this->points <= 10000)
            return 'Avansat';

        if ($this->points > 10000)
            return 'Expert';
    }

}
