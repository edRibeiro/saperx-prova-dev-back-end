<?php

namespace Tests\Feature;

use App\Models\Contact;
use App\Services\ContactServiceInterface;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

class ContactFeatureTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_can_list_all_contacts()
    {
        // Arrange
        Contact::factory()->count(5)->create();

        // Act
        $response = $this->getJson(route('contacts.index'));

        // Assert
        $response->assertStatus(Response::HTTP_OK)
            ->assertJsonCount(5, 'data');
    }

    public function test_it_can_show_a_contact()
    {
        // Arrange
        $contact = Contact::factory()->create();

        // Act
        $response = $this->getJson(route('contacts.show', ['contact' => $contact->id]));

        // Assert
        $response->assertStatus(Response::HTTP_OK)
            ->assertJsonFragment(['name' => $contact->name, 'email' => $contact->email]);
    }

    public function test_it_can_create_a_contact()
    {
        // Arrange
        $data = [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'birth_date' => '1990-01-01',
            'phones' => ['(99) 9999-9999']
        ];

        // Act
        $response = $this->postJson(route('contacts.store'), $data);

        // Assert
        $response->assertStatus(Response::HTTP_CREATED)
            ->assertJsonPath('data.name', 'John Doe')
            ->assertJsonPath('data.email', 'john@example.com')
            ->assertJsonPath('data.birth_date', '1990-01-01')
            ->assertJsonPath('data.phones', ['(99) 9999-9999']);
    }

    public function test_it_can_update_a_contact()
    {
        // Arrange
        $contact = Contact::factory()->create();
        $updatedData = [
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
            'birth_date' => '1985-05-20',
            'phones' => ['(88) 8888-8888']
        ];

        // Act
        $response = $this->putJson(route('contacts.update', ['contact' => $contact->id]), $updatedData);

        // Assert
        $response->assertStatus(Response::HTTP_OK)
            ->assertJsonPath('data.name', 'Jane Doe')
            ->assertJsonPath('data.email', 'jane@example.com')
            ->assertJsonPath('data.birth_date', '1985-05-20')
            ->assertJsonPath('data.phones', ['(88) 8888-8888']);
    }

    public function test_it_returns_not_found_error_when_contact_does_not_exist()
    {
        // Arrange
        $nonExistentId = 9999;

        // Act
        $response = $this->getJson(route('contacts.show', ['contact' => $nonExistentId]));

        // Assert
        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }

    public function test_it_returns_internal_server_error_when_service_throws_exception()
    {
        // Arrange
        $this->mock(ContactServiceInterface::class, function ($mock) {
            $mock->shouldReceive('findAll')->andThrow(new \Exception('Some error message'));
        });

        // Act
        $response = $this->getJson(route('contacts.index'));

        // Assert
        $response->assertStatus(Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}
