<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'country_code',
    ];

    public function states() {
        return $this->hasMany(State::class);
    }

    public function employees() {
        return $this->hasMany(Employee::class);
    }

    public function cities() {
        return $this->hasManyThrough(City::class, State::class);
    }
}
