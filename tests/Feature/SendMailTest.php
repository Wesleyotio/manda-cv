<?php

namespace Tests\Feature;

use App\Mail\SendCandidate;
use Faker\Factory;
use Illuminate\Support\Facades\Mail;

use Tests\TestCase;

class SendMailTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_mailable_content(): void
    {
        $faker = Factory::create();
        $faker->addProvider(new \Faker\Provider\pt_BR\Person($faker));
        $faker->addProvider(new \Faker\Provider\pt_BR\Address($faker));
        $faker->addProvider(new \Faker\Provider\pt_BR\Company($faker));
        $faker->addProvider(new \Faker\Provider\pt_BR\PhoneNumber($faker));

        $candidate = [
            'name' => $faker->name,
            'email' => $faker->freeEmail,
            'phone' => $faker->phoneNumberCleared,
            'job' => $faker->word,
            'education_level' => 'Ensino Médio',
            'obs' => $faker->sentence($nbWords = 6, $variableNbWords = true) , 
        ];
        Mail::fake();
 
        Mail::to($faker->freeEmail)->send(new SendCandidate( $candidate));
       
        Mail::assertSent(SendCandidate::class);
 
      
    }
}
