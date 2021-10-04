<?php

namespace Database\Factories;

use App\Models\City;
use App\Models\State;
use Illuminate\Database\Eloquent\Factories\Factory;

class CityFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = City::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        // Retrieve a random country 
        $state = State::all()->random();

        // Generate a random city
        $name = $this->faker->city();

        // Search by city and state
        $city = City::query()
            ->where('state_id', '=', $state->id)
            ->where('name', '=', $name)
            ->first();

        // If we have a record already, delete it
        if ($city) {
            error_log('Deleted: ' . $city->name);
            $city->delete();
        }

        return [
            'name' => $name,
            'state_id' => $state->id,
        ];
    }
}
