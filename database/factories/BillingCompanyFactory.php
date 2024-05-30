<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\BillingCompany;
use App\Models\Subject;

class BillingCompanyFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = BillingCompany::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'subjects_id' => Subject::factory(),
            'billing_companie' => $this->faker->company(),
            'address' => $this->faker->address(),
            'telephone' => $this->faker->phoneNumber(),
            'billing_department' => $this->faker->name(),
            'billing_source' => $this->faker->name()
        ];
    }
}
