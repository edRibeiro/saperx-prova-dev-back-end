<?php

namespace App\Services;

use App\Models\Contact;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface ContactServiceInterface
{
  public function findAll(): LengthAwarePaginator;
  public function findAllRaw(): Collection;
  public function findById(int $contactId): Contact;
  public function store(array $data): Contact;
  public function update(array $data, int $contactId): Contact;
  public function delete(int $contactId): void;
}
