<?php

namespace App\Services\Implements;

use App\Models\Contact;
use App\Services\ContactServiceInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Arr;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ContactService implements ContactServiceInterface
{
  protected Contact $model;

  public function __construct(Contact $model)
  {
    $this->model = $model;
  }

  public function findAll(): LengthAwarePaginator
  {
    return $this->model->with('phones')->paginate(15);
  }

  public function findById(int $contactId): Contact
  {
    return $this->model->findOrFail($contactId);
  }

  public function store(array $data): Contact
  {
    $contact = Contact::create(Arr::except($data, ['phones']));
    $contact->addPhones($data['phones']);
    return $contact->load('phones');
  }

  public function update(array $data, int $contactId): Contact
  {
    $contact = $this->model->find($contactId);
    if (!$contact) {
      throw new ModelNotFoundException();
    }
    $contact->fill($data);
    if (array_key_exists('phones', $data)) {
      $contact->phones()->delete();
      $contact->addPhones($data['phones']);
    }
    return $contact->load('phones');
  }

  public function delete(int $contactId): void
  {
    $contact = $this->model->find($contactId);
    if (!$contact) {
      throw new ModelNotFoundException();
    }
    $contact->delete();
  }
}
