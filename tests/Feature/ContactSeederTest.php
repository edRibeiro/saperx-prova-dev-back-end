<?php

namespace Tests\Feature;

use Database\Seeders\ContactSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ContactSeederTest extends TestCase
{
    use RefreshDatabase;

    public function test_sould_seed_contacts_with_one_phone(): void
    {
        $this->seed(ContactSeeder::class);
        $this->assertDatabaseCount('contacts', 20);
        $this->assertDatabaseCount('phones', 20);
    }
}
