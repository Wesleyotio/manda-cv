<?php

namespace Tests\Feature;

use App\Enums\EducationLevel;
use Faker\Factory;
use Illuminate\Http\Response;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class CandidateTest extends TestCase
{
    
    public function test_list_education_level(): void
    {
        $response = $this->get('api/list-education-level',
        [
            "Accept"=>"application/json"
        ]);

        $response->assertStatus(Response::HTTP_OK)
            ->assertJson([
                'success' => true,
                'educationLevels' => EducationLevel::forSelect()
            ]);
        
        
    }
    public function test_send_cv(): void
    {

        $faker = Factory::create();
        $faker->addProvider(new \Faker\Provider\pt_BR\Person($faker));
        $faker->addProvider(new \Faker\Provider\pt_BR\Address($faker));
        $faker->addProvider(new \Faker\Provider\pt_BR\Company($faker));
        $faker->addProvider(new \Faker\Provider\pt_BR\PhoneNumber($faker));
        $faker->addProvider(new \Faker\Provider\Internet($faker));

        Storage::fake('storage');

        $file = UploadedFile::fake()->create('cv_test.pdf');

        $response = $this->post('api/send-cv',
        [
            "Accept"=>"application/json",
            'name' => $faker->name,
            'email' => $faker->freeEmail,
            'phone' => $faker->phoneNumberCleared,
            'job' => $faker->word,
            'education_level' => rand(1,5),
            'doc_name_cv' => $file,
            'obs' => $faker->sentence($nbWords = 6, $variableNbWords = true) , 
            'ip_candidate' => $faker->ipv4
        ]);


        $response->assertStatus(Response::HTTP_OK)
            ->assertJson([
                'success'   => true,
                'message'   => "Currículo enviado com sucesso"
            ]);
    }
}
