<?php

namespace Database\Factories;

//Subjectモデルをインポート
use App\Models\Subject;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Subject>
 */
class SubjectFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Subject::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'company' => $this->faker->company(),
            'address' => $this->faker->address(),
            'telephone' =>  $this->faker->phoneNumber(),
            'representative' => $this->faker->name()
        ];
    }
}
