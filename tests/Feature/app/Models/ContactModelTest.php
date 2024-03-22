<?php

namespace Tests\Feature\App\Models;

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

    public function test_it_can_add_one_phone_number_to_contact()
    {
        // Arrange
        $contact = Contact::factory()->create();
        $phone = '22987654321';

        // Act
        $contact->addPhone($phone);

        // Assert
        $this->assertDatabaseHas('phones', [
            'number' => $phone, 'contact_id' => $contact->id
        ]);
        $this->assertCount(1, $contact->load('phones')->phones);
    }

    public function test_it_can_add_many_phones_numbers_to_contact()
    {
        // Arrange
        $contact = Contact::factory()->create();
        $data = [
            '22987654320',
            '22987654321',
            '22987654322',
            '22987654323',
            '22987654324',
        ];

        // Act
        $contact->addPhones($data);

        // Assert
        $this->assertDatabaseHas('phones', [
            'number' => $data[0], 'contact_id' => $contact->id
        ]);
        $this->assertDatabaseHas('phones', [
            'number' => $data[1], 'contact_id' => $contact->id
        ]);
        $this->assertDatabaseHas('phones', [
            'number' => $data[2], 'contact_id' => $contact->id
        ]);
        $this->assertDatabaseHas('phones', [
            'number' => $data[3], 'contact_id' => $contact->id
        ]);
        $this->assertDatabaseHas('phones', [
            'number' => $data[4], 'contact_id' => $contact->id
        ]);
        $this->assertCount(count($data), $contact->load('phones')->phones);
    }
}
