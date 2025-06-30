<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserRegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_register()
    {
        $response = $this->post('/users', [
            'LastName' => 'Doe',
            'FirstName' => 'John',
            'MiddleName' => 'Rawr',
            'Email' => 'john.doe@example.com',
            'Username' => 'johndoe',
            'Password' => 'password',
            'Password_confirmation' => 'password',
            'ContactNumber' => '+639123456789',
            'Gender' => 'Male',
            'Birthdate' => '2000-01-01',
            'Nationality' => 'Filipino',
            'Status' => 'Single',
            'HomeAddress' => '123 Main St',
            'HomeTelephoneNumber' => '1234567',
            'Occupation' => 'Engineer',
            'Age' => '21',
            'Religion' => 'Christian',
            'ReferredBy' => 'N/A', // Optional field, added 'N/A' as placeholder if it's nullable
            'OfficeNumber' => '9876543210', // Optional field, added placeholder if it's nullable

            // Add other necessary fields as per your form
        ]);

        $response->assertStatus(201); // Adjust based on your actual expected response
        $this->assertDatabaseHas('users', [
            'email' => 'john.doe@example.com',
        ]);
    }
}
