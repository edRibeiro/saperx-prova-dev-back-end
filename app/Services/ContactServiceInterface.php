<?php

namespace App\Services;

use App\Models\Contact;

interface ContactServiceInterface
{
  public function findAll(): array;
  public function findById(int $contactId): Contact;
  public function store(array $data): Contact;
  public function update(array $data): void;
  public function delete(int $contactId): void;
}
