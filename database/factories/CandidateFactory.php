<?php

namespace Database\Factories;

use App\Models\Candidate;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class CandidateFactory extends Factory
{
    protected $model = Candidate::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //
            'name' => $this->faker->name,
            'email' => $this->faker->freeEmail,
            'phone' => $this->faker->phoneNumberCleared,
            'job' => $this->faker->word,
            'education_level' => rand(1,5),
            'obs' => $this->faker->sentence($nbWords = 6, $variableNbWords = true) , 
            'doc_name_cv' => $this->faker->word,
            'ip_candidate' => $this->faker->ipv4
            
        ];
    }
}
