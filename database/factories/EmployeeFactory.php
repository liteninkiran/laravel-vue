<?php

namespace Database\Factories;

use App\Models\Employee;
use App\Models\City;
use App\Models\Department;
use Illuminate\Database\Eloquent\Factories\Factory;

class EmployeeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Employee::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition() {

        $city = City::all()->random();
        $department = Department::all()->random();

        $hireDate = $this->faker->dateTimeBetween($startDate = '-30 years', $endDate = 'now');
        $birthDate = $this->faker->dateTimeBetween($startDate = '-60 years', $endDate = '-18 years');

        return [
            'last_name' => $this->faker->lastName(),
            'first_name' =>  $this->faker->firstName(),
            'middle_name' =>  $this->faker->randomDigit > 7 ? $this->faker->firstName() : null,
            'address' => $this->faker->streetAddress(),
            'department_id' => $department->id,
            'country_id' => $city->state->country->id,
            'state_id' => $city->state->id,
            'city_id' => $city->id,
            'zip_code' => $this->faker->postcode(),
            'birthdate' => $birthDate->format("Y-m-d"),
            'date_hired' => $hireDate->format("Y-m-d"),
        ];
    }
}
