<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'state_id',
    ];


    public function employees() {
        return $this->hasMany(Employee::class);
    }

    public function state() {
        return $this->belongsTo(State::class);
    }

    public function country() {
        return $this->hasOneThrough(Country::class, State::class);
    }
}
