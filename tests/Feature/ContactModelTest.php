<?php

namespace Tests\Feature;

use App\Models\Contact;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ContactModelTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_can_create_a_contact_without_phones()
    {
        // Arrange
        $data = [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'birth_date' => '1990-01-01',
        ];

        // Act
        $contact = new Contact($data);
        $contact->save();

        // Assert
        $this->assertDatabaseHas('contacts', [
            'name' => $data['name'],
            'email' => $data['email'],
            'birth_date' => $data['birth_date'],
        ]);
    }

    public function test_it_can_create_a_contact_with_one_phone()
    {
        // Arrange
        $data = [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'birth_date' => '1990-01-01',
        ];
        $phone = '22987654321';

        // Act
        $contact = new Contact($data);
        $contact->save();
        $contact->phones()->create(['number' => $phone]);

        // Assert
        $this->assertDatabaseHas('contacts', [
            'name' => $data['name'],
            'email' => $data['email'],
            'birth_date' => $data['birth_date'],
        ]);
        $this->assertDatabaseHas('phones', [
            'number' => $phone

        ]);
    }
}
