<?php

namespace App\Http\Controllers;

use App\Http\Resources\ContactCollection;
use App\Models\Contact;
use App\Services\ContactServiceInterface;
use App\Services\Implements\ContactService;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Inertia\Inertia;

class ContactController extends Controller
{
    protected ContactService $service;

    public function __construct(ContactServiceInterface $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = $this->service->findAllRaw()->toArray();
        $contacts = Arr::map($data, function ($contact) {
            $contact['phones'] = Arr::map($contact['phones'], fn ($phone) => $phone['number']);
            return $contact;
        });
        return Inertia::render('Contacts/Index', ['contacts' => $contacts]);
    }
}
