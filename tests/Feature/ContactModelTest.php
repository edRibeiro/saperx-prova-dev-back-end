<?php

namespace Tests\Feature;

use App\Models\Contact;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ContactModelTest extends TestCase
{
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
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'birth_date' => '1990-01-01',
        ]);
    }
}
