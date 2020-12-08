<?php

namespace Database\Factories;

use App\Models\Appointment;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class AppointmentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \App\Models\Appointment::class;


    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        
        return [
            //
            'firstName' => $this->faker->firstNameMale,
            'lastName' => $this->faker->lastName,
            'secretary' => $this->faker->firstNameFemale,
            'day' => $this->faker->dayOfWeek($max = 'now') 
        ];
    }
}
