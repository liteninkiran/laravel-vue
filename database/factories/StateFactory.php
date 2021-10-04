<?php

namespace Database\Factories;

use App\Models\State;
use App\Models\Country;
use Illuminate\Database\Eloquent\Factories\Factory;

class StateFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = State::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        // Retrieve a random country 
        $country = Country::all()->random();

        // Generate a random state
        $name = $this->faker->state();

        // Search by state and country
        $state = State::query()
            ->where('country_id', '=', $country->id)
            ->where('name', '=', $name)
            ->first();

        // If we have a record already, delete it
        if ($state) {
            error_log('Deleted: ' . $state->name);
            $state->delete();
        }

        return [
            'name' => $name,
            'country_id' => $country->id,
        ];
    }
}
