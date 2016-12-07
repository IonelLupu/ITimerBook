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
        'firstName', 'lastName', 'email', 'password', 'gender',
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
        if ($this->points < 50)
            return 'Incepator';
        else
            return 'Mediu';
    }

}
