<?php

namespace Tests\Feature\App\Services;

use App\Models\Contact;
use App\Services\Implements\ContactService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Arr;
use Tests\TestCase;

class ContactServiceTest extends TestCase
{
    use RefreshDatabase;

    protected $contactService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->contactService = app(ContactService::class);
    }

    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_it_can_create_a_contact()
    {
        // Arrange
        $data = [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'birth_date' => '1990-01-01',
            'phones' => ['22987654321']
        ];

        // Act
        $contact = $this->contactService->store($data);

        // Assert
        $this->assertDatabaseHas('contacts', Arr::except($data, ['phones']));
        $this->assertDatabaseHas('phones', [
            'number' => $data['phones'][0], 'contact_id' => $contact->id
        ]);
        $this->assertCount(count($data['phones']), $contact->load('phones')->phones);
        $this->assertInstanceOf(Contact::class, $contact);
    }

    public function test_it_can_update_a_contact_without_phones()
    {
        // Arrange
        $contact = Contact::factory()->hasPhones(1)->create();
        $data = [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'birth_date' => '1990-01-01'
        ];

        // Act
        $updatedContact = $this->contactService->update($data, $contact->id);

        // Assert
        $this->assertEquals($data['name'], $updatedContact->name);
        $this->assertEquals($data['email'], $updatedContact->email);
        $this->assertEquals($data['birth_date'], $updatedContact->birth_date);
    }

    public function test_it_can_update_a_contact_with_phones()
    {
        // Arrange
        $contact = Contact::factory()->hasPhones(1)->create();
        $data = [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'birth_date' => '1990-01-01',
            'phones' => ['22987654321']
        ];

        // Act
        $updatedContact = $this->contactService->update($data, $contact->id);

        // Assert
        $this->assertEquals($data['name'], $updatedContact->name);
        $this->assertEquals($data['email'], $updatedContact->email);
        $this->assertEquals($data['birth_date'], $updatedContact->birth_date);
        $this->assertEquals($data['phones'][0], $updatedContact->phones[0]->number);
    }

    public function test_it_can_update_throws_exception_when_contact_not_found()
    {
        // Arrange
        $nonExistentContactId = 0;

        // Expect
        $this->expectException(ModelNotFoundException::class);

        // Act
        $this->contactService->update(['name' => 'John Doe'], $nonExistentContactId);
    }

    public function test_it_can_delete_contact()
    {
        // Arrange
        $contact = Contact::factory()->create();

        // Act
        $this->contactService->delete($contact->id);

        // Assert
        $this->assertSoftDeleted($contact);
    }

    public function test_it_can_delete_throws_exception_when_contact_not_found()
    {
        // Expect
        $this->expectException(ModelNotFoundException::class);

        // Act
        $this->contactService->delete(9999); // ID que não existe no banco de dados
    }

    public function test_it_can_find_all_contacts()
    {
        Contact::factory()->count(10)->create();

        // Act
        $result = $this->contactService->findAll();

        // Assert
        $this->assertInstanceOf(LengthAwarePaginator::class, $result);
        $this->assertTrue($result->count() == 10);
    }

    public function test_it_can_find_contact_by_id()
    {
        // Arrange
        $contact = Contact::factory()->create();

        // Act
        $result = $this->contactService->findById($contact->id);

        // Assert
        $this->assertInstanceOf(Contact::class, $result);
        $this->assertEquals($contact->id, $result->id);
    }

    public function test_it_can_find_contact_by_invalid_id_throws_exception()
    {
        // Expect
        $this->expectException(ModelNotFoundException::class);

        // Act
        $this->contactService->findById(9999); // ID que não existe no banco de dados
    }
}
