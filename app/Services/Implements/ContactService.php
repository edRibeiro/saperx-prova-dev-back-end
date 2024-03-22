<?php

namespace App\Services\Implements;

use App\Models\Contact;
use App\Services\ContactServiceInterface;
use Illuminate\Support\Arr;

class ContactService implements ContactServiceInterface
{
  protected Contact $model;

  public function __construct(Contact $model)
  {
    $this->model = $model;
  }

  public function findAll(): array
  {
    return [];
  }

  public function findById(int $contactId): Contact
  {
    return new Contact();
  }
  public function store(array $data): Contact
  {
    $contact = Contact::create(Arr::except($data, ['phones']));
    $contact->addPhones($data['phones']);
    return $contact->load('phones');
  }
  public function update(array $data): void
  {
  }
  public function delete(int $contactId): void
  {
  }
}
